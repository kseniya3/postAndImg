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
                    <h3 class="box-title">Create Role</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form  role="form" method="POST" action="{{route('roles.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Name</label>
                        <input name="name" class="form-control" id="exampleFormControlInput1" value="{{old('name')}}">
                    </div>
                    <div class="form-check">
                        @foreach($permissions as $permission)
                            <input class="form-check-input" type="checkbox" name="permission[]" value="{{$permission->id}}">
                            <label class="form-check-label" for="defaultCheck1">
                                {{$permission->name}}
                            </label>
                            <br/>
                        @endforeach
                    </div>
                    <br/>
                    <button type="submit" class="btn btn-success">Create Role</button>
                </form>
            </div>
        </div>
    </div>
@endsection
