<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/home', function () {
    return "
    <div Style = 'text-align: center;'>
        Selamat datang di halaman home
        <br><br>
        <a href='/produk pria'>
        Produk untuk Pria
        </a>
        <br></br>
        <a href='/produk wanita'>
        Produk untuk Wanita
        </a>
        <br></br>
        <a href='/produk anak-anak'>
        Produk untuk anak-anak
        </a>
        <br></br>
        <a href='/equipment'>
        Equipment
        </a>
        <br></br>
        <a href='/koleksi'>
        Koleksi
        </a>
        <br></br>
        <a href='/notifikasi'>
        notifikasi
        </a>
        <br></br>
        <a href='/keranjang'>
        Keranjang
        </a>
        <br></br>
        <a href='/profil'>
        Profil
        <br></br>
        <a href='https://eigeradventure.com/' target='_blank'>Website Eiger Adventure</a>
    </div>
    ";
});

Route::get('/produk pria', function () {
    return 'Ini adalah halaman produk untuk pria';  
});

Route::get('/produk wanita', function () {
    return 'Ini adalah halaman produk untuk wanita';
});

Route::get('/produk anak-anak', function () {
    return 'Ini adalah halaman produk untuk anak';
});

Route::get('/equipment', function () {
    return 'Ini adalah halaman equipment';
});

Route::get('/koleksi', function () {
    return 'Ini adalah halaman koleksi';
});

Route::get('/notifikasi', function () {
    return 'Ini adalah halaman notifikasi';
});

Route::get('/keranjang', function () {
    return 'Ini adalah halaman keranjang';
});

Route::get('/profil', function () {
    return 'Ini adalah halaman profil';
});

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
