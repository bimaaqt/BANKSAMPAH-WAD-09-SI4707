<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'level' => ['required', Rule::in(['bronze', 'silver', 'gold'])],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'level' => $validated['level'],
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'level' => ['required', Rule::in(['bronze', 'silver', 'gold'])],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->level = $validated['level'];
        
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }

    public function updateLevel(Request $request, User $user)
    {
        $validated = $request->validate([
            'level' => ['required', Rule::in(['bronze', 'silver', 'gold'])],
        ]);

        $user->level = $validated['level'];
        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('success', "Level user {$user->name} berhasil diubah menjadi " . ucfirst($validated['level']));
    }
} 