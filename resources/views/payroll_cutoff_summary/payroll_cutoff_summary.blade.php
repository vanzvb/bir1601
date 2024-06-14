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

                <!-- Display Success Message -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Display Error Message -->
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            
                <br/>

                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="row">
                            <div class="col-md-12">
                                <h1 class="text-center fs-3">Payroll Cutoff Summary</h1>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            {{-- <div class="d-flex justify-content-between align-items-center">Parameter {{ $month }} , {{ $year }}</div> --}}
                            {{-- <div>BOU : {{ $bouID }}</div> --}}
                            {{-- <div><button type="button" class="btn btn-success">Transfer to 1601</button></div> --}}
                            <form method="GET" action="{{ route('payroll_cutoff_summary.payroll_cutoff_summary') }}">
                                <div class="form-group">
                                    <label for="year">Year:</label>
                                    <select name="year" id="year" class="form-control">
                                        <option value="">Select Year</option>
                                        @for($y = date('Y'); $y >= 2000; $y--)
                                            <option value="{{ $y }}" {{ (old('year') == $y || $year == $y) ? 'selected' : '' }}>{{ $y }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="month">Month:</label>
                                    <select name="month" id="month" class="form-control">
                                        <option value="">Select Month</option>
                                        @for($m = 1; $m <= 12; $m++)
                                            <option value="{{ $m }}" {{ (old('month') == $m || $month == $m) ? 'selected' : '' }}>{{ $m }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </form>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <form method="post" action="{{ route('save.payroll') }}">
                                    @csrf
                                    <div class="table-responsive" style="width:100%">
                                        @if($payroll_cuttoff_summaries->isEmpty())
                                            <p>No data available.</p>
                                        @else
                                        <table id="manageBIR" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Employee Name</th>
                                                    <th>Month</th>
                                                    <th>Year</th>
                                                    <th>Basic Pay(1-15)</th>
                                                    <th>Basic Pay(16-31)</th>
                                                    <th>Total Basic Pay</th>
                                                    <th>Premium (1-15)</th>
                                                    <th>Premium (16-31)</th>
                                                    <th>Total Premium</th>
                                                    <th>DMM(1-15)</th>
                                                    <th>DMM(16-31)</th>
                                                    <th>Total DMM</th>
                                                    <th>Proj Exp(1-15)</th>
                                                    <th>Proj Exp(16-31)</th>
                                                    <th>Total Proj Exp Reim</th>
                                                    <th>Deduction(1-15)</th>
                                                    <th>Deduction(16-31)</th>
                                                    <th>Total Deduction</th>
                                                    <th>Gross Pay Salary(1-15)</th>
                                                    <th>Gross Pay Salary(16-31)</th>
                                                    <th>Total Gross Pay Salary</th>
                                                    <th>Tax(1-15)</th>
                                                    <th>Tax(16-31)</th>
                                                    <th>Total Tax</th>
                                                    {{-- <th>Total Project Exp</th>
                                                    <th>Total Deduction</th>
                                                    <th>Total Gross Pay Salary</th>
                                                    <th>Tax</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($payroll_cuttoff_summaries as $payroll_cuttoff_summary)
                                                <tr>
                                                    <td>{{ $payroll_cuttoff_summary->user->name }}</td>
                                                    {{-- <td>
                                                        @if($payroll_cuttoff_summary->cutoff == 1)
                                                            1-15
                                                        @elseif($payroll_cuttoff_summary->cutoff == 2)
                                                            16-31
                                                        @endif
                                                    </td> --}}
                                                    <td>{{ DateTime::createFromFormat('!m', $payroll_cuttoff_summary->month)->format('F') }}</td>
                                                    <td>{{ $payroll_cuttoff_summary->year }}</td>
                                                    <td>{{ number_format($payroll_cuttoff_summary->BasicPay1, 2) }}</td>
                                                    <td>{{ number_format($payroll_cuttoff_summary->BasicPay2, 2) }}</td>
                                                    <td>{{ number_format($payroll_cuttoff_summary->TotalBasicPay, 2) }}</td>
                                                    <td>{{ number_format($payroll_cuttoff_summary->Premium1, 2) }}</td>
                                                    <td>{{ number_format($payroll_cuttoff_summary->Premium2, 2) }}</td>
                                                    <td>{{ number_format($payroll_cuttoff_summary->TotalPremium, 2) }}</td>
                                                    <td>{{ number_format($payroll_cuttoff_summary->DMM1, 2) }}</td>
                                                    <td>{{ number_format($payroll_cuttoff_summary->DMM2, 2) }}</td>
                                                    <td>{{ number_format($payroll_cuttoff_summary->TotalDMM, 2) }}</td>
                                                    <td>{{ number_format($payroll_cuttoff_summary->ProjExp1, 2) }}</td>
                                                    <td>{{ number_format($payroll_cuttoff_summary->ProjExp2, 2) }}</td>
                                                    <td>{{ number_format($payroll_cuttoff_summary->TotalProjExp, 2) }}</td>
                                                    <td>{{ number_format($payroll_cuttoff_summary->Deduction1, 2) }}</td>
                                                    <td>{{ number_format($payroll_cuttoff_summary->Deduction2, 2) }}</td>
                                                    <td>{{ number_format($payroll_cuttoff_summary->TotalDeduction, 2) }}</td>
                                                    <td>{{ number_format($payroll_cuttoff_summary->GrossPaySal1, 2) }}</td>
                                                    <td>{{ number_format($payroll_cuttoff_summary->GrossPaySal2, 2) }}</td>
                                                    <td>{{ number_format($payroll_cuttoff_summary->TotalGrossPaySal, 2) }}</td>
                                                    <td>{{ number_format($payroll_cuttoff_summary->Tax1, 2) }}</td>
                                                    <td>{{ number_format($payroll_cuttoff_summary->Tax2, 2) }}</td>
                                                    <td>{{ number_format($payroll_cuttoff_summary->TotalTax, 2) }}</td>

                                                    <!-- Hidden inputs to capture the data -->
                                                    <input type="hidden" name="empID[]" value="{{ $payroll_cuttoff_summary->user->id }}">
                                                    <input type="hidden" name="month[]" value="{{ $payroll_cuttoff_summary->month }}">
                                                    <input type="hidden" name="year[]" value="{{ $payroll_cuttoff_summary->year }}">
                                                    <input type="hidden" name="basic_pay_first[]" value="{{ $payroll_cuttoff_summary->BasicPay1 }}">
                                                    <input type="hidden" name="basic_pay_second[]" value="{{ $payroll_cuttoff_summary->BasicPay2 }}">
                                                    <input type="hidden" name="basic_pay_total[]" value="{{ $payroll_cuttoff_summary->TotalBasicPay }}">
                                                    <input type="hidden" name="premium_first[]" value="{{ $payroll_cuttoff_summary->Premium1 }}">
                                                    <input type="hidden" name="premium_second[]" value="{{ $payroll_cuttoff_summary->Premium2 }}">
                                                    <input type="hidden" name="tot_premium[]" value="{{ $payroll_cuttoff_summary->TotalPremium }}">
                                                    <input type="hidden" name="dmm_first[]" value="{{ $payroll_cuttoff_summary->DMM1 }}">
                                                    <input type="hidden" name="dmm_second[]" value="{{ $payroll_cuttoff_summary->DMM2 }}">
                                                    <input type="hidden" name="tot_dmm[]" value="{{ $payroll_cuttoff_summary->TotalDMM }}">
                                                    <input type="hidden" name="proj_exp_first[]" value="{{ $payroll_cuttoff_summary->ProjExp1 }}">
                                                    <input type="hidden" name="proj_exp_second[]" value="{{ $payroll_cuttoff_summary->ProjExp2 }}">
                                                    <input type="hidden" name="tot_proj_exp[]" value="{{ $payroll_cuttoff_summary->TotalProjExp }}">
                                                    <input type="hidden" name="deduction_first[]" value="{{ $payroll_cuttoff_summary->Deduction1 }}">
                                                    <input type="hidden" name="deduction_second[]" value="{{ $payroll_cuttoff_summary->Deduction2 }}">
                                                    <input type="hidden" name="tot_deduction[]" value="{{ $payroll_cuttoff_summary->TotalDeduction }}">
                                                    <input type="hidden" name="gross_pay_first[]" value="{{ $payroll_cuttoff_summary->GrossPaySal1 }}"> 
                                                    <input type="hidden" name="gross_pay_second[]" value="{{ $payroll_cuttoff_summary->GrossPaySal2 }}"> 
                                                    <input type="hidden" name="tot_gross_pay_salary[]" value="{{ $payroll_cuttoff_summary->TotalGrossPaySal }}"> 
                                                    <input type="hidden" name="tax_first[]" value="{{ $payroll_cuttoff_summary->Tax1 }}">
                                                    <input type="hidden" name="tax_second[]" value="{{ $payroll_cuttoff_summary->Tax2 }}">
                                                    <input type="hidden" name="tot_tax[]" value="{{ $payroll_cuttoff_summary->TotalTax }}">
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                        <button type="submit" class="btn btn-success">Sync Data</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Card for totals and averages -->
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

// Initialize select2 for select dropdowns
initializeSelect2('#filterBou', null, "Select BOU");

let manageLeavesTable = $('#manageBIR').DataTable({
    processing: true,
    responsive: true,
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

});
        
</script>
