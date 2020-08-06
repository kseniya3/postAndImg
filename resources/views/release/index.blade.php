@extends('adminlte::page')

@section('content')
    <div class="row background-row">
        <div class="card">
            <div class="box">
                <div class="box-header with-border">
                    <div class="col-md-12">
                        <div class="card-header">
                            <h3 class="card-title">Articles Table</h3>
                        </div>
                        <div class="card-body">
                            <form  role="form" method="POST" action="{{route('template.addPost')}}" enctype="multipart/form-data">
                                @csrf
                                <table class="table">
                                    @csrf
                                    <div class="form-group">
                                        <div class="form-group">
                                            <select class="form-control" name="blocName">
                                                <option value="home">Home</option>
                                                <option value="featured">Featured</option>
                                                <option value="recentWork">Recent Work</option>
                                                <option value="blogEntires">Blog Entires</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <select class="form-control" name="postId">
                                                @foreach($posts as $post)
                                                    <option value="{{$post->id}}">{{$post->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </table>
                            </form>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th style="width: 40px">Date</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($posts as $post)
                                    <tr>
                                        <td>{{ $post->name }}</td>
                                        <td>{{ $post->bloc}}</td>
                                        <td>
                                            <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                                                <form method="POST" action="{{route('template.destroy', $post->id)}}">
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

