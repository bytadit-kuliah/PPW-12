<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Barang,
    Kategori,
    BarangKategori
};

class MainController extends Controller
{
    public function index(){
        $barangs = Barang::get();
        $kategoris = Kategori::get();
        return view('main', compact('barangs', 'kategoris'));
    }

    public function store(Request $request){
        $request->validate([
            'nama' => 'required|max:255|min:2',
            'stok' => 'required|integer',
        ]);

        $barang = Barang::create([
            'nama' => $request['nama'],
            'stok' => (int) $request['stok']
        ]);
        
        if ($request->has('kategori')) {
            foreach ($request['kategori'] as $kategoriId) {
                BarangKategori::create([
                    'barangs_id' => $barang->id,
                    'kategoris_id' => (int) $kategoriId
                ]);
            }
        }

        return redirect('/')->with('status', 'Barang created!');
    }

    public function update(Request $request, Barang $barang){
        $request->validate([
            'nama' => 'required|max:255|min:2',
            'stok' => 'required|integer',
        ]);
        
        $barang->nama = $request['nama'];
        $barang->stok = (int) $request['stok'];
        $barang->save();
        
        BarangKategori::where('barangs_id', $barang->id)->delete();

        if ($request->has('kategori')) {
            foreach ($request['kategori'] as $kategoriId) {
                BarangKategori::create([
                    'barangs_id' => $barang->id,
                    'kategoris_id' => (int) $kategoriId
                ]);
            }
        }

        return redirect('/')->with('status', 'Barang updated!');
    }

    public function destroy(Barang $barang){
        BarangKategori::where('barangs_id', $barang->id)->delete();
        $barang->delete();

        return redirect('/')->with('status', 'Barang deleted!');
    }
}
