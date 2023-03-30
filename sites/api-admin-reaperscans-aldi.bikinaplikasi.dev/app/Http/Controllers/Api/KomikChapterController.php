<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KomikChapter;
use App\Models\KomikChapterDilihat;
use App\Models\KomikChapterDilike;
use Illuminate\Http\Request;

class KomikChapterController extends Controller
{

    private $relations = [
        'komik.komik_chapters',
        'komik.komik_tipe',
        'user.user_premium',
    ];

    public function model()
    {
        $komikchapter = new KomikChapter();

        return $komikchapter->with($this->relations)->first();
    }

    public function index(Request $request)
    {
        $komikchapter = new KomikChapter();

        $komikchapter = $komikchapter->with($this->relations);

        if ($request->last_id) {
            $komikchapter = $komikchapter->where('id', '>', $request->last_id);
        }

        if ($request->limit) {

            $komikchapter = $komikchapter->limit($request->limit);
        }

        if ($request->user_id) {
            $komikchapter = $komikchapter->where('user_id', $request->user_id);
        }

        $komikchapter = $komikchapter->get();

        return response()->json([
            "success" => true,
            'data' => $komikchapter
        ]);
    }

    public function getKomikChapterDilihat(Request $request)
    {
        //
        $komikchapter = new KomikChapter();

        $relasi = [
            'komik.komik_list_genres.komik_genre',
            'komik.komik_tipe',
            'komik.komik_bookmarks.user',
            'komik.komik_chapters.komik_chapter_dilikes.user.user_premium',
            'komik.komik_chapters.komik_chapter_dilihats.user',
            'komik.komik_chapters.komik_chapter_komentars.user.user_premium',
            'komik.komik_details.user',
            'komik.komik_komentars',
            'komik.komik_komentars.komik_komentar_likes',
            'komik.komik_komentars.komik_komentar_likes.user',
            'komik.komik_komentars.user.user_premium',
            'komik.komik_komentars.komik_komentar_balasans',
            'komik.komik_komentars.komik_komentar_balasans.komik_komentar_balasan_likes.user.user_premium',
            'komik.komik_komentars.komik_komentar_balasans.user.user_premium',
        ];

        $count = [
            'komik_chapter_dilikes',
            'komik_chapter_dilihats',
            'komik_chapter_komentars',
        ];

        $komikchapter = $komikchapter->whereHas('komik_chapter_dilihats', function ($query) use ($request) {

            $query->where('user_id', $request->user_id)->orderByDesc('updated_at')->limit(1);
        });

        $relasi['komik'] = function ($query) use ($request) {
            $query->withCount([
                'komik_chapters' => function ($query) {
                    $query->withCount(['komik_chapter_dilikes', 'komik_chapter_dilihats', 'komik_chapter_komentars']);
                }
                ,
                'komik_list_genres',
                'komik_bookmarks',
                'komik_details',
                'komik_chapters',
                'komik_chapter_komentars',
                'komik_chapter_dilikes',
                'komik_chapter_dilihats',
                'komik_komentars',
                'komik_komentar_likes',
                'komik_komentar_balasans',
                'komik_komentar_balasan_likes',
                'komik_detail_dilikes',
                'komik_detail_dilihats',
            ])->with([
                    'komik_list_genres' => function ($query) use ($request) {
                        $query->limit(20);
                    }
                    ,
                    'komik_bookmarks' => function ($query) use ($request) {

                        $query->limit(20);
                    }
                    ,
                    'komik_chapters' => function ($query) use ($request) {
                        $query->limit(20);
                    }
                    ,
                    'komik_chapter_komentars' => function ($query) use ($request) {

                        $query->limit(20);
                    }
                    ,
                    'komik_chapter_dilikes' => function ($query) use ($request) {

                        $query->limit(20);
                    }
                    ,
                    'komik_chapter_dilihats' => function ($query) use ($request) {
                        $query->where('user_id', $request->user_id)->orderByDesc('updated_at')->limit(1)->with('komik_chapter');
                    }
                    ,
                    'komik_komentars' => function ($query) use ($request) {
                        $query->limit(20);
                    }
                    ,
                    'komik_komentar_likes' => function ($query) use ($request) {

                        $query->limit(20);
                    }
                    ,
                    'komik_komentar_balasans' => function ($query) use ($request) {

                        $query->limit(20);
                    }
                    ,
                    'komik_komentar_balasan_likes' => function ($query) use ($request) {

                        $query->limit(20);
                    }
                    ,
                    'komik_detail_dilikes' => function ($query) use ($request) {

                        $query->limit(20);
                    }
                    ,
                    'komik_detail_dilihats' => function ($query) use ($request) {

                        $query->limit(20);
                    }
                    ,
                ]);
        };

        $relasi['komik.komik_chapters.komik_chapter_dilikes'] = function ($query) use ($request) {
            $query->limit(20);
        };

        $relasi['komik.komik_chapters.komik_chapter_dilihats'] = function ($query) use ($request) {
            $query->limit(20);
        };

        $relasi['komik.komik_chapters.komik_chapter_komentars'] = function ($query) use ($request) {
            $query->limit(20);
        };

        if ($request->last_id) {
            $komikchapter = $komikchapter->where('id', '<', $request->last_id);
        }

        if ($request->limit) {

            $komikchapter = $komikchapter->limit($request->limit);
        }

        $komikchapter = $komikchapter->with($relasi);

        $komikchapter = $komikchapter->withCount($count);

        $komikchapter = $komikchapter->orderByDesc("id");
        
        $komikchapter = $komikchapter->get();

        $komikchapter = $komikchapter->sortByDesc('komik_chapters.komik_chapter_dilihats.updated_at')->unique('komik_id');

        return response()->json([
            "success" => true,
            'data' => $komikchapter
        ]);
    }

    public function addToDilihat(Request $request)
    {
        if ($komikChapter = KomikChapterDilihat::where(['user_id' => $request->user_id, 'komik_chapter_id' => $request->komik_chapter_id])->first()) {
            
            $komikChapter->update([
                'user_id' => $request->user_id,
                'komik_chapter_id' => $request->komik_chapter_id,
            ]);

            return response()->json([
                "success" => true,
            ]);
        } else {
            KomikChapterDilihat::create([
                'komik_chapter_id' => $request->komik_chapter_id,
                'user_id' => $request->user_id,
            ]);

            return response()->json([
                "success" => true,
            ]);
        }

    }

    public function addKomikChapterToDilike(Request $request)
    {
        if ($komikChapter = KomikChapterDilike::where(['user_id' => $request->user_id, 'komik_chapter_id' => $request->komik_chapter_id])->first()) {
            $komikChapter->update([
                'komik_chapter_id' => $request->komik_chapter_id,
                'user_id' => $request->user_id,
                "is_dilike" => $komikChapter->is_dilike == "Ya" ? "Tidak" : "Ya"
            ]);

            return response()->json([
                "success" => true,
            ]);
        } else {
            KomikChapterDilike::create([
                'komik_chapter_id' => $request->komik_chapter_id,
                'user_id' => $request->user_id,
                'is_dilike' => "Ya",
            ]);

            return response()->json([
                "success" => true,
            ]);
        }

    }

    public function checkUserChapterDilihat(Request $request)
    {
        return response()->json([
            "success" => (bool) KomikChapter::where($request->all())->first(),
        ]);
    }

    public function removeKomikChapterFromDilihat(Request $request)
    {
        KomikChapterDilihat::whereIn('komik_chapter_id', json_decode($request->komik_chapter_ids))->where('user_id', $request->user_id)->delete();

        return response()->json([
            "success" => true,
        ]);
    }

}