@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'transfers'
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
                <form class="col-md-12" action="{{ route('transfer.update', ['id' => $transfer['id']]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title"> {{ $transfer['is_accepted'] ? 'View Transfer' : 'Maintain Transfer' }} </h5>
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
                                        <input type="text" name="id" class="form-control" placeholder="ID" value="{{ $transfer['id'] ?? '' }}" disabled>
                                    </div>
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Member From') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <select name="member_from" class="form-control" id="member_from">
                                            @foreach ($members as $member)
                                                @if($member->can_hold_fund)
                                                    <option value="{{ $member->id }}"  @if($member->id == $transfer['member_from']) selected @endif> {{ $member->id }}  - {{ $member->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('member_from'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('member_from') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Date Transferred') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="date" name="transferred_at" class="form-control" placeholder="Date Transferred" value="{{ $transfer['transferred_at'] ?? date('Y-m-d') }}" required>
                                    </div>
                                    @if ($errors->has('transferred_at'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('transferred_at') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('From Bank') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                    <input type="text" name="bank_from" class="form-control" placeholder="From Bank" value="{{ $transfer['bank_from'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('bank_from'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('bank_from') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Account Number') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                    <input type="text" name="account_number_from" class="form-control" placeholder="From Bank" value="{{ $transfer['account_number_from'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('account_number_from'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('account_number_from') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Amount') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="amount" class="form-control" placeholder="0.00"value="{{ $transfer['amount'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('amount'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('amount') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Remarks') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="remarks" class="form-control" placeholder="Remarks" value="{{ $transfer['remarks'] }}">
                                    </div>
                                    @if ($errors->has('remarks'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('remarks') }}</strong>
                                        </span>
                                    @endif
                                    <hr>
                                    <hr>
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Member To') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <select name="member_to" class="form-control" id="member_to">
                                            @foreach ($members as $member)
                                                @if($member->can_hold_fund)
                                                    <option value="{{ $member->id }}"  @if($member->id == $transfer['member_to']) selected @endif> {{ $member->id }}  - {{ $member->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('member_to'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('member_to') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('To Bank') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                    <input type="text" name="bank_to" class="form-control" placeholder="To Bank" value="{{ $transfer['bank_to'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('bank_to'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('bank_to') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Account Number') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                    <input type="text" name="account_number_to" class="form-control" placeholder="Account Number" value="{{ $transfer['account_number_to'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('account_number_to'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('account_number_to') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <div class="row">
                                <div class="col-md-12 text-right">

                                    @if(Helper::canUpdateRecords())

                                        @if ($transfer->is_accepted == false)

                                            <button type="submit" class="btn btn-info btn-round">{{ __('Save') }}</button>

                                            <!-- Delete Button trigger modal -->
                                            <button type="button" class="btn btn-info btn-round" data-toggle="modal" data-target="#deleteTransferModal">
                                                Delete
                                            </button>

                                            <!-- Accept Button trigger modal -->
                                            <button type="button" class="btn btn-info btn-round" data-toggle="modal" data-target="#acceptTransferModal">
                                                Accept
                                            </button>

                                        @endif
                                    @endif

                                    <a href="{{ route('transfer.index') }}" class="btn btn-info btn-round">
                                        Back
                                    </a>
                                    
                                </div>

                            </div>

                            <br>
                        </div>
                    </div>
                </form>
                <!-- Form end -->

                <!-- Form start | Transfer delete -->
                <form class="col-md-12" action="{{ route('transfer.destroy', ['id' => $transfer['id']]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <!-- Modal Start  -->
                    <div class="modal fade" id="deleteTransferModal" tabindex="-1" role="dialog" aria-labelledby="deleteTransferModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteTransferModalLabel">Delete Transfer</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h4>
                                    Are you sure you want to delete Transfer {{ $transfer['id'] ?? '' }}? 
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
                <!-- Form end | Transfer delete -->

                <!-- Form start | Transfer accept -->
                <form class="col-md-12" action="{{ route('transfer.accept', ['id' => $transfer['id']]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <!-- Modal Start  -->
                    <div class="modal fade" id="acceptTransferModal" tabindex="-1" role="dialog" aria-labelledby="acceptTransferModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="acceptTransferModalLabel">Delete Transfer</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h4>
                                    Are you sure you want to accept Transfer {{ $transfer['id'] ?? '' }}? 
                                    <br> <br>
                                    This action is ireversable.
                                </h4>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-secondary">{{ __('Accept') }}</button>
                            </div>
                            </div>
                        </div>
                    </div> 
                    <!-- Modal End-->

                </form>
                <!-- Form end | Transfer accept -->

            </div>
        </div>
    </div>
@endsection