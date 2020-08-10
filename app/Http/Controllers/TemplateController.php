<?php

namespace App\Http\Controllers;

use App\Models\Articl;
use App\Models\Picture;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TemplateController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:articl-release', ['only' => ['index','destroy', 'addPost']]);
    }

    public function welcome()
    {
        $slider = Articl::where('bloc', 'home')->get();
        $featuredPost = Articl::where('bloc', 'featured')->get();
        $blogPost = Articl::where('bloc', 'blogEntires')->get();
        $blogPostDate = Articl::where('bloc', 'blogEntires')->get('date');
        $projects = Picture::where('storage', 'recentWork')->get();

        //dd($blogPost->sortBy('date'));


        return view('welcome',
            ['featuredPosts' => $featuredPost, 'sliderPosts' => $slider, 'projectImages' => $projects],
            ['blogPosts' => $blogPost->sortBy('date'), 'blogPostDate' => $blogPostDate->sortBy('date')]
        );
    }

    public function index()
    {
        return view('release.index', ['posts' => Articl::with('user')->paginate(5)]);
    }

    public function destroy($id)
    {
        DB::table('articles')->where('id', $id)->update(['bloc' => null]);

        return redirect('/template')->with(['success' => 'Успешно удалено!']);
    }

    public function addPost(Request $request)
    {
        DB::table('articles')->where('id', $request->get('postId'))->update(['bloc' => $request->get('blocName')]);
        return redirect('/template')->with(['success' => 'Успешно добавлено!']);
    }

}
