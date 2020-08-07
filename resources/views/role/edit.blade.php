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
        <div class="col-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Role</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form method="POST" action="{{route('roles.update', $role->id)}}">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Name</label>
                        <input name="name" class="form-control" id="exampleFormControlInput1" value="{{$role->name}}">
                    </div>
                    <div class="form-check">
                        @foreach($permissions as $permission)
                            <input class="form-check-input" type="checkbox" name="permission[]" value="{{$permission->id}}" @if($role->permissions->contains($permission->id)) checked=checked @endif>
                            <label class="form-check-label" for="defaultCheck1">
                                {{$permission->name}}
                            </label>
                            <br/>
                        @endforeach
                    </div>
                    <br/>
                    <button type="submit" class="btn btn-success">Edit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
