<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LearningCategory extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'slug',
        'name',
        'level',
        'icon',
        'color_theme',
        'description',
        'sort_order',
    ];

    /**
     * @return HasMany<Vocabulary, $this>
     */
    public function vocabularies()
    {
        return $this->hasMany(Vocabulary::class, 'category_id')->orderBy('id');
    }

    /**
     * @return HasMany<Conversation, $this>
     */
    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'category_id');
    }
}
