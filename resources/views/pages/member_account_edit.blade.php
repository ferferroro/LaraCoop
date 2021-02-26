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

                <!-- Form start -->
                <form class="col-md-12" action="{{ route('member.update_account', ['id' => $member_account['id']]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">{{ __('Edit Member Account') }}</h5>
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
                                        <input type="text" name="id" class="form-control" placeholder="ID" value="{{ $member_account->id ?? '' }}" disabled>
                                    </div>
                                </div>       

                                <label class="col-md-2 col-form-label">{{ __('Member ID') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group disabled">
                                        <input type="text" name="member_id" class="form-control" placeholder="ID" value="{{ $member_account->member_id ?? '' }}" disabled>
                                    </div>
                                </div>  

                                <label class="col-md-2 col-form-label">{{ __('Member Name') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group disabled">
                                        <input type="text" name="member_name" class="form-control" placeholder="ID" value="{{ $member_account->member->name ?? '' }}" disabled>
                                    </div>
                                </div>   

                                <label class="col-md-2 col-form-label">{{ __('Bank') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="bank" class="form-control" placeholder="Bank" value="{{ $member_account->bank }}" required>
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
                                        <input type="text" name="name" class="form-control" placeholder="Account Name" value="{{ $member_account->name }}" required>
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
                                        <input type="text" name="account" class="form-control" placeholder="Account" value="{{ $member_account->account }}" required>
                                    </div>

                                    @if ($errors->has('account'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('account') }}</strong>
                                        </span>
                                    @endif
                                </div> 

                                <label class="col-md-2 col-form-label">{{ __('Amount') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="amount" class="form-control" placeholder="0.00" value="{{ $member_account->amount }}" disabled>
                                    </div>
                                </div> 
                                  
                            </div>
                            
                        </div>
                        <div class="card-footer ">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    @if(Helper::canUpdateRecords())
                                        <button type="submit" class="btn btn-info btn-round">{{ __('Save') }}</button>

                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-info btn-round" data-toggle="modal" data-target="#deleteMemberAccountModal">
                                            Delete
                                        </button>
                                        <!-- Button trigger modal -->
                                    @endif

                                    <a href="{{ route('member.edit', ['id' => $member_account->member_id]) }}" class="btn btn-info btn-round">
                                        Cancel
                                    </a>

                                    <br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Form end -->

                <!-- Form start -->
                <form class="col-md-12" action="{{ route('member.destroy_account', ['id' => $member_account['id']]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <!-- Modal Start  -->
                    <div class="modal fade" id="deleteMemberAccountModal" tabindex="-1" role="dialog" aria-labelledby="deleteMemberAccountModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteMemberAccountModalLabel">Delete Member Account</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h4>
                                    Are you sure you want to delete {{ $member_account['bank'] ?? '' }} with account number {{ $member_account['account'] ?? '' }}? 
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