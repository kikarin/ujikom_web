<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:user,admin',
        ]);

        User::create($validatedData);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registerStore(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // Default role adalah 'user'
        $validatedData['role'] = 'user';

        User::create($validatedData);


        return redirect()->route('login')->with('success', 'User registered successfully. Please log in.');
    }

    public function login()
{
    return view('auth.login');
}

public function loginStore(Request $request)
{
    $user = User::where('email', $request->email)
               ->where('password', $request->password)
               ->first();

    if ($user) {
        Auth::login($user);
        if ($user->role === 'admin') {
            return redirect()->route('dashboard.index')->with('success', 'Welcome Admin!');
        }
        return redirect()->route('home')->with('success', 'Login successful.');
    }

     // Log activity
     Log::info('User logged in: ' . $user->name . ' (' . $user->email . ')');

    return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
}


    public function logout()
    {
        $user = Auth::user();
        Log::info('User logged out: ' . $user->name . ' (' . $user->email . ')');
        Auth::logout();
        
        return redirect()->route('login')->with('success', 'Logout successful.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
    

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|required|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|min:6',
            'role' => 'sometimes|required|in:user,admin',
        ]);

        $user->update($validatedData);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('users.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = Auth::user();

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
            ]);

            $user->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Profile Update Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile: ' . $e->getMessage()
            ], 500);
        }
    }

}

