<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Civil Tracker - Forgot Password</title>
    <link rel="icon" href="{{ asset('images/cos.ico') }}" type="image/x-icon">
    <link href="{{ asset('css/tabler.css') }}" rel="stylesheet"/>
</head>
<body>
<div class="page page-center">
    <div class="container container-tight py-4">
        <div class="text-center mb-4">
            <a href="{{ url('/') }}" class="navbar-brand">
                <img src="{{ asset('images/logo.png') }}" alt="MOICDE Logo" height="48">
            </a>
        </div>

        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">Forgot your password?</h2>
                <p class="text-muted text-center mb-4">
                    Enter your email and we'll send you a password reset link.
                </p>

                <!-- Status Message -->
                @if (session('status'))
                    <div class="alert alert-success text-center">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Forgot Password Form -->
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input id="email" type="email" name="email" class="form-control" placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">
                            Email Password Reset Link
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="text-center text-muted mt-3">
            <a href="{{ route('login') }}">Back to login</a>
        </div>
    </div>
</div>

<script src="{{ asset('js/tabler.min.js') }}"></script>
</body>
</html>
