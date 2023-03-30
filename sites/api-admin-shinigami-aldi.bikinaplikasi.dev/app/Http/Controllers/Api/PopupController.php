<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Popup;
use Illuminate\Http\Request;

class PopupController extends Controller
{

    private $relations = [
    ];

    public function model()
    {
        $popup = new Popup();

        return $popup->with($this->relations)->first();
    }

    public function index(Request $request)
    {        
        $popup = new Popup();

        $popup = $popup->with($this->relations);

        if ($request->last_id) {
            $popup = $popup->where('id', '>', $request->last_id);
        }

        if ($request->limit) {

            $popup = $popup->limit($request->limit);
        }

        if($request->user_id) {
            $popup = $popup->where('user_id', $request->user_id);
        }

        $popup = $popup->where(['status' => 'Aktif'])->get();

        return response()->json([
            "success" => true,
            'data' => $popup
        ]);
    }

    public function store(Request $request)
    {
        
    }

}