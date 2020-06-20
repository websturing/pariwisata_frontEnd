<?php

namespace App\Http\Controllers;

use App\model\mdGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class galleryControl extends Controller
{
    function index(Request $r)
    {

        $type = $r->get("type");
        if ($type == 'insertData') {
            return self::insertData($r);
        }
    }


    function uploadImage($file)
    {
        $date = date("Ymd");
        $folder = "gallery";
        $pathFolder = Storage::disk("ResourcesExternalImages")->path($folder . '/' . $date);
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
        $path = Storage::disk("ResourcesExternalImages")->path($folder . '/' . $date . '/' . $filename);
        file_put_contents($path, $decoded);

        return $filename;
    }

    function insertData(Request $r)
    {
        $data =  $r->get("gallery");

        $tgl = date("Y-m-d", strtotime($data['date_publish']));
        $image = self::uploadImage($data['image']);

        $todatabase = array(
            "image" => $image,
            "description" => $data['description'],
            "date_publish" => $tgl,
            "caption" => $data['caption'],
            "judul" => $data['judul'],
            "is_active" => $data['is_active'],
        );
        mdGallery::insert($todatabase);
        $gallery_id = DB::getPdo()->lastInsertId();


        return $gallery_id;
    }
}
