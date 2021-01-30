@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'menus'
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
                <form class="col-md-12" action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">{{ __('Add Menu') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <label class="col-md-2 col-form-label">{{ __('Display Name') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="display_name" class="form-control" placeholder="Display Name" value="" required>
                                    </div>
                                    @if ($errors->has('display_name'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('display_name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Element Name') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="element_name" class="form-control" placeholder="Element Name" value="" required>
                                    </div>
                                    @if ($errors->has('element_name'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('element_name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Route') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="route" class="form-control" placeholder="Route" value="" required>
                                    </div>
                                    @if ($errors->has('route'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('route') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Link') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="link" class="form-control" placeholder="Link" value="" required>
                                    </div>
                                    @if ($errors->has('link'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('link') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Sequence') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="sequence" class="form-control" placeholder="Sequence" value="" required>
                                    </div>
                                    @if ($errors->has('sequence'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('sequence') }}</strong>
                                        </span>
                                    @endif
                                </div>                               

                                <label class="col-md-2 col-form-label">{{ __('Icon Class') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="icon_class" class="form-control" placeholder="Icon Class" value="" required>
                                    </div>
                                    @if ($errors->has('icon_class'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('icon_class') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                        </div>
                        <div class="card-footer ">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-info btn-round">{{ __('Save') }}</button>
        
                                    <a href="{{ route('menu.index') }}" class="btn btn-info btn-round">
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