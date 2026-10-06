<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLearningRecord extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'session_id',
        'vocabulary_id',
        'is_mastered',
        'pronunciation_score',
        'review_count',
        'last_reviewed_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_mastered' => 'boolean',
            'pronunciation_score' => 'integer',
            'review_count' => 'integer',
            'last_reviewed_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<Vocabulary, $this>
     */
    public function vocabulary()
    {
        return $this->belongsTo(Vocabulary::class, 'vocabulary_id');
    }
}
