<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use CrudTrait;
    use HasFactory;
    protected $guarded = ['id']; 


    public function subcategory(){
        return $this->hasOne(Category::class,'parent_id','id');
    }
   

}
