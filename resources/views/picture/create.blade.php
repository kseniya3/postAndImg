@extends('adminlte::page')

@section('content')
    <div class="container">
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
        <h1 align="center">Image Resize</h1>
        <br />
        <form method="post" action="{{ route('pictures.store') }}" enctype="multipart/form-data">
            @CSRF
            <div class="form-group">
                <div class="form-group">
                    <select class="form-control" name="blocName">
                        <option value="home">Home</option>
                        <option value="featured">Featured</option>
                        <option value="recentWork">Recent Work</option>
                        <option value="blogEntire">Blog Entires</option>
                    </select>
                </div>
            </div>
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
    </div>
@endsection
