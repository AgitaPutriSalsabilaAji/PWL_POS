<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Barang',
            'list' => ['Home', 'Barang']
        ];

        $page = (object)[
            'title' => 'Daftar barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'barang';
        $kategori = KategoriModel::all(); // Ambil data kategori untuk filter

        return view('barang.index', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'kategori' => $kategori,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        $barang = BarangModel::select('barang_id','kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
            ->with('kategori');

        if ($request->kategori_id) {
            $barang->where('kategori_id', $request->kategori_id);
        }

        return DataTables()->eloquent($barang)
            ->addIndexColumn()
            ->addColumn('aksi', function ($barang) {
                $btn  = '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id . '/delete_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Barang',
            'list'  => ['Home', 'Barang', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Barang Baru'
        ];

        $kategori = KategoriModel::all(); // Ambil data kategori untuk dropdown
        $activeMenu = 'barang';

        return view('barang.create', compact('breadcrumb', 'page', 'kategori', 'activeMenu'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|integer',
            'barang_kode' => 'required|string|unique:barang,barang_kode',
            'barang_nama' => 'required|string|max:255',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        BarangModel::create([
            'kategori_id' => $request->kategori_id,
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
        ]);

        return redirect('/barang')->with('success', 'Data barang berhasil disimpan!');
    }

    public function show(string $id)
     {
         $barang = BarangModel::with('kategori')->find($id);
 
         $breadcrumb = (object) [
             'title' => 'Detail Barang',
             'list'  => ['Home', 'Barang', 'Detail']
         ];
 
         $page = (object) [
             'title' => 'Detail Barang'
         ];
 
         $activeMenu = 'barang';
 
         return view('barang.show', [
             'breadcrumb' => $breadcrumb,
             'page'       => $page,
             'barang'     => $barang,
             'activeMenu' => $activeMenu
         ]);
     }
 
     public function edit(string $id)
     {
         $barang  = BarangModel::find($id);
         $kategori = KategoriModel::all();
 
         $breadcrumb = (object) [
             'title' => 'Edit Barang',
             'list'  => ['Home', 'Barang', 'Edit']
         ];
 
         $page = (object) [
             'title' => 'Edit Barang'
         ];
 
         $activeMenu = 'barang';
 
         return view('barang.edit', [
             'breadcrumb' => $breadcrumb,
             'page'       => $page,
             'barang'     => $barang,
             'kategori'   => $kategori,
             'activeMenu' => $activeMenu
         ]);
     }
 

    public function update(Request $request, BarangModel $barang)
    {
        $request->validate([
            'kategori_id' => 'required|integer',
            'barang_kode' => 'required|string|unique:barang,barang_kode,' . $barang->barang_id . ',barang_id',
            'barang_nama' => 'required|string|max:255',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        $barang->update([
            'kategori_id' => $request->kategori_id,
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
        ]);

        return redirect('/barang')->with('success', 'Data barang berhasil diubah!');
    }

    public function destroy(string $id)
    {
        $check = BarangModel::find($id);
        if (!$check) {
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }

        try {
            BarangModel::destroy($id);
            return redirect('/barang')->with('success', 'Data barang berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/barang')->with('error', 'Data barang gagal dihapus karena masih terkait dengan data lain');
        }
    }

    public function create_ajax()
     {
         $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();
         return view('barang.create_ajax', compact('kategori'));
     }
 
     public function store_ajax(Request $request)
     {
         if ($request->ajax() || $request->wantsJson()) {
             $rules = [
                 'kategori_id' => 'required|integer',
                'barang_kode' => 'required|string|unique:barang,barang_kode',
                'barang_nama' => 'required|string|max:100',
                 'harga_beli'  => 'required|numeric',
                 'harga_jual'  => 'required|numeric'
             ];
 
             $validator = Validator::make($request->all(), $rules);
 
             if ($validator->fails()) {
                 return response()->json([
                     'status' => false,
                     'message' => 'Validasi Gagal',
                     'msgField' => $validator->errors(),
                 ]);
             }
 
             BarangModel::create($request->all());
             return response()->json([
                 'status' => true,
                 'message' => 'Data barang berhasil disimpan'
             ]);
         }
         return redirect('/');
     }
 
     public function edit_ajax(string $id)
     {
         $barang = BarangModel::find($id);
         $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();
         return view('barang.edit_ajax', compact('barang', 'kategori'));
     }
 
     public function update_ajax(Request $request, $id)
     {
         if ($request->ajax() || $request->wantsJson()) {
             $rules = [
                 'kategori_id' => 'required|integer',
                'barang_kode' => 'required|string|unique:barang,barang_kode,'.$id.',barang_id',
                'barang_nama' => 'required|string|max:100',
                 'harga_beli'  => 'required|numeric',
                 'harga_jual'  => 'required|numeric'
             ];
 
             $validator = Validator::make($request->all(), $rules);
 
             if ($validator->fails()) {
                 return response()->json([
                     'status'   => false,
                     'message'  => 'Validasi gagal.',
                     'msgField' => $validator->errors()
                 ]);
             }
 
             $barang = BarangModel::find($id);
             if ($barang) {
                 $barang->update($request->all());
                 return response()->json([
                     'status'  => true,
                     'message' => 'Data berhasil diperbarui'
                 ]);
             }
 
             return response()->json([
                 'status'  => false,
                 'message' => 'Data tidak ditemukan'
             ]);
         }
         return redirect('/');
     }
 
     public function confirm_ajax(string $id)
      {
        $barang = BarangModel::with('kategori')->find($id);
  
        return view('barang.confirm_ajax', ['barang' => $barang]);
      }
 
     public function delete_ajax(Request $request, $id)
     {
         if ($request->ajax() || $request->wantsJson()) {
             $barang = BarangModel::find($id);
             if ($barang) {
                 $barang->delete();
                 return response()->json([
                     'status'  => true,
                     'message' => 'Data berhasil dihapus'
                 ]);
             }
 
             return response()->json([
                 'status'  => false,
                 'message' => 'Data tidak ditemukan'
             ]);
         }
         return redirect('/');
     }
}
