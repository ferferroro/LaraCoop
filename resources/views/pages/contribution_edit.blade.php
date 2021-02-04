@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'contributions'
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
                <form class="col-md-12" action="{{ route('contribution.update', ['id' => $contribution['id']]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">{{ __('Edit Contribution') }}</h5>
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
                                        <input type="text" name="id" class="form-control" placeholder="ID" value="{{ $contribution['id'] ?? '' }}" disabled>
                                    </div>
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Member ID') }}</label>
                                <div class="col-md-10">

                                    <div class="form-group">
                                        <select name="member_id" class="form-control" id="member_id" {{  $contribution['is_approved'] ? 'disabled' : 'required' }}>
                                            @foreach ($members as $member)
                                                <option value="{{ $member->id }}" @if($member->id == $contribution['member_id']) selected @endif> {{ $member->id }}  - {{ $member->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('member_id'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('member_id') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <!-- <label class="col-md-2 col-form-label">{{ __('Name') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $contribution['name'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div> -->

                                <label class="col-md-2 col-form-label">{{ __('Period') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="period" class="form-control" placeholder="Period" value="{{ $contribution['period'] ?? '' }}" {{  $contribution['is_approved'] ? 'disabled' : 'required' }}>
                                    </div>
                                    @if ($errors->has('period'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('period') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Amount') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="amount" class="form-control" placeholder="Amount" value="{{ $contribution['amount'] ?? 0 }}" {{  $contribution['is_approved'] ? 'disabled' : 'required' }}>
                                    </div>
                                    @if ($errors->has('amount'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('amount') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Fund Collector') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <select name="fund_collector" class="form-control" id="fund_collector" {{  $contribution['is_approved'] ? 'disabled' : 'required' }}>
                                            @foreach ($members as $member)
                                                @if($member->can_hold_fund)
                                                    <option value="{{ $member->id }}" @if($member->id == $contribution['fund_collector']) selected @endif> {{ $member->id }}  - {{ $member->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    @if ($errors->has('fund_collector'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('fund_collector') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Remarks') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="remarks" class="form-control" placeholder="Remarks" value="{{ $contribution['remarks'] ?? '' }}" {{  $contribution['is_approved'] ? 'disabled' : '' }}>
                                    </div>
                                    @if ($errors->has('remarks'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('remarks') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                        </div>
                        <div class="card-footer ">
                            <div class="row">
                                <div class="col-md-12 text-right">

                                    @if(Helper::canApproveContributions() && $contribution['is_approved'] == false)
                                        <button type="button" class="btn btn-info btn-round" data-toggle="modal" data-target="#approveContribution">
                                            Approve
                                        </button>
                                    @endif

                                    @if ($contribution['is_approved'] == false)
                                        <button type="submit" class="btn btn-info btn-round">{{ __('Save') }}</button>
            
                                        <button type="button" class="btn btn-info btn-round" data-toggle="modal" data-target="#deleteContributionModal">
                                            Delete
                                        </button>
                                    @endif

                                    <a href="{{ route('contribution.index') }}" class="btn btn-info btn-round">
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
                <form class="col-md-12" action="{{ route('contribution.destroy', ['id' => $contribution['id']]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <!-- Modal Start  -->
                    <div class="modal fade" id="deleteContributionModal" tabindex="-1" role="dialog" aria-labelledby="deleteContributionModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteContributionModalLabel">Delete Contribution</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h4>
                                    Are you sure you want to delete {{ $contribution['name'] ?? '' }} with Contribution ID {{ $contribution['id'] ?? '' }}? 
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

                <!-- Form Approve Contribution start -->
                <form class="col-md-12" action="{{ route('contribution.approve', ['id' => $contribution['id']]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <!-- Modal Start  -->
                    <div class="modal fade" id="approveContribution" tabindex="-1" role="dialog" aria-labelledby="approveContributionLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="approveContributionLabel">Delete Contribution</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h4>
                                    Are you sure you want to approve Contribution ID {{ $contribution['id'] ?? '' }}? 
                                    <br> <br>
                                    This action will update the company balance.
                                </h4>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-secondary">{{ __('Approve') }}</button>
                            </div>
                            </div>
                        </div>
                    </div> 
                    <!-- Modal End-->

                </form>
                <!-- Form Approve Contribution  end -->

            </div>
        </div>
    </div>
@endsection