@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'borrowers'
])

@section('content')
    <div class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <form action="{{ route('member.contributions') }}" method="GET" enctype="multipart/form-data">
                                    <!-- @csrf
                                    @method('GET') -->
                                    <div class="form-group">
                                        <h3 class="mb-0">{{ $borrower->name ?? '' }}'s Loans</h3>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="search_string" class="form-control" id="searchString" aria-describedby="searchStringHelp" placeholder="Search" value="{{ $search_string ?? '' }}">
                                        <input type="hidden" name="borrower_id" class="form-control" id="searchMember" aria-describedby="searchMemberHelp" placeholder="Search" value="{{ $borrower->id ?? '' }}">
                                    </div>

                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary">Search</button>
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

                        @if (Session::has('error_message'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> {{ Session::get('error_message') }}
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

                                    @foreach ($borrower_loans as $loan)
                                       
                                        <tr>
                                            <td>
                                                <a href="{{ route('borrower.loan_view', ['id' => $loan->id]) }}" >
                                                    # {{ $loan->id }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('borrower.edit', ['id' => $loan->borrower_id]) }}" >
                                                    {{ $borrower->name }}
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
                                                {{ $loan->is_settled ? 'Yes' : 'No' }}
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
                            {{ $borrower_loans->links() }}
                        </div>

                    </div>

                    <div class="card-footer ">
                        <div class="row">
                            <div class="col-md-12 text-right">

                                <a href="{{ route('borrower.edit', ['id' => $borrower->id]) }}" class="btn btn-info btn-round">
                                    Cancel
                                </a>

                                <br><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
@endsection