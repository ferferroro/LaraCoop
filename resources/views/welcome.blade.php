@extends('layouts.app', [
    'class' => 'login-page',
    'elementActive' => ''
])

@section('content')
    <div class="content col-md-12 ml-auto mr-auto">
        <div class="header py-5 pb-7 pt-lg-9">
            <div class="container col-md-10">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-md-12 pt-5">
                            <h1 class="@if(Auth::guest()) text-white @endif">{{ __('Welcome to LaraCoop') }}</h1>

                            <p class="@if(Auth::guest()) text-white @endif text-lead mt-3 mb-0">
                                {{ __('Lend hands with friends and the world around you on Lara Cooperative Web Application.') }}
                            </p>

                            <br>

                            @if (\App\Setups\AppSetup::instance()->setupHasBeenRan())
                            
                                @guest
                                    <a href="{{ route('login') }}" class="btn btn-warning">
                                        {{ __('Manage your Cooperative') }}
                                    </a>
                                @endguest
                            @else
                                <a href="{{ route('register') }}" class="btn btn-warning">
                                    {{ __('Register Defaults') }}
                                </a>
                            @endif
                            
                        </div>
                    </div>
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
