<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Students Add | Laravel</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="container-fluid mt-4">
        <div class="card">
            <div class="card-header">
                Tambah Siswa
                <a href="/student" class="btn btn-danger float-right">Kembali</a>
            </div>
            <form action="/student/add" method="POST">
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
    </div>
</div>
</body>
</html>
