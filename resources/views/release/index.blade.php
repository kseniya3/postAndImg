@extends('adminlte::page')

@section('content')

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Post Release Table</h3>
                    <div class="card-tools">
                        <ul class="pagination pagination-sm float-right">
                            {{$posts->links()}}
                        </ul>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th style="width: 40px">Img</th>
                            <th style="width: 40px">Bloc</th>
                            <th style="width: 40px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td>{{ $post->name }}</td>
                                @foreach($post->pictures as $img)
                                    <td>{{ $img->name}}</td>
                                @endforeach
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
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Articles Table</h3>
                </div>
                <!-- /.card-header -->
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
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
@endsection

