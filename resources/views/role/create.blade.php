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
            <h3 class="box-title">Create Role</h3>
        </div>
        <form  role="form" method="POST" action="{{route('roles.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="exampleFormControlInput1">Name</label>
                <input name="name" class="form-control" id="exampleFormControlInput1" value="{{old('name')}}">
            </div>
            <div class="form-check">
                <br/>
                @foreach($permissions as $permission)
                <input class="form-check-input" type="checkbox" name="permission[]" value="{{$permission->id}}" id="defaultCheck1">
                <label class="form-check-label" for="defaultCheck1">
                    {{$permission->name}}
                    <br/>
                </label>
                @endforeach
            </div>
            <button type="submit" class="btn btn-success">Create</button>
        </form>
    </div>
@endsection
