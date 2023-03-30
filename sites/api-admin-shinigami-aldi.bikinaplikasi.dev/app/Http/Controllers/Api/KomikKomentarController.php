<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KomikKomentar;
use App\Models\KomikKomentarBalasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KomikKomentarController extends Controller
{
    private $relations = [
        'user',
        'user.user_premium',
        'komik_komentar_likes',
        'komik_komentar_like_is_current_user_like',
        'komik_komentar_balasans',
        'komik_komentar_balasans.komik_komentar_balasan_likes.user.user_premium',
        'komik_komentar_balasans.user.user_premium',
    ];

    private $count = [
        'komik_komentar_likes',
        'komik_komentar_balasans',
    ];

    public function model(Request $request)
    {
        
        $komikKomentar = (new KomikKomentar())->withCount($this->count);

        $komikKomentar = (new KomikKomentar());

        $komikKomentar = $komikKomentar->withCount($this->count);
        $komikKomentar = $komikKomentar->with($this->relations);
        $komikKomentar = $komikKomentar->orderBy("id", "DESC");

        $this->relations['komik_komentar_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id);
        };
        
        $this->relations['komik_komentar_balasans'] = function ($query) use ($request) {
            return $query->limit(20)->orderBy('id', "DESC");
        };
        
        $this->relations['komik_komentar_balasans.komik_komentar_balasan_likes'] = function ($query) use ($request) {
            return $query->limit(20)->orderBy('id', "DESC");
        };

        if ($request->komik_id) {
            $komikKomentar = $komikKomentar->where('komik_id', $request->komik_id);
        }

        if ($request->last_id) {
            $komikKomentar = $komikKomentar->where('id', '<', $request->last_id);
        }

        if ($request->limit) {

            $komikKomentar = $komikKomentar->limit($request->limit);
        }

        if ($request->where) {

            $komikKomentar = DB::select("select * from komik where $request->where");
        }

        return $komikKomentar->with($this->relations)->first();
    }

    public function index(Request $request)
    {
        
        $komikKomentar = (new KomikKomentar())->withCount($this->count);

        $komikKomentar = (new KomikKomentar());

        $komikKomentar = $komikKomentar->withCount($this->count);
        $komikKomentar = $komikKomentar->with($this->relations);
        $komikKomentar = $komikKomentar->orderBy("id", "DESC");

        $this->relations['komik_komentar_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id);
        };
        
        $this->relations['komik_komentar_balasans'] = function ($query) use ($request) {
            return $query->limit(20)->orderBy('id', "DESC");
        };
        
        $this->relations['komik_komentar_balasans.komik_komentar_balasan_likes'] = function ($query) use ($request) {
            return $query->limit(20)->orderBy('id', "DESC");
        };

        if ($request->komik_id) {
            $komikKomentar = $komikKomentar->where('komik_id', $request->komik_id);
        }

        if ($request->last_id) {
            $komikKomentar = $komikKomentar->where('id', '<', $request->last_id);
        }

        if ($request->limit) {

            $komikKomentar = $komikKomentar->limit($request->limit);
        }

        if ($request->where) {

            $komikKomentar = DB::select("select * from komik where $request->where");
        }

        $komikKomentar = $komikKomentar->get();

        return response()->json([
            "success" => true,
            'data' => $komikKomentar
        ]);
    }

    public function getKomikKomentarBalasan(Request $request)
    {
        $komikKomentarBalasan = (new KomikKomentarBalasan());

        $komikKomentarBalasan = $komikKomentarBalasan->withCount([]);
        $komikKomentarBalasan = $komikKomentarBalasan->with(['komik_komentar_balasan_likes.user.user_premium', 'user.user_premium']);
        $komikKomentarBalasan = $komikKomentarBalasan->orderBy("id", "DESC");

        $this->relations['komik_komentar_balasan_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id);
        };


        $this->relations['komik_komentar_balasans'] = function ($query) use ($request) {
            return $query->limit(20)->withCount(['komik_komentar_balasans'])->orderBy('id', "DESC");
        };

        $this->relations['komik_komentar_balasan_likes'] = function ($query) use ($request) {
            return $query->limit(20)->orderBy('id', "DESC");
        };

        if ($request->komik_komentar_id) {
            $komikKomentarBalasan = $komikKomentarBalasan->where('komik_komentar_id', $request->komik_komentar_id);
        }

        if ($request->last_id) {
            $komikKomentarBalasan = $komikKomentarBalasan->where('id', '<', $request->last_id);
        }

        if ($request->limit) {

            $komikKomentarBalasan = $komikKomentarBalasan->limit($request->limit);
        }

        if ($request->where) {

            $komikKomentarBalasan = DB::select("select * from komik where $request->where");
        }

        $komikKomentarBalasan = $komikKomentarBalasan->get();

        return response()->json([
            "success" => true,
            'data' => $komikKomentarBalasan
        ]);
    }

    public function store(Request $request)
    {
       
    }

}