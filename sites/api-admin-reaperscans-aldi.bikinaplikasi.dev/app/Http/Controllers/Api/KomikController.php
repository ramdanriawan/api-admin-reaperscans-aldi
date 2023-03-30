<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Komik;
use App\Models\KomikBookmark;
use App\Models\KomikChapterKomentar;
use App\Models\KomikChapterKomentarBalasan;
use App\Models\KomikChapterKomentarBalasanLike;
use App\Models\KomikChapterKomentarLike;
use App\Models\KomikDetail;
use App\Models\KomikKomentar;
use App\Models\KomikKomentarBalasan;
use App\Models\KomikKomentarBalasanLike;
use App\Models\KomikKomentarLike;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KomikController extends Controller
{
    private $relations = [
        'komik_list_genres.komik_genre',
        'komik_tipe',
        'komik_bookmarks.user',
        'komik_bookmarks.user',
        'komik_chapters',
        'komik_chapters.komik_chapter_dilikes.user.user_premium',
        'komik_chapters.komik_chapter_dilihats.user',
        'komik_chapters.komik_chapter_komentars.user.user_premium',
        'komik_details.user',
        'komik_komentars',
        'komik_komentars.komik_komentar_likes',
        'komik_komentars.komik_komentar_likes.user',
        'komik_komentars.user.user_premium',
        'komik_komentars.komik_komentar_balasans',
        'komik_komentars.komik_komentar_balasans.komik_komentar_balasan_likes.user.user_premium',
        'komik_komentars.komik_komentar_balasans.user.user_premium',
    ];

    private $count = [
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
    ];

    public function model(Request $request)
    {
        $this->relations['komik_bookmarks'] = function ($query) {

            return $query->limit(20);
        };


        $this->relations['komik_chapters'] = function (HasMany $query) use ($request) {

            return $query
                ->with([
                    'komik_chapter_komentars' => function (HasMany $query) {
                        return $query
                            ->limit(20);
                    }
                    ,
                    'komik_chapter_dilihats' => function (HasMany $query) {
                        return $query->limit(20);
                    }
                    ,
                    'komik_chapter_dilikes' => function (HasMany $query) {
                        return $query->limit(20);
                    }
                    ,
                    'komik_chapter_like_is_current_user_like' => function (BelongsTo $query) use ($request) {
                        return $query->where('user_id', $request->user_id);
                    }
                ])
                ->withCount(['komik_chapter_komentars', 'komik_chapter_dilihats', 'komik_chapter_dilikes'])
                ->orderBy("nama");
        };

        // komik chapter
        $this->relations['komik_chapters.komik_chapter_komentars'] = function ($query) {
            return $query->orderBy('id', "DESC")->withCount(['komik_chapter_komentar_balasans', 'komik_chapter_komentar_likes'])->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans'] = function ($query) use ($request) {
            return $query->limit(20);
        };


        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans.user'] = function ($query) use ($request) {
            return $query->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_likes'] = function ($query) use ($request) {
            return $query->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans.komik_chapter_komentar_balasan_likes'] = function ($query) {
            return $query->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans.komik_chapter_komentar_balasan_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };
        //

        $this->relations['komik_komentars'] = function ($query) {
            return $query->orderBy('id', "DESC")->withCount(['komik_komentar_balasans', 'komik_komentar_likes'])->limit(20);
        };

        $this->relations['komik_komentars.komik_komentar_balasans'] = function ($query) use ($request) {
            return $query->limit(20);
        };

        $this->relations['komik_komentars.komik_komentar_balasans.komik_komentar_balasan_likes'] = function ($query) {
            return $query->limit(20);
        };

        $this->relations['komik_komentars.komik_komentar_balasans.komik_komentar_balasan_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };

        $this->relations['komik_komentars.komik_komentar_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };

        $this->count['komik_detail_dilihats'] = function ($query) {
            return $query->where("is_dilihat", "Ya");
        };

        $this->count['komik_detail_dilikes'] = function ($query) {
            return $query->where("is_dilike", "Ya");
        };

        $komik = (new Komik())->withCount($this->count);

        $komik = $komik->whereHas('komik_chapters');

        return $komik->with($this->relations)->first();
    }

    public function index(Request $request)
    {

        $this->relations['komik_bookmarks'] = function ($query) {

            return $query->limit(20);
        };


        $this->relations['komik_chapters'] = function (HasMany $query) use ($request) {

            return $query
                ->with([
                    'komik_chapter_komentars' => function (HasMany $query) {
                        return $query->withCount(['komik_chapter_komentar_balasans', 'komik_chapter_komentar_likes'])->limit(20);
                    }
                    ,
                    'komik_chapter_dilihats' => function (HasMany $query) {
                        return $query->limit(20);
                    }
                    ,
                    'komik_chapter_dilikes' => function (HasMany $query) {
                        return $query->limit(20);
                    }
                    ,
                    'komik_chapter_like_is_current_user_like' => function (BelongsTo $query) use ($request) {
                        return $query->where('user_id', $request->user_id);
                    }
                ])
                ->withCount(['komik_chapter_komentars', 'komik_chapter_dilihats', 'komik_chapter_dilikes'])

                ->orderBy("nama");
        };

        // komik chapter
        $this->relations['komik_chapters.komik_chapter_komentars'] = function ($query) {
            return $query->orderBy('id', "DESC")->withCount(['komik_chapter_komentar_balasans', 'komik_chapter_komentar_likes'])->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans'] = function ($query) use ($request) {
            return $query->limit(20);
        };


        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans.user'] = function ($query) use ($request) {
            return $query->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_likes'] = function ($query) use ($request) {
            return $query->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans.komik_chapter_komentar_balasan_likes'] = function ($query) {
            return $query->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans.komik_chapter_komentar_balasan_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };
        //

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans'] = function ($query) use ($request) {
            return $query->withCount(['komik_chapter_komentar_balasan_likes'])->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_likes'] = function ($query) use ($request) {
            return $query->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans.komik_chapter_komentar_balasan_likes'] = function ($query) {
            return $query->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans.komik_chapter_komentar_balasan_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };
        //


        $this->relations['komik_komentars'] = function ($query) {
            return $query->orderBy('id', "DESC")->withCount(['komik_komentar_balasans', 'komik_komentar_likes'])->limit(20);
        };

        $this->relations['komik_komentars.komik_komentar_balasans'] = function ($query) use ($request) {
            return $query->limit(20);
        };

        $this->relations['komik_komentars.komik_komentar_balasans.komik_komentar_balasan_likes'] = function ($query) {
            return $query->limit(20);
        };

        $this->relations['komik_komentars.komik_komentar_balasans.komik_komentar_balasan_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };

        $this->relations['komik_komentars.komik_komentar_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };


        $this->count['komik_detail_dilihats'] = function ($query) {
            return $query->where("is_dilihat", "Ya");
        };

        $this->count['komik_detail_dilikes'] = function ($query) {
            return $query->where("is_dilike", "Ya");
        };

        $komik = (new Komik())->withCount($this->count);

        $komik = $komik->whereHas('komik_chapters');

        $komik = $komik->with($this->relations);

        if ($request->last_id) {
            $komik = $komik->where('id', '>', $request->last_id);
        }

        if ($request->limit) {

            $komik = $komik->limit($request->limit);
        }

        if ($request->where) {

            $komik = DB::select("select * from komik where $request->where");
        }

        $komik = $komik->get();

        return response()->json([
            "success" => true,
            'data' => $komik
        ]);
    }


    public function getBookmark(Request $request)
    {

        $this->relations['komik_bookmarks'] = function ($query) {

            return $query->limit(20);
        };


        $this->relations['komik_chapters'] = function (HasMany $query) use ($request) {

            return $query
                ->with([
                    'komik_chapter_komentars' => function (HasMany $query) {
                        return $query->withCount(['komik_chapter_komentar_balasans', 'komik_chapter_komentar_likes'])->limit(20);
                    }
                    ,
                    'komik_chapter_dilihats' => function (HasMany $query) {
                        return $query->limit(20);
                    }
                    ,
                    'komik_chapter_dilikes' => function (HasMany $query) {
                        return $query->limit(20);
                    }
                    ,
                    'komik_chapter_like_is_current_user_like' => function (BelongsTo $query) use ($request) {
                        return $query->where('user_id', $request->user_id);
                    }
                ])
                ->withCount(['komik_chapter_komentars', 'komik_chapter_dilihats', 'komik_chapter_dilikes'])


                ->orderBy("nama");
        };

        // komik chapter
        $this->relations['komik_chapters.komik_chapter_komentars'] = function ($query) {
            return $query->orderBy('id', "DESC")->withCount(['komik_chapter_komentar_balasans', 'komik_chapter_komentar_likes'])->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans'] = function ($query) use ($request) {
            return $query->limit(20);
        };


        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans.user'] = function ($query) use ($request) {
            return $query->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_likes'] = function ($query) use ($request) {
            return $query->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans.komik_chapter_komentar_balasan_likes'] = function ($query) {
            return $query->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans.komik_chapter_komentar_balasan_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };
        //


        $this->relations['komik_komentars'] = function ($query) {
            return $query->orderBy('id', "DESC")->withCount(['komik_komentar_balasans', 'komik_komentar_likes'])->limit(20);
        };

        $this->relations['komik_komentars.komik_komentar_balasans'] = function ($query) use ($request) {
            return $query->limit(20);
        };

        $this->relations['komik_komentars.komik_komentar_balasans.komik_komentar_balasan_likes'] = function ($query) {
            return $query->limit(20);
        };

        $this->relations['komik_komentars.komik_komentar_balasans.komik_komentar_balasan_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };

        $this->relations['komik_komentars.komik_komentar_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };


        $this->count['komik_detail_dilihats'] = function ($query) {
            return $query->where("is_dilihat", "Ya");
        };

        $this->count['komik_detail_dilikes'] = function ($query) {
            return $query->where("is_dilike", "Ya");
        };

        $komik = (new Komik())->withCount($this->count);

        $komik = $komik->with($this->relations);

        $komik = $komik->whereHas("komik_bookmarks", function ($query) use ($request) {

            return $query->limit(20)->where("user_id", $request->user_id);
        });

        if ($request->last_id) {
            $komik = $komik->where('id', '>', $request->last_id);
        }

        if ($request->limit) {

            $komik = $komik->limit($request->limit);
        }

        if ($request->where) {

            $komik = DB::select("select * from komik where $request->where");
        }

        $komik = $komik->whereHas('komik_chapters');

        $komik = $komik->get();

        return response()->json([
            "success" => true,
            'data' => $komik
        ]);
    }

    public function getSlider(Request $request)
    {

        $this->relations['komik_slider'] = function ($query) {

            return $query->limit(20);
        };


        $this->relations['komik_chapters'] = function (HasMany $query) use ($request) {

            return $query
                ->with([
                    'komik_chapter_komentars' => function (HasMany $query) {
                        return $query->withCount(['komik_chapter_komentar_balasans', 'komik_chapter_komentar_likes'])->limit(20);
                    }
                    ,
                    'komik_chapter_dilihats' => function (HasMany $query) {
                        return $query->limit(20);
                    }
                    ,
                    'komik_chapter_dilikes' => function (HasMany $query) {
                        return $query->limit(20);
                    }
                    ,
                    'komik_chapter_like_is_current_user_like' => function (BelongsTo $query) use ($request) {
                        return $query->where('user_id', $request->user_id);
                    }
                ])
                ->withCount(['komik_chapter_komentars', 'komik_chapter_dilihats', 'komik_chapter_dilikes'])


                ->orderBy("nama");
        };

        // komik chapter
        $this->relations['komik_chapters.komik_chapter_komentars'] = function ($query) {
            return $query->orderBy('id', "DESC")->withCount(['komik_chapter_komentar_balasans', 'komik_chapter_komentar_likes'])->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans'] = function ($query) use ($request) {
            return $query->limit(20);
        };


        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans.user'] = function ($query) use ($request) {
            return $query->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_likes'] = function ($query) use ($request) {
            return $query->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans.komik_chapter_komentar_balasan_likes'] = function ($query) {
            return $query->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans.komik_chapter_komentar_balasan_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };
        //


        $this->relations['komik_komentars'] = function ($query) {
            return $query->orderBy('id', "DESC")->withCount(['komik_komentar_balasans', 'komik_komentar_likes'])->limit(20);
        };

        $this->relations['komik_komentars.komik_komentar_balasans'] = function ($query) use ($request) {
            return $query->limit(20);
        };

        $this->relations['komik_komentars.komik_komentar_balasans.komik_komentar_balasan_likes'] = function ($query) {
            return $query->limit(20);
        };

        $this->relations['komik_komentars.komik_komentar_balasans.komik_komentar_balasan_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };

        $this->relations['komik_komentars.komik_komentar_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };


        $this->count['komik_detail_dilihats'] = function ($query) {
            return $query->where("is_dilihat", "Ya");
        };

        $this->count['komik_detail_dilikes'] = function ($query) {
            return $query->where("is_dilike", "Ya");
        };

        $komik = (new Komik())->withCount($this->count);

        $komik = $komik->with($this->relations);

        $komik = $komik->whereHas("komik_slider");

        if ($request->last_id) {
            $komik = $komik->where('id', '>', $request->last_id);
        }

        if ($request->limit) {

            $komik = $komik->limit($request->limit);
        }

        if ($request->where) {

            $komik = DB::select("select * from komik where $request->where");
        }

        $komik = $komik->whereHas('komik_chapters');

        $komik = $komik->get();

        return response()->json([
            "success" => true,
            'data' => $komik
        ]);
    }


    public function getRanking(Request $request)
    {

        $this->relations['komik_ranking'] = function ($query) {

            return $query->limit(20)->orderBy('ranking');
        };


        $this->relations['komik_chapters'] = function (HasMany $query) use ($request) {

            return $query
                ->with([
                    'komik_chapter_komentars' => function (HasMany $query) {
                        return $query->withCount(['komik_chapter_komentar_balasans', 'komik_chapter_komentar_likes'])->limit(20);
                    }
                    ,
                    'komik_chapter_dilihats' => function (HasMany $query) {
                        return $query->limit(20);
                    }
                    ,
                    'komik_chapter_dilikes' => function (HasMany $query) {
                        return $query->limit(20);
                    }
                    ,
                    'komik_chapter_like_is_current_user_like' => function (BelongsTo $query) use ($request) {
                        return $query->where('user_id', $request->user_id);
                    }
                ])
                ->withCount(['komik_chapter_komentars', 'komik_chapter_dilihats', 'komik_chapter_dilikes'])
                ->orderBy("nama");
        };

        // komik chapter
        $this->relations['komik_chapters.komik_chapter_komentars'] = function ($query) {
            return $query->orderBy('id', "DESC")->withCount(['komik_chapter_komentar_balasans', 'komik_chapter_komentar_likes'])->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans'] = function ($query) use ($request) {
            return $query->limit(20);
        };


        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans.user'] = function ($query) use ($request) {
            return $query->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_likes'] = function ($query) use ($request) {
            return $query->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans.komik_chapter_komentar_balasan_likes'] = function ($query) {
            return $query->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans.komik_chapter_komentar_balasan_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };
        //


        $this->relations['komik_komentars'] = function ($query) {
            return $query->orderBy('id', "DESC")->withCount(['komik_komentar_balasans', 'komik_komentar_likes'])->limit(20);
        };

        $this->relations['komik_komentars.komik_komentar_balasans'] = function ($query) use ($request) {
            return $query->limit(20);
        };

        $this->relations['komik_komentars.komik_komentar_balasans.komik_komentar_balasan_likes'] = function ($query) {
            return $query->limit(20);
        };

        $this->relations['komik_komentars.komik_komentar_balasans.komik_komentar_balasan_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };

        $this->relations['komik_komentars.komik_komentar_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };


        $this->count['komik_detail_dilihats'] = function ($query) {
            return $query->where("is_dilihat", "Ya");
        };

        $this->count['komik_detail_dilikes'] = function ($query) {
            return $query->where("is_dilike", "Ya");
        };

        $komik = (new Komik())->withCount($this->count);

        $komik = $komik->with($this->relations);

        $komik = $komik->whereHas("komik_ranking");

        if ($request->last_id) {
            $komik = $komik->where('id', '>', $request->last_id);
        }

        if ($request->limit) {

            $komik = $komik->limit($request->limit);
        }

        if ($request->where) {

            $komik = DB::select("select * from komik where $request->where");
        }

        $komik = $komik->whereHas('komik_chapters');

        $komik = $komik->get();

        return response()->json([
            "success" => true,
            'data' => $komik
        ]);
    }


    public function getRekomendasi(Request $request)
    {

        $this->relations['komik_rekomendasi'] = function ($query) {

            return $query->limit(20)->orderBy('rekomendasi');
        };


        $this->relations['komik_chapters'] = function (HasMany $query) use ($request) {

            return $query
                ->with([
                    'komik_chapter_komentars' => function (HasMany $query) {
                        return $query->withCount(['komik_chapter_komentar_balasans', 'komik_chapter_komentar_likes'])->limit(20);
                    }
                    ,
                    'komik_chapter_dilihats' => function (HasMany $query) {
                        return $query->limit(20);
                    }
                    ,
                    'komik_chapter_dilikes' => function (HasMany $query) {
                        return $query->limit(20);
                    }
                    ,
                    'komik_chapter_like_is_current_user_like' => function (BelongsTo $query) use ($request) {
                        return $query->where('user_id', $request->user_id);
                    }
                ])
                ->withCount(['komik_chapter_komentars', 'komik_chapter_dilihats', 'komik_chapter_dilikes'])


                ->orderBy("nama");
        };

        // komik chapter
        $this->relations['komik_chapters.komik_chapter_komentars'] = function ($query) {
            return $query->orderBy('id', "DESC")->withCount(['komik_chapter_komentar_balasans', 'komik_chapter_komentar_likes'])->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans'] = function ($query) use ($request) {
            return $query->limit(20);
        };


        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans.user'] = function ($query) use ($request) {
            return $query->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_likes'] = function ($query) use ($request) {
            return $query->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans.komik_chapter_komentar_balasan_likes'] = function ($query) {
            return $query->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans.komik_chapter_komentar_balasan_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };
        //


        $this->relations['komik_komentars'] = function ($query) {
            return $query->orderBy('id', "DESC")->withCount(['komik_komentar_balasans', 'komik_komentar_likes'])->limit(20);
        };

        $this->relations['komik_komentars.komik_komentar_balasans'] = function ($query) use ($request) {
            return $query->limit(20);
        };

        $this->relations['komik_komentars.komik_komentar_balasans.komik_komentar_balasan_likes'] = function ($query) {
            return $query->limit(20);
        };

        $this->relations['komik_komentars.komik_komentar_balasans.komik_komentar_balasan_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };

        $this->relations['komik_komentars.komik_komentar_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };


        $this->count['komik_detail_dilihats'] = function ($query) {
            return $query->where("is_dilihat", "Ya");
        };

        $this->count['komik_detail_dilikes'] = function ($query) {
            return $query->where("is_dilike", "Ya");
        };

        $komik = (new Komik())->withCount($this->count);

        $komik = $komik->with($this->relations);

        $komik = $komik->whereHas("komik_rekomendasi");

        if ($request->last_id) {
            $komik = $komik->where('id', '>', $request->last_id);
        }

        if ($request->limit) {

            $komik = $komik->limit($request->limit);
        }

        if ($request->where) {

            $komik = DB::select("select * from komik where $request->where");
        }

        $komik = $komik->whereHas('komik_chapters');

        $komik = $komik->get();

        return response()->json([
            "success" => true,
            'data' => $komik
        ]);
    }

    public function search(Request $request)
    {

        $this->relations['komik_bookmarks'] = function ($query) {

            return $query->limit(20);
        };


        $this->relations['komik_chapters'] = function (HasMany $query) use ($request) {

            return $query
                ->with([
                    'komik_chapter_komentars' => function (HasMany $query) {
                        return $query->withCount(['komik_chapter_komentar_balasans', 'komik_chapter_komentar_likes'])->limit(20);
                    }
                    ,
                    'komik_chapter_dilihats' => function (HasMany $query) {
                        return $query->limit(20);
                    }
                    ,
                    'komik_chapter_dilikes' => function (HasMany $query) {
                        return $query->limit(20);
                    }
                    ,
                    'komik_chapter_like_is_current_user_like' => function (BelongsTo $query) use ($request) {
                        return $query->where('user_id', $request->user_id);
                    }
                ])
                ->withCount(['komik_chapter_komentars', 'komik_chapter_dilihats', 'komik_chapter_dilikes'])


                ->orderBy("nama");
        };

        // komik chapter
        $this->relations['komik_chapters.komik_chapter_komentars'] = function ($query) {
            return $query->orderBy('id', "DESC")->withCount(['komik_chapter_komentar_balasans', 'komik_chapter_komentar_likes'])->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans'] = function ($query) use ($request) {
            return $query->limit(20);
        };


        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans.user'] = function ($query) use ($request) {
            return $query->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_likes'] = function ($query) use ($request) {
            return $query->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans.komik_chapter_komentar_balasan_likes'] = function ($query) {
            return $query->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans.komik_chapter_komentar_balasan_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };
        //


        $this->relations['komik_komentars'] = function ($query) {
            return $query->orderBy('id', "DESC")->withCount(['komik_komentar_balasans', 'komik_komentar_likes'])->limit(20);
        };

        $this->relations['komik_komentars.komik_komentar_balasans'] = function ($query) use ($request) {
            return $query->limit(20);
        };

        $this->relations['komik_komentars.komik_komentar_balasans.komik_komentar_balasan_likes'] = function ($query) {
            return $query->limit(20);
        };

        $this->relations['komik_komentars.komik_komentar_balasans.komik_komentar_balasan_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };

        $this->relations['komik_komentars.komik_komentar_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };


        $this->count['komik_detail_dilihats'] = function ($query) {
            return $query->where("is_dilihat", "Ya");
        };

        $this->count['komik_detail_dilikes'] = function ($query) {
            return $query->where("is_dilike", "Ya");
        };

        $komik = (new Komik())->withCount($this->count);

        $komik = $komik->whereHas('komik_chapters');

        $komik = $komik->with($this->relations);

        if ($request->last_id) {
            $komik = $komik->where('id', '>', $request->last_id);
        }

        if ($request->limit) {

            $komik = $komik->limit($request->limit);
        }

        if ($request->keyword) {

            $komik = $komik->where('judul', 'like', '%' . $request->keyword . '%');
        }

        if ($request->where) {

            $komik = DB::select("select * from komik where $request->where");
        }

        $komik = $komik->get();

        return response()->json([
            "success" => true,
            'data' => $komik
        ]);
    }

    public function store(Request $request)
    {

    }

    public function removeBookmark(Request $request)
    {


        KomikBookmark::where(['user_id' => $request->user_id])->whereNotIn('komik_id', json_decode($request->bookmark_id_availables))->delete();

        return response()->json([
            "success" => true,
            'message' => ""
        ]);
    }

    public function addToDilihat(Request $request)
    {
        if ($komik = KomikDetail::where(['user_id' => $request->user_id])->first()) {
            $komik->update([
                'komik_id' => $request->komik_id,
                'user_id' => $request->user_id,
                "is_dilihat" => "Ya"
            ]);

            return response()->json([
                "success" => true,
            ]);
        } else {
            KomikDetail::create([
                'komik_id' => $request->komik_id,
                'user_id' => $request->user_id,
                "is_dilihat" => "Ya"
            ]);

            return response()->json([
                "success" => true,
            ]);
        }

    }

    public function addToDilike(Request $request)
    {
        if ($komik = KomikDetail::where(['user_id' => $request->user_id])->first()) {
            $komik->update([
                'komik_id' => $request->komik_id,
                'user_id' => $request->user_id,
                "is_dilike" => $komik->is_dilike == "Ya" ? "Tidak" : "Ya"
            ]);

            return response()->json([
                "success" => true,
            ]);
        } else {
            KomikDetail::create([
                'komik_id' => $request->komik_id,
                'user_id' => $request->user_id,
                "is_dilike" => "Ya"
            ]);

            return response()->json([
                "success" => true,
            ]);
        }

    }

    public function addKomikKomentarLike(Request $request)
    {
        if ($komikKomentar = KomikKomentarLike::where(['komik_komentar_id' => $request->komik_komentar_id, 'user_id' => $request->user_id])->first()) {
            $komikKomentar->update([
                'komik_komentar_id' => $request->komik_komentar_id,
                'user_id' => $request->user_id,
                "is_dilike" => $komikKomentar->is_dilike == "Ya" ? "Tidak" : "Ya"
            ]);

            return response()->json([
                "success" => true,
            ]);
        } else {
            KomikKomentarLike::create([
                'komik_komentar_id' => $request->komik_komentar_id,
                'user_id' => $request->user_id,
                "is_dilike" => "Ya"
            ]);

            return response()->json([
                "success" => true,
            ]);
        }
    }

    public function addKomikKomentarBalasanLike(Request $request)
    {
        if ($komikKomentarBalasan = KomikKomentarBalasanLike::where(['komik_komentar_balasan_id' => $request->komik_komentar_balasan_id, 'user_id' => $request->user_id])->first()) {
            $komikKomentarBalasan->update([
                'komik_komentar_balasan_id' => $request->komik_komentar_balasan_id,
                'user_id' => $request->user_id,
                "is_dilike" => $komikKomentarBalasan->is_dilike == "Ya" ? "Tidak" : "Ya"
            ]);

            return response()->json([
                "success" => true,
            ]);
        } else {
            KomikKomentarBalasanLike::create([
                'komik_komentar_balasan_id' => $request->komik_komentar_balasan_id,
                'user_id' => $request->user_id,
                "is_dilike" => "Ya"
            ]);

            return response()->json([
                "success" => true,
            ]);
        }
    }

    public function addKomikKomentarBalasan(Request $request)
    {
        $requestData = json_decode($request->all()['data'], true);
        unset($requestData['gambar']);

        if ($request->hasFile('gambar')) {
            $requestData['gambar'] = str_replace("\\", "/", $request->file('gambar')
                ->move('uploads', time() . "." . $request->file('gambar')->getClientOriginalExtension()));
        }

        KomikKomentarBalasan::create($requestData);

        return response()->json([
            "success" => true,
        ]);

    }

    public function addKomikChapterKomentarLike(Request $request)
    {
        if ($komikKomentar = KomikChapterKomentarLike::where(['komik_chapter_komentar_id' => $request->komik_chapter_komentar_id, 'user_id' => $request->user_id])->first()) {
            $komikKomentar->update([
                'komik_chapter_komentar_id' => $request->komik_chapter_komentar_id,
                'user_id' => $request->user_id,
                "is_dilike" => $komikKomentar->is_dilike == "Ya" ? "Tidak" : "Ya"
            ]);

            return response()->json([
                "success" => true,
            ]);
        } else {
            KomikChapterKomentarLike::create([
                'komik_chapter_komentar_id' => $request->komik_chapter_komentar_id,
                'user_id' => $request->user_id,
                "is_dilike" => "Ya"
            ]);

            return response()->json([
                "success" => true,
            ]);
        }
    }

    public function addKomikChapterKomentarBalasanLike(Request $request)
    {
        if ($komikChapterKomentarBalasan = KomikChapterKomentarBalasanLike::where(['komik_chapter_komentar_balasan_id' => $request->komik_chapter_komentar_balasan_id, 'user_id' => $request->user_id])->first()) {
            $komikChapterKomentarBalasan->update([
                'komik_chapter_komentar_balasan_id' => $request->komik_chapter_komentar_balasan_id,
                'user_id' => $request->user_id,
                "is_dilike" => $komikChapterKomentarBalasan->is_dilike == "Ya" ? "Tidak" : "Ya"
            ]);

            return response()->json([
                "success" => true,
            ]);
        } else {
            KomikChapterKomentarBalasanLike::create([
                'komik_chapter_komentar_balasan_id' => $request->komik_chapter_komentar_balasan_id,
                'user_id' => $request->user_id,
                "is_dilike" => "Ya"
            ]);

            return response()->json([
                "success" => true,
            ]);
        }
    }

    public function addKomikChapterKomentarBalasan(Request $request)
    {
        $requestData = json_decode($request->all()['data'], true);
        unset($requestData['gambar']);

        if ($request->hasFile('gambar')) {
            $requestData['gambar'] = str_replace("\\", "/", $request->file('gambar')
                ->move('uploads', time() . "." . $request->file('gambar')->getClientOriginalExtension()));
        }

        KomikChapterKomentarBalasan::create($requestData);

        return response()->json([
            "success" => true,
        ]);
    }

    public function getKomik(Request $request, $onlyModel = false)
    {
        $this->relations['komik_bookmarks'] = function ($query) {

            return $query->limit(20);
        };


        $this->relations['komik_chapters'] = function (HasMany $query) use ($request) {

            return $query
                ->with([
                    'komik_chapter_komentars' => function (HasMany $query) {
                        return $query->withCount(['komik_chapter_komentar_balasans', 'komik_chapter_komentar_likes'])->limit(20);
                    }
                    ,
                    'komik_chapter_dilihats' => function (HasMany $query) {
                        return $query->limit(20);
                    }
                    ,
                    'komik_chapter_dilikes' => function (HasMany $query) {
                        return $query->limit(20);
                    }
                    ,
                    'komik_chapter_like_is_current_user_like' => function (BelongsTo $query) use ($request) {
                        return $query->where('user_id', $request->user_id);
                    }
                ])
                ->withCount(['komik_chapter_komentars', 'komik_chapter_dilihats', 'komik_chapter_dilikes'])


                ->orderBy("nama");
        };

        // komik chapter
        $this->relations['komik_chapters.komik_chapter_komentars'] = function ($query) {
            return $query->orderBy('id', "DESC")->withCount(['komik_chapter_komentar_balasans', 'komik_chapter_komentar_likes'])->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans'] = function ($query) use ($request) {
            return $query->limit(20);
        };


        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans.user'] = function ($query) use ($request) {
            return $query->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_likes'] = function ($query) use ($request) {
            return $query->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans.komik_chapter_komentar_balasan_likes'] = function ($query) {
            return $query->limit(20);
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_balasans.komik_chapter_komentar_balasan_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };

        $this->relations['komik_chapters.komik_chapter_komentars.komik_chapter_komentar_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };
        //


        $this->relations['komik_komentars'] = function ($query) {
            return $query->orderBy('id', "DESC")->withCount(['komik_komentar_balasans', 'komik_komentar_likes'])->limit(20);
        };

        $this->relations['komik_komentars.komik_komentar_balasans'] = function ($query) use ($request) {
            return $query->limit(20);
        };

        $this->relations['komik_komentars.komik_komentar_balasans.komik_komentar_balasan_likes'] = function ($query) {
            return $query->limit(20);
        };

        $this->relations['komik_komentars.komik_komentar_balasans.komik_komentar_balasan_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };

        $this->relations['komik_komentars.komik_komentar_like_is_current_user_like'] = function ($query) use ($request) {
            return $query->where('user_id', $request->user_id)->where('is_dilike', 'Ya');
        };


        $this->count['komik_detail_dilihats'] = function ($query) {
            return $query->where("is_dilihat", "Ya");
        };

        $this->count['komik_detail_dilikes'] = function ($query) {
            return $query->where("is_dilike", "Ya");
        };

        $komik = (new Komik())->withCount($this->count);

        $komik = $komik->whereHas('komik_chapters');

        if ($request->komik_id) {

            $komik = $komik->where('id', $request->komik_id);
        }

        if ($onlyModel) {
            return $komik->with($this->relations)->first();
        }

        return response()->json([
            "success" => true,
            'data' => $komik->with($this->relations)->first()
        ]);
    }


    public function addKomentar(Request $request)
    {
        $requestData = json_decode($request->all()['data'], true);
        unset($requestData['gambar']);

        if ($request->hasFile('gambar')) {
            $requestData['gambar'] = str_replace("\\", "/", $request->file('gambar')
                ->move('uploads', time() . "." . $request->file('gambar')->getClientOriginalExtension()));
        }

        if (isset($requestData['komik_chapter_id'])) {

            KomikChapterKomentar::create($requestData);
        } else {
            KomikKomentar::create($requestData);
        }

        return response()->json([
            "success" => true,
        ]);
    }
}