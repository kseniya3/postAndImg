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
                    <h3 class="box-title">Create Articles</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form  role="form" method="POST" action="{{route('articles.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Name</label>
                        <input name="name" class="form-control" id="exampleFormControlInput1" value="{{old('name')}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Date</label>
                        <input type="dateTime-local" min="2020-08-01T08:30" max="2030-06-30T16:30" name="date" class="form-control" value="{{old('date')}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Content</label>
                        <textarea name="content" class="form-control" id="content" maxlength="1024" rows="3">{{{ old('content') }}}</textarea>
                    </div>

                    <input type="hidden" name="user_id" value="{{auth()->user()->id}}">

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
