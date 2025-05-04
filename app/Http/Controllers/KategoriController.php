<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel; // Menggunakan KategoriModel
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    // Menampilkan halaman awal user 
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar kategori yang terdaftar dalam sistem'
        ];

        $activeMenu = 'kategori'; // set menu yang sedang aktif 

        return view('kategori.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
        ]);
    }

        public function list(Request $request)
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_kode','kategori_nama');
        
        return DataTables::of($kategori) // Gantilah $kategori dengan yang sesuai
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {
                $btn  = '<button onclick="modalAction(\''.url('/kategori/' . $kategori->kategori_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/kategori/' . $kategori->kategori_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/kategori/' . $kategori->kategori_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // Menampilkan halaman form tambah user
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Kategori',
            'list' => ['Home', 'Kategori', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah kategori baru'
        ];

        $activeMenu = 'kategori'; // Set menu yang aktif

        return view('kategori.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan data user baru
    public function store(Request $request)
    {
        $request->validate([
            'kategori_kode' => 'required|string|max:255|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|string|max:255'
        ]);

        KategoriModel::create($request->all());
 
         return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
     
    }

    // Menampilkan detail user
    public function show($id)
    {
        $kategori = KategoriModel::findOrFail($id);
 
        $breadcrumb = (object) [
             'title' => 'Detail Kategori',
             'list'  => ['Home', 'Kategori', 'Detail']
        ];
 
        $page = (object) [
             'title' => 'Detail Kategori'
        ];
 
         $activeMenu = 'kategori';
 
         return view('kategori.show', [
             'breadcrumb' => $breadcrumb,
             'page'       => $page,
             'kategori'   => $kategori,
             'activeMenu' => $activeMenu
        ]);
    }

    // Menampilkan halaman form edit user
    public function edit($id)
     {
         $kategori = KategoriModel::findOrFail($id);
 
         $breadcrumb = (object) [
             'title' => 'Edit Kategori',
             'list'  => ['Home', 'Kategori', 'Edit']
         ];
 
         $page = (object) [
             'title' => 'Edit Kategori'
         ];
 
         $activeMenu = 'kategori';
 
         return view('kategori.edit', [
             'breadcrumb' => $breadcrumb,
             'page'       => $page,
             'kategori'   => $kategori,
             'activeMenu' => $activeMenu
        ]);
    }
 

    // Menyimpan perubahan data user
    public function update(Request $request, $id)
     {
         $request->validate([
             'kategori_kode' => 'required|string|max:255|unique:m_kategori,kategori_kode,'.$id.',kategori_id',
             'kategori_nama' => 'required|string|max:255'
         ]);
 
         $kategori = KategoriModel::findOrFail($id);
         $kategori->update($request->all());
 
         return redirect('/kategori')->with('success', 'Data kategori berhasil diperbarui');
    }
 

    public function destroy($id)
    {
        $kategori = KategoriModel::find($id);
        if (!$kategori) {
             return response()->json([
                 'status' => false,
                 'message' => 'Data yang anda cari tidak ditemukan'
             ]);
         }
 
         $kategori->delete();
 
         return response()->json([
             'status' => true,
             'message' => 'Data kategori berhasil dihapus'
        ]);
    }

    public function create_ajax()
     {
         return view('kategori.create_ajax');
     }
 
     public function store_ajax(Request $request)
     {
         if ($request->ajax()) {
             $validator = Validator::make($request->all(), [
                 'kategori_nama' => 'required|string|unique:m_kategori,kategori_nama|min:3|max:100'
             ]);
 
             if ($validator->fails()) {
                 return response()->json(['status' => false, 'message' => 'Validasi Gagal', 'msgField' => $validator->errors()]);
             }
 
             KategoriModel::create($request->all());
             return response()->json(['status' => true, 'message' => 'Data kategori berhasil disimpan']);
         }
         return redirect('/');
     }
 
     public function edit_ajax(string $id)
     {
         $kategori = KategoriModel::find($id);
         return view('kategori.edit_ajax', compact('kategori'));
     }
 
     public function update_ajax(Request $request, $id)
     {
         if ($request->ajax()) {
             $validator = Validator::make($request->all(), [
                 'kategori_nama' => 'required|string|unique:m_kategori,kategori_nama,'.$id.',kategori_id|min:3|max:100'
             ]);
 
             if ($validator->fails()) {
                 return response()->json(['status' => false, 'message' => 'Validasi gagal.', 'msgField' => $validator->errors()]);
             }
 
             $kategori = KategoriModel::find($id);
             if ($kategori) {
                 $kategori->update($request->all());
                 return response()->json(['status' => true, 'message' => 'Data berhasil diupdate']);
             }
             return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
         }
         return redirect('/');
     }
 
     public function confirm_ajax(string $id)
      {
          $kategori = KategoriModel::find($id);
  
          if (!$kategori) {
              return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
          }
  
          return view('kategori.confirm_ajax', ['kategori' => $kategori]);
      }
 
      public function delete_ajax(Request $request, $id)
      {
          if ($request->ajax() || $request->wantsJson()) {
              $kategori = KategoriModel::find($id);
  
              if ($kategori) {
                  $kategori->delete();
  
                  return response()->json([
                      'status' => true,
                      'message' => 'Data berhasil dihapus'
                  ]);
              } else {
                  return response()->json([
                      'status' => false,
                      'message' => 'Data tidak ditemukan'
                  ]);
              }
          }
  
          return redirect('/');
      }

}
