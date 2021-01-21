@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'setup_menu'
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
                <form class="col-md-12" action="{{ route('menu.setup') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">{{ __('Setup Default Menus') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                        
                                <div class="col-md-12 text-center">
                                    <p>Welcome to LaraCoop! <br> Please click to button to setup the default menus!</p>

                                    

                                    <button type="submit" class="btn btn-info btn-round">{{ __('Setup') }}</button>

                                    <br><br>
                                </div>
                                
                            </div>
                            
                        </div>
                        <!-- <div class="card-footer ">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-info btn-round">{{ __('Save') }}</button>
        
                                    <a href="{{ route('borrower.index') }}" class="btn btn-info btn-round">
                                        &nbsp; Cancel &nbsp;
                                    </a>

                                    <br><br>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection