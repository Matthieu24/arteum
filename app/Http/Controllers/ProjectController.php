<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function show(int $id)
    {
        $project = Project::find($id)->first();
        $project->images = $project->images()->orderBy("position")->pluck('path');

        return $project;
    }
}