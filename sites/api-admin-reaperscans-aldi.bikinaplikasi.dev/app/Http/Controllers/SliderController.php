<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Komik;
use App\Models\KomikSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data['slider'] = KomikSlider::paginate(10000);

        $data['slider_count'] = count(Schema::getColumnListing('slider'));

        return view('slider.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data['komik'] = Komik::pluck('judul', 'id');

        return view('slider.create', $data);
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

        if ($request->hasFile('gambar')) {
            $requestData['gambar'] = str_replace("\\", "/", $request->file('gambar')->move("gambar", time() . "." . $request->file('gambar')->getClientOriginalExtension()));
        }

        KomikSlider::create($requestData);

        return redirect()->route('slider.index')->with('success', 'Berhasil menambah Slider');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show(KomikSlider $slider)
    {
        $data["item"] = $slider;
        $data["slider"] = $slider;

        return view('slider.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit(KomikSlider $slider)
    {
        $data["slider"] = $slider;
        $data[strtolower("Slider")] = $slider;
        $data['komik'] = Komik::pluck('judul', 'id');

        return view('slider.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, KomikSlider $slider)
    {
        $requestData = $request->all();

        if ($request->hasFile('gambar')) {
            $requestData['gambar'] = str_replace("\\", "/", $request->file('gambar')->move("gambar", time() . "." . $request->file('gambar')->getClientOriginalExtension()));
        }

        $slider->update($requestData);

        return redirect()->route('slider.index')->with('success', 'Berhasil mengubah Slider');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(KomikSlider $slider)
    {
        $slider->delete();

        return redirect()->route('slider.index')->with('success', 'Slider berhasil dihapus!');
    }

    public function hapus_semua(Request $request)
    {
        $sliders = KomikSlider::whereIn('id', json_decode($request->ids, true))->get();

        KomikSlider::whereIn('id', $sliders->pluck('id'))->delete();

        return back()->with('success', 'Berhasil menghapus banyak data slider');
    }

    public function laporan()
    {
        $data['limit'] = KomikSlider::count();

        return view('slider.laporan.index', $data);
    }

    public function print(Request $request)
    {
        
    }
}