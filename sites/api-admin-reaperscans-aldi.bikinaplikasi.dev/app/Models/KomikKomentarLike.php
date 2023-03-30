<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomikKomentarLike extends Model
{
    protected $table = 'komik_komentar_like';
    protected $guarded = [];

    public $timestamps = true;
    public const UPDATED_AT = "updated_at";
    public const CREATED_AT = "created_at";

    public function komik_komentar()
    {
        return $this->belongsTo(KomikKomentar::class);
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
