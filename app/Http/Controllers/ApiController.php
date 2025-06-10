<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
     public function getApiData() 
    { 
        try { 
            $response = Http::get('https://wilayah.id/api/provinces.json'); 
 
            // Memeriksa apakah request berhasil 
            if ($response->successful()) { 
                $data = $response->json(); // Mengubah response menjadi format JSON 
                return view('api_view', ['data' => $data]); // Kirim data ke view 
            } else { 
                // Menangani error jika request gagal 
                return 'Terjadi kesalahan saat mengambil data dari API.'; 
            } 
 
        } catch (\Exception $e) { 
            // Menangani exception yang mungkin terjadi 
            return 'Terjadi kesalahan: ' . $e->getMessage(); 
        } 
    }
}