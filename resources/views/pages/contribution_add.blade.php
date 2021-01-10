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
                                        <input type="text" name="memberId" class="form-control" placeholder="Member ID" value="" required>
                                    </div> -->

                                    <div class="form-row">
                                        <div class="form-group col-md-11">
                                            <input type="text" name="member_id" class="form-control" placeholder="Member ID" value="" required>
                                        </div>
                                        
                                        <div class="form-group col-md-1 text-left">
                                            <!-- Button trigger modal start -->
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#memberFinderModal">
                                                <i class="nc-icon nc-zoom-split"></i>  Find
                                            </button>
                                            <!-- Button trigger modal end -->
                                        </div>
                                        
                                    </div>
                                    @if ($errors->has('member_id'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('member_id') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Name') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Name" value="" disabled>
                                    </div>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Period') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="period" class="form-control" placeholder="yyyy-mm" value="" required>
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
                                        <input type="text" name="amount" class="form-control" placeholder="0.00" value="" required>
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
                                        <input type="text" name="remarks" class="form-control" placeholder="Remarks" value="" required>
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

                <!-- Form start -->
                <form class="col-md-12" action="{{ route('member.index') }}" method="GET" enctype="multipart/form-data">
                    @csrf
                    @method('GET')

                    <!-- Modal Start  -->
                    <div class="modal fade" id="memberFinderModal" tabindex="-1" role="dialog" aria-labelledby="memberFinderModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="memberFinderModalLabel">Find Member</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h4>
                                        
                                        <br> <br>
                                        This function is not yet implemented
                                    </h4>

                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <!-- <button type="submit" class="btn btn-secondary">{{ __('Find') }}</button> -->
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

    

    <!-- romel start -->
    
    <!-- romel end -->
    
@endsection