@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <div class="box">
                    <div class="box-body no-padding">
                        <a class="btn btn-success" href="{{route('pictures.index')}}" role="button">Image</a>
                        <br/>
                        <br/>
                        <img src="{{url('storage/img/' . $picture->storage . '/' . $picture->name)}}" alt="Image"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

