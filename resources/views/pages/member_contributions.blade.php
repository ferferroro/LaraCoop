@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'members'
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
                                        <h3 class="mb-0">{{ $member->name ?? '' }}'s Contributions</h3>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="search_string" class="form-control" id="searchString" aria-describedby="searchStringHelp" placeholder="Search" value="{{ $search_string ?? '' }}">
                                        <input type="hidden" name="member_id" class="form-control" id="searchMember" aria-describedby="searchMemberHelp" placeholder="Search" value="{{ $member->id ?? '' }}">
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
                                        <th> ID </th>
                                        <th> Approved </th>
                                        <th> Member </th>
                                        <th> Period </th>
                                        <th> Amount </th>
                                        <th> Remarks </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($member_contributions as $contribution)
                                       
                                        <tr>
                                            <td>
                                            <a href="{{ route('contribution.edit', ['id' => $contribution->id]) }}" >
                                                # {{ $contribution->id }}
                                            </a>
                                            <td>
                                                {{ $contribution->is_approved ? 'Yes' : 'No' }}
                                            </td>
                                            <td>
                                                <a href="{{ route('member.edit', ['id' => $contribution->member_id]) }}" >
                                                    {{ $contribution->member_id }} - {{ $contribution->member->name }}
                                                </a>
                                            </td>
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
                            {{ $member_contributions->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
@endsection