<?php

namespace App\Http\Controllers;
use App\Http\Controllers\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin; // Make sure to import the Admin model

class AdminController extends Controller
{
    // Show the admin dashboard
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    
    // Show the form to create a new admin
    public function create()
    {
        return view('admin.register');
    }

    // Store a new admin in the database
    public function store(Request $request)
    {
        // Validate the incoming request data
                $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8',
        ]);

        // Create a new admin instance
        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->save();

        // Redirect back with a success message
        return redirect()->route('admin.dashboard')->with('success', 'Admin created successfully.');
    }

    // Show the form to edit an existing admin
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.edit', compact('admin'));
    }

    // Update an existing admin in the database
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:admins,email,'.$id,
            'password' => 'nullable|string|min:8',
        ]);

        // Find the admin by ID
        $admin = Admin::findOrFail($id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        // Update password only if provided
        if ($request->password) {
            $admin->password = bcrypt($request->password);
        }
        $admin->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Admin updated successfully.');
    }

    // Delete an existing admin from the database
   
    public function destroy(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
