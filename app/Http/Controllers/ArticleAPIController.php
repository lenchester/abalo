<?php


namespace App\Http\Controllers;

use App\Models\ab_article;
use App\Models\ab_shoppingcart;
use App\Models\ab_shoppingcart_item;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\NewArticleRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ArticleAPIController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->get('search');
        if ($search) {
            $articles = DB::table('ab_articles')->select('ab_name', 'ab_price')->where('ab_name', 'ILIKE', '%' . $search . '%')->get();
        } else {
            $articles = ab_article::all();
        }
        return response()->json($articles);
    }

    public function available_articles(Request $request)
    {
        if($request->get('shoppingcartid') != null)
        {
            $available_articles = DB::table('ab_articles')
                ->leftJoin('ab_shoppingcart_item', 'ab_articles.id', '=', 'ab_shoppingcart_item.ab_article_id')
                ->whereNull('ab_shoppingcart_item.id')
                ->select('ab_articles.*')->limit(5)->orderBy('ab_name')->get();
        }
        else
        {
            $available_articles = DB::table('ab_articles')->select('ab_articles.*')->orderBy('ab_name')->limit(5)->get();
        }

        return response()->json($available_articles);
    }

    public function search_offset(Request $request)
    {
        $search = $request->get('search');
        $offset = $request->get('offset');
        Log::debug(auth()->id());
        //Log::debug($offset);
        if($request->get('shoppingcartid') != null)
        {
            $available_articles = DB::table('ab_articles')
                ->leftJoin('ab_shoppingcart_item', 'ab_articles.id', '=', 'ab_shoppingcart_item.ab_article_id')
                ->whereNull('ab_shoppingcart_item.id')
                ->select('ab_articles.*')->limit(5)
                ->where('ab_name', 'ILIKE', '%' . $search . '%')
                ->limit(5)
                ->offset($offset)
                ->orderBy('ab_name')->get();
        }
        else
        {
            $available_articles = DB::table('ab_articles')
                ->select('ab_articles.*')
                ->orderBy('ab_name')
                ->where('ab_name', 'ILIKE', '%' . $search . '%')
                ->limit(5)
                ->offset($offset)
                ->get();
        }

        return response()->json($available_articles);
    }
    public function number_of_search_results(Request $request){
        $search = $request->get('search');
        if($request->get('shoppingcartid') != null)
        {
            $number_of_results = DB::table('ab_articles')
                ->leftJoin('ab_shoppingcart_item', 'ab_articles.id', '=', 'ab_shoppingcart_item.ab_article_id')
                ->whereNull('ab_shoppingcart_item.id')
                ->select( DB::raw('COUNT(ab_name)'))
                ->where('ab_name', 'ILIKE', '%' . $search . '%')
                ->get();
        }
        else
        {
            $number_of_results = DB::table('ab_articles')
                ->select(DB::raw('COUNT(ab_name)'))
                ->where('ab_name', 'ILIKE', '%' . $search . '%')
                ->get();
        }
        return response()->json($number_of_results);
    }

    public function shoppingcart_items(Request $request)
    {
        $shoppingcart_items = DB::table('ab_shoppingcart_item')
            ->where('ab_shoppingcart_item.ab_shoppingcart_id', '=', $request->get('shoppingcartid'))
            ->join('ab_articles', 'ab_articles.id', '=', 'ab_shoppingcart_item.ab_article_id')
            ->select('ab_articles.id', 'ab_articles.ab_name', 'ab_articles.ab_price', 'ab_shoppingcart_item.ab_shoppingcart_id')->get();
        return response()->json($shoppingcart_items);
    }

    public function add_to_cart(Request $request)
    {
        $shoppingcartid = $request->post('shoppingcartid');
        $articleid = $request->post('articleid');
        $creatorid = $request->post('creatorid');

        if($shoppingcartid == null)
        {
            $newshoppingcart = new ab_shoppingcart();
            $newshoppingcart->ab_creator_id = $creatorid;
            $newshoppingcart->ab_createdate = DB::raw('CURRENT_TIMESTAMP');
            $newshoppingcart->save();
            $shoppingcartid = $newshoppingcart->id;
        }
        $newshoppingcartitem = new ab_shoppingcart_item();
        $newshoppingcartitem->ab_shoppingcart_id = $shoppingcartid;
        $newshoppingcartitem->ab_article_id = $articleid;
        $newshoppingcartitem->ab_createdate = DB::raw('CURRENT_TIMESTAMP');
        $newshoppingcartitem->save();
        return response()->json($shoppingcartid);
    }

    public function remove_from_cart($shoppingcartid, $articleid)
    {
        DB::table('ab_shoppingcart_item')
            ->where([
                ['ab_shoppingcart_id', '=', $shoppingcartid],
                ['ab_article_id', '=', $articleid]
            ])
            ->delete();
        if(DB::table('ab_shoppingcart_item')->where('ab_shoppingcart_id', '=', $shoppingcartid)->count() == 0)
        {
            return $this->remove_all_from_cart($shoppingcartid);
        }
        return response()->json($shoppingcartid);
    }

    public function remove_all_from_cart($shoppingcartid)
    {
        DB::table('ab_shoppingcart')
            ->where('id', '=', $shoppingcartid)
            ->delete();
        return response()->json(null);
    }
}
