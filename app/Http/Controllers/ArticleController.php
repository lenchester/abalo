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
            $articles = DB::table('ab_articles')->select('ab_name','ab_price')->where('ab_name', 'ILIKE','%'.$search.'%')->get();
        }
        else {
            $articles = ab_article::all();
        }
        return view('articles',['articles'=>$articles]);
    }

    public function new_article(Request $request){
        return view('newarticle');
    }

    public function insert_article(Request $request){
        //dd($request->post());
        $newArticle = new ab_article();
        $newArticle->id = 39;
        $newArticle->ab_name = request('article_name');
        $newArticle->ab_price = request('article_price');
        $newArticle->ab_description = request('article_desc');
        $newArticle->ab_creator_id = '5';
        $newArticle->ab_createdate = '1970-01-01 00:00:00';
        $newArticle->save();

        //return view('articles');
    }

    public function learn_js(Request $request){
        return view('js_learning');
    }

    public function json_reader(Request $request){
        return view('json_reader');
    }

}
