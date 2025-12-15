<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => Notifikasi::orderBy('created_at', 'desc')->get()
        ]);
    }
}
