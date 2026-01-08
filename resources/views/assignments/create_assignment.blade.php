@extends('layouts.base')
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
                <form id="assignmentForm" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label class="form-label required">Reasons for Travelling</label>
                                <select id="travel_reason" name="travel_type" class="form-control" required>
                                    <option value="">Select your reason for travelling</option>
                                    <option value="1">OFFICIAL</option>
                                    <option value="2">PERSONAL</option>
                                </select>
                            </div>
                        </div>

                        <!-- LEAVE QUESTION (PERSONAL ONLY) -->
                        <div class="row g-3 mb-4 d-none" id="leaveSection">
                            <div class="col-md-12">
                                <label class="form-label required">Have you applied for leave?</label>
                                <select id="leaveApplied" class="form-control" >
                                    <option value="">Select</option>
                                    <option value="YES">YES</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>

                        <!-- WRITE UP -->
                        <div class="row g-3 mb-4 d-none" id="writeUpSection">
                            <div class="col-md-12">
                                <label class="form-label required" id="writeUpLabel">Reason for Travelling</label>
                                <textarea class="form-control" id="assignment_textarea" name="assignment_name"
                                          rows="4" placeholder=""></textarea>
                            </div>
                        </div>

                        <!-- ATTACHMENTS -->
                        <div class="row g-3 mb-4 d-none" id="attachmentSection">
                            <div class="col-md-12">
                                <label class="form-label required" id="attachmentLabel">Attachments</label>
                                <div id="dropArea" class="border border-dashed p-4 text-center" style="cursor:pointer;">
                                    <p>Drag & drop files here, or click to select files</p>
                                    <small class="form-text text-muted" id="attachmentHelp"></small>
                                    <input type="file" id="attachments" name="attachments[]" multiple style="display:none;">
                                </div>
                            </div>

                            <div class="col-md-12 mt-2">
                                <ul id="attachmentList" class="list-group"></ul>
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
                        @php
                            $sixMonthsAgo = date('Y-m-d', strtotime('-6 months'));
                        @endphp
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label required">Start Date of Assignment</label>
                                <input type="date" class="form-control" name="start" required min="{{ $sixMonthsAgo }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">End Date of Assignment</label>
                                <input type="date" class="form-control" name="end" required min="{{ $sixMonthsAgo }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="reset" class="btn btn-link">Clear</button>
                        <button type="submit" class="btn btn-primary">Save Assignment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset ('js/jquery-3.7.1.min.js') }}"></script>
    <script>
        document.getElementById('assignmentForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const form = this;
            const submitBtn = form.querySelector('button[type="submit"]');
            const formData = new FormData(form);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // 🔵 Disable submit button
            submitBtn.disabled = true;

            // 🔵 Show persistent processing message
            const processingNotification = notyf.open({
                type: 'info',
                message: 'Submitting request, please wait...',
                duration: 0, // stays until dismissed
                ripple: false,
                dismissible: false
            });

            fetch("{{ route('save_assignment') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    notyf.dismiss(processingNotification);

                    if (data.status === 'success') {
                        notyf.success(data.message);
                        form.reset();

                        setTimeout(() => {
                            window.location.href = "{{ route('assignHistory') }}";
                        }, 1500);
                    } else {
                        submitBtn.disabled = false;
                        notyf.error(data.message);
                    }
                })
                .catch(() => {
                    notyf.dismiss(processingNotification);
                    submitBtn.disabled = false;
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
    <script>
        document.getElementById('travel_reason').addEventListener('change', function () {
            resetSections();

            if (this.value === '1') {
                showOfficial();
            }

            if (this.value === '2') {
                document.getElementById('leaveSection').classList.remove('d-none');
            }
        });

        document.getElementById('leaveApplied').addEventListener('change', function () {
            if (this.value === 'NO') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Leave Required',
                    text: 'Please apply for leave first and ensure it is approved before submitting this request.',
                    confirmButtonText: 'Okay'
                }).then(() => {
                    location.reload();
                });
                return;
            }

            if (this.value === 'YES') {
                showPersonal();
            }
        });

        function showOfficial() {
            document.getElementById('writeUpLabel').innerText = 'Reason for Travelling';
            document.getElementById('assignment_textarea').placeholder =
                'Provide a brief write-up and attach the memo or any official supporting documents.';

            document.getElementById('attachmentLabel').innerText = 'Attach Official Documents';
            document.getElementById('attachmentHelp').innerText =
                'Attach memo, official approval, invitation letter or any supporting official documents.';

            showWriteUpAndAttachments();
        }

        function showPersonal() {
            document.getElementById('writeUpLabel').innerText = 'Personal Travel Justification';
            document.getElementById('assignment_textarea').placeholder =
                'Provide a brief write-up and attach approved leave or any relevant documents.';

            document.getElementById('attachmentLabel').innerText = 'Attach Leave Documents';
            document.getElementById('attachmentHelp').innerText =
                'Attach approved leave form or any other relevant documents.';

            showWriteUpAndAttachments();
        }

        function showWriteUpAndAttachments() {
            document.getElementById('writeUpSection').classList.remove('d-none');
            document.getElementById('attachmentSection').classList.remove('d-none');

            document.getElementById('assignment_textarea').required = true;
            document.getElementById('attachments').required = true;
        }

        function resetSections() {
            document.getElementById('leaveSection').classList.add('d-none');
            document.getElementById('writeUpSection').classList.add('d-none');
            document.getElementById('attachmentSection').classList.add('d-none');

            document.getElementById('assignment_textarea').required = false;
            document.getElementById('attachments').required = false;
        }
    </script>




@endsection

