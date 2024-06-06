@extends('layouts.app')

@section('content')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Font Awesome 6.5 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- DataTables and DataTables Responsive CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.dataTables.min.css">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        input[type="number"] {
            border: 1px solid #999 !important;
        }
    </style>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <div class="container">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-center fs-3">BIR 1601</h1>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <form action="{{ route('reports.bir1601') }}" method="GET">
                        <div class="table-responsive">
                            <table class="table table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th class="text-center">Report Name</th>
                                        <th class="text-center">Month</th>
                                        <th class="text-center">Year</th>
                                        <th class="text-center">BOU</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form action="{{ route('reports.bir1601') }}" method="GET">
                                        <tr>
                                            <td>BIR 1601</td>
                                            <td>
                                                <select id="month" name="month" class="form-control select2" required>
                                                    <option value="">Select Month</option>
                                                    @for ($m = 1; $m <= 12; $m++)
                                                        <option value="{{ $m }}">{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                                                    @endfor
                                                </select>
                                            </td>
                                            <td>
                                                <select id="year" name="year" class="form-control select2" required>
                                                    <option value="">Select Year</option>
                                                    @for ($y = date('Y'); $y >= 2000; $y--)
                                                        <option value="{{ $y }}">{{ $y }}</option>
                                                    @endfor
                                                </select>
                                            </td>
                                            <td>Sample BOU</td>
                                            <td class="text-center">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-file-alt"></i> Generate Report
                                                </button>
                                            </td>
                                        </tr>
                                    </form>

                                    <form action="{{ route('reports.bir1601plus') }}" method="GET">
                                        <tr>
                                            <td>BIR 1601 ++</td>
                                            <td>
                                                <select id="month" name="month" class="form-control select2" required>
                                                    <option value="">Select Month</option>
                                                    @for ($m = 1; $m <= 12; $m++)
                                                        <option value="{{ $m }}">{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                                                    @endfor
                                                </select>
                                            </td>
                                            <td>
                                                <select id="year" name="year" class="form-control select2" required>
                                                    <option value="">Select Year</option>
                                                    @for ($y = date('Y'); $y >= 2000; $y--)
                                                        <option value="{{ $y }}">{{ $y }}</option>
                                                    @endfor
                                                </select>
                                            </td>
                                            <td>Sample BOU</td>
                                            <td class="text-center">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-file-alt"></i> Generate Report
                                                </button>
                                            </td>
                                        </tr>
                                    </form>
                                </tbody>
                            </table>
                        </div>
                   
                </div>
            </div>
        </div>
    </div>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- jQuery 3.7.1 JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Sweetalert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- DataTables and DataTables Responsive JS -->
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.min.js"></script>

    <!-- Font Awesome 6.5 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5'
            });
        });
    </script>
@endsection
