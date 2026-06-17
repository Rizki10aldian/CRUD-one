<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Siswa</h6>
        <a href="/student/add" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah
        </a>
    </div>
    <div class="card-body">
        @if(session('notifikasi'))
        <div class="alert alert-{{ session('type') }}">
            {{ session('notifikasi') }}
        </div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <td>No.</td>
                        <td>NIM</td>
                        <td>Nama</td>
                        <td>Prodi</td>
                        <td>Foto</td>
                        <td>#</td>
                    </tr>
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
