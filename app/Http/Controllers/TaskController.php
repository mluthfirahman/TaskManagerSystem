<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TaskController extends Controller
{
    // Middleware to check if the user is authenticated
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Display the dashboard with tasks and users
    public function index()
    {
        $user = auth()->user();
        $role = $user->role->nama;

        // Filter tasks based on the role
        $tasks = $role === 'Administrasion'
            ? Task::all() // Admin can see all tasks
            : Task::where('assigned_to', $user->id)->get(); // Staff/user can see only their assigned tasks

        $users = $role === 'Administrasion' ? User::all() : null;

        return view('dashboard', compact('tasks', 'users', 'role'));
    }

    // Show additional user information and tasks on the dashboard
    public function index1()
    {
        $userName = auth()->user()->username;
        $userRole = auth()->user()->role;

        $tasks = auth()->user()->id_role == 1
            ? Task::all()
            : Task::where('assigned_to', auth()->id())->get();

        return view('dashboard', compact('tasks', 'userName', 'userRole'));
    }

    // Display form to add a new task
    public function create()
    {
        $users = User::all();
        return view('tasks.create', compact('users')); // Adjust view path as needed
    }

    // Store a new task
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'assigned_to' => 'nullable|exists:users,id', // Ensure the selected user exists in the users table
        ]);

        // Create the new task
        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'pending', // Default status
            'assigned_to' => $request->assigned_to, // Set assigned user
            'user_id' => auth()->id(), // Assuming the logged-in user is creating the task
        ]);

        return redirect()->route('dashboard')->with('success', 'Task created successfully!');
    }


    // Mark a task as complete
    public function complete($id)
    {
        $task = Task::findOrFail($id);

        // Ensure only the assigned user or an admin can mark the task as complete
        if (Auth::user()->id != $task->assigned_to && Auth::user()->role_id != 1) {
            return back()->with('error', 'You are not authorized to complete this task.');
        }        

        // Check if the task is already completed
        if ($task->status == 'completed') {
            return back()->with('error', 'This task is already completed.');
        }

        // Mark the task as completed
        $task->status = 'completed';
        $task->save();

        return redirect()->route('dashboard')->with('success', 'Task marked as completed!');
    }

    // Delete a task
    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        // Ensure only an admin can delete a task
        if (Auth::user()->id_role != 1) {
            return back()->with('error', 'You are not authorized to delete this task.');
        }

        $task->delete();

        return redirect()->route('dashboard')->with('success', 'Task deleted successfully!');
    }
}

