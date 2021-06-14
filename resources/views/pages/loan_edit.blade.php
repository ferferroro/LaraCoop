@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'loans'
])

@section('content')
    <div class="content">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        @if (session('password_status'))
            <div class="alert alert-success" role="alert">
                {{ session('password_status') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-12 text-center">

                <!-- Form start -->
                <form class="col-md-12" action="{{ route('loan.update', ['id' => $loan['id']]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title"> {{ $loan['is_settled'] ? 'View Loan' : 'Maintain Loan' }} </h5>
                        </div>
                        <div class="card-body">

                            @if (Session::has('success_message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> {{ Session::get('success_message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if (Session::has('error_message'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error!</strong> {{ Session::get('error_message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            
                            <div class="row">
                                <label class="col-md-2 col-form-label">{{ __('ID') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group disabled">
                                        <input type="text" name="id" class="form-control" placeholder="ID" value="{{ $loan['id'] ?? '' }}" disabled>
                                    </div>
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Borrower') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <select name="borrower_id" class="form-control" id="borrower_id" onchange="borrower_id_selected_on_add_loan()">
                                        <option value="">Select Borrower</option>
                                            @foreach ($borrowers as $borrower)
                                                <option value="{{ $borrower->id }}" @if($borrower->id == $loan['borrower_id']) selected @endif> {{ $borrower->id }}  - {{ $borrower->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('borrower_id'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('borrower_id') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Type') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <select name="loan_type" class="form-control" id="loan_type">
                                            <option value="Loan" @if($loan['loan_type'] == "Loan") selected @endif>Loan</option>
                                            <option value="Quote" @if($loan['loan_type'] == "Quote") selected @endif>Quote</option>  
                                        </select>
                                    </div>
                                    @if ($errors->has('loan_type'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('loan_type') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Date Loan') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="date" name="date_loan" class="form-control" placeholder="Date Loan" value="{{ $loan['date_loan'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('date_loan'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('date_loan') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Date Start') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="date" name="date_start" class="form-control" placeholder="Date Start" value="{{ $loan['date_start'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('date_start'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('date_start') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Date End') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="date" name="date_end" class="form-control" placeholder="Date Start" value="{{ $loan['date_end'] ?? '' }}" required disabled>
                                    </div>
                                    @if ($errors->has('date_end'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('date_end') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Terms') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                    <input type="text" name="terms" class="form-control" placeholder="0.00" value="{{ $loan['terms'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('terms'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('terms') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Schedule') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <select name="type_schedule" class="form-control" id="type_schedule">
                                            <option value="Monthly" @if($loan['type_schedule'] == "Monthly") selected @endif>Monthly</option>
                                            <option value="Semi-Monthly" @if($loan['type_schedule'] == "Semi-Monthly") selected @endif>Semi-Monthly</option>
                                        </select>
                                    </div>
                                    @if ($errors->has('type_schedule'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('type_schedule') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Amount') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="amount" class="form-control" placeholder="0.00"value="{{ $loan['amount'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('amount'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('amount') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Interest Percentage') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="percent_interest" class="form-control" placeholder="0.00" value="{{ $loan['percent_interest'] ?? '' }}" id="percent_interest" required>
                                    </div>
                                    @if ($errors->has('percent_interest'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('percent_interest') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Interest Penalty') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="percent_penalty" class="form-control" placeholder="0.00" value="{{ $loan['percent_penalty'] ?? '' }}" id="percent_penalty" required>
                                    </div>
                                    @if ($errors->has('percent_penalty'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('percent_penalty') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Collector') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <select name="member_id" class="form-control" id="member_id">
                                            @foreach ($members as $member)
                                                <option value="{{ $member->id }}" @if($member->id == $loan['member_id']) selected @endif> {{ $member->id }}  - {{ $member->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('member_id'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('member_id') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Source Account') }}</label>
                                <div class="col-md-10">

                                    <div class="form-group">
                                        <select name="member_account_id" class="form-control" id="member_account_id">
                                            
                                            @foreach ($selected_member_accounts as $member_account)
                                                <option value="{{ $member_account['id'] }}" @if($loan->member_account_id == $member_account['id']) selected @endif> {{ $member_account->bank }} - {{ $member_account->name }} ({{ $member_account->account }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('member_account_id'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('member_account_id') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Remarks') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="remarks" class="form-control" placeholder="Remarks" value="{{ $loan['remarks'] }}">
                                    </div>
                                    @if ($errors->has('remarks'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('remarks') }}</strong>
                                        </span>
                                    @endif
                                </div>

                            </div>

                            <!-- table start -->
                            <div class="card card-plain">
                                <div class="card-header">
                                    <h4 class="card-title"> Loan Details</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class=" text-primary">
                                                <th>
                                                    Term
                                                </th>
                                                <th>
                                                    Type
                                                </th>
                                                <th>
                                                    Date Due
                                                </th>
                                                <th class="text-right">
                                                    Date Payed
                                                </th>
                                                <th>
                                                    Principal
                                                </th>
                                                <th>
                                                    Interest
                                                </th>
                                                <th>
                                                    Amount Due
                                                </th>
                                                <th>
                                                    Amount Paid
                                                </th>
                                                <th>
                                                    
                                                </th>
                                            </thead>
                                            <tbody>
                                                @isset($loan->loan_details)
                                                    @foreach ($loan->loan_details as $detail)
                                                        <tr>
                                                            <td>
                                                                {{ $detail->term_number }}
                                                            </td>
                                                            <td>
                                                                {{ $detail->type_line }}
                                                            </td>
                                                            <td>
                                                                {{ $detail->date_payment_due }}
                                                            </td>
                                                            <td>
                                                                {{ $detail->date_payment }}
                                                            </td>
                                                            <td>
                                                                {{ $detail->amount_base }}
                                                            </td>
                                                            <td>
                                                                {{ $detail->interest_amount }}
                                                            </td>
                                                            <td>
                                                                {{ $detail->amount_due }}
                                                            </td>
                                                            <td>
                                                                {{ $detail->amount_payed }}
                                                            </td>
                                                            <td>
                                                                <!-- Pay Loan Detail Button trigger modal -->
                                                                <button type="button" class="btn btn-primary btn-fab btn-icon btn-round btn-sm" 
                                                                    data-toggle="modal" 
                                                                    data-target="#payLoanDetailModal"
                                                                    data-loan-detail-id="{{ $detail->id }}"
                                                                    data-loan-detail-type-line="{{ $detail->type_line }}"
                                                                    data-loan-detail-date-payment-due="{{ $detail->date_payment_due }}"
                                                                    data-loan-detail-term="{{ $detail->term_number }} of {{ $loan->terms }}"
                                                                    data-loan-detail-amount-due="{{ $detail->amount_due }}"
                                                                    data-loan-detail-amount-payed="{{ $detail->amount_payed }}"
                                                                    data-loan-detail-pay-form-action="{{ route('loan.detail.pay', ['id' => $detail->id]) }}"

                                                                >
                                                                    <i class="nc-icon nc-money-coins"></i>
                                                                </button>
                                                                <!-- Pay Loan Detail Button trigger modal -->
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endisset

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- table end -->
                            
                        </div>
                        <div class="card-footer ">
                            <div class="row">
                                <div class="col-md-12 text-right">

                                    @if(Helper::canUpdateRecords())

                                        @if($loan->is_approved || $loan->is_settled || $loan->is_transferred)
                                            <!-- dont show any thing -->                                            
                                        @else
                                            <button type="submit" class="btn btn-info btn-round">{{ __('Save') }}</button>

                                            <!-- Delete Button trigger modal -->
                                            <button type="button" class="btn btn-info btn-round" data-toggle="modal" data-target="#deleteLoanModal">
                                                Delete
                                            </button>
                                            <!-- Delete Button trigger modal -->
                                        @endif
                                        
                                        @if(Helper::canApproveLoans() && $loan->is_approved == false)
                                            <!-- Approve Button trigger modal -->
                                            <button type="button" class="btn btn-info btn-round" 
                                                data-toggle="modal" 
                                                data-target="#approveLoanModal" 
                                                >
                                                Approve
                                            </button>
                                            <!-- Approve Button trigger modal -->
                                        @endif

                                        @if(Helper::canTransferFunds() && $loan->is_transferred == false && $loan->is_approved == true && $loan->is_settled == false)
                                            <!-- Transfer Button trigger modal -->
                                            <button type="button" class="btn btn-info btn-round" 
                                                data-toggle="modal" 
                                                data-target="#transferLoanModal" 
                                                >
                                                Transfer
                                            </button>
                                            <!-- Transfer Button trigger modal -->
                                        @endif

                                        @if(Helper::isMasterAccount() && $loan->is_settled == false)
                                            <!-- Settle Button trigger modal -->
                                            <!-- <button type="button" class="btn btn-info btn-round" 
                                                data-toggle="modal" 
                                                data-target="#settleLoanModal" 
                                                >
                                                Settle
                                            </button> -->
                                            <!-- Settle Button trigger modal -->
                                        @endif

                                        
                                        @if($loan->is_approved && $loan->is_transferred && $loan->is_settled == false )
                                            <!-- Penalty Button trigger modal -->
                                            <button type="button" class="btn btn-info btn-round" data-toggle="modal" data-target="#createPenaltyDetailModal">
                                                Penalty
                                            </button>
                                            <!-- Penalty Button trigger modal -->                                   
                                        @else
                                            
                                        @endif
                                    @endif

                                    <a href="{{ route('loan.index') }}" class="btn btn-info btn-round">
                                        Back
                                    </a>
                                    
                                </div>

                            </div>

                            <br>
                        </div>
                    </div>
                </form>
                <!-- Form end -->

                <!-- Form start | Loan delete -->
                <form class="col-md-12" action="{{ route('loan.destroy', ['id' => $loan['id']]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <!-- Modal Start  -->
                    <div class="modal fade" id="deleteLoanModal" tabindex="-1" role="dialog" aria-labelledby="deleteLoanModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteLoanModalLabel">Delete Loan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h4>
                                    Are you sure you want to delete Loan {{ $loan['id'] ?? '' }}? 
                                    <br> <br>
                                    This action is ireversable.
                                </h4>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-secondary">{{ __('Delete') }}</button>
                            </div>
                            </div>
                        </div>
                    </div> 
                    <!-- Modal End-->

                </form>
                <!-- Form end | Loan delete -->

                <!-- Form start | Loan approve  -->
                <form class="col-md-12" action="{{ route('loan.approve', ['id' => $loan['id']]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <!-- Modal Start  -->
                    <div class="modal fade" id="approveLoanModal" tabindex="-1" role="dialog" aria-labelledby="approveLoanModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="approveLoanModalLabel">Approve Loan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h4>
                                    Are you sure you want to Approve Loan {{ $loan['id'] ?? '' }}? 
                                </h4>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                                <button type="submit" class="btn btn-secondary">{{ __('Approve') }}</button>
                            </div>
                            </div>
                        </div>
                    </div> 
                    <!-- Modal End-->

                </form>
                <!-- Form end | Loan approve  -->

                <!-- Form start | Loan transfer  -->
                <form class="col-md-12" action="{{ route('loan.transfer', ['id' => $loan['id']]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <!-- Modal Start  -->
                    <div class="modal fade" id="transferLoanModal" tabindex="-1" role="dialog" aria-labelledby="transferLoanModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="transferLoanModalLabel">Transfer</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h4>
                                    Are you sure you have Transferred the Loan to the Client? 
                                </h4>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                                <button type="submit" class="btn btn-secondary">{{ __('Transfer') }}</button>
                            </div>
                            </div>
                        </div>
                    </div> 
                    <!-- Modal End-->

                </form>
                <!-- Form end | Loan transfer  -->


                <!-- Form start | Pay loan detail -->
                <form id="loan_detail_pay_form" class="col-md-12" action="/" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <!-- Modal Start  -->
                    <div class="modal fade" id="payLoanDetailModal" tabindex="-1" role="dialog" aria-labelledby="payLoanDetailModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="payLoanDetailModalLabel">Loan : {{ $loan->id }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h5>Line Details</h5>
                                <!-- table start -->
                                <table class="table">
                                    
                                    <tbody>
                                        <tr>
                                            <td class="text-right">
                                                Type:
                                            </td>
                                            <td class="text-left" id="loan_detail_type_line">
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-right">
                                                Due:
                                            </td>
                                            <td class="text-left" id="loan_detail_date_payment_due">
                                             
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-right">
                                                Term:
                                            </td>
                                            <td class="text-left" id="loan_detail_term">
                                                
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="text-right">
                                                Amount:
                                            </td>
                                            <td class="text-left" id="loan_detail_amount_due"> 
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-right">
                                                Paid:
                                            </td>
                                            <td class="text-left" id="loan_detail_amount_payed">
                                               0.00
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-right">
                                                Account:
                                            </td>
                                            <td class="text-left" id="account">
                                                {{ $saved_member_account->bank }} - {{ $saved_member_account->name }} ({{ $saved_member_account->account }})
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-right">
                                                Enter Payment:
                                            </td>
                                            <td class="text-left">
                                                <div class="form-group">
                                                    <input type="text" name="amount_payed" class="form-control" placeholder="0.00" value="0.00" @if($loan->is_settled) disabled @else required @endif>
                                                    <input name="loan_id" type="hidden" value="{{ $loan->id }}">
                                                </div>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td class="text-right">
                                                Date Payment:
                                            </td>
                                            <td class="text-left">
                                                <div class="form-group">
                                                    <input type="date" name="date_payment" class="form-control" placeholder="Date Loan" value="<?php echo date('Y-m-d'); ?>" required>
                                                </div>
                                            </td>
                                        </tr>
                                        


                                        
                                        
                                    </tbody>
                                </table>
                                <!-- table end -->
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-secondary">{{ __('Pay') }}</button>
                            </div>
                            </div>
                        </div>
                    </div> 
                    <!-- Modal End-->

                </form>
                <!-- Form end | Pay loan detail  -->

                <!-- Form start | Create Penalty -->
                <form id="loan_create_penalty_form" class="col-md-12" action="{{ route('loan.detail.add_penalty', ['id' => $detail->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <!-- Modal Start  -->
                    <div class="modal fade" id="createPenaltyDetailModal" tabindex="-1" role="dialog" aria-labelledby="createPenaltyDetailModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createPenaltyDetailModalLabel">Loan : {{ $loan->id }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h5>Line Details</h5>
                                <!-- table start -->
                                <table class="table">
                                    
                                    <tbody>
                                        <tr>
                                            <td class="text-right">
                                                Type: 
                                            </td>
                                            <td class="text-left" id="loan_line_type">
                                                Penalty
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-right">
                                                Due:
                                            </td>
                                            <td class="text-left" id="loan_detail_date_due">
                                                <div class="form-group">
                                                    <input type="date" name="date_payment_due" class="form-control" placeholder="Date Loan" value="{{ date('Y-m-d') }}" required>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-right">
                                                Penalty Amount:
                                            </td>
                                            <td class="text-left">
                                                <div class="form-group">
                                                    <input type="text" name="amount_due" class="form-control" placeholder="0.00" value="{{ $loan->amount * ($loan->percent_penalty / 100)  }}" @if($loan->is_settled) disabled @else required @endif>
                                                    <input name="loan_id" type="hidden" value="{{ $loan->id }}">
                                                </div>
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                <!-- table end -->
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-secondary">{{ __('Add') }}</button>
                            </div>
                            </div>
                        </div>
                    </div> 
                    <!-- Modal End-->

                </form>
                <!-- Form end | Create Penalty  -->

                <!-- Form start | Loan Settle  -->
                <form class="col-md-12" action="{{ route('loan.settle', ['id' => $loan['id']]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <!-- Modal Start  -->
                    <div class="modal fade" id="settleLoanModal" tabindex="-1" role="dialog" aria-labelledby="settleLoanModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="settleLoanModalLabel">Transfer</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h4>Forcing to settle this loan means the Client is unable to make any payments and Company has lost Money.</h4>
                                <h4>Are you sure you want to settle this Loan?</h4>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                                <button type="submit" class="btn btn-secondary">{{ __('Settle') }}</button>
                            </div>
                            </div>
                        </div>
                    </div> 
                    <!-- Modal End-->

                </form>
                <!-- Form end | Loan Settle  -->

            </div>
        </div>
    </div>
@endsection