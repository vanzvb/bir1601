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
                            <form method="GET" action="{{ route('payroll_cutoff_summary.payroll_cutoff_summary') }}" class="w-100">
                                <div class="row">
                                    {{-- Card for BOU --}}
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="bouID">BOU:</label>
                                            <select name="bouID[]" id="bouID" class="form-control select2" multiple required>
                                                <option value="">Select BOU</option>
                                                @foreach($companyBOUs as $companyBOU)
                                                    <option value="{{ $companyBOU->bouID }}" {{ in_array($companyBOU->bouID, (array)$bouIDs) ? 'selected' : '' }}>
                                                        {{ $companyBOU->bouName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>  
                                    </div>
                                
                                    {{-- card for year --}}
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="year">Year:</label>
                                            <select name="year" id="year" class="form-control select2" required>
                                                <option value="">Select Year</option>
                                                @for($y = date('Y'); $y >= 2000; $y--)
                                                    <option value="{{ $y }}" {{ (old('year') == $y || $year == $y) ? 'selected' : '' }}>{{ $y }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    {{-- card for month --}}
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="months">Months:</label>
                                            <select name="months[]" id="months" class="form-control select2" multiple
                                                required>
                                                @for($m = 1; $m <= 12; $m++)
                                                <option value="{{ $m }}" {{ (in_array($m, $months)) ? 'selected' : '' }}>
                                                    {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                                </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
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
                                        <button type="submit" class="btn btn-success">Sync Data</button>
                                        @if($payroll_cuttoff_summaries->isEmpty())
                                            <p>No data available.</p>
                                        @else
                                        <table id="payrollCutoffSummary" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Employee Name</th>
                                                    <th>BOU</th>
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
                                                    {{-- <th>Proj Exp(1-15)</th>
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
                                                    <th>Total Tax</th> --}}
                                                    {{-- <th>Total Project Exp</th>
                                                    <th>Total Deduction</th>
                                                    <th>Total Gross Pay Salary</th>
                                                    <th>Tax</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($payroll_cuttoff_summaries as $index => $summary)
                                                    <tr>
                                                        <td>{{ $summary['user']->name ?? 'N/A' }}</td>
                                                        <td>{{ $summary['user']->companyBOU->bouName ?? 'N/A' }}</td>
                                                        <td>{{ DateTime::createFromFormat('!m', $summary['month'])->format('F') }}</td>
                                                        <td>{{ $summary['year'] }}</td>
                                                        <td>{{ $summary['basicpay0'] }}</td>
                                                        <td>{{ $summary['basicpay1'] }}</td>
                                                        <td>{{ $summary['totalBasicPay'] }}</td>
                                                        <td>{{ $summary['premium0'] }}</td>
                                                        <td>{{ $summary['premium1'] }}</td>
                                                        <td>{{ $summary['totalPremium'] }}</td>
                                                        <td>{{ $summary['dmm0'] }}</td>
                                                        <td>{{ $summary['dmm1'] }}</td>
                                                        <td>{{ $summary['totalDmm'] }}</td>

                                                        <!-- Add other columns as needed -->


                                                        <!-- Hidden inputs for each summary item -->
                                                        <input type="hidden" name="summaries[{{ $index }}][empID]" value="{{ $summary['empID'] }}">
                                                        {{-- <input type="hidden" name="summaries[{{ $index }}][bouID]" value="{{ $summary['bouID'] }}"> --}}
                                                        <input type="hidden" name="summaries[{{ $index }}][month]" value="{{ $summary['month'] }}">
                                                        <input type="hidden" name="summaries[{{ $index }}][year]" value="{{ $summary['year'] }}">
                                                        <input type="hidden" name="summaries[{{ $index }}][basicpay0]" value="{{ $summary['basicpay0'] }}">
                                                        <input type="hidden" name="summaries[{{ $index }}][basicpay1]" value="{{ $summary['basicpay1'] }}">
                                                        <input type="hidden" name="summaries[{{ $index }}][totalBasicPay]" value="{{ $summary['totalBasicPay'] }}">
                                                        <input type="hidden" name="summaries[{{ $index }}][premium0]" value="{{ $summary['premium0'] }}">
                                                        <input type="hidden" name="summaries[{{ $index }}][premium1]" value="{{ $summary['premium1'] }}">
                                                        <input type="hidden" name="summaries[{{ $index }}][totalPremium]" value="{{ $summary['totalPremium'] }}">
                                                        <input type="hidden" name="summaries[{{ $index }}][dmm0]" value="{{ $summary['dmm0'] }}">
                                                        <input type="hidden" name="summaries[{{ $index }}][dmm1]" value="{{ $summary['dmm1'] }}">
                                                        <input type="hidden" name="summaries[{{ $index }}][totalDmm]" value="{{ $summary['totalDmm'] }}">
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                        {{-- <button type="submit" class="btn btn-success">Sync Data</button> --}}
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
    initializeSelect2('#bouID');
    initializeSelect2('#year');
    initializeSelect2('#months');

    let manageLeavesTable = $('#payrollCutoffSummary').DataTable({
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
