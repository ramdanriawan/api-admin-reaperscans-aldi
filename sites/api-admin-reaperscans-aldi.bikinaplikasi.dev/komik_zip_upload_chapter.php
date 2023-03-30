<?php
include("./vendor/autoload.php");

use App\Models\Komik;

// $komik = Komik::findOrFail($request->komik_id);
// $zip = new ZipArchive;
// $zip->open($request->file('file_zip')->getRealPath());
// $zip->getNameIndex(0);

// try {
//     $filesToInsertToDatabase = [];
//     for ($i = 0; $i < $zip->count(); $i++) {
        
//         // untuk melakukan checking apakah dia folder atau bukan
//         $namaGambar = 'gambar/' . rand(10000000, 99999999) . ".png";
//         $statName = $zip->statIndex($i)['name'];
//         $fileName = basename($statName);
//         $fileNameWithoutExtension = pathinfo($fileName, PATHINFO_FILENAME);
//         $dirname = dirname($statName);
//         $checkIfDir = $dirname != ".";
//         $checkIfFile = preg_match("/\.png|\.jpg|\.jpeg|\.PNG|\.JPG|\.JPEG/", $statName);

//         // ini adalah if untuk mengecek jika dia adalah multiple chapter
//         if ($checkIfFile && $checkIfDir) {
//             $chapterName = "$dirname - $fileNameWithoutExtension";

//             if ($komik->komik_chapters->where('nama', $chapterName)->first()) {
//                 return redirect()->back()->with('error', "Nama chapter $chapterName tersebut sudah ada!");
//             }

//             $filesToInsertToDatabase[$i]['nama_chapter'] = $chapterName;
//             $filesToInsertToDatabase[$i]['nama_gambar'] = $namaGambar;
//             $filesToInsertToDatabase[$i]['data_gambar'] = $zip->getFromName($statName);

//         } else if ($checkIfFile && !$checkIfDir) {
//             $chapterName = "Chapter $fileNameWithoutExtension";
//             if ($komik->komik_chapters->where('nama', $chapterName)->first()) {
//                 return redirect()->back()->with('error', "Nama chapter $chapterName tersebut sudah ada!");
//             }

//             $filesToInsertToDatabase[$i]['nama_chapter'] = $chapterName;
//             $filesToInsertToDatabase[$i]['nama_gambar'] = $namaGambar;
//             $filesToInsertToDatabase[$i]['data_gambar'] = $zip->getFromName($statName);
//         }
//     }
    
//     foreach ($filesToInsertToDatabase as $key => $file) {
//         file_put_contents($file['nama_gambar'], $file['data_gambar']);

//         KomikChapter::create([
//             'komik_id' => $komik->id,
//             'nama' => $file['nama_chapter'],
//             'gambar' => $file['nama_gambar']
//         ]);
//     }
// } catch (Throwable $t) {
//     return redirect()->back()->with('error', $t->getMessage());
// }