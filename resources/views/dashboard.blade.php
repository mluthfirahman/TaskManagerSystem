<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.15/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body>
    <div class="mx-auto">    
        <nav class="navbar navbar-light" style="background-color: rgb(63, 135, 75)">
            <h1><a class="navbar-brand m-5 text-white" style="font-size: 80%; display: center; font-weight: 700; 
            font-size:64px" href="#">Task Manager</a></h1>
        </nav>
    </div>

    <div class="container mt-5">
        @if(auth()->check())
            <p style="font-size:20px">Welcome, {{ auth()->user()->username }}! You are logged in as {{ auth()->user()->role->nama }}.</p>

            <!-- Logout Form -->
            <form action="{{ route('logout') }}" method="POST" class="mb-3">
                @csrf
                <button type="submit" class="btn btn-primary">Logout</button>
            </form>
    
            <!-- Task Table -->
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Status</th>
                        @if(auth()->user()->role->nama === 'Administrasion' || auth()->user()->role->nama === 'Staff')
                            <th scope="col">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        <tr>
                            <th scope="row">{{ $task->id }}</th>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->description }}</td>
                            <td>{{ $task->status == 'completed' ? 'Completed' : 'Pending' }}</td>
                            <td>
                                @if($task->assigned_to == auth()->user()->id)
                                    <form id="completeForm{{ $task->id }}" action="{{ route('tasks.complete', $task->id) }}
                                        " method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" class="btn btn-success btn-sm" 
                                                {{ $task->status == 'completed' ? 'disabled' : '' }} 
                                                onclick="confirmComplete({{ $task->id }})">
                                            Complete
                                        </button>
                                    </form>
                                @endif
                                @if(auth()->user()->role->nama == 'Administrasion')
                                    <!-- Delete Button for Admin -->
                                    <form id="deleteForm{{ $task->id }}" action="{{ route('tasks.destroy', $task->id) }}
                                        " method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $task->id }})
                                        ">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    
            <!-- Only Admin Can Add New Tasks -->
            @if(auth()->user()->role->nama === 'Administrasion')
                <h2 class="mt-4">Create a New Task</h2>
                
                <!-- Task Creation Form with Confirmation -->
                <form id="taskCreateForm" action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title:</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description:</label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="assigned_to" class="form-label">Assign to:</label>
                        <select name="assigned_to" class="form-select">
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->username }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Button to trigger SweetAlert -->
                    <button type="button" class="btn btn-primary" onclick="confirmTaskCreate()">Create Task</button>
                </form>
            @endif
        @else
            <p>You are not logged in. Please <a href="{{ route('login') }}">login</a> to access the dashboard.</p>
        @endif
    </div>
            
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.15/dist/sweetalert2.min.js"></script>

    <script>
    // Confirmation for task creation
    function confirmTaskCreate() {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to create this task?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, create it!',
            cancelButtonText: 'No, cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form if confirmed
                document.getElementById('taskCreateForm').submit();
            }
        });
    }

    // Confirmation for task deletion
    function confirmDelete(taskId) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this task!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm' + taskId).submit();
            }
        });
    }

    // Confirmation for task completion
    function confirmComplete(taskId) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to mark this task as completed?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, complete it!',
            cancelButtonText: 'No, keep it pending',
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form if confirmed
                document.querySelector('form[action="{{ route('tasks.complete', '') }}/' + taskId + '"]').submit();
            }
        });
    }
    </script>

<script>
    // Confirmation for task completion
    function confirmComplete(taskId) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to mark this task as completed?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, complete it!',
            cancelButtonText: 'No, keep it pending',
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form if confirmed
                document.getElementById('completeForm' + taskId).submit();
            }
        });
    }
</script>
</body>
</html>
