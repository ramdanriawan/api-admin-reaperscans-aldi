<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\UserPembayaran;
use App\Models\UserPremium;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
////
class UserPremiumController extends Controller
{

    public function requestTransaksi(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        
        // check apakah ada transaksi yang dilakukan dalam 24 jam terakhir sebanyak 2x
        if ($userPremium = UserPremium::where(['user_id' => $request->user_id, 'status' => 'Aktif'])->first()) {
            return response()->json([
                "success" => false,
                'message' => "User sudah terdaftar!"
            ]);
        }
        
        if (UserPremium::where(['user_id' => $request->user_id, 'status' => 'Tidak Aktif'])->whereDate('created_at', date("Y-m-d"))->get()->count() >= 2) {
            return response()->json([
                "success" => false,
                'message' => "Hari ini sudah 2x, Coba lagi besok!"
            ]);
        }

        $apiKey = 'wDT9UyWOm1wfnV4GHNDS4WtQMCtn9VY9FXxY4Bk8';
        $privateKey = '5iIaa-QYpam-IfzyA-2KLWz-UcLGI';
        $merchantCode = 'T3010';
        $amount = $request->jumlah;
        $merchantRef = 'INV-' . time();

        $data = [
            'method' => $request->metode_pembayaran,
            'merchant_ref' => $merchantRef,
            'amount' => $amount,
            'customer_name' => $user->fullName,
            'customer_email' => $user->email,
            'customer_phone' => $user->noHp,
            'order_items' => [
                [
                    'name' => "Pembelian premium untuk user: $user->fullName",
                    'quantity' => 1,
                    'price' => $amount
                ],
            ],
            'return_url' => !preg_match("/\.dev/", $_SERVER['HTTP_HOST']) ? "http://$_SERVER[HTTP_HOST]/api/user-premium/redirect" : "https://$_SERVER[HTTP_HOST]/api/user-premium/redirect",
            'expired_time' => (time() + (24 * 60 * 60)),
            // 24 jam
            'signature' => hash_hmac('sha256', $merchantCode . $merchantRef . $amount, $privateKey)
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT => true,
            CURLOPT_URL => 'https://tripay.co.id/api/transaction/create',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR => false,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4
        ]);

        $response = json_decode(curl_exec($curl));
        $error = curl_error($curl);

        curl_close($curl);

        if (!isset($response->data)) {
            return response()->json([
                'success' => false,
                'message' => $response->message
            ]);
        }

        if (empty($error)) {

            DB::transaction(function () use ($request, $response, $merchantRef) {
                $userPembayaranCreate = UserPembayaran::create([
                    'user_id' => $request->user_id,
                    'no_invoice' => $merchantRef,
                    'reference' => $response->data->reference,
                    'jumlah' => $request->jumlah,
                    'jumlah_bulan' => $request->jumlah_bulan,
                    'status' => 'Pending',
                ]);

                UserPremium::create([
                    'user_id' => $request->user_id,
                    'user_pembayaran_id' => $userPembayaranCreate->id,
                    'license' => Hash::make(time()),
                    'berlaku_dari' => Carbon::parse(now())->format("Y-m-d h:i:s"),
                    'berlaku_hingga' => Carbon::parse(now()->addMonths($request->jumlah_bulan))->format("Y-m-d h:i:s"),
                    "Status" => "Tidak Aktif"
                ]);
            });

            return response()->json([
                'success' => true,
                'data' => $response
            ]);
        }

        die($error);

    }

    public function updateStatus(Request $request)
    {
        // if ($request->status == "PAID") {
        //     Notification::where('forTableRowId', $request->forTableRowId)->first()->update([
        //         "user_id" => $request->user_id,
        //         "forTable" => "giving",
        //         "type" => "Success",
        //         "message" => "Payment Success: " . $request->forTableRowId,
        //     ]);
        // }

        // if ($request->status == "EXPIRED") {
        //     Notification::where('forTableRowId', $request->forTableRowId)->first()->update([
        //         "user_id" => $request->user_id,
        //         "forTable" => "giving",
        //         "type" => "Error",
        //         "message" => "Payment Expired: " . $request->forTableRowId,
        //     ]);
        // }

        return response()->json([
            "success" => true,
        ]);
    }

    public function detailTransaksi(Request $request)
    {
        $apiKey = 'wDT9UyWOm1wfnV4GHNDS4WtQMCtn9VY9FXxY4Bk8';

        $payload = ['reference' => $request->reference];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT => true,
            CURLOPT_URL => 'https://tripay.co.id/api/transaction/detail?' . http_build_query($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR => false,
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        if (empty($error)) {
            $data = json_decode($response);

            if ($data->data->status == "PAID") {
                $userPembayaran = UserPembayaran::where(['reference' => $request->reference])->first();

                $userPembayaran->update([
                    'status' => 'Selesai'
                ]);

                if ($userPembayaran) {
                    UserPremium::where(['user_pembayaran_id' => $userPembayaran->id])->first()->update([
                        'status' => 'Aktif'
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }

        die($error);
    }


    public function redirect(Request $request)
    {

    }
}