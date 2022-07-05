<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LookbookPhotos extends Model
{
    use HasFactory;
    protected $table = 'lookbookPhotos';


    public function lookbook()
    {
        return $this->hasOne(Lookbook::class,'id','lookbookId');
    }


}
