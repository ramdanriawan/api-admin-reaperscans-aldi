<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\UserPembayaran;
use App\Models\UserPremium;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data['pembayaran'] = UserPembayaran::paginate(10000);

        $data['pembayaran_count'] = count(Schema::getColumnListing('pembayaran'));

        return view('pembayaran.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('pembayaran.create');
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
			'no_hp' => 'required|max:15'
		]);
        $requestData = $request->all();

        

        UserPembayaran::create($requestData);

        return redirect()->route('pembayaran.index')->with('success', 'Berhasil menambah Pembayaran');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show(UserPembayaran $pembayaran)
    {
        $data["item"] = $pembayaran;
        $data["pembayaran"] = $pembayaran;

        return view('pembayaran.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit(UserPembayaran $pembayaran)
    {
        $data["pembayaran"] = $pembayaran;
        $data[strtolower("Pembayaran")] = $pembayaran;

        return view('pembayaran.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, UserPembayaran $pembayaran)
    {
        $this->validate($request, [
			'jumlah' => 'required',
			'status' => 'required',
			'jumlah_bulan' => 'required',
		]);

        $requestData = $request->all();

        // update user premium
        if($request->status == 'selesai') {
            $userPremium = UserPremium::where('user_pembayaran_id', $pembayaran->id)->first();

            if(!$userPremium) {
                $berlakuHingga = Carbon::parse($pembayaran->waktu_bayar)->addMonths($pembayaran->jumlah_bulan)->format("Y-m-d h:i:s");

                UserPremium::create([
                    'user_id' => $pembayaran->user_id,
                    'user_pembayaran_id' => $pembayaran->id,
                    'license' => Hash::make(time()),
                    'berlaku_dari' => $pembayaran->waktu_bayar,
                    'berlaku_hingga' => Carbon::parse($pembayaran->waktu_bayar)->addMonths($pembayaran->jumlah_bulan)->format("Y-m-d h:i:s"),
                    'status' => $berlakuHingga > date("Y-m-d h:i:s") ? "Aktif" : "Berakhir"
                ]);
            } else {
                $userPremium->update([
                    'user_id' => $pembayaran->user_id,
                    'user_pembayaran_id' => $pembayaran->id,
                    'license' => Hash::make(time()),
                    'berlaku_dari' => $pembayaran->waktu_bayar,
                    'berlaku_hingga' => Carbon::parse($pembayaran->waktu_bayar)->addMonths($pembayaran->jumlah_bulan)->format("Y-m-d h:i:s"),
                    'status' => $berlakuHingga > date("Y-m-d h:i:s") ? "Aktif" : "Berakhir"
                ]);
            }
        }       

        $pembayaran->update($requestData);

        return redirect()->route('pembayaran.index')->with('success', 'Berhasil mengubah Pembayaran');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(UserPembayaran $pembayaran)
    {
        $pembayaran->delete();

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil dihapus!');
    }

    public function hapus_semua(Request $request)
    {
        $pembayarans = UserPembayaran::whereIn('id', json_decode($request->ids, true))->get();

        UserPembayaran::whereIn('id', $pembayarans->pluck('id'))->delete();

        return back()->with('success', 'Berhasil menghapus banyak data pembayaran');
    }

    public function laporan()
    {
        $data['limit'] = UserPembayaran::count();

        return view('pembayaran.laporan.index', $data);
    }

    public function print(Request $request)
    {
        $table = (new UserPembayaran)->getTable();
        $object = (new UserPembayaran);

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

        $data["pembayarans"] = $object->orderBy($request->field, $request->order)->limit($request->limit)->get();

        if(!$data["pembayarans"]->count()) {
            
            return back()->with('error', 'Data tidak ada!');
        }

        return view("pembayaran.laporan.print", $data);
    }
}