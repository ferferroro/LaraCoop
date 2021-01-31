@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'system_users'
])

@section('content')
    <div class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <form action="{{ route('system_user.index') }}" method="GET" enctype="multipart/form-data">
                                    @csrf
                                    @method('GET')
                                    <div class="form-group">
                                        <h3 class="mb-0">System Users</h3>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="search_string" class="form-control" id="searchSystemUser" aria-describedby="searchSystemUserHelp" placeholder="Search" value="{{ $search_string ?? '' }}">
                                    </div>

                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                        
                                        <a href="{{ route('system_user.create') }}" class="btn btn-primary btn-md">
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
                                        <th> User ID </th>
                                        <th> Name </th>
                                        <th> Email </th>
                                        <th> Contact </th>
                                        <th> Can Approve Loan </th>
                                        <th> Can Approve Contributions </th>
                                        <th> Can Transfer Fund </th>
                                        <th> Linked Member </th>
                                        <th> Linked Borrower </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($system_users as $system_user)
                                       
                                        <tr>
                                            <td>
                                                <a href="{{ route('system_user.edit', ['id' => $system_user->id]) }}" >
                                                    # {{ $system_user->id }}
                                                </a>
                                            </td>
                                            <td>
                                                {{ $system_user->name }}
                                            </td>
                                            <td>
                                                {{ $system_user->email }}
                                            </td>
                                            <td>
                                                {{ $system_user->contact }}
                                            </td>
                                            <td>
                                                {{ $system_user->can_approve_loans }}
                                            </td>
                                            <td>
                                                {{ $system_user->can_apprrove_contributions }}
                                            </td>
                                            <td>
                                                {{ $system_user->can_transfer_funds }}
                                            </td>
                                            <td>
                                                member name
                                            </td>    
                                            <td>
                                                borrower Name
                                            </td>
                                        </tr>
                                        
                                    @endforeach

                                    
                                </tbody>
                                
                            </table>
                        </div>

                        
                        <div>
                            <br>
                            {{ $system_users->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
@endsection