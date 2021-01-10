@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'contributions'
])

@section('content')
    <div class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <form action="{{ route('contribution.index') }}" method="GET" enctype="multipart/form-data">
                                    @csrf
                                    @method('GET')
                                    <div class="form-group">
                                        <h3 class="mb-0">Contributions</h3>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="search_string" class="form-control" id="searchContribution" aria-describedby="searchContributionHelp" placeholder="Search" value="{{ $search_string ?? '' }}">
                                    </div>

                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                        
                                        <a href="{{ route('contribution.create') }}" class="btn btn-primary btn-md">
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
                                        <th> ID </th>
                                        <th> Member ID </th>
                                        <th> Name </th>
                                        <th> Period </th>
                                        <th> Amount </th>
                                        <th> Remarks </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($contributions as $contribution)
                                       
                                        <tr>
                                            <td>
                                            <a href="{{ route('contribution.edit', ['id' => $contribution->id]) }}" >
                                                # {{ $contribution->id }}
                                            </a>
                                            <td>
                                                <a href="{{ route('member.edit', ['id' => $contribution->id]) }}" >
                                                    {{ $contribution->member_id }}
                                                </a>
                                            </td>
                                            </td>
                                            <td>
                                                {{ $contribution->member->name }}
                                            </td>
                                            <td>
                                                {{ $contribution->period }}
                                            </td>
                                            <td>
                                                {{ $contribution->amount }}
                                            </td>
                                            <td>
                                                {{ $contribution->remarks }}
                                            </td>
                                            
                                            
                                        </tr>
                                    @endforeach

                                    
                                </tbody>
                                
                            </table>
                        </div>

                        
                        <div>
                            <br>
                            {{ $contributions->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
@endsection