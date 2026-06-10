<?php

namespace App\Livewire\Front;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Support\Facades\Auth;

class DynamicForm extends Component
{
    use WithFileUploads;

    public $slug;
    public $form;
    public $data = [];
    public $successMessage = '';
    public $showForm = true;
    public $mySubmissions = [];
    public $isQuotaFull = false;
    public $isDateValid = true;
    public $dateMessage = '';
    public $editingSubmissionId = null; // ID submission yang sedang direvisi
    public $revisionMode = false;       // Apakah sedang dalam mode revisi
    public $existingFilePaths = [];     // Menyimpan path file lama saat mode revisi

    public function mount($slug = null, $submissionId = null)
    {
        $this->slug = $slug;
        if ($slug) {
            $this->form = Form::where('slug', $slug)->where('is_active', true)->first();
            if ($this->form) {
                // Date Validation
                $now = \Carbon\Carbon::now()->startOfDay();
                if ($this->form->start_date && $now->lt($this->form->start_date)) {
                    $this->isDateValid = false;
                    $this->dateMessage = 'Pendaftaran belum dibuka. Dibuka pada: ' . \Carbon\Carbon::parse($this->form->start_date)->translatedFormat('d F Y');
                    $this->showForm = false;
                } elseif ($this->form->end_date && $now->gt($this->form->end_date)) {
                    $this->isDateValid = false;
                    $this->dateMessage = 'Pendaftaran sudah ditutup pada: ' . \Carbon\Carbon::parse($this->form->end_date)->translatedFormat('d F Y');
                    $this->showForm = false;
                }

                // Quota Validation
                if ($this->form->max_quota) {
                    // Only check global quota if this is NOT a booking/session based form
                    if (!$this->form->booking_date_label && !$this->form->time_slot_label) {
                        $currentUsage = $this->form->submissions->reduce(function (int $carry, $submission) {
                            return $carry + (int) ($this->form->quota_count_label && isset($submission->data[$this->form->quota_count_label]) 
                                ? $submission->data[$this->form->quota_count_label] 
                                : 1);
                        }, 0);

                        if ($currentUsage >= $this->form->max_quota) {
                            $this->isQuotaFull = true;
                            $this->showForm = false;
                        }
                    }
                }

                if ($this->showForm) {
                    // Initialize data array
                    foreach ($this->form->fields as $field) {
                        $this->data[$field['label']] = '';
                    }

                    // Pre-fill user data for ISBN form
                    if ($this->slug === 'pengajuan-isbn') {
                        $this->data['Email'] = Auth::user()->email;
                        $this->data['Nama Pemohon'] = Auth::user()->name;
                        $this->data['Unit Kerja / Satuan Kerja Pemohon '] = Auth::user()->satuan_kerja ?? '';
                        $this->data['Terbitan Pemerintah'] = 'Non Penelitian';
                    }
                }
                
                // Load user's past submissions
                $this->loadMySubmissions();

                // If a submission ID is passed for revision/editing, load it!
                if ($submissionId) {
                    $this->loadForRevision((int)$submissionId);
                }
            }
        }
    }

    public function loadMySubmissions()
    {
        if (Auth::check() && $this->form) {
            $this->mySubmissions = FormSubmission::where('form_id', $this->form->id)
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get()
                ->toArray();
        }
    }

    public function toggleForm()
    {
        if ($this->slug === 'pengajuan-isbn') {
            $this->showForm = true;
            $this->successMessage = '';
            $this->editingSubmissionId = null;
            $this->revisionMode = false;
            $this->existingFilePaths = [];
            return;
        }

        $this->showForm = !$this->showForm;
        $this->successMessage = '';
        // Reset revision mode saat toggle
        if (!$this->showForm) {
            $this->editingSubmissionId = null;
            $this->revisionMode = false;
            $this->existingFilePaths = [];
        }
    }

