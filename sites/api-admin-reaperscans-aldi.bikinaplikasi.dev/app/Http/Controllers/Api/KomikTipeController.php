<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KomikTipe;
use Illuminate\Http\Request;

class KomikTipeController extends Controller
{

    private $relations = [
    ];

    public function model()
    {
        $komiktipe = new KomikTipe();

        return $komiktipe->with($this->relations)->first();
    }

    public function index(Request $request)
    {        
        $komiktipe = new KomikTipe();

        $komiktipe = $komiktipe->with($this->relations);

        if ($request->last_id) {
            $komiktipe = $komiktipe->where('id', '>', $request->last_id);
        }

        if ($request->limit) {

            $komiktipe = $komiktipe->limit($request->limit);
        }

        if($request->user_id) {
            $komiktipe = $komiktipe->where('user_id', $request->user_id);
        }

        $komiktipe = $komiktipe->get();

        return response()->json([
            "success" => true,
            'data' => $komiktipe
        ]);
    }

    public function store(Request $request)
    {
        
    }

}