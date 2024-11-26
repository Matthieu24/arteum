<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Companie;

class CompanieController extends Controller
{
    public function getAll()
    {
        return Companie::all();
    }

    public function getCompanyProjects(int $id)
    {
        $company = Companie::find($id)->first();

        return $company->actifProjects()->orderBy("is_priority", 'DESC')->get();
    }
}