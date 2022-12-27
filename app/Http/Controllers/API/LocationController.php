<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    //menampilkan  provinsi dan kota atau kabupaten
    public function provinces(Request $request)
    {
        return Province::all();
    }

    public function regencies(Request $request, $id)
    {
        return Regency::where('province_id', $id)->get();
    }

}
