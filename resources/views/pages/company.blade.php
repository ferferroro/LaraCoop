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

                <!-- Form start -->
                <form class="col-md-12" action="{{ route('company.update', ['id' => $company['id']]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">{{ __('Company Maintenance') }}</h5>
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
                            
                            <div class="row">
                                <label class="col-md-2 col-form-label">{{ __('ID') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group disabled">
                                        <input type="text" name="id" class="form-control" placeholder="ID" value="{{ $company['id'] ?? '' }}" disabled>
                                    </div>
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Name') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $company['name'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Primary Contact') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="primary_contact" class="form-control" placeholder="Primary Contact" value="{{ $company['primary_contact'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('primary_contact'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('primary_contact') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Address') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="address" class="form-control" placeholder="Address" value="{{ $company['address'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Interest Percentage') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="percent_interest" class="form-control" placeholder="Interest Percentage" value="{{ $company['percent_interest'] ?? 0 }}" required>
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
                                        <input type="text" name="percent_penalty" class="form-control" placeholder="Penalty Percentage" value="{{ $company['percent_penalty'] ?? 0 }}" required>
                                    </div>
                                    @if ($errors->has('percent_penalty'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('percent_penalty') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Fund Total') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="fund_total" class="form-control" placeholder="0.00" value="{{ $company['fund_total'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('fund_total'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('fund_total') }}</strong>
                                        </span>
                                    @endif
                                </div>           

                                <label class="col-md-2 col-form-label">{{ __('Fund Available') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="fund_available" class="form-control" placeholder="0.00" value="{{ $company['fund_available'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('fund_available'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('fund_available') }}</strong>
                                        </span>
                                    @endif
                                </div>                       

                                <label class="col-md-2 col-form-label">{{ __('Fund Lended') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="fund_lended" class="form-control" placeholder="0.00" value="{{ $company['fund_lended'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('fund_lended'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('fund_lended') }}</strong>
                                        </span>
                                    @endif
                                </div>   

                                <label class="col-md-2 col-form-label">{{ __('Fund Profit') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="fund_profit" class="form-control" placeholder="0.00" value="{{ $company['fund_profit'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('fund_profit'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('fund_profit') }}</strong>
                                        </span>
                                    @endif
                                </div>   
                                

                                <label class="col-md-2 col-form-label">{{ __('Date Founded') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="date" name="date_founded" class="form-control" placeholder="Date Joined" value="{{ $company['date_founded'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('date_founded'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('date_founded') }}</strong>
                                        </span>
                                    @endif
                                </div>      

                                <label class="col-md-2 col-form-label">{{ __('Mission') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="mission" class="form-control" placeholder="Mission" value="{{ $company['mission'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('mission'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('mission') }}</strong>
                                        </span>
                                    @endif
                                </div>  
                                
                                <label class="col-md-2 col-form-label">{{ __('Vision') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="vision" class="form-control" placeholder="Vision" value="{{ $company['vision'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('vision'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('vision') }}</strong>
                                        </span>
                                    @endif
                                </div>  
                                 
                                
                            </div>
                            
                        </div>
                        <div class="card-footer ">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-info btn-round">{{ __('Save') }}</button>
                                    <br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Form end -->

            </div>
        </div>
    </div>
@endsection