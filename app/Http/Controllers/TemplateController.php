<?php

namespace App\Http\Controllers;

use App\Models\Articl;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TemplateController extends Controller
{
    public function welcome()
    {
        $slider = Articl::where('bloc', 'home')->get();
        $featuredPost = Articl::where('bloc', 'featured')->get();
        $blogPost = Articl::where('bloc', 'blogEntires')->get();

        return view('welcome', ['featuredPosts' => $featuredPost, 'sliderPosts' => $slider, 'blogPosts' => $blogPost]);
    }

    public function index()
    {
        return view('release.index', ['posts' => Articl::all()]);
    }

    public function show()
    {
        return view('welcome');
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
