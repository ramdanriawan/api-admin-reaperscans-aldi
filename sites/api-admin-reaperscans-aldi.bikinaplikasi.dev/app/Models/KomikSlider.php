<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomikSlider extends Model
{
    protected $table = 'komik_slider';
    protected $guarded = [];

    public $timestamps = true;
    public const UPDATED_AT = "updated_at";
    public const CREATED_AT = "created_at";

    public function komik()
    {
        return $this->belongsTo(Komik::class);
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
