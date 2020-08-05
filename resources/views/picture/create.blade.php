@extends('adminlte::page')

@section('content')
    <div class="container">
        <br />
        <h1 align="center">Image Resize</h1>
        <br />
        <form method="post" action="{{ route('pictures.store') }}" enctype="multipart/form-data">
            @CSRF
            <div class="form-group">
                <label>Name Pictures</label>
                <input type="text" class="form-control" name="name">
            </div>
            <div class="form-group">
                <label>Select Image</label>
                <input type="file" name="image" class="image" />
            </div>

            <button type="submit" class="btn btn-success">Upload Image</button>
        </form>
        <br />
        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($message = session()->get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <strong>Original Image:</strong>
                    <br/>
                    <img src="{{url('/images/')}}{{'/'.session()->get('imageName')}}" alt="Image"/>
                </div>
                <div class="col-md-4">
                    <strong>Thumbnail Image:</strong>
                    <br/>
                    <img src="{{url('/img/')}}{{'/'.session()->get('imageName')}}" alt="Image"/>
                </div>
            </div>
        @endif
    </div>
@endsection
