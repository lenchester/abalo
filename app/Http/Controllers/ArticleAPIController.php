<?php


namespace App\Http\Controllers;

use App\Models\ab_article;
use App\Models\ab_shoppingcart;
use App\Models\ab_shoppingcart_item;
use App\Helpers\myWebsocketClient;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\NewArticleRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth;

class ArticleAPIController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->get('search');
        if ($search) {
            $articles = ab_article::query()->select('ab_name', 'ab_price')->where('ab_name', 'ILIKE', '%' . $search . '%')->get();
        }
        else {
            $articles = ab_article::all();
        }
        return response()->json($articles);
    }

    public function search_offset(Request $request)
    {
        $search = $request->get('search');
        $offset = $request->get('offset');
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
        $available_articles->toArray();
        Log::debug(get_class($available_articles));
        foreach ($available_articles as $article)
        {
            if($article->ab_creator_id == 5)
            {
                $article->promotable = true;
            }
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
        $shoppingcart_items = ab_shoppingcart_item::getShoppingCartItems($request->get('shoppingcartid'));
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

    public function sold($id)
    {
        $article = ab_article::query()->where('id', $id)->get()->first();
        $user = ab_article::query()->where('id', $article->ab_creator_id)->get()->first();
        $article_name = $article->ab_name;
        $msg = "Grossartig! Ihr Artikel $article_name wurde erfolgreich verkauf!";
        $msgJSON = json_encode($msg);
        $socket = new myWebsocketClient();
        $socket->sendMessage($msgJSON);
    }

    public function makeoffer($id)
    {
        $socket = new myWebsocketClient();
        $socket->sendMessage($id);
    }
}
