@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'transfers'
])

@section('content')
    <div class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <form action="{{ route('transfer.index') }}" method="GET" enctype="multipart/form-data">
                                    @csrf
                                    @method('GET')
                                    <div class="form-group">
                                        <h3 class="mb-0">Transfers</h3>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="search_string" class="form-control" id="searchTransfer" aria-describedby="searchTransferHelp" placeholder="Search" value="{{ $search_string ?? '' }}">
                                    </div>

                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                        
                                        <a href="{{ route('transfer.create') }}" class="btn btn-primary btn-md">
                                            &nbsp; New &nbsp;
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
                                        <th> Transfer ID </th>
                                        <th> From </th>
                                        <th> To </th>
                                        <th> Accepted </th>
                                        <th> Accepted By </th>
                                        <th> Bank </th>
                                        <th> Account </th>
                                        <th> Amount </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($transfers as $transfer)
                                       
                                        <tr>
                                            <td>
                                                <a href="{{ route('transfer.edit', ['id' => $transfer->id]) }}" >
                                                    # {{ $transfer->id }}
                                                </a>
                                            </td>
                                            <td>
                                                {{ $transfer->member_from_info->name }}
                                            </td>
                                            <td>
                                                {{ $transfer->member_to_info->name }}
                                            </td>
                                            <td>
                                                {{ $transfer->is_accepted ? 'Yes' : 'No' }}
                                            </td>
                                            <td>
                                                {{ $transfer->accepted_by_info->name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $transfer->bank_from }}
                                            </td>
                                            <td>
                                                {{ $transfer->account_number_from }}
                                            </td>  
                                            <td>
                                                {{ $transfer->amount }}
                                            </td>
                                        </tr>
                                        
                                    @endforeach

                                    
                                </tbody>
                                
                            </table>
                        </div>

                        
                        <div>
                            <br>
                            {{ $transfers->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
@endsection