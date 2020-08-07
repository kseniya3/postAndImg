@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                @if(count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-header">
                    <h3 class="card-title">Articles Table</h3>
                </div>
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
            </div>
        </div>
    </div>
@endsection

