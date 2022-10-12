<?php

namespace App\Http\Livewire;

use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class TambahProduk extends Component
{
    public $nama, $harga, $berat, $gambar;
    use WithFileUploads;
    public function mount()
    {
        // cek apakah yang login admin atau bukan.
        if (Auth::user()) {
            if (Auth::user()->level !== 1) {
                return redirect()->to(''); // redirect ke home
            }
        }
    }

    public function store()
    {
        // validasi
        $this->validate([
            'nama' => 'required',
            'harga' => 'required',
            'berat' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // proses data file gambar
        $nama_gambar = md5($this->gambar . microtime()) . '.' . $this->gambar->extension(); // buat nama gambar unik
        Storage::disk('public')->putFileAs('photos', $this->gambar, $nama_gambar); // jangan lupa di folder config/filesystems line 70an 'public_path('storage/photos') => storage_path('app/photos')'
        // sama ketik 'php artisan storage:link' di shell



        // memasukan data ke db
        Produk::create([
            'nama' => $this->nama,
            'harga' => $this->harga,
            'berat' => $this->berat,
            'gambar' => $nama_gambar,
        ]);

        // redirect
        return redirect()->to('');
    }

    public function render()
    {
        return view('livewire.tambah-produk')->extends('layouts.app')->section('content');
    }
}
