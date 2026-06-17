@extends('layouts.admin')

@push('title', 'Tambah Siswa')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Siswa</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Form Tambah Siswa</h6>
        <a href="/student" class="btn btn-danger btn-sm">Kembali</a>
    </div>
    <form action="/student/add" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            @if(session('notifikasi'))
            <div class="alert alert-{{ session('type') }}">{{ session('notifikasi') }}</div>
            @endif

            <div class="form-group">
                <label>NIM <b class="text-danger">*</b></label>
                <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror" placeholder="Masukkan NIM" value="{{ old('nim') }}">
                @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Nama <b class="text-danger">*</b></label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan Nama" value="{{ old('nama') }}">
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>E-Mail <b class="text-danger">*</b></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan E-Mail" value="{{ old('email') }}">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Foto <b class="text-danger">*</b></label>
                <input type="file" name="foto" id="foto" accept="image/jpeg, image/jpg, image/png"
                    class="form-control @error('foto') is-invalid @enderror">
                @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Prodi <b class="text-danger">*</b></label>
                <select name="prodi" class="form-control @error('prodi') is-invalid @enderror">
                    <option value="">- Pilih Prodi -</option>
                    <option>Teknik Informatika</option>
                    <option>Teknik Rekayasa Keamanan Siber</option>
                    <option>Teknik Rekayasa Perangkat Lunak</option>
                </select>
                @error('prodi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="card-footer">
            <a href="/student" class="btn btn-danger">Batal</a>
            <button type="reset" class="btn btn-warning">Reset</button>
            <button type="submit" class="btn btn-success">Simpan</button>
        </div>
    </form>
</div>

@push('addon-script-footer')
<script>
document.getElementById('foto').addEventListener('change', function() {
    const file = this.files[0];
    const maxSize = 2 * 1024 * 1024;
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

    if (file) {
        if (!allowedTypes.includes(file.type)) {
            alert('Format file harus JPEG, JPG, atau PNG!');
            this.value = '';
            return;
        }
        if (file.size > maxSize) {
            alert('Ukuran file maksimal 2MB!');
            this.value = '';
            return;
        }
    }
});
</script>
@endpush

@endsection
