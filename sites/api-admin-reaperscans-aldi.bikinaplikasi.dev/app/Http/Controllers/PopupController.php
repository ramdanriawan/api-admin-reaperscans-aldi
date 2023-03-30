<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Popup;
use App\Models\PopupChapter;
use App\Models\PopupGenre;
use App\Models\PopupListGenre;
use App\Models\PopupTipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Throwable;
use ZipArchive;

class PopupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data['popup'] = Popup::paginate(10000);

        $data['popup_count'] = count(Schema::getColumnListing('popup'));

        return view('popup.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        return view('popup.create');
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
            'link' => 'required',
            'gambar' => 'required',
        ]);
        $requestData = $request->except([]);

        if ($request->hasFile('gambar')) {
            $requestData['gambar'] = str_replace("\\", "/", $request->file('gambar')->move("gambar", time() . "." . $request->file('gambar')->getClientOriginalExtension()));
        }

        DB::transaction(function () use ($requestData, $request) {
            $popupCreate = Popup::create($requestData);
        });

        return redirect()->route('popup.index')->with('success', 'Berhasil menambah Popup');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show(Popup $popup)
    {
        $data["item"] = $popup;
        $data["popup"] = $popup;

        return view('popup.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit(Popup $popup)
    {
        $data["popup"] = $popup;
        $data[strtolower("Popup")] = $popup;

        return view('popup.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Popup $popup)
    {
        $this->validate($request, [
            'link' => 'required',
        ]);

        $requestData = $request->except([]);

        if ($request->hasFile('gambar')) {
            $requestData['gambar'] = str_replace("\\", "/", $request->file('gambar')->move("gambar", time() . "." . $request->file('gambar')->getClientOriginalExtension()));
        }

        $popup->update($requestData);

        return redirect()->route('popup.index')->with('success', 'Berhasil mengubah Popup');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Popup $popup)
    {
        $popup->delete();

        return redirect()->route('popup.index')->with('success', 'Popup berhasil dihapus!');
    }

    public function hapus_semua(Request $request)
    {
        $popups = Popup::whereIn('id', json_decode($request->ids, true))->get();

        Popup::whereIn('id', $popups->pluck('id'))->delete();

        return back()->with('success', 'Berhasil menghapus banyak data popup');
    }

    public function laporan()
    {
        $data['limit'] = Popup::count();

        return view('popup.laporan.index', $data);
    }

    public function aktifkan(Popup $popup)
    {

        $popup->update([
            'status' => 'Aktif'
        ]);
        
        Popup::where('id', '!=', $popup->id)->update([
            'status' => 'Tidak Aktif'
        ]);

        return redirect()->route('popup.index')->with('success', 'popup berhasil diupdate!');
    }
}