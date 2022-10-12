<div class="container">
    
    {{-- cek apakah yang login admin --}}
    @if (Auth::user())
        @if (Auth::user()->level==1)
        <div class="row">
            <div class="col-md-3">
                <a href="{{ url('TambahProduk') }}" class="btn btn-success btn-block">Tambah Produk</a>
            </div>
        </div>
        @endif
    @endif


    {{-- section filtering --}}
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Cari..." wire:model="search">
            </div>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Harga min..." wire:model="min">
            </div>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Harga max..." wire:model="max">
            </div>
        </div>
    </div>

    {{-- section produk --}}
    <section class="products mb-5">
        <div class="row mt-4">
            @foreach ($products as $product)
            
            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="{{ asset('storage/photos/'.$product->gambar) }}" width="200px" height="270px" alt="{{$product->gambar}}">
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <h5><strong>{{ $product->nama }}</strong></h5>
                                <h5><strong>Rp. {{ number_format($product->harga) }}</strong></h5>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-12">
                                <button class="btn btn-success btn-block" wire:click="beli({{ $product->id }})">Beli</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            @endforeach
        </div>
    </section>

    
</div>
