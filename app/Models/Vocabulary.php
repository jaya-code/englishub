<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vocabulary extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'category_id',
        'word',
        'phonetic',
        'part_of_speech',
        'translation',
        'example_sentence',
        'example_translation',
        'pronunciation_tip',
        'difficulty',
    ];

    /**
     * @return BelongsTo<LearningCategory, $this>
     */
    public function category()
    {
        return $this->belongsTo(LearningCategory::class, 'category_id');
    }

    /**
     * @return HasMany<UserLearningRecord, $this>
     */
    public function learningRecords()
    {
        return $this->hasMany(UserLearningRecord::class, 'vocabulary_id');
    }
}
