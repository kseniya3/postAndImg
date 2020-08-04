@extends('adminlte::page')

@section('content')
    <div class="row background-row">
        <div class="card">
            <div class="box">
                <div class="box-header with-border">
                    <div class="col-md-12">
                        <div class="card-header">
                            <h3 class="card-title">Admin Table</h3>

                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    {{--                                    {{$users->links()}}--}}
                                </ul>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th style="width: 40px">Role</th>
                                    <th style="width: 40px">Email</th>
                                    <th>
                                        <a class="btn btn-success btn-block" href="{{route('admin.create')}}" role="button">Create</a>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{$user->roles->pluck('name','name')->implode('')}}</td>
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
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

