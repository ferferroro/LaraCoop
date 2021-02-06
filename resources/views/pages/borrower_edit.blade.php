@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'borrowers'
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
                <form class="col-md-12" action="{{ route('borrower.update', ['id' => $borrower['id']]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title">{{ __('Edit Borrower') }}</h5>
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
                                        <input type="text" name="id" class="form-control" placeholder="ID" value="{{ $borrower['id'] ?? '' }}" disabled>
                                    </div>
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Order') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="order" class="form-control" placeholder="Order" value="{{ $borrower['order'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('order'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('order') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Name') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $borrower['name'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Primary Contact') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="primary_contact" class="form-control" placeholder="Primary Contact" value="{{ $borrower['primary_contact'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('primary_contact'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('primary_contact') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Address') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="address" class="form-control" placeholder="Address" value="{{ $borrower['address'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Interest Percentage') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="percent_interest" class="form-control" placeholder="Interest Percentage" value="{{ $borrower['percent_interest'] ?? 0 }}" required>
                                    </div>
                                    @if ($errors->has('percent_interest'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('percent_interest') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Penalty Percentage') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="text" name="percent_penalty" class="form-control" placeholder="Penalty Percentage" value="{{ $borrower['percent_penalty'] ?? 0 }}" required>
                                    </div>
                                    @if ($errors->has('percent_penalty'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('percent_penalty') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <label class="col-md-2 col-form-label">{{ __('Date Joined') }}</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input type="date" name="date_joined" class="form-control" placeholder="Date Joined" value="{{ $borrower['date_joined'] ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('date_joined'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('date_joined') }}</strong>
                                        </span>
                                    @endif
                                </div>                               

                                
                            </div>
                            
                        </div>
                        <div class="card-footer ">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    @if(Helper::canUpdateRecords())
                                        <button type="submit" class="btn btn-info btn-round">{{ __('Save') }}</button>

                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-info btn-round" data-toggle="modal" data-target="#deleteBorrowerModal">
                                            Delete
                                        </button>
                                        <!-- Button trigger modal -->
                                    @endif

                                    <a href="{{ route('borrower.loans', ['borrower_id' => $borrower['id']]) }}" class="btn btn-info btn-round">
                                        Loans
                                    </a>

                                    <a href="{{ route('borrower.index') }}" class="btn btn-info btn-round">
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
                <form class="col-md-12" action="{{ route('borrower.destroy', ['id' => $borrower['id']]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    <!-- Modal Start  -->
                    <div class="modal fade" id="deleteBorrowerModal" tabindex="-1" role="dialog" aria-labelledby="deleteBorrowerModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteBorrowerModalLabel">Delete Borrower</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h4>
                                    Are you sure you want to delete {{ $borrower['name'] ?? '' }} with Borrower ID {{ $borrower['id'] ?? '' }}? 
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