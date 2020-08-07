@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
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
                    <h3 class="card-title">Admin Table</h3>
                    <div class="card-tools">
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 10px">Name</th>
                                <th style="width: 10px">Role</th>
                                <th style="width: 10px">Permissions</th>
                                <th style="width: 10px">Email</th>
                                <th style="width: 20px">
                                    <a class="btn btn-success" href="{{route('admin.create')}}" role="button">Create</a>
                                    <a class="btn btn-danger" href="{{route('admin.delArticleShow')}}" role="button">HardDel</a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->roles->pluck('name')->implode('')}}</td>
                                <td>
                                    @foreach($user->roles as $role)
                                        @foreach($role->permissions as $permission)
                                            {{ $permission->name }}
                                        @endforeach
                                    @endforeach
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                                        <div class="btn-group mr-2" role="group" aria-label="Second group">
                                            <a class="btn btn-primary" href="{{route('admin.edit', $user->id)}}" role="button">Edit</a>
                                        </div>
                                        <form method="POST" action="{{route('admin.destroy', $user->id)}}">
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
@endsection

