<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <title>Register</title>
</head>
<body>
    <div class="container-fluid">
        <main class="container-fluid">
            <form class="form-register box shadow rounded-5 mt-3 p-3" method="POST" action="{{ route('register') }}">
                <h2 class="label mt-3 font-weight-bold">Register</h2>
                @csrf
                <div class="input-username mx-3 my-4">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" class="form-control py-2 @error('username') is-invalid @enderror" 
                           name="username" placeholder="Masukkan username...." id="username" value="{{ old('username') }}" required>
                </div>
                <div class="input-email mx-3 my-4">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control py-2 @error('email') is-invalid @enderror" 
                           name="email" placeholder="Masukkan email...." id="email" value="{{ old('email') }}" required>
                </div>
                <div class="input-password mx-3 my-4">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control py-2 @error('password') is-invalid @enderror" 
                           name="password" placeholder="Masukkan kata sandi...." id="password" required>
                </div>
                <div class="input-password_confirmation mx-3 my-4">
                    <label for="password_confirmation" class="form-label">Confirm Password:</label>
                    <input type="password" class="form-control py-2 @error('password_confirmation') is-invalid @enderror" 
                           name="password_confirmation" placeholder="Masukkan kata sandi ulang...." id="password_confirmation" required>
                </div>
                <div class="mx-3 my-4">
                    <label for="role_status" class="form-label">Role:</label>
                    <select class="form-select" name="role_status" id="role_status" required>
                        <option selected>Choose...</option>
                        <option value="Administrasion">Administrasion</option>
                        <option value="Staff">Staff</option>
                    </select>
                </div>
                <div class="d-flex justify-content-between mx-3 my-4">
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">Back</a>
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
