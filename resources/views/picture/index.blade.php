@extends('adminlte::page')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                @if(count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-header">
                    <h3 class="card-title">Picture Table</h3>
                    <div class="card-tools">
                        <ul class="pagination pagination-sm float-right">
                            {{$pictures->links()}}
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Storage</th>
                            <th>Path</th>
                            <th>Resize</th>
                            <th>Articles</th>
                            <th>
                                <a class="btn btn-success" href="{{route('pictures.create')}}" role="button">Create</a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pictures as $picture)
                            <tr>
                                <td>{{ $picture->name }}</td>
                                <td>{{ $picture->storage }}</td>
                                <td>{{ $picture->path }}</td>
                                @if($picture->articles_id == null)
                                    <td>
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <a class="btn btn-primary" href="{{route('pictures.addImgPostShow', $picture->id)}}" role="button">Add</a>
                                        </div>
                                    </td>
                                @else
                                    <td>{{$picture->articles_id}}</td>
                                @endif
                                <th>
                                    <a class="btn btn-success btn-block" href="{{route('pictures.resizeShow', $picture->id)}}" role="button">Resize</a>
                                </th>
                                <td>
                                    <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <a class="btn btn-primary" href="{{route('pictures.show', $picture->id)}}" role="button">Show</a>
                                        </div>
                                        <form method="POST" action="{{route('pictures.destroy', $picture->id)}}">
                                            @csrf
                                            @method('DELETE')
                                            <div class="btn-group" role="group" aria-label="Third group">
                                                <button class="btn btn-danger">Delete</button>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

