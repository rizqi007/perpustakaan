<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:superadmin']);
    }
    
    public function index(Request $request)
    {
        $query = User::query();
        
        // Filter by role
        if ($request->has('role') && in_array($request->role, ['user', 'admin', 'superadmin'])) {
            $query->where('role', $request->role);
        }
        
        // Search by name or email
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        $users = $query->latest()->paginate(15);
        
        $stats = [
            'total' => User::count(),
            'users' => User::where('role', 'user')->count(),
            'admins' => User::where('role', 'admin')->count(),
            'superadmins' => User::where('role', 'superadmin')->count(),
        ];
        
        return view('admin.users.index', compact('users', 'stats'));
    }
    
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:user,admin,superadmin',
        ]);
        
        $user = User::findOrFail($id);
        
        // Prevent changing own role
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat mengubah role Anda sendiri.');
        }
        
        $user->update(['role' => $request->role]);
        
        return back()->with('success', 'Role pengguna berhasil diubah.');
    }
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }
        
        $user->delete();
        
        return back()->with('success', 'Pengguna berhasil dihapus.');
    }
}
