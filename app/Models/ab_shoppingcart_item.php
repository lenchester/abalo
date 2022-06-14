<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ab_shoppingcart_item extends Model
{
    use HasFactory;
    protected $table = 'ab_shoppingcart_item';


    public $timestamps = false;
    static public function getShoppingCartItems($shoppingcartid)
    {
        return self::query()->where('ab_shoppingcart_item.ab_shoppingcart_id', '=', $shoppingcartid)
            ->join('ab_articles', 'ab_articles.id', '=', 'ab_shoppingcart_item.ab_article_id')
            ->select('ab_articles.id', 'ab_articles.ab_name', 'ab_articles.ab_price', 'ab_shoppingcart_item.ab_shoppingcart_id')->get();
    }
}