    /**
     * Load existing submission data into form for revision.
     * Called when user clicks "Ajukan Perbaikan".
     */
    public function loadForRevision(int $submissionId): void
    {
        $submission = FormSubmission::where('id', $submissionId)
            ->where('user_id', Auth::id())
            ->where('workflow_status', 'perlu_diperbaiki')
            ->first();

        if (!$submission) return;

        // Pre-fill form dengan data lama
        $oldData = $submission->data ?? [];
        $this->existingFilePaths = [];
        
        foreach ($this->form->fields as $field) {
            $label = $field['label'];
            // Jangan pre-fill file field (user harus upload ulang jika diperlukan)
            if ($field['type'] === 'file') {
                $this->data[$label] = '';
                if (!empty($oldData[$label])) {
                    $this->existingFilePaths[$label] = $oldData[$label];
                }
            } else {
                $this->data[$label] = $oldData[$label] ?? '';
            }
        }

        $this->editingSubmissionId = $submissionId;
        $this->revisionMode = true;
        $this->showForm = true;
        $this->successMessage = '';
    }

    /**
     * Get the existing submission record if in revision mode.
     */
    protected function getExistingSubmission(): ?FormSubmission
    {
        if ($this->revisionMode && $this->editingSubmissionId) {
            return FormSubmission::where('id', $this->editingSubmissionId)
                ->where('user_id', Auth::id())
                ->first();
        }
        return null;
    }

    /**
     * Build validation rules and messages based on form fields and existing data.
     */
    protected function getValidationRulesAndMessages(array $existingData): array
    {
        $rules = [];
        $messages = [];

        foreach ($this->form->fields as $field) {
            $key = 'data.' . $field['label'];
            $rule = [];
            
            if ($field['required']) {
                // Untuk file di mode revisi: jika file sudah ada sebelumnya, jangan wajibkan upload ulang
                $isFileAndExists = $field['type'] === 'file' && !empty($existingData[$field['label']]);
                
                if (!$isFileAndExists) {
                    $rule[] = 'required';
                    $messages[$key . '.required'] = $field['label'] . ' wajib diisi.';
                }
            }

            if ($field['type'] === 'email') {
                $rule[] = 'email';
            }
            
            if ($field['type'] === 'number') {
                $rule[] = 'numeric';
            }

            // File validation rules
            if ($field['type'] === 'file') {
                 $rule[] = 'file|max:10240|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif,webp,zip,rar'; // Max 10MB, allowed types only
            }

            if (!empty($rule)) {
                $rules[$key] = implode('|', $rule);
            }
        }

        return [$rules, $messages];
    }

    /**
     * Determine booking date and session time slot from the submitted data.
     */
    protected function getBookingDateAndSessionTime(): array
    {
        $bookingDate = null;
        if ($this->form->booking_date_label && isset($this->data[$this->form->booking_date_label])) {
            $bookingDate = $this->data[$this->form->booking_date_label];
        } else {
            // Fallback to first date field found
            foreach ($this->form->fields as $field) {
                if ($field['type'] === 'date') {
                    $bookingDate = $this->data[$field['label']] ?? null;
                    break;
                }
            }
        }

        $sessionTime = null;
        if ($this->form->time_slot_label && isset($this->data[$this->form->time_slot_label])) {
            $sessionTime = $this->data[$this->form->time_slot_label];
        }

        return [$bookingDate, $sessionTime];
    }

