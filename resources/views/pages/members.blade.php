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
                                <form action="{{ route('member.index') }}" method="GET" enctype="multipart/form-data">
                                    @csrf
                                    @method('GET')
                                    <div class="form-group">
                                        <h3 class="mb-0">Members</h3>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="search_string" class="form-control" id="searchMember" aria-describedby="searchMemberHelp" placeholder="Search" value="{{ $search_string ?? '' }}">
                                    </div>

                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                        
                                        @if(Helper::canUpdateRecords())
                                            <a href="{{ route('member.create') }}" class="btn btn-primary btn-md">
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
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Contact
                                        </th>
                                        <th>
                                            Monthly
                                        </th>
                                        <th>
                                            Total
                                        </th>
                                        <th>
                                            Distribute Share
                                        </th>
                                        <th>
                                            Address
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($members as $member)
                                        @if ($loop->first)
                                            <!-- This is the first iteration. -->
                                        @endif

                                        @if ($loop->last)
                                            <!-- This is the last iteration. -->
                                        @endif

                                        <tr>
                                            <td>
                                            <a href="{{ route('member.edit', ['id' => $member->id]) }}" class="">
                                                # {{ $member->id }}
                                            </a>
                                               
                                            </td>
                                            <td>
                                                {{ $member->name }}
                                            </td>
                                            <td>
                                                {{ $member->primary_contact }}
                                            </td>
                                            <td>
                                                {{ $member->monthly_contribution }}
                                            </td>
                                            <td>
                                                {{ $member->total_contribution }}
                                            </td>
                                            <td>
                                                {{ $member->distribution_schedule }}
                                            </td>
                                            <td>
                                                {{ $member->address }}
                                            </td>
                                        </tr>
                                    @endforeach

                                    
                                </tbody>
                                
                            </table>
                        </div>

                        
                        <div>
                            <br>
                            {{ $members->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
@endsection