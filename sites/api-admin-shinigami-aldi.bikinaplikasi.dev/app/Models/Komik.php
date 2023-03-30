<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komik extends Model
{
    protected $table = 'komik';
    protected $guarded = [];

    public $timestamps = true;
    public const UPDATED_AT = "updated_at";
    public const CREATED_AT = "created_at";

    public function komik_list_genres()
    {
        return $this->hasMany(KomikListGenre::class);
    }

    public function komik_chapters()
    {
        return $this->hasMany(KomikChapter::class);
    }

    public function komik_chapter_komentars()
    {
        return $this->hasManyThrough(KomikChapterKomentar::class, KomikChapter::class, );
    }

    public function komik_chapter_dilikes()
    {
        return $this->hasManyThrough(KomikChapterDilike::class, KomikChapter::class, );
    }

    public function komik_chapter_dilihats()
    {
        return $this->hasManyThrough(KomikChapterDilihat::class, KomikChapter::class, );
    }

    public function komik_komentar_likes()
    {
        return $this->hasManyThrough(KomikKomentarLike::class, KomikKomentar::class, );
    }

    public function komik_komentar_balasans()
    {
        return $this->hasManyThrough(KomikKomentarBalasan::class, KomikKomentar::class, );
    }

    public function komik_komentar_balasan_likes()
    {
        return $this->hasManyThrough(KomikKomentarBalasanLike::class, KomikKomentarBalasan::class, 'id', 'komik_komentar_balasan_id');
    }

    public function komik_details()
    {
        return $this->hasMany(KomikDetail::class);
    }

    public function komik_detail_dilihats()
    {
        return $this->hasMany(KomikDetail::class);
    }

    public function komik_detail_dilikes()
    {
        return $this->hasMany(KomikDetail::class);
    }

    public function komik_komentars()
    {
        return $this->hasMany(KomikKomentar::class);
    }

    public function komik_bookmarks()
    {
        return $this->hasMany(KomikBookmark::class);
    }
    public function komik_slider()
    {
        return $this->hasOne(KomikSlider::class);
    }
    public function komik_ranking()
    {
        return $this->hasOne(KomikRanking::class);
    }
    public function komik_rekomendasi()
    {
        return $this->hasOne(KomikRekomendasi::class);
    }
    public function komik_tipe()
    {
        return $this->belongsTo(KomikTipe::class);
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