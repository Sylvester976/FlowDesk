@extends('layouts.base')
@section('main-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Assignments for each individual</h2>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-lg-12">

            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom-0 d-flex align-items-center">
                    <h5 class="mb-0 fw-semibold text-primary">
                        <i class="fas fa-users me-2 text-secondary"></i>List of Active staff with history of their Assignments
                    </h5>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="assignmentsTable" class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted">
                            <tr>
                                <th class="text-center">#</th>
                                <th>Name</th>
                                <th>Personal Number</th>
                                <th>Current Assignment</th>
                                <th>End Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>

                            <tbody>
                            @forelse($all_users as $active_assignment)
                                <tr>
                                    <td class="text-center fw-bold">{{ $loop->iteration }}</td>

                                    <td class="fw-semibold text-dark">
                                        {{ $active_assignment['name'] }}
                                    </td>

                                    <td>
                                    <span class="badge bg-light text-dark px-3 py-2">
                                        {{ $active_assignment['pfNumber'] }}
                                    </span>
                                    </td>

                                    <td>
                                    <span class="badge bg-light text-dark px-3 py-2">
                                        {{ $active_assignment['current_assignment'] }}
                                    </span>
                                    </td>

                                    <td>
                                        {{ $active_assignment['end_date'] }}
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- View -->
                                            <a href="{{ route('view.assignment', ['id' => $active_assignment['id']]) }}"
                                               class="btn btn-sm btn-outline-info rounded-pill px-3"
                                               data-bs-toggle="tooltip" title="View Assignments">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="fas fa-info-circle me-1"></i>No employees found
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Optional: Enable tooltips -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const table = $('#assignmentsTable').DataTable({
                dom: '<"d-flex justify-content-between align-items-center mb-2"Bf>rtip',
                buttons: [
                    {extend: 'copy', text: '<i class="fas fa-copy"></i> Copy'},
                    {extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV'},
                    {extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel'},
                    {extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF'},
                    {extend: 'print', text: '<i class="fas fa-print"></i> Print'}
                ],
                order: [[15, 'desc']]
            });

            // 🔽 Enable per-column filters
            $('#assignmentsTable tfoot th').each(function () {
                const input = $(this).find('input');
                if (input.length) {
                    $(input).on('keyup change', function () {
                        if (table.column($(this).parent().index()).search() !== this.value) {
                            table.column($(this).parent().index()).search(this.value).draw();
                        }
                    });
                }
            });

        });


    </script>
@endsection
