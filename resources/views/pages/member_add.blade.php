@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'members'
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
                <form class="col-md-12" action="{{ route('member.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">{{ __('Add Member') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-2 col-form-label">{{ __('Name') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Order') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="order" class="form-control" placeholder="Order" value="{{ old('order') ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('order'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('order') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Address') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="address" class="form-control" placeholder="Address" value="{{ old('address') ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Monthly Contribution') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="monthly_contribution" class="form-control" placeholder="Monthly Contribution" value="{{ old('monthly_contribution') ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('monthly_contribution'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('monthly_contribution') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Date Distribute') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="date" name="distribution_schedule" class="form-control" placeholder="Date Distribute" value="{{ old('distribution_schedule') ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('distribution_schedule'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('distribution_schedule') }}</strong>
                                        </span>
                                    @endif
                                </div>                               

                                <label class="col-md-2 col-form-label">{{ __('Primary Contact') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="primary_contact" class="form-control" placeholder="Primary Contact" value="{{ old('primary_contact') ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('primary_contact'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('primary_contact') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Can Hold Funds?') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input class="form-check-input" type="checkbox"  name="can_hold_fund" value="{{ old('can_hold_fund') ?? '' }}">
                                    </div>
                                    @if ($errors->has('can_hold_fund'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('can_hold_fund') }}</strong>
                                        </span>
                                    @endif
                                </div> 
                            </div>
                            
                        </div>
                        <div class="card-footer ">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    @if(Helper::canUpdateRecords())
                                        <button type="submit" class="btn btn-info btn-round">{{ __('Save') }}</button>
                                    @endif
        
                                    <a href="{{ route('member.index') }}" class="btn btn-info btn-round">
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
@endsection