<?php

namespace Tests\Feature;

use App\Models\Vocabulary;
use Database\Seeders\EnglishLearningSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LearningFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(EnglishLearningSeeder::class);
    }

    public function test_it_loads_englishub_mobile_web_page_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('EnglisHub');
        $response->assertSee('Tahapan Belajar');
    }

    public function test_it_returns_categories_json(): void
    {
        $response = $this->getJson(route('learning.categories'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'id',
                        'slug',
                        'name',
                        'level',
                        'icon',
                        'vocabularies_count',
                    ],
                ],
            ]);
    }

    public function test_it_can_filter_vocabularies_by_level(): void
    {
        $response = $this->getJson(route('learning.vocabularies', ['level' => 'beginner']));

        $response->assertStatus(200)
            ->assertJsonPath('success', true);
    }

    public function test_it_records_user_learning_progress_and_scores(): void
    {
        $vocab = Vocabulary::first();
        $this->assertNotNull($vocab);

        $response = $this->postJson(route('learning.progress'), [
            'vocabulary_id' => $vocab->id,
            'is_mastered' => true,
            'pronunciation_score' => 95,
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('record.is_mastered', true)
            ->assertJsonPath('record.pronunciation_score', 95);
    }
}
