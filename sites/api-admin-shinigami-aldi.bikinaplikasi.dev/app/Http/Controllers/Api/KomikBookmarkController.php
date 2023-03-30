<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KomikBookmark;
use Illuminate\Http\Request;

class KomikBookmarkController extends Controller
{

    private $relations = [
        'komik.komik_chapters',
        'komik.komik_tipe',
        'user.user_premium',
    ];

    public function model()
    {
        $komikbookmark = new KomikBookmark();

        return $komikbookmark->with($this->relations)->first();
    }

    public function index(Request $request)
    {
        $komikbookmark = new KomikBookmark();

        $komikbookmark = $komikbookmark->with($this->relations);

        if ($request->last_id) {
            $komikbookmark = $komikbookmark->where('id', '>', $request->last_id);
        }

        if ($request->limit) {

            $komikbookmark = $komikbookmark->limit($request->limit);
        }

        if ($request->user_id) {
            $komikbookmark = $komikbookmark->where('user_id', $request->user_id);
        }

        $komikbookmark = $komikbookmark->get();

        return response()->json([
            "success" => true,
            'data' => $komikbookmark
        ]);
    }

    public function addToBookmark(Request $request)
    {
        if (!KomikBookmark::where($request->all())->first()) {
            KomikBookmark::create($request->all());

            return response()->json([
                "success" => true,
            ]);
        }

        return response()->json([
            "success" => false,
        ]);
    }

    public function removeFromBookmark(Request $request)
    {
        if (!KomikBookmark::where($request->all())->first()) {
            KomikBookmark::where($request->all())->delete();
            
            return response()->json([
                "success" => true,
            ]);
        }

        return response()->json([
            "success" => false,
        ]);
    }

    //sdfdopsfdilosjfiodsfioudsfihsf
    public function checkUserBookmark(Request $request)
    {
        return response()->json([
            "success" => (bool) KomikBookmark::where($request->all())->first(),
        ]);
    }
}