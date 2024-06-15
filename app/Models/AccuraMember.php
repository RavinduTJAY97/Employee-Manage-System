<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccuraMember extends Model
{
    use HasFactory;
    protected $fillable = ['fname' ,'lname','d_o_b','ds_division_id','summary'];

    // relation function  to get division data
    public function division()
    {
        return $this->belongsTo(DSDivision::class, 'ds_division_id', 'id','ds_division_id');
    }
}
