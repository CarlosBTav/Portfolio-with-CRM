<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectLink extends Model
{
    protected $fillable = [
        'project_id',
        'url',
        'type',
        'visibility',
        'sort_order',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function label(): string
    {
        return config('projects.link_types.'.$this->type, $this->type);
    }

    public function isGitHub(): bool
    {
        return $this->type === 'github';
    }

    public function isApp(): bool
    {
        return $this->type === 'app';
    }

    public function isPublic(): bool
    {
        return $this->visibility === 'public';
    }
}
