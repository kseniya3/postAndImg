@extends('adminlte::page')

@section('content')
    <div class="row background-row">
        <div class="card">
            <div class="box">
                <div class="box-header with-border">
                    <div class="col-md-12">

                        @if(count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="card-header">
                            <h3 class="card-title">Roles Table</h3>

                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    {{$roles->links()}}
                                </ul>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th></th>
                                    <th></th>
                                    <th>
                                        <a class="btn btn-success btn-block" href="{{route('roles.create')}}" role="button">Create</a>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($roles as $role)
                                    <tr>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @foreach($role->permissions as $permission)
                                            {{ $permission->name}}
                                            @endforeach
                                        </td>
                                        <td></td>
                                        <td>
                                            <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                                                <div class="btn-group mr-2" role="group" aria-label="Second group">
                                                    <a class="btn btn-primary" href="{{route('roles.edit', $role->id)}}" role="button">Edit</a>
                                                </div>
                                                <form method="POST" action="{{route('roles.destroy', $role->id)}}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="btn-group" role="group" aria-label="Third group">
                                                        <button class="btn btn-danger">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

