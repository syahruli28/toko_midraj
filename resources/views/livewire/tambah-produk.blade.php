<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tambah Produk</div>

                {{-- isi body --}}
                <div class="card-body">
                    <form wire:submit.prevent="store">
                        
                        {{-- nama --}}
                        <label for="nama" class="col-md-12 col-form-label text-md-left">Nama Produk</label>
                        <input type="text" id="nama" class="form-control @error('nama') is-invalid @enderror" wire:model="nama" value="{{ old('nama') }}" autocomplete="nama" autofocus>

                        {{-- errornya --}}
                        @error('nama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror


                        {{-- harga --}}
                        <label for="harga" class="col-md-12 col-form-label text-md-left">Harga Produk</label>
                        <input type="number" id="harga" class="form-control @error('harga') is-invalid @enderror" wire:model="harga" value="{{ old('harga') }}" autocomplete="harga">

                        {{-- errornya --}}
                        @error('harga')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror


                        {{-- berat --}}
                        <label for="berat" class="col-md-12 col-form-label text-md-left">Berat Produk</label>
                        <input type="number" id="berat" class="form-control @error('berat') is-invalid @enderror" wire:model="berat" value="{{ old('berat') }}" autocomplete="berat">

                        {{-- errornya --}}
                        @error('berat')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror


                        {{-- gambar --}}
                        <label for="gambar" class="col-md-12 col-form-label text-md-left">Gambar Produk</label>
                        <input type="file" id="gambar" wire:model="gambar" value="{{ old('gambar') }}" autocomplete="gambar">

                        {{-- errornya --}}
                        @error('gambar')
                        <span class="error">{{$message}}</span>
                        @enderror


                        {{-- btn submit --}}
                        <div class="col-md-6 mt-3">
                            <button type="submit" class="btn btn-success btn-block">Tambah Produk</button>
                        </div>

                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>
