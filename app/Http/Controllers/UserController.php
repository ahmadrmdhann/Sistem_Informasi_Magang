<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = UserModel::orderBy('user_id', 'asc')->get();
        $levels = LevelModel::all();
        return view('dashboard.admin.user.index', compact('users', 'levels'));
    }

    public function show($id)
    {
        $user = UserModel::findOrFail($id);
        $level = LevelModel::findOrFail($user->level_id);
        return view('dashboard.admin.user.show', compact('user', 'level'));
    }

    public function create()
    {
        $levels = LevelModel::all();
        return view('dashboard.admin.user.create', compact('levels'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:m_user,username',
            'password' => 'required|min:6',
            'email' => 'required|email|unique:m_user,email',
            'nama' => 'required',
            'level_id' => 'required|exists:m_level,level_id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        UserModel::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'nama' => $request->nama,
            'level_id' => $request->level_id,

        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = UserModel::findOrFail($id);
        $levels = LevelModel::all();
        return view('dashboard.admin.user.edit', compact('user', 'levels'));
    }

    public function update(Request $request, $id)
    {
        $user = UserModel::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:m_user,username,' . $id . ',user_id',
            'email' => 'required|email|unique:m_user,email,' . $id . ',user_id',
            'nama' => 'required',
            'level_id' => 'required|exists:m_level,level_id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userData = [
            'username' => $request->username,
            'email' => $request->email,
            'nama' => $request->nama,
            'id' => $request->level_id,
            'user_status' => $request->has('status') ? 1 : 0,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $validator = Validator::make($request->all(), [
                'password' => 'min:6',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $userData['user_password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = UserModel::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
    }
}
