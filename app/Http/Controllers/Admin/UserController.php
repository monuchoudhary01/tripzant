<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        $roles = Role::where('slug', '!=', 'admin')->get();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'role' => 'required|string'
        ]);

        $roleModel = \App\Models\Role::where('slug', $request->role)->first();
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => \Hash::make($request->password),
            'role' => $request->role,
            'role_id' => $roleModel ? $roleModel->id : null,
            'status' => 'active',
            'agency_name' => $request->business_name,
            'company_name' => $request->business_name,
            'gst_number' => $request->gst_number,
            'created_by' => 'admin'
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    /**
     * List all users or pending requests
     */
    public function index(Request $request)
    {
        $query = User::where('role', '!=', User::ROLE_ADMIN);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%")
                  ->orWhere('agency_name', 'LIKE', "%{$search}%")
                  ->orWhere('company_name', 'LIKE', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Display the specified user profile
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::where('slug', '!=', 'admin')->get();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'phone' => 'required|string|max:20',
            'role' => 'required|string',
            'status' => 'required|string'
        ]);

        $roleModel = \App\Models\Role::where('slug', $request->role)->first();

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'role_id' => $roleModel ? $roleModel->id : null,
            'status' => $request->status,
            'agency_name' => $request->agency_name,
            'company_name' => $request->company_name,
            'gst_number' => $request->gst_number,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8']);
            $data['password'] = \Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Show pending signup requests
     */
    public function requests()
    {
        $users = User::where('status', 'pending')->latest()->get();
        return view('admin.users.requests', compact('users'));
    }

    /**
     * Approve a user request
     */
    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'active']);

        return back()->with('success', 'User approved successfully!');
    }

    /**
     * Reject a user request
     */
    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'rejected']);

        return back()->with('success', 'User request rejected.');
    }

    /**
     * Delete user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role === User::ROLE_ADMIN) {
            return back()->with('error', 'Main Admin cannot be deleted.');
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }
}
