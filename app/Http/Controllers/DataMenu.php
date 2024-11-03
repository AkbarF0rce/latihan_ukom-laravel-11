<?php

namespace App\Http\Controllers;

/**
 * @file DataMenu.php
 * @brief Controller untuk mengelola data menu
 * 
 * Controller ini untuk mengelola data menu baik dari nama, harga, dan gambar
 * 
 * @author [Akbar Ridho Arrafi](https://github.com/AkbarF0rce)
 * @version 1.0
 */


use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class DataMenu extends Controller
{
    private $idmenu;
    private $nama_menu;
    private $harga_menu;
    private $stok;

    public function __construct() {}

    // Fungsi index untuk tampilkan halaman menu di dalam folder dashboard
    public function index()
    {
        $data = Menu::all();
        return view('menu.index', compact('data'));
    }

    // Fungsi untuk redirect ke halaman tambah menu
    public function tambahMenu()
    {
        return view('menu.tambah');
    }

    // Fungsi create data menu
    public function simpanTambahMenu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_menu' => 'required|numeric',
            'nama_menu' => 'required|max:50',
            'harga_menu' => 'required|numeric',
            'gambar_menu' => 'image|max:2048',
        ], [
            'required' => ':attribute harus diisi.',
            'image' => ':attribute harus berupa gambar.',
            'max' => ':attribute tidak boleh lebih dari 2MB.',
            'numeric' => ':attribute harus berupa angka.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
        ]);

        if ($validator->fails()) {
            // Mengembalikan ke view dengan pesan kesalahan
            return redirect()->route('menu_tambah_data')->withErrors($validator)->withInput();
        }

        // Proses file gambar
        $gambarMenuPath = null;
        if ($request->hasFile('gambar_menu')) {
            $foto = $request->file('gambar_menu');
            $gambarMenuPath = Str::uuid() . '.' . $foto->getClientOriginalExtension();

            // Simpan file di public/storage/menu
            Storage::disk('public')->put('menu/' . $gambarMenuPath, file_get_contents($foto));
        }

        $data = [
            'id_menu' => $request->input('id_menu'),
            'nama_menu' => $request->input('nama_menu'),
            'harga_menu' => $request->input('harga_menu'),
            'gambar_menu' => $gambarMenuPath,
        ];

        Menu::create($data);

        return redirect()->route('menu_index')->with('success', 'Data dengan ID ' . $request->input('id_menu') . ' berhasil ditambahkan.');
    }

    // Fungsi get data menu
    public function listMenu()
    {
        $data = Menu::all();
        return DataTables::of($data)->make(true); // Mengembalikan data sebagai JSON
    }

    // Fungsi untuk redirect ke halaman edit menu beserta dengan data berdasarkan id
    public function editMenu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_menu' => 'required',
        ], [
            'required' => ':attribute harus diisi.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('menu_index')->with('error', $validator->errors()->first());
        }

        $data = Menu::where('id_menu', $request->input('id_menu'))->first();

        if (!$data) {
            return redirect()->route('menu_index')->with('error', 'Data dengan Id ' . $request->input('id_menu') . ' tidak ditemukan.');
        } else {
            return view('menu.edit', compact('data'));
        }
    }

    // Fungsi untuk rediret ke halaman detail berdasarkan id menu yang dikirim
    public function detailMenu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_menu' => 'required',
        ], [
            'required' => ':attribute harus diisi.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('menu_index')->with('error', $validator->errors()->first());
        }

        $data = Menu::where('id_menu', $request->input('id_menu'))->first();

        if (!$data) {
            return redirect()->route('menu_index')->with('error', 'Data dengan Id ' . $request->input('id_menu') . ' tidak ditemukan.');
        } else {
            return view('menu.detail', compact('data'));
        }
    }

    // Fungsi update data menu
    public function simpanEditMenu(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_menu' => 'required|max:50',
            'harga_menu' => 'required|numeric',
            'gambar_menu' => 'image|max:2048',
        ], [
            'required' => ':attribute harus diisi.',
            'image' => ':attribute harus berupa gambar.',
            'max' => ':attribute tidak boleh lebih dari 2MB.',
            'numeric' => ':attribute harus berupa angka.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $data = Menu::where('id_menu', $id)->first();

        $gambarMenuPath = null;
        if ($request->hasFile('gambar_menu')) {
            $foto = $request->file('gambar_menu');
            $gambarMenuPath = Str::uuid() . '.' . $foto->getClientOriginalExtension();

            // Lakukan update image
            $this->updateImage($data->gambar_menu, $gambarMenuPath, $foto);
        }

        if ($data) {
            $data->nama_menu = $request->input('nama_menu');
            $data->harga_menu = $request->input('harga_menu');
            $data->gambar_menu = $gambarMenuPath ?? $data->gambar_menu;
            $data->save();
        }

        return redirect()->route('menu_index')->with('success', 'Data dengan ID ' . $id . ' berhasil diperbarui.');
    }

    // Fungsi delete data menu
    public function hapusMenu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_menu' => 'required'
        ], [
            'required' => ':attribute harus diisi.',
        ]);

        if ($validator->fails()) {
            // Mengembalikan ke view dengan pesan kesalahan
            return redirect()->route('menu_index')->with('error', 'Id menu harus diisi.');
        }

        $search = Menu::where('id_menu', $request->input('id_menu'))->first();

        if (!$search) {
            return redirect()->route('menu_index')->with('error', 'Data dengan Id ' . $request->input('id_menu') . ' tidak ditemukan.');
        }

        $search->delete();
        $this->deleteImage($search->gambar_menu);
        return redirect()->route('menu_index')->with('success', 'Data dengan Id ' . $request->input('id_menu') . ' berhasil dihapus.');
    }

    public function deleteImage($path)
    {
        if ($path && Storage::disk('public')->exists('menu/' . $path)) {
            Storage::disk('public')->delete('menu/' . $path);
        }
    }

    public function updateImage($pathLama, $pathBaru, $file)
    {
        if ($pathBaru && Storage::disk('public')->exists('menu/' . $pathLama)) {
            Storage::disk('public')->delete('menu/' . $pathLama);
            Storage::disk('public')->put('menu/' . $pathBaru, file_get_contents($file));
        }
    }
}
