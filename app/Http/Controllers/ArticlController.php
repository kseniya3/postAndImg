<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Articl;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ArticlController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:articl-list|articl-create|articl-edit|articl-delete', ['only' => ['index','show']]);
        $this->middleware('permission:articl-create', ['only' => ['create','store']]);
        $this->middleware('permission:articl-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:articl-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        return view('editor.index', ['posts'=>Articl::with('user')->paginate(4)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('editor.create');
    }

    protected function validator(array $data,$str_Carbon)
    {
        return Validator::make($data,[
            'name' => 'required|unique:articles,name|max:125',
            'date' => 'required|date|after_or_equal:'.$str_Carbon,
            'content' => 'required|max:1024',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $carbon = Carbon::now();
        $str_Carbon = (String)$carbon;
        $validate = self::validator($request->all(),$str_Carbon);
        if($validate->fails()){
            /* dd($validate->errors()); */
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $post = Articl::create([
            'name' => $request->get('name'),
            'date' => $request->get('date'),
            'content' => $request->get('content'),
            'user_id' => $request->user()->id,
        ]);

        if($post) {
            $post->save();
            return redirect('/articles')->with(['success' => 'Успешно сохранено']);
        }else{
            return back()->withErrors(['msg' => 'Ошибка сохранения!'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('editor.show', ['post' => Articl::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Articl::find($id);

        return view('editor.edit', ['post' => $post, 'users'=>User::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Articl::find($id);

        $validate=self::validator($request->all(),(string)$post->created_at);
        if($validate->fails()){
            /* dd($validate->errors()); */
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $post->name = $request->get('name');
        $post->date = $request->get('date');
        $post->content = $request->get('content');
        $post->user_id = $request->get('user_id');

        if($post) {
            $post->save();
            return redirect('/articles')->with(['success' => 'Успешно изменено!']);
        }else{
            return back()->withErrors(['msg' => 'Ошибка изменено!'])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Articl::find($id);

        if($post->user_id == auth()->user()->id){

            $post->delete();

            if($post->trashed()) {
                return redirect('/articles')->with(['success' => 'Успешно удалено!']);
            }else{
                return back()->withErrors(['msg' => 'Ошибка при удалении!'])->withInput();
            }
        } else{
            return back()->withErrors(['msg' => 'Вы не можете удалить статью другого пользователя!'])->withInput();
        }
    }

    public function delArticleShow()
    {
        return view('admin.deleteArticles', ['posts' => Articl::onlyTrashed()->get()]);
    }

    public function delArticle($id)
    {
        Articl::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect('/admin/delArticleShow')->with(['success' => 'Успешно удалено!']);

    }

}
