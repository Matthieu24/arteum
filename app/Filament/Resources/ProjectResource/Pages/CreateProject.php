<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Project;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if ($data['is_priority']) {
            $project = Project::where('company_id', $data['company_id'])->priority();
            if ($project) {
                $project->is_priority = false;
                $project->save();
            }
        }

        return $data;
    }
}