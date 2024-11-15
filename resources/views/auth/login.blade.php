<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/main.css') }}">
    <title>Login</title>
</head>
<body>
    <div class="container-fluid">
        <main class="container-fluid">
            <form class="form-login box shadow rounded-5 mt-3 p-3" method="POST" action="{{ route('login') }}">
                <h2 class="label mt-3 font-weight-bold">Login</h2>
                @csrf
                <div class="input-login mx-3 my-4 ">
                    <label for="username" class="form-label">Username:</label>
                    <input type="username" class="form-control py-2 @error('username') is-invalid @enderror"
                    name="username" id="username" placeholder="Masukkan username...." autofocus required
                    value="{{ old ('username') }}">
                </div>
                <div class="input-password mx-3 my-4">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control py-2 @error('password') is-invalid @enderror" name="password"
                    id="password" placeholder="Masukkan kata sandi...." required
                    value="{{ old ('password') }}">
                </div>
                <button class="w-100 btn btn-lg text-white btn-login mb-3" style="background-color: rgb(63, 135, 75)" type="submit">Login</button>
                @if ($errors->any())
                    <div>{{ $errors->first('username') }}</div>
                @endif
                    
                <div class="container-fluid">
                    <button type="button" class="btn btn-outline-primary"><a href="{{ route('register') }}">Register</a></button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
