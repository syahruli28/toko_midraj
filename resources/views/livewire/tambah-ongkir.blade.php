<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tambah Ongkir</div>
                <div class="card-body">

                    <form wire:submit.prevent="getOngkir">

                        {{-- provinsi --}}
                        <label for="provinsi" class="col-md-12 col-form-label text-md-left">Pilih Provinsi</label>
                        <select name="provinsi" wire:model="provinsi_id" id="provinsi" class="form-control">
                            <option value="0">-- PILIH PROVINSI --</option>
                            @forelse ($daftarProvinsi as $p)
                                <option value="{{ $p['province_id'] }}">{{ $p['province'] }}</option>
                            @empty
                                <option value="0"> Provinsi tidak ada </option>
                            @endforelse
                        </select>

                        {{-- kota --}}
                        <label for="kota" class="col-md-12 col-form-label text-md-left">Pilih Kota</label>
                        <select name="kota" wire:model="kota_id" id="kota" class="form-control">
                            <option value="">-- PILIH KABUPATEN/KOTA --</option>
                            @if ($provinsi_id) {{-- tampilkan jika provinsi sudah dipilih --}}
                                @forelse ($daftarKota as $k)
                                    <option value="{{ $k['city_id'] }}">{{ $k['city_name'] }}</option>
                                @empty
                                    <option value=""> Kota/Kabupaten tidak ada </option>
                                @endforelse
                            @endif
                        </select>

                        {{-- jasa --}}
                        <label for="jasa" class="col-md-12 col-form-label text-md-left">Pilih Jasa</label>
                        <select name="jasa" wire:model="jasa" id="jasa" class="form-control">
                            <option value="">-- PILIH JASA PENGIRIMAN --</option>
                            <option value="jne">JNE</option>
                            <option value="pos">POS Indonesia</option>
                            <option value="tiki">TIKI</option>
                        </select>

                        <br><br>

                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success btn-block">Lihat Daftar Ongkir</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>


    {{-- tampilkan menu ongkir (jika sudah submit) --}}
    @if ($result) 
        <section class="products mb-5">
            <div class="row mt-4">
                @forelse ($result as $r)
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div><h5>{{ $nama_jasa }}</h5></div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <h5><strong>Rp. {{ number_format($r['biaya']) }}</strong></h5>
                                        <h5><strong>{{ $r['etd'] }} Hari</strong></h5>
                                        <h5><strong>{{ $r['description'] }}</strong></h5>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <button class="btn btn-success btn-block" wire:click="save_ongkir({{ $r['biaya'] }})">Tambah Sebagai Ongkir</button>
                                </div>
                            </div>
                        </div>
                    </div>                    
                @empty
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div><h5>Tidak ada jasa pengirima ke tujuan ini</h5></div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>
    @endif

</div>
