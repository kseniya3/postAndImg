<?php

namespace App\Http\Controllers;

use App\Models\Articl;
use App\Models\Picture;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PictureController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:articl-list|articl-create|articl-edit|articl-delete', ['only' => ['index','show']]);
        $this->middleware('permission:articl-create', ['only' => ['create','store']]);
        $this->middleware('permission:articl-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:articl-delete', ['only' => ['destroy']]);
    }

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
        $blocName = $request->get('blocName');
        $imgOriginal = $request->file('image');


        if($blocName == 'home'){

            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=1400,height=750',
            ]);

            if($request->get('name') == null){
                $imgOriginalName = $imgOriginal->getClientOriginalName();
            }else{
                $imgOriginalName = $request->get('name') . '.' . $imgOriginal->getClientOriginalExtension();
            };
            $destinationPath = '\public\img\home';

            $imgOriginal->storeAs($destinationPath, $imgOriginalName);

            //$path = $request->file('image')->store($destinationPath);

            Picture::create([
                'name' => $imgOriginalName,
                'storage' => 'home',
                'path' => $destinationPath."\\". $imgOriginalName,
                'type' => $imgOriginal->getClientOriginalExtension(),
            ]);
        }else if($blocName == 'featured'){

            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=306,height=360',
            ]);

            if($request->get('name') == null){
                $imgOriginalName = $imgOriginal->getClientOriginalName();
            }else{
                $imgOriginalName = $request->get('name') . '.' . $imgOriginal->getClientOriginalExtension();
            };
            $destinationPath = '\public\img\featured';

            $imgOriginal->storeAs($destinationPath, $imgOriginalName);

            //$path = $request->file('image')->store($destinationPath);

            Picture::create([
                'name' => $imgOriginalName,
                'storage' => 'featured',
                'path' => $destinationPath."\\". $imgOriginalName,
                'type' => $imgOriginal->getClientOriginalExtension(),
            ]);

        }else if($blocName = 'blogEntire'){

            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=306,height=230',
            ]);

            if($request->get('name') == null){
                $imgOriginalName = $imgOriginal->getClientOriginalName();
            }else{
                $imgOriginalName = $request->get('name') . '.' . $imgOriginal->getClientOriginalExtension();
            };
            $destinationPath = '\public\img\blogEntires';

            $imgOriginal->storeAs($destinationPath, $imgOriginalName);

            //$path = $request->file('image')->store($destinationPath);

            Picture::create([
                'name' => $imgOriginalName,
                'storage' => 'blogEntires',
                'path' => $destinationPath,
                'type' => $imgOriginal->getClientOriginalExtension(),
            ]);

        }else if($blocName = 'recentWork'){


        }

//        $this->validate($request, [
//            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//        ]);
//
//        $imgOriginal = $request->file('image');
//        if($request->get('name') == null){
//            $imgOriginalName = $imgOriginal->getClientOriginalName();
//        }else{
//            $imgOriginalName = $request->get('name') . '.' . $imgOriginal->getClientOriginalExtension();
//        };
//
//        $destinationPath = storage_path('app\public\img\resize')."\\";
//
//        Picture::create([
//            'name' => $imgOriginalName,
//            'storage' => 'resize',
//            'path' => $destinationPath . $imgOriginalName,
//            'type' => $imgOriginal->getClientOriginalExtension(),
//        ]);
//
//        $img = Image::make($imgOriginal->path());
//        $img->resize(100, 100, function ($constraint) {
//            $constraint->aspectRatio();
//        })->save($destinationPath.$imgOriginalName);
//
//        $destinationPath = storage_path('app\public\img\original');
//        $imgOriginal->move($destinationPath, $imgOriginalName);
//
//        Picture::create([
//            'name' => $imgOriginalName,
//            'storage' => 'original',
//            'path' => "\\" . $destinationPath . "\\"  .$imgOriginalName,
//            'type' => $imgOriginal->getClientOriginalExtension(),
//        ]);

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

    public function addImgPostShow($id)
    {
        $picture = Picture::find($id);

        return view('picture.addShow', ['picture' => $picture, 'articles' => Articl::all()]);
    }

    public function addImgPost(Request $request, $id)
    {
        DB::table('pictures')->where('id', $id)->update(['articles_id' => $request->get('postId')]);
        return redirect('/pictures')->with(['success' => 'Успешно добавлено!']);
    }
}
