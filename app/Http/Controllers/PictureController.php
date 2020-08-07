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
use App\Jobs\ResizeImageSave;

class PictureController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:picture-list|picture-create|picture-edit|picture-delete', ['only' => ['index','show']]);
        $this->middleware('permission:picture-create', ['only' => ['create','store']]);
        $this->middleware('permission:picture-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:picture-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        return view('picture.index', ['pictures'=>Picture::with('articl')->paginate(4)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     *
     */
    public function create()
    {
        return view('picture.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     *
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

            Picture::create([
                'name' => $imgOriginalName,
                'storage' => 'featured',
                'path' => $destinationPath."\\". $imgOriginalName,
                'type' => $imgOriginal->getClientOriginalExtension(),
            ]);

        }else if($blocName == 'blogEntire'){

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

            Picture::create([
                'name' => $imgOriginalName,
                'storage' => 'blogEntires',
                'path' => $destinationPath,
                'type' => $imgOriginal->getClientOriginalExtension(),
            ]);

        }else if($blocName == 'recentWork'){

            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            if($request->get('name') == null){
                $imgOriginalName = $imgOriginal->getClientOriginalName();
            }else{
                $imgOriginalName = $request->get('name') . '.' . $imgOriginal->getClientOriginalExtension();
            };
            $destinationPath = '\public\img\original';

            $imgOriginal->storeAs($destinationPath, $imgOriginalName);

            Picture::create([
                'name' => $imgOriginalName,
                'storage' => 'recentWork',
                'path' => $destinationPath,
                'type' => $imgOriginal->getClientOriginalExtension(),
            ]);
        }
        return back()->with('success','Image Upload successful');
    }

    /**
     * Display the specified resource.
     *
     *
     */
    public function show($id)
    {
        return view('picture.show', ['picture' => Picture::find($id)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     *
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

    public function resizeShow($id)
    {
        return view('picture.resizeShow',  ['picture' => Picture::find($id)]);
    }

    public function resize(Request $request, $id)
    {
        $this->validate($request, [
            'width' => 'required|integer|max:1024|min:1',
            'height' => 'required|integer|max:1024|min:1',
        ]);

        $imgOriginal = Picture::find($id);

        ResizeImageSave::dispatch($imgOriginal, $request->get('width'), $request->get('height'));

        return redirect('/pictures ')->with(['success' => 'Успешно добавлено!']);
    }
}
