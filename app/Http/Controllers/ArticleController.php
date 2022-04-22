<?php

namespace App\Http\Controllers;
use App\Models\ab_article;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\NewArticleRequest;

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

    public function insert_article(NewArticleRequest $request){
        $newArticle = new ab_article();
        $newArticle->ab_name = $request->post('article_name');
        $newArticle->ab_price = $request->post('article_price');
        $newArticle->ab_description = $request->post('article_desc');
        $newArticle->ab_creator_id = '5';
        $newArticle->ab_createdate = '1970-01-01 00:00:00';
        $newArticle->save();
        return redirect()->route('articles');
    }

    public function learn_js(Request $request){
        return view('js_learning');
    }

    public function json_reader(Request $request){
        return view('json_reader');
    }

}

