@extends('layouts.app', [
    'class' => 'register-page',
    'backgroundImagePath' => 'img/bg/Hello-Cooperative.png'
])

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-5 ml-auto">
                    <div class="info-area info-horizontal mt-5">
                        <div class="icon icon-primary">
                            <i class="nc-icon nc-tv-2"></i>
                        </div>
                        <div class="description">
                            <h5 class="info-title">{{ __('Cooperative') }}</h5>
                            <p class="description">
                                {{ __('Manage Small Cooperative by keeping a logbook of members, borrower, loans and company funds.') }}
                            </p>
                        </div>
                    </div>
                    <div class="info-area info-horizontal">
                        <div class="icon icon-primary">
                            <i class="nc-icon nc-calendar-60"></i>
                        </div>
                        <div class="description">
                            <h5 class="info-title">{{ __('Paluwagan') }}</h5>
                            <p class="description">
                                {{ __('Manage Filipino Paluwagan, collectively save record of every member and their contributions.') }}
                            </p>
                        </div>
                    </div>
                    <div class="info-area info-horizontal">
                        <div class="icon icon-info">
                            <i class="nc-icon nc-circle-10"></i>
                        </div>
                        <div class="description">
                            <h5 class="info-title">{{ __('Manage Personal Fund') }}</h5>
                            <p class="description">
                                {{ __('Manage your personal fundings, store who has debt on you, how much and when it is supposed to be collected.') }}
                            </p>
                        </div>
                    </div>
                    
                    @if (\App\Setups\AppSetup::instance()->setupHasBeenRan())
                        <div class="info-area info-horizontal">
                            <a href="{{ route('login') }}" class="btn btn-warning">
                                    {{ __('You can only run registert once. Please proceed to Login') }}
                            </a>
                        </div>
                    @endif
                </div>
                <div class="col-lg-4 col-md-6 mr-auto">
                    @if (\App\Setups\AppSetup::instance()->setupHasBeenRan())
                        <!-- N/A -->
                    @else
                        <div class="card card-signup text-center">
                            <div class="card-header ">
                                <h4 class="card-title">{{ __('Setup Default') }}</h4>
                            </div>
                            
                            <div class="card-body ">
                                <form class="form" method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="input-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="nc-icon nc-single-02"></i>
                                            </span>
                                        </div>
                                        <input name="name" type="text" class="form-control" placeholder="Name" value="{{ old('name') }}" required autofocus>
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="input-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="nc-icon nc-email-85"></i>
                                            </span>
                                        </div>
                                        <input name="email" type="email" class="form-control" placeholder="Email" required value="{{ old('email') }}">
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="input-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="nc-icon nc-key-25"></i>
                                            </span>
                                        </div>
                                        <input name="password" type="password" class="form-control" placeholder="Password" required>
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="nc-icon nc-key-25"></i>
                                            </span>
                                        </div>
                                        <input name="password_confirmation" type="password" class="form-control" placeholder="Password confirmation" required>
                                        @if ($errors->has('password_confirmation'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-check text-left">
                                        <label class="form-check-label">
                                            <input class="form-check-input" name="agree_terms_and_conditions" type="checkbox">
                                            <span class="form-check-sign"></span>
                                                {{ __('I agree to the') }}
                                            <a href="#something">{{ __('terms and conditions') }}</a>.
                                        </label>
                                        @if ($errors->has('agree_terms_and_conditions'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('agree_terms_and_conditions') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="card-footer ">
                                        <button type="submit" class="btn btn-info btn-round">{{ __('Get Started') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
             </div>
        </div>
     </div> 
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            demo.checkFullPageBackgroundImage();
        });
    </script>
@endpush
