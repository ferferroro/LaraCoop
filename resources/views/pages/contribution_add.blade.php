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
                <form class="col-md-12" action="{{ route('contribution.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">{{ __('Add Contribution') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <label class="col-md-2 col-form-label">{{ __('Member ID') }}</label>
                                <div class="col-md-10">
                                    <!-- <div class="form-group">
                                        <input type="text" name="member_id" class="form-control" placeholder="Member ID" value="" required>
                                    </div> -->

                                    <div class="form-group">
                                        <select name="member_id" class="form-control" id="member_id" onchange="member_id_selected_on_add_contribution()">
                                            @foreach ($members as $member)
                                                <option value="{{ $member->id }}"> {{ $member->id }}  - {{ $member->name }}</option>
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
                                        <input type="text" name="name" class="form-control" placeholder="Name" value="" disabled>
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
                                        <input type="text" name="period" class="form-control" placeholder="yyyy-mm" value="{{ old('period') ?? date('Y') . '-' . date('m') }}" required>
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
                                        <input type="text" id="amount" name="amount" class="form-control" placeholder="0.00" value="{{ old('amount') ?? '' }}" required>
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
                                        <select name="fund_collector" class="form-control" id="fund_collector" onchange="fund_collector_selected_on_new_contribution()">
                                            <option value="0"> - </option>
                                            @foreach ($members as $member)
                                                @if($member->can_hold_fund)
                                                    <option value="{{ $member->id }}"> {{ $member->id }}  - {{ $member->name }}</option>
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

                                <label class="col-md-2 col-form-label">{{ __('Account') }}</label>
                                <div class="col-md-10">

                                    <div class="form-group">
                                        <select name="fund_collector_account_id" class="form-control" id="fund_collector_account_id">
                                            
                                        </select>
                                    </div>
                                    @if ($errors->has('fund_collector_account_id'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('fund_collector_account_id') }}</strong>
                                        </span>
                                    @endif
                                </div>


                                <label class="col-md-2 col-form-label">{{ __('Remarks') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="remarks" class="form-control" placeholder="Remarks" value="{{ old('remarks') ?? '' }}" >
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
                                    <button type="submit" class="btn btn-info btn-round">{{ __('Save') }}</button>
        
                                    <a href="{{ route('contribution.index') }}" class="btn btn-info btn-round">
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