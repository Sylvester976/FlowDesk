@extends('layouts.base')
@section('main-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">All Employees</h2>
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
                        <table id="stafftable" class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>ID Number</th>
                                <th>Pf Number</th>
                                <th>Designation</th>
                                <th>status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($allUsers as $user)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$user->name}} {{$user->surname}} {{$user->other_names}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->idNumber}}</td>
                                    <td>{{$user->pfNumber}}</td>
                                    <td>{{$user->designation}}</td>
                                    <td>{{ strtoupper($user->status)}}</td>
                                    <td class="table-actions">
                                        <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">No employees found</td>
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
            const table = $('#stafftable').DataTable({
                dom: '<"d-flex justify-content-between align-items-center mb-2"Bf>rtip',
                buttons: [
                    {extend: 'copy', text: '<i class="fas fa-copy"></i> Copy'},
                    {extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV'},
                    {extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel'},
                    {extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF'},
                    {extend: 'print', text: '<i class="fas fa-print"></i> Print'}
                ],
            });

            // 🔽 Enable per-column filters
            $('#stafftable tfoot th').each(function () {
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


