@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'company'
])

@section('content')
    <div class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <form action="{{ route('company.adjustment') }}" method="GET" enctype="multipart/form-data">
                                    @csrf
                                    @method('GET')
                                    <div class="form-group">
                                        <h3 class="mb-0">Company Adjustments</h3>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="search_string" class="form-control" id="searchLoan" aria-describedby="searchLoanHelp" placeholder="Search" value="{{ $search_string ?? '' }}">
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
                    
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <tr>
                                        <th> ID </th>
                                        <th> Type </th>
                                        <th> From </th>
                                        <th> To </th>
                                        <th> Adjusted By </th>
                                        <th> Date </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($company_adjustments as $company_adjustment)
                                       
                                        <tr>
                                            <td>
                                                # {{ $company_adjustment->id }}
                                            </td>
                                            <td>
                                                {{ $company_adjustment->type }}
                                            </td>
                                            <td>
                                                {{ $company_adjustment->amount_from }}
                                            </td>
                                            <td>
                                                {{ $company_adjustment->amount_to }}
                                            </td>
                                            <td>
                                                {{ $company_adjustment->user_adjusted->name }}
                                            </td>
                                            <td>
                                                {{ $company_adjustment->adjusted_at }}
                                            </td>
                                        </tr>
                                        
                                    @endforeach

                                    
                                </tbody>
                                
                            </table>
                        </div>

                        
                        <div>
                            <br>
                            {{ $company_adjustments->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
@endsection