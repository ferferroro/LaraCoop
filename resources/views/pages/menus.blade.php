@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'menus'
])

@section('content')
    <div class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <form action="{{ route('menu.index') }}" method="GET" enctype="multipart/form-data">
                                    @csrf
                                    @method('GET')
                                    <div class="form-group">
                                        <h3 class="mb-0">Menus</h3>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="search_string" class="form-control" id="searchMenu" aria-describedby="searchMenuHelp" placeholder="Search" value="{{ $search_string ?? '' }}">
                                    </div>

                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                        
                                        <a href="{{ route('menu.create') }}" class="btn btn-primary btn-md">
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
                                        <th> Menu ID </th>
                                        <th> Display Name </th>
                                        <th> Element Name </th>
                                        <th> Route Name </th>
                                        <th> Link </th>
                                        <th> Sequence </th>
                                        <th> Icon Class </th>
                                        <th> Restricted </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($menus as $menu)
                                       
                                        <tr>
                                            <td>
                                                <a href="{{ route('menu.edit', ['id' => $menu->id]) }}" >
                                                    # {{ $menu->id }}
                                                </a>
                                            </td>
                                            <td>
                                                {{ $menu->display_name }}
                                            </td>
                                            <td>
                                                {{ $menu->element_name }}
                                            </td>
                                            <td>
                                                {{ $menu->route }}
                                            </td>
                                            <td>
                                                {{ $menu->link }}
                                            </td>
                                            <td>
                                                {{ $menu->sequence }}
                                            </td>
                                            <td>
                                                {{ $menu->icon_class }}
                                            </td>    
                                            <td>
                                                {{ $menu->restricted }}
                                            </td>
                                        </tr>
                                        
                                    @endforeach

                                    
                                </tbody>
                                
                            </table>
                        </div>

                        
                        <div>
                            <br>
                            {{ $menus->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
@endsection