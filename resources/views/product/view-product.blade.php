@extends('index')
@section('judul', 'Produk')
@section('script_head')
@endsection

@section('content')
<div class="row mb-2">
    <div class="d-flex justify-content-between">
        <h3>{{$title}}</h3>
        <a class="btn btn-success" href="{{route('product.create')}}">Add</a>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="/">Home</a>
            </li>
            <li class="breadcrumb-item active">{{$title}}</li>
        </ol>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{$title}} Table</h3>
    </div>
    <div class="card-body p-0" style="margin: 20px">
        <table id="myTable" class="table table-striped table-bordered display" style="width:100% ">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Tenan</th>
                    <th class="text-center">Kode</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Satuan</th>
                    <th class="text-center">Harga</th>
                    <th class="text-center">Stok</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $id = 1 ?>
                @forelse($data as $d)
                <tr>
                    <td>{{$id++}}</td>
                    <td>{{$d->tenan->nama_tenan}}</td>
                    <td>{{$d->kode_barang}}</td>
                    <td>{{ucwords($d->nama_barang)}}</td>
                    <td>{{$d->satuan}}</td>
                    <td>{{$d->harga_satuan}}</td>
                    <td>{{$d->stok}}</td>
                    <td><a class="btn btn-warning pr-2" href="/product/{{$d->id}}/edit">Edit</a>
                        <a class="btn btn-danger" href="/product/{{$id}}">Delete</a></td>
                </tr>
                @empty
                <tr class="text-center"><td colspan="8">Tidak ada barang.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script_footer')
<script>
    $(document).ready(function () {
        $('#myTable').DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": {
                "url": "{{ route('product-list') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columns": [
                { "data": "id", "className": "text-center"},
                { "data": "nama_tenan"},
                { "data": "kode_barang", "className": "text-center" },
                { "data": "nama_barang" },
                { "data": "satuan", "className": "text-center" },
                { "data": "harga_satuan", "className": "text-center" },
                { "data": "stok", "className": "text-center" },
                { "data": "options", "className": "text-center" }
            ],
        });

        // hapus data
        $('#myTable').on('click', '.hapusData', function () {
            var id = $(this).data("id");
            var url = $(this).data("url");
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#DC3545",
                confirmButtonText: 'Ya, hapus!',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            "id": id,
                            "_token": "{{csrf_token()}}"
                        },
                        success: function (response) {
                            Swal.fire('Terhapus!', response.msg, 'success');
                            $('#myTable').DataTable().ajax.reload();
                        }
                    });
                }
            })
        });
    });
</script>
@endsection