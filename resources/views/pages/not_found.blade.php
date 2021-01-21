@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'not_found'
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
                
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">{{ __('Page Not Found') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                    
                            <div class="col-md-12 text-center">
                                <br>
                                <p>The Page you are looking for is not found, please contact Admin!</p>
                                <br>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>

        </div>
    </div>
@endsection