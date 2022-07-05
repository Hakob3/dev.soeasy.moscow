<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItems extends Model
{
    use HasFactory;

    public $table = 'cart_items';


    public function sizeValue()
    {
        return $this->hasOne(CatalogSizes::class, 'id', 'size_id');
    }

    public function catalogItem()
    {
        return $this->hasOne(Catalog::class, 'id', 'catalog_id');
    }

}
