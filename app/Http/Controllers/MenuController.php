<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    // 📋 tampil semua menu (admin)
    public function index()
    {
        $menus = Menu::with('category')->latest()->get();
        return view('admin.menu.index', compact('menus'));
    }

    // ➕ form tambah
    public function create()
    {
        $categories = Category::all();
        return view('admin.menu.create', compact('categories'));
    }

    // 💾 simpan data + upload gambar
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // upload gambar
        $imagePath = $request->file('image')->store('menus', 'public');

        // simpan
        Menu::create([
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'image' => $imagePath,
            'rating' => 4.5,
            'cook_time' => 15
        ]);

        return redirect('/admin/menu')->with('success', 'Menu berhasil ditambahkan 🔥');
    }

    // ✏️ form edit
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $categories = Category::all();

        return view('admin.menu.edit', compact('menu', 'categories'));
    }

    // 🔄 update
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // kalau upload gambar baru
        if ($request->hasFile('image')) {

            // hapus gambar lama
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }

            $menu->image = $request->file('image')->store('menus', 'public');
        }

        // update data
        $menu->update([
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'description' => $request->description
        ]);

        return redirect('/admin/menu')->with('success', 'Menu berhasil diupdate ✨');
    }

    // 🗑️ delete
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        // hapus gambar dari storage
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return back()->with('success', 'Menu dihapus 🗑️');
    }
}