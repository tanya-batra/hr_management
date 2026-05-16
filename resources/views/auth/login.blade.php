<!DOCTYPE html>
<html>
<head>
    <title>HR Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
        }
        .login-card {
            width:400px;
            background:white;
            padding:40px;
            border-radius:15px;
            box-shadow:0 10px 30px rgba(0,0,0,0.2);
        }
        .login-card h3 {
            text-align:center;
            margin-bottom:25px;
            font-weight:bold;
        }
        .form-control {
            height:45px;
        }
        .btn-login {
            height:45px;
            background:#4e73df;
            border:none;
        }
        .btn-login:hover {
            background:#2e59d9;
        }
    </style>
</head>
<body>

<div class="login-card">
    <h3> HR Login</h3>

    <!-- Display Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Display Error Message -->
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Display Validation Errors -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login.submit') }}">
        @csrf

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button class="btn btn-primary btn-login w-100">Login</button>
    </form>
</div>

</body>
</html>