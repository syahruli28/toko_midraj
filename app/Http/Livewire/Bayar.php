<?php

namespace App\Http\Livewire;

use App\Models\Belanja;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Bayar extends Component
{

    // catatan untuk va transfer simulatornya
    //https://simulator.sandbox.midtrans.com/bca/va/index


    public $belanja;

    // MIDTRANS, (jangan lupa cdn jquery)
    public $snapToken;
    public $va_number, $gross_amount, $bank, $transaction_status, $deadline;

    public function mount($id)
    {
        if (!Auth::user()) { // cek apakah sudah login, jika belum
            return redirect()->route('login'); // redirect
        }

        // SET MIDTRANS
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-VC_TRkp7jC7GEU0DjQO4kL8A';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        if (isset($_GET['result_data'])) // jika ada data dikirimkan dari input ber-id result-data, maka
        {
            $current_status = json_decode($_GET['result_data'], true);
            $order_id = $current_status['order_id'];
            $this->belanja = Belanja::where('id', $order_id)->first(); // ambil data berdasarkan id
            $this->belanja->status = 2; // update nilai statusnya
            $this->belanja->update();
        } else { // jika belum ada data dikirimkan dari input ber-id result-data, maka
            // ambil data belanja sesuai idnya
            $this->belanja = Belanja::find($id);
        }


        if (!empty($this->belanja)) // jika data belanja tidak kosong
        {
            if ($this->belanja->status == 1) // jika status belanjanya bernilai 1, maka
            {
                // SET MIDTRANS
                $params = array(
                    'transaction_details' => array(
                        'order_id' => $this->belanja->id, // sesuaikan, harus unik
                        'gross_amount' => $this->belanja->total_harga, // sesuaikan
                    ),
                    'customer_details' => array(
                        'first_name' => 'Saudara/i... ', // sesuaikan
                        'last_name' => Auth::user()->name, // sesuaikan
                        'email' => Auth::user()->email, // sesuaikan
                        'phone' => '081320375696', // sesuaikan
                    ),
                );
                $this->snapToken = \Midtrans\Snap::getSnapToken($params);
            } elseif ($this->belanja->status == 2) {
                $status = \Midtrans\Transaction::status($this->belanja->id); // sesuaikan
                $status = json_decode(json_encode($status), true);
                // dd($status);
                // menampilkan status pembayaran
                $this->va_number = $status['va_numbers'][0]['va_number'];
                $this->gross_amount = $status['gross_amount'];
                $this->bank = $status['va_numbers'][0]['bank'];
                $this->transaction_status = $status['transaction_status'];
                $transaction_time = $status['transaction_time'];
                $this->deadline = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($transaction_time)));
            }
        }
    }

    public function render()
    {
        return view('livewire.bayar')->extends('layouts.app')->section('content');
    }
}
