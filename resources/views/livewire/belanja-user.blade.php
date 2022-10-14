<div class="container">
    <div class="row mt-4">
        <div class="col">
            <div class="table-responsive">
                <table class="table text-center">
                    <thead>
                        <td>No.</td>
                        <td>Tanggal Pesan</td>
                        <td>Nama Produk</td>
                        <td>Status</td>
                        <td>Total Harga</td>
                        <td>Aksi</td>
                        <td>Hapus</td>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @forelse ($belanja as $pesanan)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $pesanan->created_at }}</td>
                                <td>
                                    {{-- relasi untuk ambil gambar di tb produk --}}
                                    <?php $produk = \App\Models\Produk::where('id', $pesanan->produk_id)->first(); ?>
                                    <img src="{{ asset('storage/photos/'.$produk->gambar) }}" width="62px">
                                    {{ $produk->nama }}
                                </td>
                                <td>
                                    @if ($pesanan->status == 0)
                                        <strong>pesanan belum ditambahkan ongkir</strong>
                                    @endif
                                    @if ($pesanan->status == 1)
                                        <strong>pesanan sudah ditambahkan ongkir</strong>
                                    @endif
                                    @if ($pesanan->status == 2)
                                        <strong>pesanan telah ditambahkan pembayarannya</strong>
                                    @endif
                                </td>
                                <td><strong>Rp. {{ number_format($pesanan->total_harga) }}</strong></td>
                                <td>
                                    @if ($pesanan->status == 0)
                                        <a href="{{ url('TambahOngkir/'.$pesanan->id) }}" class="btn btn-warning btn-block">Tambahkan Ongkir</a>
                                    @endif
                                    @if ($pesanan->status == 1)
                                        <a href="{{ url('Bayar/'.$pesanan->id) }}" class="btn btn-warning btn-block">Pilih Pembayaran</a>
                                    @endif
                                    @if ($pesanan->status == 2)
                                        <a href="{{ url('Bayar/'.$pesanan->id) }}" class="btn btn-warning btn-block">Lihat Status</a>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-block" wire:click="destroy({{ $pesanan->id }})">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">Data Kosong</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>