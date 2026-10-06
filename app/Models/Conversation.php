<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conversation extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'category_id',
        'title',
        'level',
        'scenario_tag',
        'description',
        'dialogue_script',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'dialogue_script' => 'array',
        ];
    }

    /**
     * @return BelongsTo<LearningCategory, $this>
     */
    public function category()
    {
        return $this->belongsTo(LearningCategory::class, 'category_id');
    }
}
