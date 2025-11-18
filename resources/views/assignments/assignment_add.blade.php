@extends('layouts.base_staff')
@section('main-content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Add New Assignment
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Assignment Form</h3>
                </div>
                <form id="registerForm" method="post">
                    <div class="card-body">
                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label class="form-label required">Name of Assignment</label>
                                <input type="text" class="form-control" name="assignment_name" placeholder="Enter the name of assignment"
                                       required>
                            </div>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label required">Country of Visit</label>
                                <select id="country_of_visit" name="country_of_visit" class="form-control" required>
                                    <option value="">Select your country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6" id="county-wrapper" style="display: none;">
                                <label class="form-label required">County</label>
                                <select id="county" name="county" class="form-control">
                                    <option value="">Select county</option>
                                    @foreach($counties as $county)
                                        <option value="{{ $county->id }}">{{ $county->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6" id="subcounty-wrapper" style="display: none;">
                                <label class="form-label required">Subcounty</label>
                                <select id="subcounty" name="subcounty" class="form-control">
                                    <option value="">Select subcounty</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">City/Town</label>
                                <input type="text" class="form-control" name="city"
                                       placeholder="e.g., Nairobi, Kisumu">
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
    <script src="{{ asset ('js/jquery-3.7.1.min.js') }}"></script>
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
    <script>
        $(document).ready(function() {
            $('#country_of_visit').on('change', function() {
                if ($(this).val() == 87) {
                    $('#county-wrapper').show();
                } else {
                    $('#county-wrapper').hide();
                    $('#subcounty-wrapper').hide();
                    $('#county').val(null).trigger('change');
                    $('#subcounty').val(null).trigger('change');
                }
            });

            $('#county').on('change', function() {
                var countyId = $(this).val();
                if(countyId) {
                    $.ajax({
                        url: '/subcounties/' + countyId,
                        type: 'GET',
                        success: function(data) {
                            $('#subcounty').empty().append('<option value="">Select subcounty</option>');
                            data.forEach(function(subcounty) {
                                $('#subcounty').append('<option value="'+subcounty.id+'">'+subcounty.name+'</option>');
                            });
                            $('#subcounty-wrapper').show();
                        }
                    });
                } else {
                    $('#subcounty-wrapper').hide();
                    $('#subcounty').val(null).trigger('change');
                }
            });
        });
    </script>
@endsection

