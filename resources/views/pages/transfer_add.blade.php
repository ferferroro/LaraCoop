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
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">{{ __('New Fund Transfer') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <label class="col-md-2 col-form-label">{{ __('From Member') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <select name="member_from" class="form-control" id="member_from">
                                            @foreach ($members as $member)
                                                @if($member->can_hold_fund)
                                                    <option value="{{ $member->id }}"  @if(old('member_id') == $member->id) selected @endif> {{ $member->id }}  - {{ $member->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('member_from'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('member_from') }}</strong>
                                        </span>
                                    @endif
                                </div>

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

                                <label class="col-md-2 col-form-label">{{ __('From Bank') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="bank_from" class="form-control" placeholder="From Bank" value="{{ old('bank_from') ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('bank_from'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('bank_from') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Account Number') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="account_number_from" class="form-control" placeholder="Account Number" value="{{ old('account_number_from') ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('account_number_from'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('account_number_from') }}</strong>
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


                                <label class="col-md-2 col-form-label">{{ __('To Member') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <select name="member_to" class="form-control" id="member_to">
                                            @foreach ($members as $member)
                                                @if($member->can_hold_fund)
                                                    <option value="{{ $member->id }}"  @if(old('member_id') == $member->id) selected @endif> {{ $member->id }}  - {{ $member->name }}</option>
                                                @endif
                                                
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('member_to'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('member_to') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('To Bank') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="bank_to" class="form-control" placeholder="From Bank" value="{{ old('bank_to') ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('bank_to'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('bank_to') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Account Number') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="account_number_to" class="form-control" placeholder="Account Number" value="{{ old('account_number_to') ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('account_number_to'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('account_number_to') }}</strong>
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