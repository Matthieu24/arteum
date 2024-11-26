<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Companie;
use App\Models\ProjectImage;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'cover',
        'is_priority',
        'description',
        'actif',
    ];

    protected $casts = [
        'is_priority' => 'boolean',
        'existing_page' => 'boolean',
        'actif' => 'boolean'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Companie::class, 'company_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class);
    }

    public function scopePriority()
    {
        return $this->where('is_priority', true)->first();
    }
}