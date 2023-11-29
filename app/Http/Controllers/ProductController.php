<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Tenan;
use Yajra\Datatables\Datatables;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Barang';
        $data = Barang::with('tenan')->get();
        return view('product.view-product', compact('title', 'data'));
    }

    public function getProductData(Request $request)
    {
        try{
            if ($request->ajax()) {
                $data = Barang::with('tenan')->get();

                $data->transform(function ($item) {
                    $item->harga_satuan = 'Rp ' . number_format($item->harga_satuan, 2, ',', '.');
                    return $item;
                });

                return Datatables::of($data)
                    ->addColumn('id', function($row) {
                        static $index = 0;
                        $index++;
                        return $index;
                    })
                    ->addColumn('Nama Tenan', function ($row) {
                        return $row->tenan->nama_tenan;
                    })
                    ->addColumn('harga_satuan', function ($row) {
                        return $row->harga_satuan;
                    })
                    ->addColumn('options', function ($row) {
                        return "<a href='product/{$row->id}/edit'><i class='fas fa-edit fa-lg'></i></a>
                                <a style='border: none; background-color:transparent;' class='hapusData' data-id='$row->id' data-url='product/{$row->id}'><i class='fas fa-trash fa-lg text-danger'></i></a>";
                    })
                    ->rawColumns(['options'])
                    ->make(true);
            }
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error while showing data: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Barang';
        $dataTenan = Tenan::all();
        return view('product.add-product', compact('title', 'dataTenan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge(['nama_barang' => strtolower($request->nama_barang)]);

        $this->validate($request, [
            'tenan_id' => 'required',
            'nama_barang' => 'required |unique:barangs',
            'satuan' => 'required',
            'harga_satuan' => 'required',
            'stok' => 'required'
        ]);

        $latestProduct = Barang::latest()->first();
        $latestProductId = $latestProduct ? $latestProduct->id : 0;
        $kode = 'BRG-' . rand(1000, 9999) . $latestProductId ;

        $data = new Barang();
        $data->tenan_id = $request->tenan_id;
        $data->kode_barang = $kode;
        $data->nama_barang = $request->nama_barang;
        $data->satuan = $request->satuan;
        $data->harga_satuan = (int) $request->harga_satuan;
        $data->stok = (int) $request->stok;
        $data->save();

        Alert::success('Berhasil', 'Data berhasil ditambah');
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Ubah Barang';
        $dataTenan = Tenan::all();
        $data = Barang::find($id);
        return view('product.edit-product', ['data'=> $data], compact('title', 'dataTenan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->merge(['nama_barang' => strtolower($request->nama_barang)]);

        $this->validate($request, [
            'tenan_id' => 'required',
            'nama_barang' => 'required|unique:barangs',
            'satuan' => 'required',
            'harga_satuan' => 'required',
            'stok' => 'required',
        ]);

        $data = Barang::find($id);

        $data->tenan_id = $request->tenan_id;
        $data->nama_barang = $request->nama_barang;
        $data->satuan = $request->satuan;
        $data->harga_satuan = (int) $request->harga_satuan;
        $data->stok = (int) $request->stok;
        $data->save();

        Alert::success('Berhasil', 'Data berhasil diupdate');
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Barang::find($id);
        $data->delete();

        return redirect()->back();
    }
}
