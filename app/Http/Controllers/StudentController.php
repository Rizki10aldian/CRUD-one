<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

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
            'prodi' => 'required'
        ], [
            'nim.required'   => 'NIM harus diisi.',
            'nim.unique'     => 'NIM sudah digunakan.',
            'nama.required'  => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email'    => 'Format email tidak valid.',
            'prodi.required' => 'Program studi harus diisi.'
        ]);

        $student = new Student();
        $student->nim   = $request->nim;
        $student->nama  = $request->nama;
        $student->email = $request->email;
        $student->prodi = $request->prodi;

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
        $request->validate([
            'nim'   => ['required', 'unique:students,nim,' . $request->old_nim . ',nim'],
            'nama'  => 'required',
            'email' => 'required|email',
            'prodi' => 'required'
        ], [
            'nim.required'   => 'NIM harus diisi.',
            'nim.unique'     => 'NIM sudah digunakan.',
            'nama.required'  => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email'    => 'Format email tidak valid.',
            'prodi.required' => 'Program studi harus diisi.'
        ]);

        $student = Student::where('nim', $id)->first();
        $student->nim   = $request->nim;
        $student->nama  = $request->nama;
        $student->email = $request->email;
        $student->prodi = $request->prodi;

        if ($student->save()) {
            return redirect('/student')->with(['notifikasi' => 'Data Berhasil diedit !', 'type' => 'success']);
        } else {
            return redirect()->back()->with(['notifikasi' => 'Data gagal diedit !', 'type' => 'danger']);
        }
    }

    public function destroy(string $id)
    {
        $student = Student::where(['nim' => $id]);
        if ($student->count() < 1) {
            return redirect('/student')->with(['notifikasi' => 'Data siswa tidak ditemukan !', 'type' => 'danger']);
        }

        if ($student->first()->delete()) {
            return redirect('/student')->with(['notifikasi' => 'Data Berhasil dihapus !', 'type' => 'success']);
        } else {
            return redirect()->back()->with(['notifikasi' => 'Data gagal dihapus !', 'type' => 'danger']);
        }
    }
}
