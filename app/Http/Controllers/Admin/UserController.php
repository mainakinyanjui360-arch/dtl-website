<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return Inertia::render('Admin/Users/Index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Users/Create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->is_super_admin) {
            return back()->with('error', 'Only super admins can create new users.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'is_super_admin' => 'boolean',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_super_admin' => $validated['is_super_admin'] ?? false,
            'permissions' => $validated['permissions'] ?? [],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Admin user created successfully.');
    }

    public function edit(User $user)
    {
        // Users can edit themselves. Super admins can edit anyone.
        if (auth()->id() !== $user->id && !auth()->user()->is_super_admin) {
            return back()->with('error', 'You are not authorized to edit this user.');
        }

        return Inertia::render('Admin/Users/Edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        if (auth()->id() !== $user->id && !auth()->user()->is_super_admin) {
            return back()->with('error', 'You are not authorized to edit this user.');
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8|confirmed';
        }

        // Only super admin can change super admin status (and not for themselves to avoid locking out)
        if (auth()->user()->is_super_admin && auth()->id() !== $user->id) {
            $rules['is_super_admin'] = 'boolean';
            $rules['permissions'] = 'nullable|array';
            $rules['permissions.*'] = 'string';
        }

        $validated = $request->validate($rules);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        if (isset($validated['is_super_admin'])) {
            $user->is_super_admin = $validated['is_super_admin'];
            
            // If they are made super admin, maybe clear specific permissions, but let's just save them
            if (isset($validated['permissions'])) {
                $user->permissions = $validated['permissions'];
            }
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Admin user updated successfully.');
    }

    public function destroy(User $user)
    {
        if (!auth()->user()->is_super_admin) {
            return back()->with('error', 'Only super admins can delete users.');
        }

        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Admin user deleted successfully.');
    }
}
