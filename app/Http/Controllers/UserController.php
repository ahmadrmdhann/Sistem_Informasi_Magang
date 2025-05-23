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
        $users = UserModel::with('level')->get();
        return view('dashboard.admin.user.index', compact('users'));
    }

    public function create()
    {
        $levels = LevelModel::all();
        return view('dashboard.admin.user.create', compact('levels'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:50|unique:m_user,username',
            'nama'     => 'nullable|string|max:100',
            'level_id' => 'required|exists:m_level,level_id',
            'email'    => 'required|email|max:100|unique:m_user,email',
            'password' => 'required|string|min:6|confirmed',
            'status'   => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ]);
            }
            return back()->withErrors($validator)->withInput();
        }

        UserModel::create([
            'username' => $request->username,
            'nama'     => $request->nama,
            'level_id' => $request->level_id,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'status'   => $request->status,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'status' => true,
                'message' => 'User berhasil ditambahkan.'
            ]);
        }

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
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
            'username' => 'required|string|max:50|unique:m_user,username,' . $id . ',user_id',
            'nama'     => 'nullable|string|max:100',
            'level_id' => 'required|exists:m_level,level_id',
            'email'    => 'required|email|max:100|unique:m_user,email,' . $id . ',user_id',
            'password' => 'nullable|string|min:6|confirmed',
            'status'   => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->username = $request->username;
        $user->nama     = $request->nama;
        $user->level_id = $request->level_id;
        $user->email    = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->status   = $request->status;
        $user->save();

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = UserModel::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }
}