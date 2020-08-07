@extends('adminlte::page')

@section('content')
    <div class="box box-primary">
        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="col-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Image Resize</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form method="post" action="{{ route('pictures.store') }}" enctype="multipart/form-data">
                    @csrf
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
            </div>
        </div>
    </div>
@endsection
