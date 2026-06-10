<?php

namespace App\Services;

use App\Models\Anggota;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SlimsSyncService
{
    /**
     * Synchronize a member record to SLiMS.
     *
     * @param Anggota $anggota
     * @return void
     * @throws \Exception
     */
    public static function sync(Anggota $anggota)
    {
        if (!config('services.slims.enabled')) {
            Log::info("SLiMS integration is disabled in services configuration.");
            return;
        }

        if (empty($anggota->nip)) {
            Log::warning("Skipped SLiMS sync for Anggota ID {$anggota->id} because NIP is empty.");
            return;
        }

        try {
            $slimsDb = DB::connection('slims');

            // SLiMS uses 'member' table
            $exists = $slimsDb->table('member')
                ->where('member_id', $anggota->nip)
                ->exists();

            // Prepare common data fields mapped to SLiMS membership
            $slimsData = [
                'member_name'          => $anggota->nama,
                'gender'               => ($anggota->gender === 'Perempuan') ? 0 : 1,
                'birth_date'           => $anggota->birth_date ? $anggota->birth_date->format('Y-m-d') : '1990-01-01',
                'member_type_id'       => $anggota->member_type_id ?? (int) config('services.slims.default_member_type_id', 1),
                'member_address'       => $anggota->alamat ?? '',
                'member_mail_address'  => $anggota->alamat_surat ?? '',
                'postal_code'          => $anggota->kode_pos ?? '',
                'inst_name'            => $anggota->institusi ?? '',
                'member_phone'         => $anggota->no_hp ?? '',
                'member_fax'           => $anggota->no_faks ?? '',
                'member_email'         => $anggota->email ?? '',
                'member_since_date'    => $anggota->member_since_date ? $anggota->member_since_date->format('Y-m-d') : now()->format('Y-m-d'),
                'register_date'        => $anggota->register_date ? $anggota->register_date->format('Y-m-d') : now()->format('Y-m-d'),
                'expire_date'          => $anggota->expire_date ? $anggota->expire_date->format('Y-m-d') : now()->addYears((int) config('services.slims.duration_years', 1))->format('Y-m-d'),
                'member_notes'         => $anggota->catatan ?? '',
                'is_pending'           => $anggota->is_pending ? 1 : 0,
                'last_update'          => now(),
            ];

            if (!$exists) {
                // Determine membership variables
                $defaultPassword = config('services.slims.default_password', '12345678');
                $hashAlgo        = strtolower(config('services.slims.password_hash_algo', 'md5'));

                $hashedPassword = match ($hashAlgo) {
                    'md5'      => md5($defaultPassword),
                    'sha256'   => hash('sha256', $defaultPassword),
                    'bcrypt'   => password_hash($defaultPassword, PASSWORD_BCRYPT),
                    default    => $defaultPassword,
                };

                $slimsData['member_id']      = $anggota->nip;
                $slimsData['pin']            = $hashedPassword;
                $slimsData['input_date']     = now()->format('Y-m-d H:i:s');

                $slimsDb->table('member')->insert($slimsData);
                Log::info("Successfully synced NEW member ID '{$anggota->nip}' to SLiMS.");
            } else {
                // If it exists, update the member details
                $slimsDb->table('member')
                    ->where('member_id', $anggota->nip)
                    ->update($slimsData);
                Log::info("Successfully updated existing member ID '{$anggota->nip}' in SLiMS.");
            }
        } catch (\Exception $e) {
            Log::error("SLiMS Member Sync failed for ID '{$anggota->nip}': " . $e->getMessage());
            throw new \Exception("Gagal menyinkronkan data anggota ke database SLiMS: " . $e->getMessage());
        }
    }

    /**
     * Import/Synchronize all members from SLiMS to the local database.
     *
     * @return array Array containing counts of 'imported' and 'updated' records.
     * @throws \Exception
     */
    public static function importFromSlims(): array
    {
        try {
            $slimsDb = DB::connection('slims');

            // Fetch all members from SLiMS table
            $slimsMembers = $slimsDb->table('member')->get();

            $importedCount = 0;
            $updatedCount = 0;

            $baseUrl = config('services.slims.base_url');

            foreach ($slimsMembers as $slimsMember) {
                // If member_id (NIP) is empty, skip
                if (empty($slimsMember->member_id)) {
                    continue;
                }

                // Determine gender
                $gender = ((int) $slimsMember->gender === 0) ? 'Perempuan' : 'Laki-laki';

                // Parse dates
                $birthDate = $slimsMember->birth_date && $slimsMember->birth_date !== '0000-00-00' ? $slimsMember->birth_date : null;
                $memberSinceDate = $slimsMember->member_since_date && $slimsMember->member_since_date !== '0000-00-00' ? $slimsMember->member_since_date : null;
                $registerDate = $slimsMember->register_date && $slimsMember->register_date !== '0000-00-00' ? $slimsMember->register_date : null;
                $expireDate = $slimsMember->expire_date && $slimsMember->expire_date !== '0000-00-00' ? $slimsMember->expire_date : null;

                // Handle member photo download
                $localFotoPath = null;
                if (!empty($slimsMember->member_image)) {
                    $potentialPath = 'anggota-fotos/' . $slimsMember->member_image;

                    if (Storage::disk('public')->exists($potentialPath)) {
                        $localFotoPath = $potentialPath;
                    } elseif (!empty($baseUrl)) {
                        try {
                            $imageUrl = rtrim($baseUrl, '/') . '/images/persons/' . $slimsMember->member_image;

                            // Fetch the image from SLiMS URL (5s timeout to prevent hanging)
                            $response = Http::withoutVerifying()->timeout(5)->get($imageUrl);

                            if ($response->successful()) {
                                Storage::disk('public')->put($potentialPath, $response->body());
                                $localFotoPath = $potentialPath;
                            } else {
                                Log::warning("Failed to download SLiMS photo from URL: {$imageUrl}. HTTP Status: " . $response->status());
                            }
                        } catch (\Exception $e) {
                            Log::warning("Exception while downloading SLiMS photo for member {$slimsMember->member_id}: " . $e->getMessage());
                        }
                    }
                }

                $data = [
                    'nama' => $slimsMember->member_name ?? '',
                    'gender' => $gender,
                    'birth_date' => $birthDate,
                    'member_type_id' => $slimsMember->member_type_id ?? 1,
                    'alamat' => $slimsMember->member_address ?? '',
                    'alamat_surat' => $slimsMember->member_mail_address ?? '',
                    'kode_pos' => $slimsMember->postal_code ?? '',
                    'email' => $slimsMember->member_email ?? '',
                    'no_hp' => $slimsMember->member_phone ?? '',
                    'no_faks' => $slimsMember->member_fax ?? '',
                    'institusi' => $slimsMember->inst_name ?? '',
                    'foto' => $localFotoPath,
                    'member_since_date' => $memberSinceDate,
                    'register_date' => $registerDate,
                    'expire_date' => $expireDate,
                    'catatan' => $slimsMember->member_notes ?? '',
                    'status' => 'approved',
                    'approved_at' => now(),
                    'is_pending' => (bool) ($slimsMember->is_pending ?? false),
                ];

                // Check if already exists locally
                $localMember = Anggota::where('nip', $slimsMember->member_id)->first();

                if ($localMember) {
                    // Update existing (without events to prevent loop syncing back to SLiMS)
                    Anggota::withoutEvents(function () use ($localMember, $data) {
                        $localMember->update($data);
                    });
                    $updatedCount++;
                } else {
                    // Create new (without events)
                    $data['nip'] = $slimsMember->member_id;
                    Anggota::withoutEvents(function () use ($data) {
                        Anggota::create($data);
                    });
                    $importedCount++;
                }
            }

            return [
                'imported' => $importedCount,
                'updated' => $updatedCount,
            ];
        } catch (\Exception $e) {
            Log::error("SLiMS Import failed: " . $e->getMessage());
            throw new \Exception("Gagal menarik data dari database SLiMS: " . $e->getMessage());
        }
    }
}

