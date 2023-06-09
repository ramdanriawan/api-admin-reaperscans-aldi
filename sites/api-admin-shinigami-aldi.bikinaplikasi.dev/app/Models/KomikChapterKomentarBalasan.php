<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomikChapterKomentarBalasan extends Model
{
    protected $table = 'komik_chapter_komentar_balasan';
    protected $guarded = [];

    public $timestamps = true;
    public const UPDATED_AT = "updated_at";
    public const CREATED_AT = "created_at";

    public function komik_komentar()
    {
        return $this->belongsTo(KomikKomentar::class);
    }


    public function komik_chapter_komentar_balasan_likes()
    {
        return $this->hasMany(KomikChapterKomentarBalasanLike::class);
    }

    public function komik_chapter_komentar_balasan_like_is_current_user_like()
    {
        return $this->belongsTo(KomikChapterKomentarBalasanLike::class, 'id', 'komik_chapter_komentar_balasan_id');
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
