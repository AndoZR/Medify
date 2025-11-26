<?php

namespace App\Models;

use App\Models\KategoriItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "master_items";

    public function kategoriItems()
    {
        return $this->belongsToMany(
            KategoriItem::class,
            'kategori_master_item',
            'master_item_id',      // FK ke master_items
            'kategori_item_id'     // FK ke kategori_items
        );
    }
}