    /**
     * Check quota and blocked dates limitations.
     */
    protected function checkQuotaAndBlockedDates(?string $bookingDate, ?string $sessionTime, ?int &$currentUsage, ?int &$requested): bool
    {
        if (!$bookingDate) {
            return true;
        }

        // 1. Check Blocked Dates
        $blockedDate = $this->form->blockedDates()
            ->where('booking_date', $bookingDate)
            ->where(function ($query) use ($sessionTime) {
                $query->whereNull('session_time') // Blocks entire day
                      ->orWhere('session_time', $sessionTime); // Blocks specific session
            })
            ->first();

        if ($blockedDate) {
            $reason = $blockedDate->reason ? " ({$blockedDate->reason})" : '';
            $this->dispatch('toast', type: 'error', message: 'Tanggal/Sesi ini tidak tersedia / sudah dibooking penuh' . $reason);
            return false;
        }

        // 2. Check Quota
        if ($this->form->max_quota) {
            $allDaySubmissions = $this->form->submissions()
                ->where('status', '!=', 'rejected')
                ->where('booking_date', $bookingDate)
                ->get();

            $requested = 1;
            if ($this->form->quota_count_label && isset($this->data[$this->form->quota_count_label])) {
                 $requested = (int) $this->data[$this->form->quota_count_label];
            }

            $isFullDay = $sessionTime === 'Sehari Full';
            $timeSlotLabel = $this->form->time_slot_label;

            if ($isFullDay) {
                // "Sehari Full" — check every individual session to make sure none are over quota
                $sessionQuotas = $this->getSessionQuotas();
                foreach ($sessionQuotas as $sq) {
                    if ($sq['value'] === 'Sehari Full') continue;
                    if (($sq['used'] + $requested) > $this->form->max_quota) {
                        $this->dispatch('toast', type: 'error', message: 'Tidak dapat memilih Sehari Full karena sesi ' . $sq['label'] . ' sudah penuh (Sisa: ' . $sq['remaining'] . ')');
                        return false;
                    }
                }
            } else {
                // Individual session — also count "Sehari Full" bookings against this session
                $submissions = $allDaySubmissions->filter(function($sub) use ($sessionTime, $timeSlotLabel) {
                    $subSession = $sub->data[$timeSlotLabel] ?? null;
                    return $subSession == $sessionTime || $subSession === 'Sehari Full';
                });

                $currentUsage = $submissions->reduce(function (int $carry, $sub) {
                    return $carry + (int) ($this->form->quota_count_label && isset($sub->data[$this->form->quota_count_label]) 
                        ? $sub->data[$this->form->quota_count_label] 
                        : 1);
                }, 0);

                if (($currentUsage + $requested) > $this->form->max_quota) {
                    $msg = 'Kuota untuk sesi ' . $sessionTime . ' pada tanggal ' . $bookingDate . ' sudah penuh (Sisa: ' . max(0, $this->form->max_quota - $currentUsage) . ')';
                    $this->dispatch('toast', type: 'error', message: $msg);
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Save the submission data (either as new or revision update) and trigger notifications/reset.
     */
    protected function saveSubmission(array $submissionData, ?string $bookingDate, ?FormSubmission $submission, array $existingData, ?string $sessionTime, ?int $currentUsage, ?int $requested)
    {
        if ($this->revisionMode && $this->editingSubmissionId && $submission) {
            // ==== MODE REVISI: UPDATE record yang ada ====
            // Merge data lama dengan data baru (field file yang tidak diupload ulang tetap pakai yang lama)
            $mergedData = [];
            foreach ($this->form->fields as $field) {
                $label = $field['label'];
                $value = data_get($this->data, $label);
                if ($field['type'] === 'file') {
                    if ($value instanceof \Illuminate\Http\UploadedFile) {
                        $mergedData[$label] = $value->store('form_submissions', 'public');
                    } else {
                        // Pertahankan file lama jika tidak di-upload ulang
                        $mergedData[$label] = $existingData[$label] ?? null;
                    }
                } else {
                    $mergedData[$label] = $value;
                }
            }

            $submission->update([
                'data'            => $mergedData,
                'workflow_status' => 'verifikasi_kemenag', // Kembali ke tahap verifikasi
                'status'          => 'pending',
                'revision_notes'  => null,
            ]);

            // Redirect ke dashboard dengan notifikasi sukses
            return redirect()->route('dashboard')->with('success', 'Perbaikan berhasil dikirim! Pengajuan Anda sedang diproses kembali.');
        } else {
            // ==== MODE NORMAL: CREATE record baru ====
            FormSubmission::create([
                'form_id'      => $this->form->id,
                'user_id'      => Auth::id(),
                'data'         => $submissionData,
                'booking_date' => $bookingDate,
                'status'       => 'pending',
            ]);

            // Check if session is now full after this submission
            if ($this->form->max_quota && $currentUsage !== null && $requested !== null) {
                $newTotal = $currentUsage + $requested;
                if ($newTotal >= $this->form->max_quota) {
                    /** @var \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users */
                    $users = \App\Models\User::where('role', 'admin')->get();
                    $sessionInfo = $sessionTime ? "Sesi: $sessionTime" : "Hari Full";
                    $dateInfo = $bookingDate ? \Carbon\Carbon::parse($bookingDate)->format('d/m/Y') : '';
                    foreach ($users as $user) {
                        /** @var \App\Models\User $user */
                        \Filament\Notifications\Notification::make()
                            ->title('Kuota Formulir Penuh')
                            ->body("Formulir '{$this->form->title}' untuk tanggal $dateInfo ($sessionInfo) telah mencapai batas kuota.")
                            ->warning()
                            ->sendToDatabase($user);
                    }
                }
            }

             $this->successMessage = 'Formulir berhasil dikirim!';
             $this->dispatch('toast', type: 'success', message: 'Formulir berhasil dikirim!');

             if ($this->slug === 'pengajuan-isbn') {
                 return redirect()->route('dashboard')->with('success', 'Pengajuan ISBN berhasil dikirim! Silakan pantau perkembangannya di dashboard Anda.');
             }
         }
         $this->showForm = false;
         $this->editingSubmissionId = null;
         $this->revisionMode = false;
         $this->existingFilePaths = [];
         
         // Reset form data
         foreach ($this->form->fields as $field) {
             $this->data[$field['label']] = '';
         }

         // Reload submissions
         $this->loadMySubmissions();
    }

    // Update submit method logic to handle file uploads
    public function submit()
    {
        if (!$this->form) return;

        if ($this->slug === 'pengajuan-isbn') {
            $this->data['Surat Permohonan ISBN '] = $this->data['File'] ?? null;
        }

        $submission = $this->getExistingSubmission();
        $existingData = $submission ? ($submission->data ?? []) : [];

        [$rules, $messages] = $this->getValidationRulesAndMessages($existingData);
        $this->validate($rules, $messages);

        // Quota & Blocked Date Check
        $currentUsage = null;
        $requested = null;
        [$bookingDate, $sessionTime] = $this->getBookingDateAndSessionTime();

        if ($this->form->max_quota || $this->form->blockedDates()->count() > 0) {
            if (!$this->checkQuotaAndBlockedDates($bookingDate, $sessionTime, $currentUsage, $requested)) {
                return;
            }
        }

        // Flatten data structure to match labels exactly
        $submissionData = [];
        $extractedBookingDate = null;
        
        foreach ($this->form->fields as $field) {
            $value = data_get($this->data, $field['label']);

            // Handle file upload storage
            if ($field['type'] === 'file' && $value instanceof \Illuminate\Http\UploadedFile) {
                $path = $value->store('form_submissions', 'public');
                $submissionData[$field['label']] = $path;
            } else {
                $submissionData[$field['label']] = $value;
            }
            
            // Auto-detect booking date from date fields
            if ($field['type'] === 'date' && !$extractedBookingDate) {
                $extractedBookingDate = $value;
            }
        }

        // Use the extracted booking date if none was explicitly configured
        $finalBookingDate = $bookingDate ?? $extractedBookingDate;

        return $this->saveSubmission(
            $submissionData,
            $finalBookingDate,
            $submission,
            $existingData,
            $sessionTime,
            $currentUsage,
            $requested
        );
    }

    public function getSessionQuotas()
    {
        if (!$this->form || !$this->form->max_quota || !$this->form->booking_date_label || !$this->form->time_slot_label) {
            return [];
        }

        $bookingDate = $this->data[$this->form->booking_date_label] ?? null;
        if (!$bookingDate) {
            return [];
        }

        // Get the options for time slot label
        $timeSlotField = collect($this->form->fields)->first(function ($f) {
            return $f['label'] === $this->form->time_slot_label;
        });

        if (!$timeSlotField || empty($timeSlotField['options'])) {
            return [];
        }

        $sessions = [];
        $options = $timeSlotField['options'];
        if (is_string($options)) {
            $optionsArr = array_map('trim', explode(',', $options));
            $options = array_combine($optionsArr, $optionsArr);
        }

        $allSubmissions = FormSubmission::where('form_id', $this->form->id)
            ->where('status', '!=', 'rejected')
            ->whereDate('booking_date', $bookingDate)
            ->get();

        $timeSlotLabel = $this->form->time_slot_label;
        $quotaCountLabel = $this->form->quota_count_label;

        // Pre-calculate "Sehari Full" usage (these bookings count for ALL individual sessions)
        $fullDayUsed = $allSubmissions
            ->filter(fn($sub) => ($sub->data[$timeSlotLabel] ?? null) === 'Sehari Full')
            ->reduce(function (int $carry, $sub) use ($quotaCountLabel) {
                return $carry + (int) ($quotaCountLabel && isset($sub->data[$quotaCountLabel]) 
                    ? $sub->data[$quotaCountLabel] 
                    : 1);
            }, 0);

        // Collect individual session option keys (excluding Sehari Full)
        $individualOptions = collect($options)->reject(fn($lbl, $val) => $val === 'Sehari Full');

        foreach ($options as $optVal => $optLabel) {
            if ($optVal === 'Sehari Full') {
                // For "Sehari Full": take the MAX usage across all individual sessions + full-day bookings
                // If any session is full, Sehari Full is also full
                $worstRemaining = $this->form->max_quota;
                foreach ($individualOptions as $indVal => $indLbl) {
                    $indUsed = $allSubmissions
                        ->filter(fn($sub) => ($sub->data[$timeSlotLabel] ?? null) === $indVal)
                        ->reduce(function (int $carry, $sub) use ($quotaCountLabel) {
                            return $carry + (int) ($quotaCountLabel && isset($sub->data[$quotaCountLabel]) 
                                ? $sub->data[$quotaCountLabel] 
                                : 1);
                        }, 0);
                    $totalUsed = $indUsed + $fullDayUsed;
                    $remaining = max(0, $this->form->max_quota - $totalUsed);
                    $worstRemaining = min($worstRemaining, $remaining);
                }
                $sessions[] = [
                    'value' => $optVal,
                    'label' => $optLabel,
                    'used' => $this->form->max_quota - $worstRemaining,
                    'remaining' => $worstRemaining,
                    'is_full' => $worstRemaining <= 0,
                ];
            } else {
                // Individual session: own bookings + all "Sehari Full" bookings
                $sessionUsed = $allSubmissions
                    ->filter(fn($sub) => ($sub->data[$timeSlotLabel] ?? null) === $optVal)
                    ->reduce(function (int $carry, $sub) use ($quotaCountLabel) {
                        return $carry + (int) ($quotaCountLabel && isset($sub->data[$quotaCountLabel]) 
                            ? $sub->data[$quotaCountLabel] 
                            : 1);
                    }, 0);

                $totalUsed = $sessionUsed + $fullDayUsed;
                $remaining = max(0, $this->form->max_quota - $totalUsed);

                $sessions[] = [
                    'value' => $optVal,
                    'label' => $optLabel,
                    'used' => $totalUsed,
                    'remaining' => $remaining,
                    'is_full' => $remaining <= 0,
                ];
            }
        }

        return $sessions;
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'data.File') {
            $this->data['Surat Permohonan ISBN '] = $this->data['File'];
        }
    }

    public function render()
    {
        $layout = ($this->slug === 'pengajuan-isbn') ? 'layouts.app' : 'layouts.public';
        return view('livewire.front.dynamic-form')->layout($layout);
    }
}
