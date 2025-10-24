<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Civil Tracker - Login</title>
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
                <h2 class="h2 text-center mb-4">Login to your account</h2>

                @if(isset($error))
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Login Failed',
                                text: '{{ $error }}',
                                confirmButtonColor: '#d33'
                            });
                        });
                    </script>
                @endif

                <form class="login-form" id="loginForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                               placeholder="Enter your Email Address" autocomplete="off" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">
                            Password
                            <span class="form-label-description"></span>
                        </label>
                        <div class="input-group input-group-flat">
                            <input type="password" class="form-control" id="password-field" name="password"
                                   placeholder="Your password" required>
                            <span class="input-group-text">
                                <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip"
                                   id="toggle-password">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                         class="icon icon-1">
                                      <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                      <path
                                          d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                    </svg>
                                </a>
                            </span>
                        </div>
                    </div>
                    @if (Route::has('password.request'))
                        <div class="d-flex mt-1 justify-content-between">
                            <h5 class="text-secondary f-w-400">
                                <a href="{{ route('password.request') }}" class="link-primary">Forgot Password?</a>
                            </h5>
                        </div>
                    @endif
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/tabler.min.js') }}"></script>
<script src="{{ asset('js/swal.js') }}"></script>
<script>
    document.getElementById("toggle-password").addEventListener("click", function (e) {
        e.preventDefault();
        const passwordInput = document.getElementById("password-field");
        const isPassword = passwordInput.type === "password";
        passwordInput.type = isPassword ? "text" : "password";
        this.title = isPassword ? "Hide password" : "Show password";
    });
</script>

<script>
    document.getElementById('loginForm').addEventListener('submit', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Processing...',
            text: 'Please wait while we log you in.',
            icon: 'info',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => Swal.showLoading()
        });

        const form = e.target;
        const formData = new FormData(form);
        const csrfToken = form.querySelector('[name="_token"]').value;

        fetch("{{ route('login') }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            body: formData
        })
            .then(async res => {
                let data;
                try {
                    data = await res.json();
                } catch {
                    throw new Error('Invalid JSON from server');
                }

                Swal.close();

                if (res.ok && data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Successful',
                        text: data.message
                    }).then(() => {
                        window.location.href = data.redirect_url; // Breeze redirect
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        text: data.message || 'Authentication failed. Please try again.'
                    });
                }
            })
            .catch(error => {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'A system error occurred. Please try again later.'
                });
                console.error(error);
            });
    });

</script>
</body>
</html>
