@extends('layouts.app')


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

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div>
            
                {{-- <div class="card-header">{{ __('Dashboard') }}</div> --}}


                {{-- <table class="table border" id="myTable">

                    <thead>
                        <th>Name</th>
                        <th>Email</th>
                    </thead>

                    <tbody>

                        @foreach ($users as $user)

                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            
                        @endforeach

                    </tbody>

                </table> --}}

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
            
                            {{-- <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong><i class="fa-solid fa-circle-info"></i> Before Syncing, Click Export DB to Backup the Data,
                                    Incase Data Syncing Fails!</strong>
                            </div>
             --}}
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="col-md-3">
                                    <label class="filter-label text-muted form-label">Filter by BOU: </label>
                                    <select class="filterBou" id="filterBou" name="bou">
                                        <option value="">All</option>
                                    </select>
                                </div>
                                {{-- <div class="mt-2">
                                    <button class="btn btn-danger text-light" id="exportLeaveDBBtn" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom" title="Export DB">
                                        <i class="fa-solid fa-database"></i> Export DB</button>
                                    <button class="btn btn-success text-light ms-2" id="exportLeaveReportBtn" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom" title="Export Record to CSV">
                                        <i class="fa fa-file-excel"></i> Export to CSV</button>
                                    <button class="btn btn-primary text-light ms-2" id="updateSyncSLVL">
                                        Sync SL/VL
                                    </button>
                                </div> --}}
                            </div>
            
                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <form id="leavesForm">
                                        <div class="table-responsive">
                                            <table class="table table-bordered w-100" id="manageBIR">
                                                <thead>
                                                    <tr>
                                                        <th class="text-white bg-primary text-center fw-bold">Employee ID</th>
                                                        <th class="text-white bg-primary text-center fw-bold">Employee Name</th>
                                                        <th class="text-white bg-primary text-center fw-bold">Cutoff</th>
                                                        <th class="text-white bg-primary text-center fw-bold">Basic Pay</th>
                                                    </tr>
                                                </thead>
            
                                                
                                                {{-- @foreach ($users as $user)
                        
                                                    <tr>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                    </tr>
                                                    
                                                @endforeach --}}

                                                {{-- @foreach ($bir1601s as $bir1601)
                                                    <tr>
                                                        <td>{{ $bir1601->empID }}</td>
                                                        <td>{{  $bir1601->user->name }}</td>
                                                        <td>
                                                        @if($bir1601->cutoff == 1)
                                                        1-15
                                                        @else
                                                            16-30
                                                        @endif
                                                        </td>
                                                    </tr>
                                                @endforeach --}}

                                                @foreach ($bir1601s as $bir1601)
                                                <tr class="main-row">
                                                    <!-- Insert a caret icon in the first column -->
                                                    <td class="expand-control">
                                                        <span class="caret-icon"><i class="fas fa-caret-down"></i></span>
                                                        {{ $bir1601->empID }}
                                                    </td>
                                                    <td>{{ $bir1601->user->name }}</td>
                                                    <td>
                                                        @if($bir1601->cutoff == 1)
                                                        1-15
                                                        @else
                                                        16-30
                                                        @endif
                                                    </td>
                                                    <td>{{ $bir1601->basic_pay }}</td>
                                                </tr>

                                                @endforeach
                        
                                            </tbody>
                                            </table>
                                            <tbody>
            
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                </div>
            
        </div>
    </div>
</div>
@endsection


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


    <!-- jQuery 3.7.1 JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Sweetalert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Filesaver and Excel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.4.0/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

    <!-- DataTables and DataTables Responsive JS -->
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.min.js"></script>

    <!-- Font Awesome 6.5 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"
        integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>




        $(document).ready(function() {



            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Initialize BOU
            // getBOUs('#filterBou');

            // Initialize select2 for select dropdowns
            initializeSelect2('#filterBou', null, "Select BOU");

            let manageLeavesTable = $('#manageBIR').DataTable({
                processing: true,
                responsive: true,
                // serverSide: true,
            //     ajax: {
            //         url: "",
            //         type: "GET",
            //     },
            //     columns: [{
            //             data: null,
            //             render: function(data, type, row, meta) {
            //                 return meta.row + 1;
            //             }
            //         },
            //         {
            //             data: 'emp_id'
            //         },
            //         {
            //             data: 'name'
            //         },
            //         {
            //             data: 'bou'
            //         },
            //         {
            //             data: 'vl_entitled',
            //             orderable: false,
            //         },
            //         {
            //             data: 'vl_earned',
            //             orderable: false,
            //         },
            //         {
            //             data: 'vl_usage',
            //             orderable: false,
            //         },
            //         {
            //             data: 'vl_balance',
            //             orderable: false,
            //         },
            //         {
            //             data: 'sl_entitled',
            //             orderable: false,
            //         },
            //         {
            //             data: 'sl_earned',
            //             orderable: false,
            //         },
            //         {
            //             data: 'sl_usage',
            //             orderable: false,
            //         },
            //         {
            //             data: 'sl_balance',
            //             orderable: false,
            //         },

            //     ],
            //     lengthMenu: [
            //         // [10, 25, 50, -1],
            //         // [10, 25, 50, "All"]
            //         [-1],
            //         ["All"]
            //     ],
            });


            // Initialize select2 for select dropdowns
            function initializeSelect2(element, dropdownParent = null, placeholder = "") {
                $(element).select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    dropdownParent,
                    placeholder
                });
            }

            // Function to get BOUs
            // function getBOUs(element) {
            //     $.ajax({
            //         type: "GET",
            //         url: "",
            //         dataType: "json",
            //         beforeSend: function() {
            //             $(element).empty();
            //             $(element).append('<option value="">Loading...</option>');
            //         },
            //         success: function(response) {
            //             $(element).empty();
            //             $(element).append('<option value="">Select BOU</option>');
            //             response.data.forEach(bou => {
            //                 $(element).append(
            //                     `<option value="${bou.bouID}">${bou.bouName}</option>`);
            //             });
            //         },
            //         error: function(error) {
            //             $(element).empty();
            //             $(element).append('<option value="">Failed to load BOUs</option>');
            //             $(element).prop('disabled', true);
            //         }
            //     });
            // }


        });
    </script>
