@extends('adminlte::page')

@section('content')
    <div class="row background-row">
        <div class="card">
            <div class="box">
                <div class="box-header with-border">
                    <div class="col-md-12">
                        <div class="card-header">
                            <h3 class="card-title">Articles Table</h3>

                            <div class="card-tools">
                                <ul class="pagination pagination-sm float-right">
                                    {{$posts->links()}}
                                </ul>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th style="width: 40px">Date</th>
                                    <th style="width: 40px">User</th>
                                    <th></th>
                                    <th>
                                        <a class="btn btn-success btn-block" href="{{route('articles.create')}}" role="button">Create</a>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($posts as $post)
                                    <tr>
                                        <td>{{ $post->name }}</td>
                                        <td>{{ $post->date }}</td>
                                        <td>{{ $post->user()->pluck('name')->implode('')}}</td>
                                        <td>{{ substr($post->content, 0, 130)}}</td>
                                        <td>
                                            <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                                                <div class="btn-group mr-2" role="group" aria-label="First group">
                                                    <a class="btn btn-primary" href="{{route('articles.show', $post->id)}}" role="button">Show</a>
                                                </div>
                                                <div class="btn-group mr-2" role="group" aria-label="Second group">
                                                    <a class="btn btn-primary" href="{{route('articles.edit', $post->id)}}" role="button">Edit</a>
                                                </div>
                                                <form method="POST" action="{{route('articles.destroy', $post->id)}}">
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

