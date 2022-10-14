<?php

namespace App\Http\Livewire;

use App\Models\Belanja;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Home extends Component
{

    public $products = [];

    // atribut filtering
    public $search, $min, $max;

    public function beli($id)
    {
        if (!Auth::user()) { // cek apakah yang klik beli sudah login
            return redirect()->route('login');
        }
        if (Auth::user()->level == 1) { // cek apakah admin
            return redirect()->to('/');
        }

        // jika sudah login, maka cari data produk sesuai dengan id yang dikasih
        $produk = Produk::find($id);

        // masukan ke tb belanja(keranjang belanja) data produk yang dipilih
        Belanja::create([
            'user_id' => Auth::user()->id,
            'total_harga' => $produk->harga,
            'produk_id' => $produk->id,
            'status' => 0,
        ]);

        // redirect
        return redirect()->to('BelanjaUser');
    }

    public function render()
    {

        // filter harga max
        if ($this->max) {
            $harga_max = $this->max;
        } else {
            $harga_max = 9999999999999999;
        }
        // filter harga min
        if ($this->min) {
            $harga_min = $this->min;
        } else {
            $harga_min = 0;
        }

        if ($this->search) { // fitur search
            $this->products = Produk::where('nama', 'like', '%' . $this->search . '%')
                ->where('harga', '>=', $harga_min)
                ->where('harga', '<=', $harga_max)->get();
        } else {
            $this->products = Produk::where('harga', '>=', $harga_min)->where('harga', '<=', $harga_max)->get();;
        }

        return view('livewire.home')->extends('layouts.app')->section('content');
    }
}
