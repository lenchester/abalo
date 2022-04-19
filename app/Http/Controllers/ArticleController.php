<?php

namespace App\Http\Controllers;
use App\Models\ab_article;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function index(Request $request){
        $search = $request->get('search');
        if($search) {
            $articles = DB::table('ab_articles')->select('ab_name')->where('ab_name', 'ILIKE','%'.$search.'%')->get();
        } else {
            $articles = ab_article::all();
        }
        return view('articles',['articles'=>$articles]);
    }

    public function learn_js(Request $request){
        return view('js_learning');
    }

    public function json_reader(Request $request){
        return view('json_reader');
    }
}
