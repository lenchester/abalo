<?php


namespace App\Http\Controllers;

use App\Models\ab_article;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\NewArticleRequest;

class newarticleAPIController extends Controller
{
    public function insert_article(NewArticleRequest $request){
        $newArticle = new ab_article();
        $newArticle->ab_name = $request->post('article_name');
        $newArticle->ab_price = $request->post('article_price');
        $newArticle->ab_description = $request->post('article_desc');
        $newArticle->ab_creator_id = '5';
        $newArticle->ab_createdate = '1970-01-01 00:00:00';
        try {
            $newArticle->save();
            return response()->json($newArticle->id);
        }
        catch (Throwable $e)
        {
            return response($e->getMessage(), 422);
        }
    }
}
