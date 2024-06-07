@extends('layouts.app')

<title>Your Page Title</title>
<!-- CSS CDN for DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
                    {{-- <div class="row"> --}}
                        <div class="col-md-12 mt-3">
                            <div class="table-responsive" style="width:100%">
                                <table id="myTable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Employee ID</th>
                                            <th>Employee Name</th>
                                            <th>Basic Pay</th>
                                            <th>Total Premium</th>
                                            <th>Total DMM</th>
                                            <th>Total E</th>
                                            <th>Total D</th>
                                            <th>Total Gross Pay Salary</th>
                                            <th>Tax</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bir1601s as $bir1601)
                                        <tr>
                                            <td><button class="toggle-details"><i class="fa fa-caret-down"></i></button></td>
                                            <td>{{ $bir1601->empID }}</td>
                                            <td>{{ $bir1601->user->name }}</td>
                                            <td>{{ $bir1601->basic_pay }}</td>
                                            <td>{{ $bir1601->total_premium }}</td>
                                            <td>{{ $bir1601->total_dmm }}</td>
                                            <td>{{ $bir1601->total_e }}</td>
                                            <td>{{ $bir1601->total_d }}</td>
                                            <td>{{ $bir1601->total_gross_pay_salary }}</td>
                                            <td>{{ $bir1601->tax }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    {{-- </div> --}}
                </div>

            </div>

        </div>    
    </div>
</div>
@endsection
<!-- JavaScript CDN for jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- JavaScript CDN for DataTables -->
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>

<!-- Font Awesome for the caret icon -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

<script>
$(document).ready(function() {
    var table = $('#myTable').DataTable({
        "columnDefs": [
            {
                "targets": [3, 4, 5, 6, 7, 8, 9], // Columns 4 to 10
                "visible": false // Hide these columns by default
            }
        ]
    });

    function format(rowData) {
        // Create a string with the hidden columns' data
        return `
            <table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">
                <tr>
                    <td>Basic Pay:</td>
                    <td>${rowData[3]}</td>
                </tr>
                <tr>
                    <td>Total Premium:</td>
                    <td>${rowData[4]}</td>
                </tr>
                <tr>
                    <td>Total DMM:</td>
                    <td>${rowData[5]}</td>
                </tr>
                <tr>
                    <td>Total E:</td>
                    <td>${rowData[6]}</td>
                </tr>
                <tr>
                    <td>Total D:</td>
                    <td>${rowData[7]}</td>
                </tr>
                <tr>
                    <td>Total Gross Pay Salary:</td>
                    <td>${rowData[8]}</td>
                </tr>
                <tr>
                    <td>Tax:</td>
                    <td>${rowData[9]}</td>
                </tr>
            </table>
        `;
    }

    // Handle button click to show/hide details rows
    $('#myTable tbody').on('click', 'button.toggle-details', function() {
        var tr = $(this).closest('tr');
        var row = table.row(tr);

        if (row.child.isShown()) {
            // Hide the details row
            row.child.hide();
            $(this).find('i').removeClass('fa-caret-up').addClass('fa-caret-down');
        } else {
            // Show the details row
            row.child(format(row.data())).show();
            $(this).find('i').removeClass('fa-caret-down').addClass('fa-caret-up');
        }
    });
});
</script>


