<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Articl;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ArticlController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:articl-list|articl-create|articl-edit|articl-delete', ['only' => ['index','show']]);
        $this->middleware('permission:articl-create', ['only' => ['create','store']]);
        $this->middleware('permission:articl-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:articl-delete', ['only' => ['destroy']]);
        $this->middleware('permission:articl-deleteHARD', ['only' => ['delArticle']]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
       return view('editor.index', ['posts'=>Articl::with('user')->paginate(4)]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('editor.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $carbon = Carbon::now();
        $str_Carbon = (String)$carbon;

        $this->validate($request, [
            'name' => 'required|unique:articles,name|max:125',
            'date' => 'required|date|after_or_equal:'.$str_Carbon,
            'content' => 'required|max:1024',
        ]);

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
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        return view('editor.show', ['post' => Articl::find($id)]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        return view('editor.edit', ['post' => Articl::find($id), 'users'=>User::all()]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $post = Articl::find($id);

        $this->validate($request, [
            'name' => 'required|max:125',
            'date' => 'required|date|',
            'content' => 'required|max:1024',
        ]);

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
     *  Мягкое удаление
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $post = Articl::find($id);

        if ($post->user_id == auth()->user()->id) {

            $post->pictures()->delete();

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

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delArticleShow()
    {
        return view('admin.deleteArticles', ['posts' => Articl::onlyTrashed()->get()]);
    }

    /**
     *  Жесткое удаление
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delArticle($id)
    {
        Articl::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect('/admin/delArticleShow')->with(['success' => 'Успешно удалено!']);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addImgShow($id)
    {
        return view('editor.showImg', ['imgs' => Articl::find($id)->pictures]);
    }


}
