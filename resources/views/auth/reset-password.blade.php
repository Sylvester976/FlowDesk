<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>NPCC || Reset Password</title>

    <link rel="icon" href="{{ asset('images/cos.ico') }}" type="image/x-icon">
    <link href="{{ asset('css/tabler.css') }}" rel="stylesheet"/>
</head>
<body>
<div class="page page-center">
    <div class="container container-tight py-4">
        <div class="text-center mb-4">
            <a href="/" class="navbar-brand">
                <img src="{{ asset('images/logo.png') }}" alt="NPCC Logo" height="48">
            </a>
        </div>

        <form id="resetPassword" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <input type="hidden" name="email" value="{{ $request->email }}">

            <div class="card my-5" style="width: 500px; max-width: 100%; margin: auto;">
                <div class="card-body">
                    <h3 class="mb-4"><b>Enter a new Password</b></h3>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group input-group-flat">
                            <input type="password" class="form-control" id="password-field" name="password"
                                   placeholder="Your password" required>
                            <span class="input-group-text" id="toggle-password">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     class="icon icon-1">
                                  <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                  <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                </svg>
                            </span>
                        </div>
                        <small class="form-text text-muted">
                            Must be at least 8 characters, include a capital letter, number, and symbol.
                        </small>
                        <div id="passwordStrength" class="mt-1"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <div class="input-group input-group-flat">
                            <input type="password" id="confirm_password" class="form-control"
                                   name="password_confirmation" placeholder="Confirm password" required>
                            <span class="input-group-text" id="toggleConfirmPassword">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     class="icon icon-1">
                                  <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                  <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                </svg>
                            </span>
                        </div>
                        <small id="matchMessage" class="form-text"></small>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('js/tabler.min.js') }}"></script>
<script src="{{ asset('js/swal.js') }}"></script>

<script>
    // Toggle visibility
    $('#toggle-password').on('click', function (e) {
        e.preventDefault();
        const input = $('#password-field');
        input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
    });

    $('#toggleConfirmPassword').on('click', function (e) {
        e.preventDefault();
        const input = $('#confirm_password');
        input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
    });

    // Password strength
    $('#password-field').on('input', function () {
        const password = $(this).val();
        const score = getPasswordStrength(password);
        const strengthDiv = $('#passwordStrength');
        const levels = ['danger', 'warning', 'info', 'primary', 'success'];
        const messages = ['Too weak', 'Weak', 'Moderate', 'Strong', 'Very strong'];
        strengthDiv.html(`
            <div class="progress">
                <div class="progress-bar bg-${levels[score]}" style="width: ${(score+1)*20}%"></div>
            </div>
            <small class="text-${levels[score]}">${messages[score]}</small>
        `);
    });

    function getPasswordStrength(password) {
        let score = 0;
        if (password.length >= 8) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/[0-9]/.test(password)) score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;
        return score;
    }

    // Password match
    $('#password-field, #confirm_password').on('input', function () {
        const p = $('#password-field').val();
        const c = $('#confirm_password').val();
        $('#matchMessage').text(p === c ? 'Passwords match' : 'Passwords do not match')
            .toggleClass('text-success', p === c)
            .toggleClass('text-danger', p !== c);
    });

    // Submit with swal
    // Submit with swal
    $('#resetPassword').on('submit', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Updating password...',
            text: 'Please wait.',
            icon: 'info',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => Swal.showLoading()
        });

        $.post("{{ route('password.store') }}", $(this).serialize()) 
            .done(function (data) {
                Swal.close();
                Swal.fire({
                    icon: 'success',
                    title: 'Password reset successfully',
                    text: 'You can now log in.'
                }).then(() => {
                    window.location.href = "{{ route('login') }}";
                });
            })
            .fail(function (xhr) {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON?.message || 'Something went wrong'
                });
            });
    });

</script>
</body>
</html>
