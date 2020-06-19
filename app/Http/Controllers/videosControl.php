<?php

namespace App\Http\Controllers;

use App\model\mdVideos;
use Illuminate\Http\Request;

class videosControl extends Controller
{
    function index(Request $r){
        $type = $r->get("type");
        if($type == 'Insert'){
           return self::InsertVideos($r);
        }
        elseif($type =='hapus'){
            return self::hapus($r);
        }
        elseif($type =='All'){
            return self::All($r);
        }
        elseif($type =='ByDate'){
            return self::ByDate($r);
        }
        elseif($type =='ByDateRange'){
            return self::ByDateRange($r);
        }
    }

    function InsertVideos(Request $r){
        $data = $r->get("data");

        $toDb = array(
            "channelId"         => $data["channelId"],
            "title"             => $data["title"],
            "description"       => $data["description"],
            "thumbnails"        => $data["thumbnails"]["high"]["url"],
            "channelTitle"      => $data["channelTitle"],
            "url"               => $data["url"],
            "publishedAt"       => date("Y-m-d H:i:s", strtotime($data["publishedAt"])),
            "id_berita"         => $data["berita"]["berita_id"],
            "berita_terkait"    => $data["berita"]["berita_terkait"],
        );
        mdVideos::insert($toDb);
        return $data;
    }

    function hapus(Request $r){
        $id = $r->get("id");
        mdVideos::where("video_id", $id)->delete();
    }

    function All(Request $r){
        return mdVideos::orderBy("publishedAt","DESC")->get();
    }

    function ByDate(Request $r){
        $date = date("Y-m-d", strtotime($r->get('date')));
        return mdVideos::where("publishedAt",$date)->get();
        
    }
    function ByDateRange(Request $r){
        $start = date("Y-m-d", strtotime($r->get('date')[0]));
        $end = date("Y-m-d", strtotime($r->get('date')[1]));
        return mdVideos::whereBetween("publishedAt",[$start, $end])->get();
        
    }
}
