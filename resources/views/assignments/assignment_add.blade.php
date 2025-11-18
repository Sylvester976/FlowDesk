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
                                <label class="form-label required">City/Town</label>
                                <input type="text" class="form-control" name="city"
                                       placeholder="e.g., Nairobi, Kisumu" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-12 mt-3">
                                <label class="form-label required">Attachments</label>
                                <div id="dropArea" class="border border-dashed p-4 text-center" style="cursor: pointer;">
                                    <p>Drag & drop files here, or click to select files</p>
                                    <small class="form-text text-muted">
                                        Allowed formats: jpg, jpeg, png, pdf. Max size per file: 2 MB.
                                        Attachments can be nomination letter, air ticket, passport, receipts, etc.
                                    </small>
                                    <input type="file" id="attachments" name="attachments[]" multiple style="display:none;" required>
                                </div>
                            </div>

                            <div class="col-md-12 mt-2">
                                <ul id="attachmentList" class="list-group"></ul>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label required">Supervisor Name</label>
                                <input type="text" class="form-control" name="supervisor" placeholder="Enter your Supervisor's Name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Supervisor's Email</label>
                                <input class="form-control" id="emailInput" name="email"
                                       placeholder="Enter your email address" required type="email">
                                <small class="form-text" id="emailFeedback"></small>
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
    <script>
        const dropArea = document.getElementById('dropArea');
        const input = document.getElementById('attachments');
        const attachmentList = document.getElementById('attachmentList');

        const allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
        const maxSize = 2 * 1024 * 1024; // 2MB

        let filesArray = []; // Store selected files

        // Click on drop area opens file dialog
        dropArea.addEventListener('click', () => input.click());

        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, (e) => e.preventDefault());
            dropArea.addEventListener(eventName, (e) => e.stopPropagation());
        });

        // Highlight on dragover
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => dropArea.classList.add('bg-light'));
        });
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => dropArea.classList.remove('bg-light'));
        });

        // Handle dropped files
        dropArea.addEventListener('drop', handleFiles);
        input.addEventListener('change', handleFiles);

        function handleFiles(e) {
            const selectedFiles = e.target.files || e.dataTransfer.files;

            for (let file of selectedFiles) {
                const ext = file.name.split('.').pop().toLowerCase();

                if (!allowedExtensions.includes(ext)) {
                    alert(`File "${file.name}" has an invalid format.`);
                    continue; // skip invalid file
                }

                if (file.size > maxSize) {
                    alert(`File "${file.name}" exceeds the 2MB size limit.`);
                    continue; // skip large file
                }

                // Add file to array if not already added
                if (!filesArray.some(f => f.name === file.name && f.size === file.size)) {
                    filesArray.push(file);
                }
            }

            renderFiles();
        }

        function renderFiles() {
            attachmentList.innerHTML = '';

            filesArray.forEach((file, index) => {
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';

                // Icon based on file type
                const ext = file.name.split('.').pop().toLowerCase();
                const icon = document.createElement('span');
                icon.className = 'me-2';
                icon.innerHTML = (ext === 'pdf') ? '📄' : '🖼️';

                // Filename and size
                const text = document.createElement('span');
                text.textContent = `${file.name} (${(file.size / 1024).toFixed(2)} KB)`;

                // Remove button
                const removeBtn = document.createElement('button');
                removeBtn.className = 'btn btn-sm btn-danger';
                removeBtn.textContent = 'Remove';
                removeBtn.addEventListener('click', () => {
                    filesArray.splice(index, 1); // remove from array
                    renderFiles(); // re-render
                });

                li.appendChild(icon);
                li.appendChild(text);
                li.appendChild(removeBtn);
                attachmentList.appendChild(li);
            });

            // Update the input files (for form submission)
            const dataTransfer = new DataTransfer();
            filesArray.forEach(file => dataTransfer.items.add(file));
            input.files = dataTransfer.files;
        }
    </script>



@endsection

