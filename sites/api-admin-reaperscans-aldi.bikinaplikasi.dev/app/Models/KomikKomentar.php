<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomikKomentar extends Model
{
    protected $table = 'komik_komentar';
    protected $guarded = [];

    public $timestamps = true;
    public const UPDATED_AT = "updated_at";
    public const CREATED_AT = "created_at";

    public function komik()
    {
        return $this->belongsTo(Komik::class);
    }

    public function komik_komentar_likes()
    {
        return $this->hasMany(KomikKomentarLike::class);
    }

    public function komik_komentar_balasans()
    {
        return $this->hasMany(KomikKomentarBalasan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function komik_komentar_like_is_current_user_like()
    {
        return $this->belongsTo(KomikKomentarLike::class, 'id', 'komik_komentar_id');
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
