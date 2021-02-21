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
                <form class="col-md-12" action="{{ route('member.update', ['id' => $member['id']]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">{{ __('Edit Member') }}</h5>
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
                                        <input type="text" name="id" class="form-control" placeholder="ID" value="{{ $member['id'] ?? '' }}" disabled>
                                    </div>
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Fund on Hand') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group disabled">
                                        <input type="text" name="id" class="form-control" placeholder="fund_on_hand" value="{{ $member['fund_on_hand'] ?? '' }}" disabled>
                                    </div>
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Name') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $member['name'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Order') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="order" class="form-control" placeholder="Order" value="{{ $member['order'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('order'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('order') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Address') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="address" class="form-control" placeholder="Address" value="{{ $member['address'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Monthly Contribution') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="monthly_contribution" class="form-control" placeholder="Monthly Contribution" value="{{ $member['monthly_contribution'] ?? 0 }}" required>
                                    </div>
                                    @if ($errors->has('monthly_contribution'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('monthly_contribution') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Total Contribution') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="total_contribution" class="form-control" placeholder="Total Contribution" value="{{ $member['total_contribution'] ?? 0 }}" disabled>
                                    </div>
                                    @if ($errors->has('total_contribution'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('total_contribution') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Date Distribute') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="date" name="distribution_schedule" class="form-control" placeholder="Date Distribute" value="{{ $member['distribution_schedule'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('distribution_schedule'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('distribution_schedule') }}</strong>
                                        </span>
                                    @endif
                                </div>                               

                                <label class="col-md-2 col-form-label">{{ __('Primary Contact') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="primary_contact" class="form-control" placeholder="Primary Contact" value="{{ $member['primary_contact'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('primary_contact'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('primary_contact') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Can Hold Funds?') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input class="form-check-input" type="checkbox"  name="can_hold_fund" value="" {{  $member['can_hold_fund'] ? 'checked' : '' }}>
                                    </div>
                                    @if ($errors->has('can_hold_fund'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('can_hold_fund') }}</strong>
                                        </span>
                                    @endif
                                </div> 

                            </div>

                            <!-- table start -->
                            <div class="card card-plain">
                                <div class="card-header">
                                    <h4 class="card-title"> Accounts</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class=" text-primary">
                                                <th>
                                                    ID
                                                </th>
                                                <th>
                                                    Bank
                                                </th>
                                                <th>
                                                    Account
                                                </th>
                                                <th>
                                                    Amount
                                                </th>
                                            </thead>
                                            <tbody>
                                                @isset($member_accounts)
                                                    @foreach ($member_accounts as $member_account)
                                                        <tr>
                                                            <td>
                                                                <a href="{{ route('member.edit_account', ['id' => $member_account->id]) }}" >
                                                                    #{{ $member_account->id }}
                                                                </a>
                                                            </td>
                                                            <td>
                                                                {{ $member_account->bank }}
                                                            </td>
                                                            <td>
                                                                {{ $member_account->account }}
                                                            </td>
                                                            <td>
                                                                {{ $member_account->amount }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endisset

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- table end -->
                            
                        </div>
                        <div class="card-footer ">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    @if(Helper::canUpdateRecords())
                                        <button type="submit" class="btn btn-info btn-round">{{ __('Save') }}</button>

                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-info btn-round" data-toggle="modal" data-target="#deleteMemberModal">
                                            Delete
                                        </button>
                                        <!-- Button trigger modal -->

                                        <a href="{{ route('member.add_account', ['member_id' => $member['id']]) }}" class="btn btn-info btn-round">
                                            Add Account
                                        </a>
                                    @endif

                                    <a href="{{ route('member.contributions', ['member_id' => $member['id']]) }}" class="btn btn-info btn-round">
                                        Contributions
                                    </a>

                                    

                                    <a href="{{ route('member.index') }}" class="btn btn-info btn-round">
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
                <form class="col-md-12" action="{{ route('member.destroy', ['id' => $member['id']]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <!-- Modal Start  -->
                    <div class="modal fade" id="deleteMemberModal" tabindex="-1" role="dialog" aria-labelledby="deleteMemberModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteMemberModalLabel">Delete Member</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h4>
                                    Are you sure you want to delete {{ $member['name'] ?? '' }} with Member ID {{ $member['id'] ?? '' }}? 
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