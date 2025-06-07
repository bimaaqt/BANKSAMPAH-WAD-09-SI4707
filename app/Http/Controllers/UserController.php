<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        try {
            if (!Auth::user()->isAdmin()) {
                return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }

            $users = User::where('role', '!=', 'admin')->get();
            return view('users.index', compact('users'));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengambil data users.');
        }
    }

    public function updateRole(Request $request, User $user)
    {
        try {
            if (!Auth::user()->isAdmin()) {
                return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }

            $validated = $request->validate([
                'role' => ['required', 'in:user,admin'],
                'level' => ['required', 'in:bronze,silver,gold'],
            ]);

            if ($user->role === 'admin') {
                return back()->with('error', 'Tidak dapat mengubah role admin.');
            }

            $user->update($validated);
            return redirect()->route('admin.users.index')->with('success', 'Role dan level user berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengupdate role user.');
        }
    }
} 