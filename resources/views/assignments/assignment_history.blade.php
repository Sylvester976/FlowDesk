@extends('layouts.base_staff')
@section('main-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Assignment History</h2>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">List of registered employees</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="assignmentsTable" class="table table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Assignment</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Country of Visit</th>
                                <th>status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($assignments as $assignment)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$assignment->assignment_name}}</td>
                                    <td>{{ \Carbon\Carbon::parse($assignment->start_date)->format('d-m-Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($assignment->end_date)->format('d-m-Y') }}</td>
                                    <td>{{ getCountryName($assignment->country_of_visit) }}</td>
                                    <td>
                                        @php
                                            $status = strtolower($assignment->status);
                                            $badgeClass = match($status) {
                                                'pending' => 'badge bg-warning',
                                                'approved' => 'badge bg-success',
                                                'rejected' => 'badge bg-danger',
                                                default => 'badge bg-secondary',
                                            };
                                        @endphp

                                        <span class="{{ $badgeClass }}">{{ strtoupper($assignment->status) }}</span>
                                    </td>
                                    <td class="table-actions">
                                        <!-- Edit button -->
                                        <a href="#" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>

                                        <!-- View More Info button -->
                                        <a href="#" class="btn btn-sm btn-outline-info" title="View More Info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">No employees found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
