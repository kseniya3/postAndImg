<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('picture.index', ['pictures'=>Picture::with('articl')->paginate(4)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('picture.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imgOriginal = $request->file('image');
        if($request->get('name') == null){
            $imgOriginalName = $imgOriginal->getClientOriginalName();
        }else{
            $imgOriginalName = $request->get('name') . '.' . $imgOriginal->getClientOriginalExtension();
        };

        $destinationPath = storage_path('app\public\img\resize')."\\";

        Picture::create([
            'name' => $imgOriginalName,
            'storage' => 'resize',
            'path' => $destinationPath . $imgOriginalName,
            'type' => $imgOriginal->getClientOriginalExtension(),
        ]);

        $img = Image::make($imgOriginal->path());
        $img->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.$imgOriginalName);

        $destinationPath = storage_path('app\public\img\original');
        $imgOriginal->move($destinationPath, $imgOriginalName);

        Picture::create([
            'name' => $imgOriginalName,
            'storage' => 'original',
            'path' => "\\" . $destinationPath . "\\"  .$imgOriginalName,
            'type' => $imgOriginal->getClientOriginalExtension(),
        ]);

        return back()
            ->with('success','Image Upload successful');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('picture.show', ['picture' => Picture::find($id)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $img = Picture::find($id);

        if(file_exists(storage_path('app\public\img')."\\". $img->storage . "\\" . $img->name))
        {
             Storage::disk("images")->delete($img->storage . "\\" . $img->name);
             $img->delete();
            return redirect('/pictures')->with(['success' => 'Успешно удалено!']);
        }else {
            return redirect('/pictures')->with(['success' => 'Нет файла!']);
        }
    }
}
