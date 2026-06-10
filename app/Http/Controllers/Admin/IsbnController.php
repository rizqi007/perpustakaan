<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IsbnSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IsbnController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }
    
    public function index(Request $request)
    {
        $query = IsbnSubmission::with(['user', 'reviewer'])->latest();
        
        // Filter by status
        if ($request->has('status') && in_array($request->status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $request->status);
        }
        
        // Filter by user
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        // Filter by date range
        if ($request->has('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        $submissions = $query->paginate(15);
        $stats = [
            'total' => IsbnSubmission::count(),
            'pending' => IsbnSubmission::pending()->count(),
            'approved' => IsbnSubmission::approved()->count(),
            'rejected' => IsbnSubmission::rejected()->count(),
        ];
        
        return view('admin.isbn.index', compact('submissions', 'stats'));
    }
    
    public function show($id)
    {
        $submission = IsbnSubmission::with(['user', 'reviewer'])->findOrFail($id);
        
        return view('admin.isbn.show', compact('submission'));
    }
    
    public function approve($id)
    {
        $submission = IsbnSubmission::findOrFail($id);
        
        $submission->update([
            'status' => IsbnSubmission::STATUS_APPROVED,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);
        
        return back()->with('success', 'Pengajuan ISBN berhasil disetujui!');
    }
    
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string',
        ]);
        
        $submission = IsbnSubmission::findOrFail($id);
        
        $submission->update([
            'status' => IsbnSubmission::STATUS_REJECTED,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);
        
        return back()->with('success', 'Pengajuan ISBN ditolak.');
    }
    
    public function downloadFile($id)
    {
        $submission = IsbnSubmission::findOrFail($id);
        
        $filePath = 'isbn_submissions/' . $submission->file_path;
        
        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }
        
        return Storage::disk('public')->download($filePath, $submission->file_original_name);
    }
    
    public function updateNotes(Request $request, $id)
    {
        $request->validate([
            'admin_notes' => 'nullable|string',
        ]);
        
        $submission = IsbnSubmission::findOrFail($id);
        $submission->update(['admin_notes' => $request->admin_notes]);
        
        return back()->with('success', 'Catatan admin berhasil disimpan.');
    }
}
