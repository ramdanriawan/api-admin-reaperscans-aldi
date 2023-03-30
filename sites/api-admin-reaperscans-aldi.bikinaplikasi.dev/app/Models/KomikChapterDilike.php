<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomikChapterDilike extends Model
{
    protected $table = 'komik_chapter_dilike';
    protected $guarded = [];

    public $timestamps = true;
    public const UPDATED_AT = "updated_at";
    public const CREATED_AT = "created_at";


    public function komik_chapter()
    {
        return $this->belongsTo(KomikChapter::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
