<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\KomikTipe;
use App\Models\Tipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data['tipe'] = KomikTipe::paginate(10000);

        $data['tipe_count'] = count(Schema::getColumnListing('tipe'));

        return view('tipe.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('tipe.create');
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
			'nama' => 'required|max:30',
		]);
        $requestData = $request->all();

        

        KomikTipe::create($requestData);

        return redirect()->route('tipe.index')->with('success', 'Berhasil menambah Tipe');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show(KomikTipe $tipe)
    {
        $data["item"] = $tipe;
        $data["tipe"] = $tipe;

        return view('tipe.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit(KomikTipe $tipe)
    {
        $data["tipe"] = $tipe;
        $data[strtolower("Tipe")] = $tipe;

        return view('tipe.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, KomikTipe $tipe)
    {
        $this->validate($request, [
			'nama' => 'required|max:30',
		]);

        $requestData = $request->all();

        

        $tipe->update($requestData);

        return redirect()->route('tipe.index')->with('success', 'Berhasil mengubah Tipe');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(KomikTipe $tipe)
    {
        $tipe->delete();

        return redirect()->route('tipe.index')->with('success', 'Tipe berhasil dihapus!');
    }

    public function hapus_semua(Request $request)
    {
        $tipes = KomikTipe::whereIn('id', json_decode($request->ids, true))->get();

        KomikTipe::whereIn('id', $tipes->pluck('id'))->delete();

        return back()->with('success', 'Berhasil menghapus banyak data tipe');
    }

    public function laporan()
    {
        $data['limit'] = KomikTipe::count();

        return view('tipe.laporan.index', $data);
    }

    public function print(Request $request)
    {
        $table = (new Tipe)->getTable();
        $object = (new Tipe);

        $fields = [];
        foreach(DB::select("DESC $table") as $tableField)
        {
            $fields[] = $tableField->Field;
        }

        $this->validate($request, [
            'field' => 'required|in:' . implode(',', $fields),
            'order' => 'required|in:ASC,DESC',
            'limit' => 'required|integer|max:' . $object->get()->count(),
        ]);

        $data["tipes"] = $object->orderBy($request->field, $request->order)->limit($request->limit)->get();

        if(!$data["tipes"]->count()) {
            
            return back()->with('error', 'Data tidak ada!');
        }

        return view("tipe.laporan.print", $data);
    }
}