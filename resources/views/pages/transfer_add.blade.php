@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'transfers'
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
                <form class="col-md-12" action="{{ route('transfer.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="_token" id="new_transfer_token" value="{{ csrf_token() }}">
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">{{ __('New Fund Transfer') }}</h5>
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
                                <label class="col-md-2 col-form-label">{{ __('Date Transferred') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="date" name="transferred_at" class="form-control" placeholder="Date Transferred" value="{{ old('transferred_at') ?? date('Y-m-d') }}" required>
                                    </div>
                                    @if ($errors->has('transferred_at'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('transferred_at') }}</strong>
                                        </span>
                                    @endif
                                </div>   

                                <label class="col-md-2 col-form-label">{{ __('From') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <select name="transfer_from" class="form-control" id="transfer_from" onchange="transfer_from_selected_on_new_transfer()">
                                            <option value="0"  @if(old('member_id') == 0) selected @endif> {{ $company->name }} (Company)</option>
                                            @foreach ($members as $member)
                                                @if($member->can_hold_fund)
                                                    <option value="{{ $member->id }}"  @if(old('member_id') == $member->id) selected @endif> {{ $member->id }}  - {{ $member->name }} (Member)</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('transfer_from'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('transfer_from') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                
                                <label class="col-md-2 col-form-label">{{ __('From Account') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <select name="account_from" class="form-control" id="account_from">
                                            @isset($company->company_accounts)
                                                @foreach ($company->company_accounts as $company_account)
                                                    <option value="{{ $company_account->id }}" >{{ $company_account->bank }} - {{ $company_account->name }} ({{ $company_account->account }})</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>

                                    @if ($errors->has('account_from'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('account_from') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Amount') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="amount" class="form-control" placeholder="0.00" value="{{ old('amount') ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('amount'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('amount') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Remarks') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="remarks" class="form-control" placeholder="Remarks" value="{{ old('remarks') ?? '' }}">
                                    </div>
                                    @if ($errors->has('remarks'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('remarks') }}</strong>
                                        </span>
                                    @endif
                                    <hr>
                                    <hr>
                                </div>


                                <label class="col-md-2 col-form-label">{{ __('To') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <select name="transfer_to" class="form-control" id="transfer_to" onchange="transfer_to_selected_on_new_transfer()">
                                            <option value="0"  @if(old('member_id') == 0) selected @endif> {{ $company->name }} (Company)</option>
                                            @foreach ($members as $member)
                                                @if($member->can_hold_fund)
                                                    <option value="{{ $member->id }}"  @if(old('member_id') == $member->id) selected @endif> {{ $member->id }}  - {{ $member->name }}</option>
                                                @endif
                                                
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('transfer_to'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('transfer_to') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('To Account') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <select name="account_to" class="form-control" id="account_to">
                                            @isset($company->company_accounts)
                                                @foreach ($company->company_accounts as $company_account)
                                                    <option value="{{ $company_account->id }}" >{{ $company_account->bank }} - {{ $company_account->name }} ({{ $company_account->account }})</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                    @if ($errors->has('account_to'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('account_to') }}</strong>
                                        </span>
                                    @endif
                                </div>

                            </div>
                            
                        </div>
                        <div class="card-footer ">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-info btn-round">{{ __('Save') }}</button>
        
                                    <a href="{{ route('transfer.index') }}" class="btn btn-info btn-round">
                                        &nbsp; Cancel &nbsp;
                                    </a>

                                    <br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    

    <!-- romel start -->
    
    <!-- romel end -->
    
@endsection