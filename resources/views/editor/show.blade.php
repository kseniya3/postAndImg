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
                                        <a class="btn btn-success btn-block" href="{{route('articles.index')}}" role="button">Back</a>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $post->name }}</td>
                                        <td>{{ $post->date }}</td>
                                        <td>{{ $post->user()->pluck('name')->implode('')}}</td>
                                        <td>{{ $post->content}}</td>
                                    </tr>
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

