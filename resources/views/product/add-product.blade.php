@extends('index')
@section('judul', 'Produk')
@section('script_head')
@endsection

@section('content')
<h3>{{$title}}</h3>
<div class="col-sm-6 mb-3">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/product">Barang</a>
        </li>
        <li class="breadcrumb-item active">{{$title}}</li>
    </ol>
</div>

@if (count($errors)>0)
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul style="list-style:none">
        @foreach($errors->all() as $error)
        <li><span class="fas fa-exclamation-triangle"></span>
            {{$error}}
        </li>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        @endforeach
    </ul>
</div>
@endif

<form action="{{route('product.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3 row">
        <label for="tenan" class="col-sm-2 col-form-label">Tenan</label>
        <div class="col-sm-8">
            <select class="form-control" name="tenan_id" required id="tenan">
                <option value="" disabled {{ old('tenan_id') == null ? 'selected' : '' }}>- Pilih Tenan -</option>
                @forelse($dataTenan as $data)
                <option value="{{ $data->id }}" {{ old('tenan_id') == $data->id ? 'selected' : '' }}>
                    {{ Str::ucfirst($data->nama_tenan) }}
                </option>
                @empty
                <option value="" disabled>Tidak ada daftar tenan</option>
                @endforelse
            </select>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="nama_barang" class="col-sm-2 col-form-label">Nama Barang</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="nama_barang" placeholder="Masukkan Nama Barang" required name="nama_barang" value="{{old('nama_barang')}}">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="satuan" class="col-sm-2 col-form-label">Satuan</label>
        <div class="col-sm-8">
            <select class="form-control" name="satuan" required id="satuan">
                <option value="" disabled {{ old('satuan') == null ? 'selected' : '' }}>- Pilih Satuan -</option>
                <option value="kg">Kg</option>
                <option value="Pcs">Pcs</option>
                <option value="Box">Box</option>
                <option value="Liter">Liter</option>
            </select>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="harga_satuan" class="col-sm-2 col-form-label">Harga Barang</label>
        <div class="col-sm-8">
            <input type="number" class="form-control" id="harga_satuan" placeholder="Masukkan Harga Barang" required min="0" name="harga_satuan" value="{{old('harga_satuan')}}">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="stok" class="col-sm-2 col-form-label">Stok Barang</label>
        <div class="col-sm-8">
            <input type="number" class="form-control" id="stok" placeholder="Masukkan Stok Barang" required min="0" name="stok" value="{{old('stok')}}">
        </div>
    </div>
    <button class="btn btn-primary" type="submit">Tambah</button>
</form>
@endsection

@section('script_footer')
@endsection