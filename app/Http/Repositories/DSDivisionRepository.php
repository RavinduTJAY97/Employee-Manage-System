<?php

namespace App\Http\Repositories;

use App\Models\DSDivision;
use Illuminate\Http\Request;

class DSDivisionRepository
{
    public function __construct(DSDivision $division)
    {
        $this->division = $division;
    }
    public function getDivisions()
    {
        return  $this->division->all();

    }
}
