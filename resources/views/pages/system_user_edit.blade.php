@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'system_users'
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
                <form class="col-md-12" action="{{ route('system_user.update', ['id' => $system_user['id']]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">{{ __('Maintain Users') }}</h5>
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

                            @if (Session::has('error_message'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error!</strong> {{ Session::get('error_message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            
                            <div class="row">
                                <label class="col-md-2 col-form-label">{{ __('ID') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group disabled">
                                        <input type="text" name="id" class="form-control" placeholder="ID" value="{{ $system_user['id'] ?? '' }}" disabled>
                                    </div>
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Name') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $system_user['name'] ?? '' }}" disabled>
                                    </div>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>   

                                <label class="col-md-2 col-form-label">{{ __('Email') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="email" class="form-control" placeholder="Email" value="{{ $system_user['email'] ?? '' }}" disabled>
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>   

                                <!-- <label class="col-md-2 col-form-label">{{ __('Password') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Password" value="" required>
                                    </div>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div> 

                                <label class="col-md-2 col-form-label">{{ __('Confirm Password') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" value="" required>
                                    </div>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>   -->

                                <label class="col-md-2 col-form-label">{{ __('Contact Number') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="contact" class="form-control" placeholder="Contact Number" value="{{ $system_user['contact'] ?? '' }}" disabled>
                                    </div>
                                    @if ($errors->has('contact'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('contact') }}</strong>
                                        </span>
                                    @endif
                                </div>  

                                <label class="col-md-2 col-form-label">{{ __('Linked Borrower') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <select name="borrower_id" class="form-control" id="borrower_id">
                                            <option value="">{{ old('borrower_id') ?? 'Select Borrower' }}</option>
                                            @foreach ($borrowers as $borrower)
                                                <option value="{{ $borrower->id }}" @if($borrower->id == $system_user['borrower_id']) selected @endif> {{ $borrower->id }}  - {{ $borrower->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('borrower_id'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('borrower_id') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Linked Member') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <select name="member_id" class="form-control" id="member_id">
                                        <!-- <option value="">{{ $system_user['member_id'] ?? 'Select Member' }}</option> -->
                                            <option value="">{{ old('member_id') ?? 'Select Member' }}</option>
                                            @foreach ($members as $member)
                                                <option value="{{ $member->id }}" @if($member->id == $system_user['member_id']) selected @endif> {{ $member->id }}  - {{ $member->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('member_id'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('member_id') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                

                                <label class="col-md-2 col-form-label">{{ __('Sidebar Background Color') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="side_bg_color" class="form-control" placeholder="Sidebar Background Color" value="{{ $system_user['side_bg_color'] ?? 'white' }}" disabled>
                                    </div>
                                    @if ($errors->has('side_bg_color'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('side_bg_color') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Sidebar Active Color') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="side_active_color" class="form-control" placeholder="Sidebar Active Color" value="{{  $system_user['side_active_color'] ?? 'danger' }}" disabled>
                                    </div>
                                    @if ($errors->has('side_active_color'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('side_active_color') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Can Approve Loans') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="checkbox" name="can_approve_loans" class="form-check-input" value="" {{  $system_user['can_approve_loans'] ? 'checked' : '' }}>
                                    </div>
                                    @if ($errors->has('can_approve_loans'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('can_approve_loans') }}</strong>
                                        </span>
                                    @endif
                                </div> 

                                <label class="col-md-2 col-form-label">{{ __('Can Approve Contributions') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input class="form-check-input" type="checkbox"  name="can_approve_contributions" value="" {{  $system_user['can_approve_contributions'] ? 'checked' : '' }}>
                                    </div>
                                    @if ($errors->has('can_approve_contributions'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('can_approve_contributions') }}</strong>
                                        </span>
                                    @endif
                                </div> 

                                <label class="col-md-2 col-form-label">{{ __('Can Transfer Funds') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input class="form-check-input" type="checkbox"  name="can_transfer_funds" value="" {{  $system_user['can_transfer_funds'] ? 'checked' : '' }}>
                                    </div>
                                    @if ($errors->has('can_transfer_funds'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('can_transfer_funds') }}</strong>
                                        </span>
                                    @endif
                                </div> 

                                <label class="col-md-2 col-form-label">{{ __('Can View Other Records') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input class="form-check-input" type="checkbox"  name="can_view_other_records" value="" {{  $system_user['can_view_other_records'] ? 'checked' : '' }}>
                                    </div>
                                    @if ($errors->has('can_view_other_records'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('can_view_other_records') }}</strong>
                                        </span>
                                    @endif
                                </div> 

                                <label class="col-md-2 col-form-label">{{ __('Can Update Records') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input class="form-check-input" type="checkbox"  name="can_update_records" value="" {{  $system_user['can_update_records'] ? 'checked' : '' }}>
                                    </div>
                                    @if ($errors->has('can_update_records'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('can_update_records') }}</strong>
                                        </span>
                                    @endif
                                </div> 

                                <label class="col-md-2 col-form-label">{{ __('User Menu') }}</label>
                                <div class="col-md-10">
                                    <select multiple class="form-control" id="menus" name="menus[]">
                                    

                                        @foreach ($menus as $menu)
                                            <option value="{{ $menu->id }}" 
                                            @foreach ($user_menus as $user_menu)
                                                @if($user_menu->menu_id == $menu->id)
                                                    {{ 'selected' }}
                                                @endif
                                                
                                            @endforeach
                                            >
                                                {{ $menu->display_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('menus'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('menus') }}</strong>
                                        </span>
                                    @endif
                                </div> 

                            </div>
                            
                        </div>
                        <div class="card-footer ">
                        <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-info btn-round">{{ __('Save') }}</button>
        
                                    <a href="{{ route('system_user.index') }}" class="btn btn-info btn-round">
                                        Cancel
                                    </a>

                                    

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