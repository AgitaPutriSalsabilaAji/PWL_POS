@extends('layouts.template')
 
 @section('content')
     <div class="card card-outline card-primary">
         <div class="card-header">
             <h3 class="card-title">{{ $page->title }}</h3>
             <div class="card-tools">
                 <a class="btn btn-sm btn-primary mt-1" href="{{ url('barang/create') }}">Tambah</a>
             </div>
         </div>
         <div class="card-body">
             @if (session('success'))
                 <div class="alert alert-success">{{ session('success') }}</div>
             @endif
 
             @if (session('error'))
                 <div class="alert alert-danger">{{ session('error') }}</div>
             @endif
             <div class="row">
                 <div class="col-md-12">
                     <div class="form-group row">
                         <label class="col-1 control-label col-form-label">Filter:</label>
                         <div class="col-3">
                             <select class="form-control" id="kategori_id" name="kategori_id">
                                 <option value="">- Semua -</option>
                                 @foreach($kategori as $item)
                                     <option value="{{ $item->kategori_id }}">{{ $item->kategori_nama }}</option>
                                 @endforeach
                             </select>
                             <small class="form-text text-muted">Kategori Barang</small>
                         </div>
                     </div>
                 </div>
             </div>
             
             <table class="table table-bordered table-striped table-hover table-sm" id="table_barang">
                 <thead>
                     <tr>
                         <th>ID</th>
                         <th>Kode Barang</th>
                         <th>Nama Barang</th>
                         <th>Kategori</th>
                         <th>Harga Beli</th>
                         <th>Harga Jual</th>
                         <th>Aksi</th>
                     </tr>
                 </thead>
             </table>
         </div>
     </div>
 @endsection
 
 @push('js')
 <script>
        function modalAction(url = ''){
    $('#myModal').load(url,function(){
         $('#myModal').modal('show');
    });
 }
     $(document).ready(function() {
        var dataBarang = $('#table_barang').DataTable({
        serverSide: true,
        processing: true,
        ajax: {
            url: "{{ url('barang/list') }}",
            type: "POST",
            dataType: "json",
            data: function (d) {
                d.kategori_id = $('#kategori_id').val();
                d._token = $('meta[name="csrf-token"]').attr('content'); // Tambahkan ini
            }
        },
        columns: [
            { data: 'id' },
            { data: 'kode_barang' },
            { data: 'nama_barang' },
            { data: 'kategori' },
            { data: 'harga_beli' },
            { data: 'harga_jual' },
            { data: 'aksi', orderable: false, searchable: false }
        ]
    });    
         $('#kategori_id').on('change', function() {
             dataBarang.ajax.reload();
         });
     });
 </script>
 @endpush