<?php

namespace App\Http\Livewire;

use App\Models\Belanja;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BelanjaUser extends Component
{
    public $belanja = [];

    public function mount()
    {

        if (!Auth::user()) { // cek apakah sudah login
            return redirect()->route('login');
        }
        if (Auth::user()->level == 1) {
            return redirect()->to('/');
        }
    }

    public function destroy($id)
    {
        $pesanan = Belanja::find($id);
        $pesanan->delete();
    }

    public function render()
    {
        if (Auth::user()) { // cek apakah sudah login
            // ambil data belanja sesuai user yang login
            $this->belanja = Belanja::where('user_id', Auth::user()->id)->get();
        }
        return view('livewire.belanja-user')->extends('layouts.app')->section('content');
    }
}
