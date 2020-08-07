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
                    <h3 class="box-title">Edit Articl</h3>
                    @if($post->user != null)
                        <label for="post-title">Author: {{$post->user->name}}</label>
                    @else
                        <label for="post-title">Author: no</label>
                    @endif
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form method="POST" action="{{route('articles.update', $post->id)}}">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="exampleFormControlInput1">Name</label>
                        <input name="name" class="form-control" id="exampleFormControlInput1" value="{{$post->name}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Date</label>
                        <input type="text" name="date" value="{{$post->date}}" class="form-control" id="post-title">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Content</label>
                        <textarea name="content" class="form-control" id="content" rows="3">{{$post->content}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Example select</label>
                        <select name="user_id"  class="form-control" id="exampleFormControlSelect1">
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}} </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Edit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
