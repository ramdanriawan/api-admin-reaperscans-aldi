<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Komik;
use App\Models\KomikRanking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data['ranking'] = KomikRanking::paginate(10000);

        $data['ranking_count'] = count(Schema::getColumnListing('ranking'));

        return view('ranking.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data['komik_ranking_ids'] = KomikRanking::all()->pluck('komik.id')->join(",");

        return view('ranking.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $requestData = $request->all();

        $komik_ids = explode(",", $request->komik_id);

        KomikRanking::where('id', ">", 0)->delete();
        foreach ($komik_ids as $key => $komik_id) {
            if(!Komik::where('id', $komik_id)->first()) {

                return redirect()->back()->with('error', "Id komik $komik_id tidak ada!");
            }
            
            KomikRanking::create([
                'ranking' => $key + 1,
                'komik_id' => $komik_id
            ]);
        }

        return redirect()->route('ranking.index')->with('success', 'Berhasil mengupdate Ranking');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show(KomikRanking $ranking)
    {
        $data["item"] = $ranking;
        $data["ranking"] = $ranking;

        return view('ranking.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit(KomikRanking $ranking)
    {
        $data["ranking"] = $ranking;
        $data[strtolower("Ranking")] = $ranking;
        $data['komik'] = Komik::pluck('judul', 'id');

        return view('ranking.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, KomikRanking $ranking)
    {
        $requestData = $request->all();

        if ($request->hasFile('gambar')) {
            $requestData['gambar'] = str_replace("\\", "/", $request->file('gambar')->move("gambar", time() . "." . $request->file('gambar')->getClientOriginalExtension()));
        }

        $ranking->update($requestData);

        return redirect()->route('ranking.index')->with('success', 'Berhasil mengubah Ranking');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(KomikRanking $ranking)
    {
        $ranking->delete();

        return redirect()->route('ranking.index')->with('success', 'Ranking berhasil dihapus!');
    }

    public function hapus_semua(Request $request)
    {
        $rankings = KomikRanking::whereIn('id', json_decode($request->ids, true))->get();

        KomikRanking::whereIn('id', $rankings->pluck('id'))->delete();

        return back()->with('success', 'Berhasil menghapus banyak data ranking');
    }

    public function laporan()
    {
        $data['limit'] = KomikRanking::count();

        return view('ranking.laporan.index', $data);
    }

    public function print(Request $request)
    {
        
    }
}