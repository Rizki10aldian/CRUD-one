<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Students Edit | Laravel</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="container-fluid mt-4">
        <div class="card">
            <div class="card-header">
                Edit Siswa
                <a href="/student" class="btn btn-danger float-right">Kembali</a>
            </div>
            <form action="/student/edit/{{ $student->nim }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <input name="old_nim" type="hidden" value="{{ $student->nim }}">
                <div class="card-body">
                    @if(session('notifikasi'))
                    <div class="alert alert-{{ session('type') }}">{{ session('notifikasi') }}</div>
                    @endif

                    <div class="form-group">
                        <label>NIM <b class="text-danger">*</b></label>
                        <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim', $student->nim) }}">
                        @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Nama <b class="text-danger">*</b></label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $student->nama) }}">
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>E-Mail <b class="text-danger">*</b></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $student->email) }}">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Foto Lama <b class="text-danger">*</b></label>
                        <div>
                            @if($student->foto)
                            <img class="my-2 img-fluid" src="{{ asset('storage/' . $student->foto) }}" style="width:80px; height:80px; object-fit:cover;">
                            @else
                            <span class="text-muted">Tidak ada foto</span>
                            @endif
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="ganti_foto" value="0">
                            <input type="checkbox" name="ganti_foto" id="ganti_foto" class="form-check-input" value="1" onclick="check_ganti()">
                            <label for="ganti_foto" class="form-check-label">Ganti Foto</label>
                        </div>
                    </div>

                    <div class="form-group" id="ganti_foto_div" style="display:none">
                        <label>Foto Baru <b class="text-danger">*</b></label>
                        <input type="file" name="foto" id="foto" accept="image/jpeg, image/jpg, image/png"
                            class="form-control @error('foto') is-invalid @enderror">
                        @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label>Prodi <b class="text-danger">*</b></label>
                        <select name="prodi" class="form-control @error('prodi') is-invalid @enderror">
                            <option value="">- Pilih Prodi -</option>
                            <option @if(old('prodi', $student->prodi) == 'Teknik Informatika') selected @endif>Teknik Informatika</option>
                            <option @if(old('prodi', $student->prodi) == 'Teknik Rekayasa Keamanan Siber') selected @endif>Teknik Rekayasa Keamanan Siber</option>
                            <option @if(old('prodi', $student->prodi) == 'Teknik Rekayasa Perangkat Lunak') selected @endif>Teknik Rekayasa Perangkat Lunak</option>
                        </select>
                        @error('prodi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="card-footer">
                    <a href="/student" class="btn btn-danger">Batal</a>
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button type="submit" class="btn btn-success">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script>
function check_ganti() {
    let ganti = $('#ganti_foto');
    let ganti_foto_div = $('#ganti_foto_div');
    let foto = $('#foto');
    ganti_foto_div.toggle(ganti.prop('checked'));
    foto.prop('required', ganti.prop('checked'));
}

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

</body>
</html>
