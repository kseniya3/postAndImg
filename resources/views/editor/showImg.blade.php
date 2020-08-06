@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pictures Table</h3>
                <div class="card-tools">
                    <ul class="pagination pagination-sm float-right">
                        {{$pictures->links()}}
                    </ul>
                </div>
            </div>
        </div>

        <form  role="form" method="POST" action="{{route('template.addPost')}}" enctype="multipart/form-data">
            @csrf
            <table class="table">
                <div class="card-body">
                    <div class="row">
                        @foreach($pictures as $picture)
                            <div class="col-md-4">
                                <img src="{{asset('storage/img/'.$picture->storage.'/'.$picture->name)}}" alt=""class="img-thumbnail">
                                <a class="users-list-name" href="#">{{'storage/img/'.$picture->storage.'/'.$picture->name}}</a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </table>
        </form>
        </div>
    </div>
@endsection

