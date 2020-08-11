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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('picture.index', ['pictures'=>Picture::with('articl')->paginate(4)]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('picture.create');
    }

    /**
     * Добавлние img по блокам. Сайт разбит на 4 блока (home,featured,blogEntire,recentWork).
     * Для каждого блока отдельная папка для хранения
     * Для каждого блока определенной размерности изображение (исключение recentWork)
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $blocName = $request->get('blocName');
        $imgOriginal = $request->file('image');

        if($request->get('name') == null){
            $imgOriginalName = $imgOriginal->getClientOriginalName();
        }else{
            $imgOriginalName = $request->get('name') . '.' . $imgOriginal->getClientOriginalExtension();
        };

        if($blocName == 'home'){

            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=1400,height=750',
            ]);

            $destinationPath = '\public\img\home';
            $imgOriginal->storeAs($destinationPath, $imgOriginalName);

        }else if($blocName == 'featured'){

            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=306,height=360',
            ]);

            $destinationPath = '\public\img\featured';
            $imgOriginal->storeAs($destinationPath, $imgOriginalName);

        }else if($blocName == 'blogEntire'){

            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=306,height=230',
            ]);

            $destinationPath = '\public\img\blogEntire';
            $imgOriginal->storeAs($destinationPath, $imgOriginalName);

        }else if($blocName == 'recentWork'){

            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $destinationPath = '\public\img\recentWork';
            $imgOriginal->storeAs($destinationPath, $imgOriginalName);
        }

        Picture::create([
            'name' => $imgOriginalName,
            'storage' => $blocName,
            'path' => $destinationPath,
            'type' => $imgOriginal->getClientOriginalExtension(),
        ]);

        return back()->with('success','Image Upload successful');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        return view('picture.show', ['picture' => Picture::find($id)]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
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

    /**
     *  К img привязать post
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addImgPostShow($id)
    {
        return view('picture.addShow', ['picture' => Picture::find($id), 'articles' => Articl::all()]);
    }

    /**
     * К img привязать post
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function addImgPost(Request $request, $id)
    {
        $articl = Articl::find($request->get('postId'));

        if($articl->pictures->count() == 0)
        {
            DB::table('pictures')->where('id', $id)->update(['articles_id' => $request->get('postId')]);
            return redirect('/pictures')->with(['success' => 'Успешно добавлено!']);
        } else{
            return redirect('/pictures')->with(['success' => 'Нет!']);
        }
    }

    /**
     * Job/Queue
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resizeShow($id)
    {
        return view('picture.resizeShow',  ['picture' => Picture::find($id)]);
    }

    /**
     * Job/Queue
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
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
