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
                                <form action="{{ route('borrower.index') }}" method="GET" enctype="multipart/form-data">
                                    @csrf
                                    @method('GET')
                                    <div class="form-group">
                                        <h3 class="mb-0">Borrowers</h3>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="search_string" class="form-control" id="searchBorrower" aria-describedby="searchBorrowerHelp" placeholder="Search" value="{{ $search_string ?? '' }}">
                                    </div>

                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary">Search</button>

                                        @if(Helper::canUpdateRecords())
                                        
                                            <a href="{{ route('borrower.create') }}" class="btn btn-primary btn-md">
                                                &nbsp; Add &nbsp;
                                            </a>
                                        @endif
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
                                        <th> ID </th>
                                        <th> Order </th>
                                        <th> Name </th>
                                        <th> Contact </th>
                                        <th> Address </th>
                                        <th> Interest Rate </th>
                                        <th> Penalty Rate </th>
                                        <th> Balance </th>
                                        <th> Joined </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($borrowers as $borrower)
                                       
                                        <tr>
                                            <td>
                                            <a href="{{ route('borrower.edit', ['id' => $borrower->id]) }}" class="">
                                                # {{ $borrower->id }}
                                            </a>
                                            <td>
                                                {{ $borrower->order }}
                                            </td>
                                            </td>
                                            <td>
                                                {{ $borrower->name }}
                                            </td>
                                            <td>
                                                {{ $borrower->primary_contact }}
                                            </td>
                                            <td>
                                                {{ $borrower->address }}
                                            </td>
                                            <td>
                                                {{ $borrower->percent_interest }}
                                            </td>
                                            <td>
                                                {{ $borrower->percent_penalty }}
                                            </td>
                                            <td>
                                                {{ $borrower->balance }}
                                            </td>
                                            <td>
                                                {{ $borrower->date_joined }}
                                            </td>
                                            
                                        </tr>
                                    @endforeach

                                    
                                </tbody>
                                
                            </table>
                        </div>

                        
                        <div>
                            <br>
                            {{ $borrowers->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
@endsection