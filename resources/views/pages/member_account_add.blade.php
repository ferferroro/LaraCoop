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
                <form class="col-md-12" action="{{ route('member.store_account') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">{{ __('Add Member Account') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <label class="col-md-2 col-form-label">{{ __('Member ID') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="member_id" class="form-control" placeholder="Member ID" value="{{ $member->id }}" readonly>
                                    </div>
                                    @if ($errors->has('member_id'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('member_id') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Member Name') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="member_name" class="form-control" placeholder="Member Name" value="{{ $member->name }}" readonly>
                                    </div>
                                    @if ($errors->has('member_name'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('member_name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <input type="hidden" name="member_id" value="{{ $member->id }}">

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
        
                                    <a href="{{ route('member.edit', ['id' => $member->id]) }}" class="btn btn-info btn-round">
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