@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-body no-padding">
                        <strong>Original Image:</strong>
                        <br/>
                        <img src="{{url('/images/')}}{{'/'.$picture->name}}" alt="Image"/>
                    </div>
                    <a class="btn btn-success" href="{{route('pictures.index')}}" role="button">Back</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <strong>Resize Image:</strong>
                        <br/>
                        <img src="{{url('/img/')}}{{'/'.$picture->name}}" alt="Image"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

