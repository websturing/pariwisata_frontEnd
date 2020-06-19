<?php

namespace App\Http\Controllers;

use App\mdPeraturan;
use Illuminate\Http\Request;

class peraturanControl extends Controller
{
    function index(Request $r)
    {
        $type = $r->get("type");
        if ($type == 'All') {
            return self::AllPeraturan($r);
        } elseif ($type == 'peraturanByDate') {
            return self::peraturanByDate($r);
        }
    }

    function AllPeraturan(Request $r)
    {
        return mdPeraturan::all();
    }
    function peraturanByDate(Request $r)
    {
        $date = date("Y-m-d", strtotime($r->get('date')));
        return mdPeraturan::where("created_at", $date)->get();
    }
}
