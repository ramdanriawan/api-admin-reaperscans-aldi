<?php

namespace App\Jobs;

use App\Models\KomikChapter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use App\Models\Komik;

class SKomikZipUploadChapter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $request;
    public $komik;
    public $komik_zip_upload_chapter;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Array $request, Komik $komik, $komik_zip_upload_chapter)
    {
        $this->request = $request;
        $this->komik = $komik;
        $this->komik_zip_upload_chapter = $komik_zip_upload_chapter;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $zip = new \ZipArchive;
        $zip->open(public_path($this->komik_zip_upload_chapter));
        $zip->getNameIndex(0);

        try {
            $filesToInsertToDatabase = [];
            for ($i = 0; $i < $zip->count(); $i++) {
                
                // untuk melakukan checking apakah dia folder atau bukan
                $namaGambar = 'gambar/' . rand(10000000, 99999999) . ".png";
                $statName = $zip->statIndex($i)['name'];
                $fileName = basename($statName);
                $fileNameWithoutExtension = pathinfo($fileName, PATHINFO_FILENAME);
                $dirname = dirname($statName);
                $checkIfDir = $dirname != ".";
                $checkIfFile = preg_match("/\.png|\.jpg|\.jpeg|\.PNG|\.JPG|\.JPEG/", $statName);

                // ini adalah if untuk mengecek jika dia adalah multiple chapter
                if ($checkIfFile && $checkIfDir) {
                    $chapterName = "$dirname - $fileNameWithoutExtension";

                    if ($this->komik->komik_chapters->where('nama', $chapterName)->first()) {
                        file_put_contents(public_path() . "/" . 'komik_zip_upload_chapter_error_log.txt', "Nama chapter $chapterName tersebut sudah ada!");
                    }

                    $filesToInsertToDatabase[$i]['nama_chapter'] = $chapterName;
                    $filesToInsertToDatabase[$i]['nama_gambar'] = $namaGambar;
                    $filesToInsertToDatabase[$i]['data_gambar'] = $zip->getFromName($statName);

                } else if ($checkIfFile && !$checkIfDir) {
                    $chapterName = "Chapter $fileNameWithoutExtension";
                    if ($this->komik->komik_chapters->where('nama', $chapterName)->first()) {
                        file_put_contents(public_path() . "/" . 'komik_zip_upload_chapter_error_log.txt', "Nama chapter $chapterName tersebut sudah ada!");
                    }

                    $filesToInsertToDatabase[$i]['nama_chapter'] = $chapterName;
                    $filesToInsertToDatabase[$i]['nama_gambar'] = $namaGambar;
                    $filesToInsertToDatabase[$i]['data_gambar'] = $zip->getFromName($statName);
                }
            }
            
            foreach ($filesToInsertToDatabase as $key => $file) {
                file_put_contents(public_path() . "/" . $file['nama_gambar'], $file['data_gambar']);

                KomikChapter::create([
                    'komik_id' => $this->komik->id,
                    'nama' => $file['nama_chapter'],
                    'gambar' => $file['nama_gambar']
                ]);
            }
        } catch (\Throwable $t) {
            file_put_contents(public_path() . "/" . 'komik_zip_upload_chapter_error_log.txt', $t->getMessage());
        }
    }
}
