<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Komik;
use App\Models\KomikRekomendasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RekomendasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data['rekomendasi'] = KomikRekomendasi::paginate(10000);

        $data['rekomendasi_count'] = count(Schema::getColumnListing('rekomendasi'));

        return view('rekomendasi.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data['komik_rekomendasi_ids'] = KomikRekomendasi::all()->pluck('komik.id')->join(",");

        return view('rekomendasi.create', $data);
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

        KomikRekomendasi::where('id', ">", 0)->delete();
        foreach ($komik_ids as $key => $komik_id) {
            if(!Komik::where('id', $komik_id)->first()) {

                return redirect()->back()->with('error', "Id komik $komik_id tidak ada!");
            }
            
            KomikRekomendasi::create([
                'rekomendasi' => $key + 1,
                'komik_id' => $komik_id
            ]);
        }

        return redirect()->route('rekomendasi.index')->with('success', 'Berhasil mengupdate Rekomendasi');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show(KomikRekomendasi $rekomendasi)
    {
        $data["item"] = $rekomendasi;
        $data["rekomendasi"] = $rekomendasi;

        return view('rekomendasi.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit(KomikRekomendasi $rekomendasi)
    {
        $data["rekomendasi"] = $rekomendasi;
        $data[strtolower("Rekomendasi")] = $rekomendasi;
        $data['komik'] = Komik::pluck('judul', 'id');

        return view('rekomendasi.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, KomikRekomendasi $rekomendasi)
    {
        $requestData = $request->all();

        if ($request->hasFile('gambar')) {
            $requestData['gambar'] = str_replace("\\", "/", $request->file('gambar')->move("gambar", time() . "." . $request->file('gambar')->getClientOriginalExtension()));
        }

        $rekomendasi->update($requestData);

        return redirect()->route('rekomendasi.index')->with('success', 'Berhasil mengubah Rekomendasi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(KomikRekomendasi $rekomendasi)
    {
        $rekomendasi->delete();

        return redirect()->route('rekomendasi.index')->with('success', 'Rekomendasi berhasil dihapus!');
    }

    public function hapus_semua(Request $request)
    {
        $rekomendasis = KomikRekomendasi::whereIn('id', json_decode($request->ids, true))->get();

        KomikRekomendasi::whereIn('id', $rekomendasis->pluck('id'))->delete();

        return back()->with('success', 'Berhasil menghapus banyak data rekomendasi');
    }

    public function laporan()
    {
        $data['limit'] = KomikRekomendasi::count();

        return view('rekomendasi.laporan.index', $data);
    }

    public function print(Request $request)
    {
        
    }
}