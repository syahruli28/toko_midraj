<?php

namespace App\Http\Livewire;

use App\Models\Belanja;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Kavist\RajaOngkir\Rajaongkir;

class TambahOngkir extends Component
{

    private $apiKey = '9640fd39cf7b28a4cc330ee48657c388'; // apiKey Rajaongkir
    public $belanja;
    public $provinsi_id, $kota_id, $jasa, $daftarProvinsi, $daftarKota, $nama_jasa;
    public $result = [];

    public function mount($id)
    {
        if (!Auth::user()) { // cek apakah tidak ada session login, jika tidak ada
            return redirect()->route('login'); // redirect ke login
        }

        $this->belanja = Belanja::find($id); // ambil data belanja sesuai idnya

        // cek apakah id keranjang belanja sama dengan user yang login, jika tidak sama
        if ($this->belanja->user_id != Auth::user()->id) {
            return redirect()->to(''); // redirect
        }
    }

    public function getOngkir()
    {
        // validasi apakah provinsi/kota/jasa dipilih
        if (!$this->provinsi_id || !$this->kota_id || !$this->jasa) {
            return; // tampilkan kosong
        }

        // mengambil data produk
        $produk = Produk::find($this->belanja->produk_id);
        // dd($this->jasa);

        // mengambil biaya ongkir
        $rajaOngkir = new Rajaongkir($this->apiKey);
        $cost = $rajaOngkir->ongkosKirim([
            'origin' => 55, // kota asal
            'destination' => $this->kota_id, // kota tujuan
            'weight' => $produk->berat, // berat (catatan eror, tidak bisa lebih dari 4 digit)
            'courier' => $this->jasa, // jasa
        ])->get();


        // mengambil nama jasa pengiriman
        $this->nama_jasa = $cost[0]['name'];

        // menyimpan deskripsi, biaya dan estimasi pengiriman ke array
        foreach ($cost[0]['costs'] as $row) {
            $this->result[] = array(
                'description' => $row['description'],
                'biaya' => $row['cost'][0]['value'],
                'etd' => $row['cost'][0]['etd'],
            );
        }

        // dd($this->result);
    }

    public function save_ongkir($biaya_pengiriman)
    {
        // update nilai di keranjang belanja(tb_belanja)
        $this->belanja->total_harga += $biaya_pengiriman; // update total harga
        $this->belanja->status = 1; // status 1 = sudah ditambah ongkir
        $this->belanja->update();

        // redirect
        return redirect()->to('BelanjaUser');
    }

    public function render()
    {
        $rajaOngkir = new RajaOngkir($this->apiKey);
        // $coba = $rajaOngkir->ongkosKirim([
        //     'origin'        => 55,     // ID kota/kabupaten asal
        //     'destination'   => 80,      // ID kota/kabupaten tujuan
        //     'weight'        => 1300,    // berat barang dalam gram
        //     'courier'       => 'jne'    // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
        // ])->get();
        // dd($coba);
        $this->daftarProvinsi = $rajaOngkir->provinsi()->all(); // tampilkan semua provinsi

        if ($this->provinsi_id) { // jika provinsi sudah dipilih
            $this->daftarKota = $rajaOngkir->kota()->dariProvinsi($this->provinsi_id)->get(); // tampilkan list kota
        }

        return view('livewire.tambah-ongkir')->extends('layouts.app')->section('content');
    }
}
