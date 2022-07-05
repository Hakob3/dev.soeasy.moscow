<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Catalog extends Model
{
    use HasFactory;

    public $table = 'catalog';

    public function photos()
    {
        return $this->hasMany(CatalogPhotos::class, 'catalogId', 'id');
    }

    public function modifications()
    {
        return $this->hasMany(CatalogModifications::class, 'catalog_id', 'id');
    }

    public function alsoBar($alsoIds)
    {
        return Catalog::whereIn('id', $alsoIds)->get();
    }

    public function modificationSizes($modifications)
    {
        $si = [];
        $sizes = [];
        foreach ($modifications as $k => $modification) {
            $si = CatalogSizes::where('name', strtolower($modification->size))->first();
            $sizes[$si->id] = $si;
        }
        return $sizes;
    }

    public function tmpImages()
    {
        return $this->hasMany(CatalogPhotos::class, 'catalogId', 'id');
    }

    public function rubrics()
    {
        return $this->hasOne(Rubrics::class, 'id', 'rubricId');
    }

    public function otherColorsIdsBlocks()
    {
        $otherColorsIds = explode(',', $this->otherColorsIds);
        $catItems = Catalog::select('colorId')
            ->whereIn('id', $otherColorsIds)
            ->get();
        $rIds = [];
        foreach ($catItems as $key => $value) {
            $rIds[] = $value->colorId;
        }

        return CatalogColors::whereIn('id', $rIds)->get();
    }

    public function otherColorsByCatalogIds()
    {
        $otherColorsIds = explode(',', $this->otherColorsIds);


        $rIds = [];
        foreach ($otherColorsIds as $key => $value) {
            $catItems = Catalog::select('colorId')->find($value);
            if (isset($catItems->colorId)) {
                $rIds[$value] = CatalogColors::find($catItems->colorId);
            }
        }

        return $rIds;
    }
}
