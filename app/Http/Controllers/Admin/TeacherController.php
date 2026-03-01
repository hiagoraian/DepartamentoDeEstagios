<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\SemesterTeacher;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = User::where('is_admin', false)
            ->orderBy('name')
            ->get();

        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'masp' => ['required', 'string', 'max:50', 'unique:users,masp'],
            'cpf' => ['required', 'string', 'max:20', 'unique:users,cpf'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'professor_type' => ['required', Rule::in(['efetivo', 'contratado'])],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        User::create([
            'name' => $data['name'],
            'masp' => $data['masp'],
            'cpf' => $data['cpf'],
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'professor_type' => $data['professor_type'],
            'is_admin' => false,
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('admin.teachers.index')->with('success', 'Professor cadastrado com sucesso!');
    }

    public function edit(User $user)
    {
        abort_if($user->is_admin, 404);

        return view('admin.teachers.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        abort_if($user->is_admin, 404);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'masp' => ['required', 'string', 'max:50', Rule::unique('users', 'masp')->ignore($user->id)],
            'cpf' => ['required', 'string', 'max:20', Rule::unique('users', 'cpf')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'professor_type' => ['required', Rule::in(['efetivo', 'contratado'])],

            // senha opcional na edição
            'password' => ['nullable', 'min:6', 'confirmed'],
        ]);

        $user->name = $data['name'];
        $user->masp = $data['masp'];
        $user->cpf = $data['cpf'];
        $user->phone = $data['phone'] ?? null;
        $user->email = $data['email'] ?? null;
        $user->professor_type = $data['professor_type'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('admin.teachers.index')->with('success', 'Professor atualizado com sucesso!');
    }

    public function destroy(User $user)
    {
        abort_if($user->is_admin, 404);

        $user->delete();

        return redirect()->route('admin.teachers.index')->with('success', 'Professor removido com sucesso!');
    }
    public function toggleSemester(Request $request, \App\Models\User $user)
    {
        $request->validate([
            'semester' => ['required', 'string'],
        ]);

        $semester = $request->semester;

        $record = SemesterTeacher::where('user_id', $user->id)
            ->where('semester', $semester)
            ->first();

        if ($record) {
            // Alterna estado
            $record->is_enabled = !$record->is_enabled;
            $record->save();
        } else {
            // Cria habilitado
            SemesterTeacher::create([
                'user_id' => $user->id,
                'semester' => $semester,
                'is_enabled' => true,
            ]);
        }

        return back()->with('success', 'Status do professor atualizado para o semestre.');
    }
}
