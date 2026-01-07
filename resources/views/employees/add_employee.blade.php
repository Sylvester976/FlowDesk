@extends('layouts.base_hr')
@section('main-content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Add New Staff Member
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Staff Registration Form</h3>
                </div>
                <form id="registerForm" method="post">
                    <div class="card-body">
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label required">First Name</label>
                                <input type="text" class="form-control" name="first_name" placeholder="Enter first name"
                                       required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Surname</label>
                                <input type="text" class="form-control" name="surname" placeholder="Enter Surname"
                                       required>
                            </div>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="last_name"
                                       placeholder="Enter last name (optional)">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Identification Number</label>
                                <input type="number" class="form-control" name="idno" placeholder="e.g., 12345678">
                            </div>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input class="form-control" id="emailInput" name="email"
                                       placeholder="Enter your email address" required type="email">
                                <small class="form-text" id="emailFeedback"></small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" name="phone"
                                       placeholder="e.g., +254712345678 / 0712345678">
                            </div>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">PF Number</label>
                                <input type="number" class="form-control" name="upn" placeholder="e.g., 20211234567">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Designation</label>
                                <input type="text" class="form-control" name="designation" placeholder="e.g., SICTO">
                            </div>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label required">Date of Birth</label>
                                <input type="date" class="form-control" name="date_of_birth" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Date of Appointment</label>
                                <input type="date" class="form-control" name="date_of_appointment" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label required">Roles</label>
                                    <select class="form-control" name="role_id" required>
                                        <option value="">-- Select Role --</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="reset" class="btn btn-link">Clear</button>
                        <button type="submit" class="btn btn-primary">Add Staff</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('registerForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("{{ route('save_staff') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        notyf.success(data.message);
                        document.getElementById('registerForm').reset();

                        setTimeout(() => {
                            window.location.href = "{{ route('employees') }}";
                        }, 1500);

                    } else {
                        notyf.error(data.message);
                    }
                })
                .catch(() => {
                    notyf.error('Something went wrong. Try again later.');
                });
        });
    </script>
@endsection
