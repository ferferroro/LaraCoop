@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'loans'
])

@section('content')
    <div class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <form action="{{ route('loan.index') }}" method="GET" enctype="multipart/form-data">
                                    @csrf
                                    @method('GET')
                                    <div class="form-group">
                                        <h3 class="mb-0">Loans</h3>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="search_string" class="form-control" id="searchLoan" aria-describedby="searchLoanHelp" placeholder="Search" value="{{ $search_string ?? '' }}">
                                    </div>

                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                        
                                        <a href="{{ route('loan.create') }}" class="btn btn-primary btn-md">
                                            &nbsp; Add &nbsp;
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
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
                    
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <tr>
                                        <th> Loan ID </th>
                                        <!-- <th> Borrower ID </th> -->
                                        <th> Name </th>
                                        <th> Type </th>
                                        <th> Start </th>
                                        <th> End </th>
                                        <th> Terms </th>
                                        <th> Schedule </th>
                                        <th> Settled </th>
                                        <th> Amount </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($loans as $loan)
                                       
                                        <tr>
                                            <td>
                                                <a href="{{ route('loan.edit', ['id' => $loan->id]) }}" >
                                                    # {{ $loan->id }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('borrower.edit', ['id' => $loan->borrower_id]) }}" >
                                                    {{ $loan->borrower->name }}
                                                </a>
                                                
                                            </td>
                                            <td>
                                                {{ $loan->loan_type }}
                                            </td>
                                            <td>
                                                {{ $loan->date_start }}
                                            </td>
                                            <td>
                                                {{ $loan->date_end }}
                                            </td>
                                            <td>
                                                {{ $loan->terms }}
                                            </td>
                                            <td>
                                                {{ $loan->type_schedule }}
                                            </td>    
                                            <td>
                                                {{ $loan->is_settled }}
                                            </td>
                                            <td>
                                                {{ $loan->amount }}
                                            </td>
                                        </tr>
                                        
                                    @endforeach

                                    
                                </tbody>
                                
                            </table>
                        </div>

                        
                        <div>
                            <br>
                            {{ $loans->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
@endsection