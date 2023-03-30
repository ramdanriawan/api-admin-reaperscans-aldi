<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomikGenre extends Model
{
    protected $table = 'komik_genre';
    protected $guarded = [];

    public $timestamps = true;
    public const UPDATED_AT = "updated_at";
    public const CREATED_AT = "created_at";



    public function komik_list_genre()
    {
        return $this->hasMany(KomikListGenre::class);
    }


    public function getCreatedAtAttribute($value)
    {
        return date("Y-m-d H:i:s", strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date("Y-m-d H:i:s", strtotime($value));
    }
}
