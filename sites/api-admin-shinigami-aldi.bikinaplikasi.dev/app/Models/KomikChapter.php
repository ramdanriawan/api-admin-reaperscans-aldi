<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomikChapter extends Model
{
    protected $table = 'komik_chapter';
    protected $guarded = [];

    public $timestamps = true;
    public const UPDATED_AT = "updated_at";
    public const CREATED_AT = "created_at";

    public function komik()
    {
        return $this->belongsTo(Komik::class,);
    }

    public function komik_chapter_like_is_current_user_like()
    {
        return $this->belongsTo(KomikChapterDilike::class, 'id', 'komik_chapter_id');
    }

    public function komik_chapter_komentars()
    {
        return $this->hasMany(KomikChapterKomentar::class);
    }

    public function komik_chapter_dilikes()
    {
        return $this->hasMany(KomikChapterDilike::class);
    }

    public function komik_chapter_dilihats()
    {
        return $this->hasMany(KomikChapterDilihat::class);
    }

    public function komik_chapter_balasans()
    {
        return $this->hasMany(KomikChapterKomentarBalasan::class);
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
