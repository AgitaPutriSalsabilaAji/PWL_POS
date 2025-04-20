<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\Kategori;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class BarangController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Barang',
            'url' => '',
            'list' => ['Home', 'Barang']
        ];

        $page = (object)[
            'title' => 'Daftar barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'barang';
        $kategori = KategoriModel::all(); // Ambil data kategori untuk filter

        return view('barang.index', compact('breadcrumb', 'kategori', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $barang = BarangModel::select('barang_id', 'kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
            ->with('kategori');

        if ($request->kategori_id) {
            $barang->where('kategori_id', $request->kategori_id);
        }

        return DataTables()->eloquent($barang)
            ->addColumn('DT_RowIndex', function ($barang) {
                return DataTables()->index() + 1;
            })
            ->addColumn('aksi', function ($barang) {
                $btn = '<a href="' . url('barang/' . $barang->barang_id . '/edit') . '" class="btn btn-sm btn-info"><i class="fas fa-edit"></i> Edit</a> ';
                $btn .= '<button type="button" class="btn btn-sm btn-danger btn-delete" data-id="' . $barang->barang_id . '" data-nama="' . $barang->barang_nama . '"><i class="fas fa-trash"></i> Delete</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Barang',
            'url' => '/barang'
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

    public function edit(BarangModel $barang)
    {
        $breadcrumb = (object)[
            'title' => 'Edit Barang',
            'url' => '/barang'
        ];

        $page = (object)[
            'title' => 'Edit Detail Barang'
        ];

        $kategori = KategoriModel::all(); // Ambil data kategori untuk dropdown
        $activeMenu = 'barang';

        return view('barang.edit', compact('breadcrumb', 'page', 'barang', 'kategori', 'activeMenu'));
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

    public function destroy(BarangModel $barang)
    {
        $check = BarangModel::findOrFail($barang->barang_id);
        if (!$check) {
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan!');
        }

        try {
            $barang->delete();
            return response()->json(['success' => 'Data barang berhasil dihapus!']);
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/barang')->with('error', 'Data barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini!');
        }
    }
}