<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Komik;
use App\Models\KomikChapter;
use App\Models\KomikGenre;
use App\Models\KomikListGenre;
use App\Models\KomikTipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Throwable;
use ZipArchive;

class KomikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data['komik'] = Komik::paginate(10000);

        $data['komik_count'] = count(Schema::getColumnListing('komik'));

        return view('komik.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data['komik_tipe'] = KomikTipe::pluck('nama', 'id');
        $data['komik_genre'] = KomikGenre::all();

        return view('komik.create', $data);
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
        $this->validate($request, [
            'komik_tipe_id' => 'required',
            'judul' => 'required',
            'sinopsis' => 'required',
            'alternatif' => 'required',
            'author' => 'required',
            'artist' => 'required',
            'gambar' => 'required',
        ]);
        $requestData = $request->except(['komik_list_genres']);


        if ($request->hasFile('gambar')) {
            $requestData['gambar'] = str_replace("\\", "/", $request->file('gambar')->move("gambar", time() . "." . $request->file('gambar')->getClientOriginalExtension()));
        }


        DB::transaction(function () use ($requestData, $request) {

            $komikCreate = Komik::create($requestData);
            foreach ($request->komik_list_genres as $item) {
                KomikListGenre::create([
                    'komik_id' => $komikCreate->id,
                    'komik_genre_id' => $item
                ]);
            }
        });

        return redirect()->route('komik.index')->with('success', 'Berhasil menambah Komik');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show(Komik $komik)
    {
        $data["item"] = $komik;
        $data["komik"] = $komik;

        return view('komik.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit(Komik $komik)
    {
        $data["komik"] = $komik;
        $data[strtolower("Komik")] = $komik;

        $data['komik_tipe'] = KomikTipe::pluck('nama', 'id');
        $data['komik_genre'] = KomikGenre::all();

        return view('komik.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Komik $komik)
    {
        $this->validate($request, [
            'komik_tipe_id' => 'required',
            'judul' => 'required',
            'sinopsis' => 'required',
            'alternatif' => 'required',
            'author' => 'required',
            'artist' => 'required',
        ]);

        $requestData = $request->except(['komik_list_genres']);

        if ($request->hasFile('gambar')) {
            $requestData['gambar'] = str_replace("\\", "/", $request->file('gambar')->move("gambar", time() . "." . $request->file('gambar')->getClientOriginalExtension()));
        }

        DB::transaction(function () use ($requestData, $request, $komik) {

            KomikListGenre::where('komik_id', $komik->id)->delete();
            foreach ($request->komik_list_genres as $item) {
                KomikListGenre::create([
                    'komik_id' => $komik->id,
                    'komik_genre_id' => $item
                ]);
            }
        });

        $komik->update($requestData);

        return redirect()->route('komik.index')->with('success', 'Berhasil mengubah Komik');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Komik $komik)
    {
        $komik->delete();

        return redirect()->route('komik.index')->with('success', 'Komik berhasil dihapus!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    

    public function hapus_semua(Request $request)
    {
        $komiks = Komik::whereIn('id', json_decode($request->ids, true))->get();

        Komik::whereIn('id', $komiks->pluck('id'))->delete();

        return back()->with('success', 'Berhasil menghapus banyak data komik');
    }

    public function laporan()
    {
        $data['limit'] = Komik::count();

        return view('komik.laporan.index', $data);
    }

    public function print(Request $request)
    {
        $table = (new Komik)->getTable();
        $object = (new Komik);

        $fields = [];
        foreach (DB::select("DESC $table") as $tableField) {
            $fields[] = $tableField->Field;
        }

        $this->validate($request, [
            'field' => 'required|in:' . implode(',', $fields),
            'order' => 'required|in:ASC,DESC',
            'limit' => 'required|integer|max:' . $object->get()->count(),
        ]);

        $data["komiks"] = $object->orderBy($request->field, $request->order)->limit($request->limit)->get();

        if (!$data["komiks"]->count()) {

            return back()->with('error', 'Data tidak ada!');
        }

        return view("komik.laporan.print", $data);
    }

    
}