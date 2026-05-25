<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Students | Laravel</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="container-fluid mt-4">
        <div class="card">
            <div class="card-header">
                Data Siswa
                <a href="/student/add" class="btn btn-primary float-right">Tambah</a>
            </div>
            <div class="card-body">
                @if(session('notifikasi'))
                <div class="alert alert-{{ session('type') }}">
                    {{ session('notifikasi') }}
                </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <td>No.</td>
                            <td>NIM</td>
                            <td>Nama</td>
                            <td>Prodi</td>
                            <td>Foto</td>
                            <td>#</td>
                        </thead>
                        <tbody>
                        @forelse($students as $index => $data)
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td>{{ $data->nim }}</td>
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->prodi }}</td>
                                <td>
                                    @if($data->foto)
                                    <img class="my-2 img-fluid" src="{{ asset('storage/' . $data->foto) }}" style="width:60px; height:60px; object-fit:cover;">
                                    @else
                                    <span class="text-muted">Tidak ada foto</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="/student/edit/{{ $data->nim }}" class="btn btn-sm btn-warning my-1">Edit</a>
                                    <form method="POST" action="/student/delete/{{ $data->nim }}" style="display:inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger my-1">Hapus</button>
                                    </form>
                                    <a href="/student/download/{{ $data->nim }}" class="btn btn-sm btn-primary my-1">Download</a>
                                    <a href="/student/preview/{{ $data->nim }}" class="btn btn-sm btn-info my-1">Preview</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">Tidak ada data untuk ditampilkan !</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
