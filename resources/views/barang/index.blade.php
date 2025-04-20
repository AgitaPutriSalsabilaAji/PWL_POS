@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary wt-1" href="{{ url('barang/create') }}">Tambah</a>
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
                                <option value="">Semua</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->kategori_id }}">{{ $item->kategori_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Kategori Barang</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
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
                        <tbody>
                            {{-- Data akan ditampilkan di sini --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@push('css')

@endpush
@push('js')

@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('#table_barang').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ url('barang/list') }}",
                type: "POST",
                data: function (d) {
                    d.kategori_id = $('#kategori_id').val();
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center', orderable: false, searchable: false },
                { data: 'barang_kode', name: 'barang_kode' },
                { data: 'barang_nama', name: 'barang_nama' },
                { data: 'kategori.kategori_nama', name: 'kategori.kategori_nama', orderable: false, searchable: false },
                { data: 'harga_beli', name: 'harga_beli' },
                { data: 'harga_jual', name: 'harga_jual' },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
            ]
        });

        $('#kategori_id').on('change', function() {
            $('#table_barang').DataTable().ajax.reload();
        });
    });
</script>
@endpush
