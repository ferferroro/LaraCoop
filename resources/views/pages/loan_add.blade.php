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
                <form class="col-md-12" action="{{ route('loan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">{{ __('Add Loan') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <label class="col-md-2 col-form-label">{{ __('Borrower') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <select name="borrower_id" class="form-control" id="borrower_id" onchange="borrower_id_selected_on_add_loan()">
                                        <option value="">Select Borrower</option>
                                            @foreach ($borrowers as $borrower)
                                                <option value="{{ $borrower->id }}"> {{ $borrower->id }}  - {{ $borrower->name }}</option>
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
                                            <option value="Loan">Loan</option>
                                            <option value="Quote">Quote</option>
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
                                        <input type="date" name="date_loan" class="form-control" placeholder="Date Loan" value="<?php echo date('Y-m-d'); ?>" required>
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
                                        <input type="date" name="date_start" class="form-control" placeholder="Date Start" value="<?php echo date('Y-m-d'); ?>" required>
                                    </div>
                                    @if ($errors->has('date_start'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('date_start') }}</strong>
                                        </span>
                                    @endif
                                </div> 


                                <label class="col-md-2 col-form-label">{{ __('Terms') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="terms" class="form-control" placeholder="0.00" value="1" required>
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
                                            <option value="Monthly">Monthly</option>
                                            <option value="Semi-Monthly">Semi-Monthly</option>
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
                                        <input type="text" name="amount" class="form-control" placeholder="0.00" value="" required>
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
                                        <input type="text" name="percent_interest" class="form-control" placeholder="0.00" value="{{ $company->percent_interest }}" id="percent_interest" required>
                                    </div>
                                    @if ($errors->has('percent_interest'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('percent_interest') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Penalty Percentage') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="percent_penalty" class="form-control" placeholder="0.00" value="{{ $company->percent_penalty }}" id="percent_penalty" required>
                                    </div>
                                    @if ($errors->has('percent_penalty'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('percent_penalty') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Referrer') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <select name="member_id" class="form-control" id="member_id">
                                            @foreach ($members as $member)
                                                <option value="{{ $member->id }}"> {{ $member->id }}  - {{ $member->name }}</option>
                                                
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('member_id'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('member_id') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Remarks') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="remarks" class="form-control" placeholder="Remarks" value="" required>
                                    </div>
                                    @if ($errors->has('remarks'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('remarks') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                                            

                                
                            </div>
                            
                        </div>
                        <div class="card-footer ">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-info btn-round">{{ __('Save') }}</button>
        
                                    <a href="{{ route('contribution.index') }}" class="btn btn-info btn-round">
                                        &nbsp; Cancel &nbsp;
                                    </a>

                                    <br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Form start -->
                <form class="col-md-12" action="{{ route('member.index') }}" method="GET" enctype="multipart/form-data">
                    @csrf
                    @method('GET')

                    <!-- Modal Start  -->
                    <div class="modal fade" id="memberFinderModal" tabindex="-1" role="dialog" aria-labelledby="memberFinderModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="memberFinderModalLabel">Find Member</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h4>
                                        
                                        <br> <br>
                                        This function is not yet implemented
                                    </h4>

                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <!-- <button type="submit" class="btn btn-secondary">{{ __('Find') }}</button> -->
                                </div>
                            </div>
                        </div>
                    </div> 
                    <!-- Modal End-->

                </form>
                <!-- Form end -->

            </div>
        </div>
    </div>

    

    <!-- romel start -->
    
    <!-- romel end -->
    
@endsection