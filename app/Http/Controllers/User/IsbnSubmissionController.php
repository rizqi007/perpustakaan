<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\IsbnSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IsbnSubmissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $query = auth()->user()->isbnSubmissions()->latest();
        
        // Filter by status if provided
        if ($request->has('status') && in_array($request->status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $request->status);
        }
        
        $submissions = $query->paginate(10);
        
        return view('user.isbn.index', compact('submissions'));
    }
    
    public function create()
    {
        return view('user.isbn.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'publication_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'isbn' => 'nullable|string|max:20',
            'pages' => 'nullable|integer|min:1',
            'language' => 'required|string|max:50',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf|max:10240', // 10MB max
        ]);
        
        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $fileName = time() . '_' . $originalName;
            $filePath = $file->storeAs('isbn_submissions', $fileName, 'public');
            
            $validated['file_path'] = $fileName;
            $validated['file_original_name'] = $originalName;
        }
        
        $validated['user_id'] = auth()->id();
        $validated['status'] = IsbnSubmission::STATUS_PENDING;
        
        IsbnSubmission::create($validated);
        
        return redirect()->route('isbn.index')->with('success', 'Pengajuan ISBN berhasil dikirim!');
    }
    
    public function show($id)
    {
        $submission = auth()->user()->isbnSubmissions()->findOrFail($id);
        
        return view('user.isbn.show', compact('submission'));
    }
    
    public function destroy($id)
    {
        $submission = auth()->user()->isbnSubmissions()->findOrFail($id);
        
        // Only allow deletion of pending submissions
        if ($submission->status !== IsbnSubmission::STATUS_PENDING) {
            return back()->with('error', 'Hanya pengajuan yang berstatus pending yang dapat dihapus.');
        }
        
        // Delete file
        if ($submission->file_path) {
            Storage::disk('public')->delete('isbn_submissions/' . $submission->file_path);
        }
        
        $submission->delete();
        
        return redirect()->route('isbn.index')->with('success', 'Pengajuan berhasil dihapus.');
    }
}
