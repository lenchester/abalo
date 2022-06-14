<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ab_article extends Model
{
    use HasFactory;

    protected $table = 'ab_articles';
    public $timestamps = false;

    static function getCreatorId($id)
    {
        return self::query()->select('ab_creator_id')->where('id', $id)->get()->first();
    }

}
