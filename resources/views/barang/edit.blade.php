@extends('layouts.template')

@section('content')
<section class="content">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page }}</h3>
            <div class="card-tools">
                <a href="{{ url('user') }}" class="btn btn-sm btn-default"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    {{ session('error') }}
                </div>
            @endif
            <form method="POST" action="{{ url('user') }}" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label for="level_id" class="col-sm-2 col-form-label">Level</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="level_id" name="level_id" required>
                            <option value="">Pilih Level</option>
                            @foreach ($level as $item)
                                <option value="{{ $item->level_id }}" {{ old('level_id') == $item->level_id ? 'selected' : '' }}>{{ $item->level_nama }}</option>
                            @endforeach
                        </select>
                        @error('level_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
                        @error('username')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password" name="password">
                        <small class="form-text text-info">Abaikan (jangan diisi) jika tidak ingin mengganti password user.</small>
                        @error('password')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('css')

@endpush

@push('js')

@endpush