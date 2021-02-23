@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'company'
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
                <form class="col-md-12" action="{{ route('company.store_account') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">{{ __('Add Company Account') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <label class="col-md-2 col-form-label">{{ __('Company Name') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="company_name" class="form-control" placeholder="Company Name" value="{{ $company->name }}" readonly>
                                    </div>
                                    @if ($errors->has('company_name'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('company_name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <input type="hidden" name="company_id" value="{{ $company->id }}">

                                <label class="col-md-2 col-form-label">{{ __('Bank') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="bank" class="form-control" placeholder="Bank Name" value="{{ old('bank') ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('bank'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('bank') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Account Name') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Account Name" value="{{ old('name') ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Account') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" id="account" name="account" class="form-control" placeholder="Account Number" value="{{ old('account') ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('account'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('account') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                
                            </div>
                            
                        </div>
                        <div class="card-footer ">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-info btn-round">{{ __('Save') }}</button>
        
                                    <a href="{{ route('company.index') }}" class="btn btn-info btn-round">
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