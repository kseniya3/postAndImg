@extends('adminlte::page')

@section('content')

    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success" href="{{route('articles.index')}}" role="button">Back</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @foreach($imgs as $img)
                        <div>
                            <img src="{{asset('storage/img/'.$img->storage.'/'.$img->name)}}" alt=""class="img-thumbnail">
                            <a class="users-list-name" href="#">{{'storage/img/'.$img->storage.'/'.$img->name}}</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection

