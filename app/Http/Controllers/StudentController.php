<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('student.index', ['students' => $students]);
    }

    public function create()
    {
        return view('student.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim'   => 'required|unique:students,nim',
            'nama'  => 'required',
            'email' => 'required|email',
            'prodi' => 'required',
            'foto'  => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'nim.required'   => 'NIM harus diisi.',
            'nim.unique'     => 'NIM sudah digunakan.',
            'nama.required'  => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email'    => 'Format email tidak valid.',
            'prodi.required' => 'Program studi harus diisi.',
            'foto.required'  => 'Foto harus diupload.',
            'foto.image'     => 'File harus berupa gambar.',
            'foto.mimes'     => 'Format foto harus JPEG, JPG, atau PNG.',
            'foto.max'       => 'Ukuran foto maksimal 2MB.',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $request->nim . '.' . $file->getClientOriginalExtension();
            $foto = $file->storeAs('foto', $filename, 'public');
        } else {
            $foto = null;
        }

        $student = new Student();
        $student->nim   = $request->nim;
        $student->nama  = $request->nama;
        $student->email = $request->email;
        $student->prodi = $request->prodi;
        $student->foto  = $foto;

        if ($student->save()) {
            return redirect('/student')->with(['notifikasi' => 'Data Berhasil disimpan !', 'type' => 'success']);
        } else {
            return redirect()->back()->with(['notifikasi' => 'Data gagal disimpan !', 'type' => 'danger']);
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $student = Student::where(['nim' => $id]);
        if ($student->count() < 1) {
            return redirect('/student')->with(['notifikasi' => 'Data siswa tidak ditemukan !', 'type' => 'danger']);
        }
        return view('student.edit', ['student' => $student->first()]);
    }

    public function update(Request $request, string $id)
    {
        $student = Student::where('nim', $id)->firstOrFail();

        $request->validate([
            'nim'   => ['required', 'unique:students,nim,' . $request->old_nim . ',nim'],
            'nama'  => 'required',
            'email' => 'required|email',
            'prodi' => 'required',
        ], [
            'nim.required'   => 'NIM harus diisi.',
            'nim.unique'     => 'NIM sudah digunakan.',
            'nama.required'  => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email'    => 'Format email tidak valid.',
            'prodi.required' => 'Program studi harus diisi.',
        ]);

        if ($request->ganti_foto == 1) {
            $request->validate([
                'foto' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            ], [
                'foto.required' => 'Foto harus diupload.',
                'foto.image'    => 'File harus berupa gambar.',
                'foto.mimes'    => 'Format foto harus JPEG, JPG, atau PNG.',
                'foto.max'      => 'Ukuran foto maksimal 2MB.',
            ]);

            if ($request->hasFile('foto')) {
                // Hapus foto lama dulu
                if (!empty($student->foto) && Storage::disk('public')->exists($student->foto)) {
                    Storage::disk('public')->delete($student->foto);
                }
                $file = $request->file('foto');
                $filename = time() . '_' . $request->nim . '.' . $file->getClientOriginalExtension();
                $foto = $file->storeAs('foto', $filename, 'public');
            } else {
                $foto = $student->foto;
            }
        } else {
            $foto = $student->foto;
        }

        $student->nim   = $request->nim;
        $student->nama  = $request->nama;
        $student->email = $request->email;
        $student->prodi = $request->prodi;
        $student->foto  = $foto ?? null;

        if ($student->save()) {
            return redirect('/student')->with(['notifikasi' => 'Data Berhasil diedit !', 'type' => 'success']);
        } else {
            return redirect()->back()->with(['notifikasi' => 'Data gagal diedit !', 'type' => 'danger']);
        }
    }

    public function destroy(string $id)
    {
        $student = Student::where(['nim' => $id])->firstOrFail();
        $foto_siswa = $student->foto;

        if ($student->delete()) {
            if (!empty($foto_siswa) && Storage::disk('public')->exists($foto_siswa)) {
                Storage::disk('public')->delete($foto_siswa);
            }
            return redirect('/student')->with(['notifikasi' => 'Data Berhasil dihapus !', 'type' => 'success']);
        } else {
            return redirect()->back()->with(['notifikasi' => 'Data gagal dihapus !', 'type' => 'danger']);
        }
    }

    public function download(string $id)
    {
        $student = Student::where('nim', $id)->firstOrFail();

        if (empty($student->foto)) {
            return redirect('/student')->with(['notifikasi' => 'Siswa ini tidak memiliki foto!', 'type' => 'danger']);
        }

        $file_path = storage_path('app/public/' . $student->foto);

        if (!file_exists($file_path)) {
            return redirect('/student')->with(['notifikasi' => 'File foto tidak ditemukan!', 'type' => 'danger']);
        }

        $file_name = 'foto-' . $student->nim . '.' . pathinfo($file_path, PATHINFO_EXTENSION);
        return response()->download($file_path, $file_name);
    }

    public function preview(string $id)
    {
        $student = Student::where('nim', $id)->firstOrFail();

        if (empty($student->foto)) {
            return redirect('/student')->with(['notifikasi' => 'Siswa ini tidak memiliki foto!', 'type' => 'danger']);
        }

        $file_path = storage_path('app/public/' . $student->foto);

        if (!file_exists($file_path)) {
            return redirect('/student')->with(['notifikasi' => 'File foto tidak ditemukan!', 'type' => 'danger']);
        }

        return response()->file($file_path, [
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
            'Pragma'        => 'no-cache',
        ]);
    }
}
