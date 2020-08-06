@extends('adminlte::page')

@section('content')
    <div class="box box-primary">
        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="box-header with-border">
            <h3 class="box-title">Create Deal</h3>
        </div>
        <form  role="form" method="POST" action="{{route('admin.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="exampleFormControlInput1">Name</label>
                <input name="name" class="form-control" id="exampleFormControlInput1" value="{{old('name')}}">
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Email</label>
                <input type="email" name="email" value="{{old('email')}}" class="form-control" id="post-title">
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Password</label>
                <input type="password" name="password"  class="form-control" id="post-title">
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Password</label>
                <input type="password" name="confirm-password" class="form-control" id="post-title">
            </div>

            <div class="form-group">
                <label for="exampleFormControlSelect1">Roles</label>
                <select name="roles"  class="form-control" id="exampleFormControlSelect1">
                    @foreach($roles as $role)
                        <option value="{{$role}}">{{$role}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">Edit</button>
        </form>
    </div>
@endsection
