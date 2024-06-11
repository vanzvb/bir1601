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
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex justify-content-between align-items-center">Parameter {{ $month }} , {{ $year }}</div>
                            {{-- <div>BOU : {{ $bouID }}</div> --}}
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <form id="leavesForm">
                                    <div class="table-responsive" style="width:100%">
                                        <table id="manageBIR" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>TIN</th>
                                                    <th>Employee ID</th>
                                                    <th>Employee Name</th>
                                                    <th>BOU</th>
                                                    <th>Basic Pay(1-15)</th>
                                                    <th>Basic Pay(16-31)</th>
                                                    <th>Tot Basic Pay</th>
                                                    <th>Premium(1-15)</th>
                                                    <th>Premium(16-31)</th>
                                                    <th>Total Premium</th>
                                                    <th>DMM(1-15)</th>
                                                    <th>DMM(16-31)</th>
                                                    <th>Tot DMM</th>
                                                    <th>Proj Exp(1-15)</th>
                                                    <th>Proj Exp(16-31)</th>
                                                    <th>Tot Proj Exp</th>
                                                    <th>Deduction(1-15)</th>
                                                    <th>Deduction(16-31)</th>
                                                    <th>Tot Deduction</th>
                                                    <th>Gross Pay(1-15)</th>
                                                    <th>Gross Pay(16-31)</th>
                                                    <th>Tot Gross Pay</th>
                                                    <th>Tax(1-15)</th>
                                                    <th>Tax(16-31)</th>
                                                    <th>Tax</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($pre_bir_1601s as $pre_bir_1601)
                                                <tr>
                                                    <td><button type="button" class="toggle-details"><i class="fa fa-caret-down"></i></button></td>
                                                    <td>{{ $pre_bir_1601->tin }}</td>
                                                    <td>{{ $pre_bir_1601->empID }}</td>
                                                    <td>{{ $pre_bir_1601->user->name }}</td>
                                                    <td>{{ $pre_bir_1601->companyBou->bouName }}</td>
                                                    <td>{{ $pre_bir_1601->basic_pay_first }}</td>
                                                    <td>{{ $pre_bir_1601->basic_pay_second }}</td>
                                                    <td>{{ $pre_bir_1601->basic_pay_total }}</td>
                                                    <td>{{ $pre_bir_1601->premium_first }}</td>
                                                    <td>{{ $pre_bir_1601->premium_second }}</td>
                                                    <td>{{ $pre_bir_1601->tot_premium }}</td>
                                                    <td>{{ $pre_bir_1601->dmm_first }}</td>
                                                    <td>{{ $pre_bir_1601->dmm_second }}</td>
                                                    <td>{{ $pre_bir_1601->tot_dmm }}</td>
                                                    <td>{{ $pre_bir_1601->proj_exp_first }}</td>
                                                    <td>{{ $pre_bir_1601->proj_exp_second }}</td>
                                                    <td>{{ $pre_bir_1601->tot_proj_exp }}</td>
                                                    <td>{{ $pre_bir_1601->deduction_first }}</td>
                                                    <td>{{ $pre_bir_1601->deduction_second }}</td>
                                                    <td>{{ $pre_bir_1601->tot_deduction }}</td>
                                                    <td>{{ $pre_bir_1601->gross_pay_first }}</td>
                                                    <td>{{ $pre_bir_1601->gross_pay_second }}</td>
                                                    <td>{{ $pre_bir_1601->tot_gross_pay_salary }}</td>
                                                    <td>{{ $pre_bir_1601->tax_first }}</td>
                                                    <td>{{ $pre_bir_1601->tax_second }}</td>
                                                    <td>{{ $pre_bir_1601->tot_tax }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Card for totals and averages -->
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title">Summary</h5>
                                <p class="card-text">
                                    <table>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Basic Pay : </strong></td>
                                            {{-- <td> {{ number_format($total_basic, 2) }}</td> --}}
                                        </tr>
                                        <tr>
                                            <td><strong>Total Premium : </strong></td>
                                            {{-- <td> {{ number_format($total_premium, 2) }}</td> --}}
                                        </tr>
                                        <tr>
                                            <td><strong>Total Project Expense : </strong></td>
                                            {{-- <td> {{ number_format($total_expense, 2) }}</td> --}}
                                        </tr>
                                        {{-- ₱ --}}
                                    </table>
                                </p>
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

        var table = $('#manageBIR').DataTable({
            "columnDefs": [
                {
                    "targets": [5, 6, 7, 8, 9, 10, 11, 12, 13 , 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25], // Columns 4 to 10
                    "visible": false // Hide these columns by default
                }
            ]
        });

        function format(rowData) {
            // Create a string with the hidden columns' data
            return `
                <table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">
                    <tr>
                        <td>Basic Pay(1-15):</td>
                        <td>${rowData[5]}</td>
                    </tr>
                    <tr>
                        <td>Basic Pay(16-31):</td>
                        <td>${rowData[6]}</td>
                    </tr>
                    <tr>
                        <td>Tot Basic Pay:</td>
                        <td>${rowData[7]}</td>
                    </tr>
                    <tr>
                        <td>Premium(1-15):</td>
                        <td>${rowData[8]}</td>
                    </tr>
                    <tr>
                        <td>Premium(16-31):</td>
                        <td>${rowData[9]}</td>
                    </tr>
                    <tr>
                        <td>Tot Premium:</td>
                        <td>${rowData[10]}</td>
                    </tr>
                    <tr>
                        <td>DMM(1-15):</td>
                        <td>${rowData[11]}</td>
                    </tr>
                    <tr>
                        <td>DMM(16-31):</td>
                        <td>${rowData[12]}</td>
                    </tr>
                    <tr>
                        <td>Tot DMM:</td>
                        <td>${rowData[13]}</td>
                    </tr>
                    <tr>
                        <td>Tot Proj Exp(1-15):</td>
                        <td>${rowData[14]}</td>
                    </tr>
                    <tr>
                        <td>Tot Proj Exp(16-31):</td>
                        <td>${rowData[15]}</td>
                    </tr>
                    <tr>
                        <td>Tot Proj Exp:</td>
                        <td>${rowData[16]}</td>
                    </tr>
                    <tr>
                        <td>Deduction(1-15):</td>
                        <td>${rowData[17]}</td>
                    </tr>
                    <tr>
                        <td>Deduction(16-31):</td>
                        <td>${rowData[18]}</td>
                    </tr>
                    <tr>
                        <td>Tot Deduction:</td>
                        <td>${rowData[19]}</td>
                    </tr>
                    <tr>
                        <td>Gross Pay(1-15):</td>
                        <td>${rowData[20]}</td>
                    </tr>
                    <tr>
                        <td>Gross Pay(16-31):</td>
                        <td>${rowData[21]}</td>
                    </tr>
                    <tr>
                        <td>Tot Gross Pay:</td>
                        <td>${rowData[22]}</td>
                    </tr>
                    <tr>
                        <td>Tax(1-15):</td>
                        <td>${rowData[23]}</td>
                    </tr>
                    <tr>
                        <td>Tax(16-31):</td>
                        <td>${rowData[24]}</td>
                    </tr>
                    <tr>
                        <td>Tax:</td>
                        <td>${rowData[25]}</td>
                    </tr>
                </table>
            `;
        }

        // Handle button click to show/hide details rows
        $('#manageBIR tbody').on('click', 'button.toggle-details', function() {
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
