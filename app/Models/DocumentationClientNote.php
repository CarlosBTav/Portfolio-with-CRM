<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentationClientNote extends Model
{
    protected $fillable = [
        'documentation_slug',
        'body',
        'pending_item_index',
    ];

    protected function casts(): array
    {
        return [
            'pending_item_index' => 'integer',
        ];
    }
}
