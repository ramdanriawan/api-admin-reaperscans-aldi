<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KomikSlider;
use Illuminate\Http\Request;

class KomikSliderController extends Controller
{

    private $relations = [
        'komik.komik_chapters',
        'komik.komik_tipe',
    ];

    public function model()
    {
        $komikslider = new KomikSlider();

        return $komikslider->with($this->relations)->first();
    }

    public function index(Request $request)
    {
        $komikslider = new KomikSlider();

        $komikslider = $komikslider->with($this->relations);

        if ($request->last_id) {
            $komikslider = $komikslider->where('id', '>', $request->last_id);
        }

        if ($request->limit) {

            $komikslider = $komikslider->limit($request->limit);
        }

        $komikslider = $komikslider->get();

        return response()->json([
            "success" => true,
            'data' => $komikslider
        ]);
    }

    public function addToSlider(Request $request)
    {
        if (!KomikSlider::where($request->all())->first()) {
            KomikSlider::create($request->all());

            return response()->json([
                "success" => true,
            ]);
        }

        return response()->json([
            "success" => false,
        ]);
    }

    public function removeFromSlider(Request $request)
    {
        if (!KomikSlider::where($request->all())->first()) {
            KomikSlider::where($request->all())->delete();
            
            return response()->json([
                "success" => true,
            ]);
        }

        return response()->json([
            "success" => false,
        ]);
    }

    //sdfdopsfdilosjfiodsfioudsfihsf
    public function checkUserSlider(Request $request)
    {
        return response()->json([
            "success" => (bool) KomikSlider::where($request->all())->first(),
        ]);
    }
}