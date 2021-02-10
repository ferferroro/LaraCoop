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
                <form class="col-md-12" action="/" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">{{ __('View Contribution') }}</h5>
                        </div>
                        <div class="card-body">
                            
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
                                        <select name="member_id" class="form-control" id="member_id" disabled>
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

                                <label class="col-md-2 col-form-label">{{ __('Period') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="period" class="form-control" placeholder="Period" value="{{ $contribution['period'] ?? '' }}" disabled>
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
                                        <input type="text" name="amount" class="form-control" placeholder="Amount" value="{{ $contribution['amount'] ?? 0 }}" disabled>
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
                                        <select name="fund_collector" class="form-control" id="fund_collector" disabled>
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
                                        <input type="text" name="remarks" class="form-control" placeholder="Remarks" value="{{ $contribution['remarks'] ?? '' }}" disabled>
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

                                    <a href="{{ route('member.contributions', ['member_id' => $member->id]) }}" class="btn btn-info btn-round">
                                        Back
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