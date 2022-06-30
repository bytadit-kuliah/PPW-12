<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'stok'];

    public function barangKategoris(){
        return $this->hasMany(BarangKategori::class, 'barangs_id', 'id');
    }

    public function hasKategoriById($id){
        if($this->barangKategoris->whereIn('kategoris_id', $id)->first()){
            return true;
        }
        
        return false;
    }
}
