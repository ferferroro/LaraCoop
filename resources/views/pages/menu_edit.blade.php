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

                <!-- Form start -->
                <form class="col-md-12" action="{{ route('menu.update', ['id' => $menu['id']]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">{{ __('Edit Menu') }}</h5>
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
                                        <input type="text" name="id" class="form-control" placeholder="ID" value="{{ $menu['id'] ?? '' }}" disabled>
                                    </div>
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Display Name') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="display_name" class="form-control" placeholder="Display Name" value="{{ $menu['display_name'] ?? '' }}" required>
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
                                        <input type="text" name="element_name" class="form-control" placeholder="Element Name" value="{{ $menu['element_name'] ?? '' }}" required>
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
                                        <input type="text" name="route" class="form-control" placeholder="Route" value="{{ $menu['route'] ?? '' }}" required>
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
                                        <input type="text" name="link" class="form-control" placeholder="Link" value="{{ $menu['link'] ?? 0 }}" required>
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
                                        <input type="text" name="sequence" class="form-control" placeholder="Sequence" value="{{ $menu['sequence'] ?? 0 }}" required>
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
                                        <input type="text" name="icon_class" class="form-control" placeholder="Icon Class" value="{{ $menu['icon_class'] ?? '' }}" required>
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
                                        Cancel
                                    </a>

                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-info btn-round" data-toggle="modal" data-target="#deleteMenuModal">
                                        Delete
                                    </button>
                                    <!-- Button trigger modal -->

                                    <br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Form end -->

                <!-- Form start -->
                <form class="col-md-12" action="{{ route('menu.destroy', ['id' => $menu['id']]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <!-- Modal Start  -->
                    <div class="modal fade" id="deleteMenuModal" tabindex="-1" role="dialog" aria-labelledby="deleteMenuModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteMenuModalLabel">Delete Menu</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h4>
                                    Are you sure you want to delete {{ $menu['name'] ?? '' }} with Menu ID {{ $menu['id'] ?? '' }}? 
                                    <br> <br>
                                    This action is ireversable.
                                </h4>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-secondary">{{ __('Delete') }}</button>
                            </div>
                            </div>
                        </div>
                    </div> 
                    <!-- Modal End-->

                </form>
                <!-- Form end -->

            </div>
        </div>
    </div>
@endsection