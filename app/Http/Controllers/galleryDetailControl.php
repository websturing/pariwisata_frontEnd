<?php

namespace App\Http\Controllers;

use App\model\mdGalleryDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class galleryDetailControl extends Controller
{
    function index(Request $r)
    {

        $type = $r->get("type");
        if ($type == 'insertData') {
            return self::insertData($r);
        }
    }

    function insertData(Request $r)
    {
        $data = $r->get("GalleryDetail");
        $id = $r->get("id");

        for ($i = 0; $i < count($data); $i++) {
            $date = date("Ymd");

            $image = self::uploadImage($data[$i]['image'], $date);

            $todatabase = array(
                "gallery_id" => $id,
                "image" => $image,
                "caption" => $data[$i]['caption']
            );
            mdGalleryDetail::insert($todatabase);
        }
        // $gallery_id = DB::getPdo()->lastInsertId();
        return $id;
    }

    function uploadImage($file, $tgl)
    {
        $date = $tgl;
        $folder = "gallery/" . $tgl;
        $pathFolder = Storage::disk("ResourcesExternalImages")->path($folder . '/detail');
        if (!File::exists($pathFolder)) {
            File::makeDirectory($pathFolder, $mode = 0777, true, true);
        }

        $expoloded = explode(",", $file);
        $decoded = base64_decode($expoloded[1]);
        $extensionBase =  $expoloded[0];
        $imgexb = preg_replace('/^data:image\/\w+;base64,/', '', $extensionBase);
        $type = explode(';', $imgexb)[0];
        $extension = explode('/', $type)[1];
        $name = Str::random(10);
        $filename = $name . '.' . $extension;
        $path = Storage::disk("ResourcesExternalImages")->path($folder . '/detail' . '/' . $filename);
        file_put_contents($path, $decoded);

        return $filename;
    }
}
