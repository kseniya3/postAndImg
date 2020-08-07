@extends('adminlte::page')

@section('content')
    <div class="box box-primary">
        <div class="col-6">
            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Image Resize</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form method="post" action="{{ route('pictures.resize', $picture->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body no-padding">
                        <img src="{{url('/img/')}}{{'/'.$picture->name}}" alt="Image"/>
                    </div>
                    <br/>
                    <div class="form-group">
                        <label>Width</label>
                        <input name="width" class="form-control" value="{{old('width')}}">
                        <label>Height</label>
                        <input name="height" class="form-control" value="{{old('height')}}" >
                    </div>

                    <button type="submit" class="btn btn-success">Resize Image</button>
                </form>
            </div>
        </div>
    </div>
@endsection
