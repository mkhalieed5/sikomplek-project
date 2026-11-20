<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class KategoriIuran extends Model
{
    use BelongsToTenant;
    protected $table = 'kategori_iurans';
    protected $fillable = ['tenant_id', 'nama_kategori', 'nominal_default', 'deskripsi'];
}
