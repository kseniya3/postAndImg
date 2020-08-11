@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                @if(count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <strong>Resize Image:</strong>
                        <br/>
                        <img src="{{url('storage/img/' . $picture->storage . '/' . $picture->name)}}" width="300" height="200" alt="Image"/>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <form  role="form" method="POST" action="{{route('pictures.addImgPost', $picture->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <div class="form-group">
                                <select class="form-control" name="postId">
                                    @foreach($articles as $article)
                                        <option value="{{$article->id}}">{{$article->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

