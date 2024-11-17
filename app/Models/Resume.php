<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Resume extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'template',
    ];

    protected $casts = [
        'content' => 'array',
    ];

    protected $attributes = [
        'content' => '{"sections":[{"type":"personal","title":"Personal Information","content":{"name":"","email":"","phone":"","address":""}},{"type":"education","title":"Education","content":[]},{"type":"experience","title":"Work Experience","content":[]},{"type":"skills","title":"Skills","content":[]}]}',
        'template' => 'modern'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
