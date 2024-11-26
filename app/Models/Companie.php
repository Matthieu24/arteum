<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Project;

class Companie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'siret',
        'phone',
        'description',
        'cover',
        'actif',
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'company_id');
    }

    public function actifProjects()
    {
        return $this->projects()->where('actif', true);
    }

    public function priorityProject()
    {
        return $this->projects()->where('is_priority', true)->first();
    }
}