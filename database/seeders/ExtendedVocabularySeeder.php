<?php

namespace Database\Seeders;

use App\Models\LearningCategory;
use App\Models\Vocabulary;
use Illuminate\Database\Seeder;

class ExtendedVocabularySeeder extends Seeder
{
    /**
     * Daftar file data kosakata (baris: kata|fonetik|jenis|arti|contoh|arti contoh).
     *
     * @var list<string>
     */
    private const DATA_FILES = [
        'vocabulary_basic_a.php',
        'vocabulary_basic_b.php',
        'vocabulary_daily_a.php',
        'vocabulary_daily_b.php',
        'vocabulary_daily_c.php',
        'vocabulary_advanced_a.php',
        'vocabulary_advanced_b.php',
    ];

    /**
     * @var array<string, string>
     */
    private const DIFFICULTY_BY_LEVEL = [
        'beginner' => 'basic',
        'daily' => 'daily',
        'advanced' => 'advanced',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $existingWords = Vocabulary::query()
            ->get(['id', 'category_id', 'word', 'part_of_speech'])
            ->keyBy(fn (Vocabulary $vocabulary): string => $this->wordKey($vocabulary->word, $vocabulary->part_of_speech));

        $sortOrder = (int) LearningCategory::max('sort_order');

        foreach (self::DATA_FILES as $file) {
            /** @var list<array{slug: string, name: string, level: string, icon: string, color_theme: string, description: string, words: string}> $categories */
            $categories = require __DIR__.'/data/'.$file;

            foreach ($categories as $categoryData) {
                $category = LearningCategory::firstOrNew(['slug' => $categoryData['slug']]);

                if (! $category->exists) {
                    $category->sort_order = ++$sortOrder;
                }

                $category->fill([
                    'name' => $categoryData['name'],
                    'level' => $categoryData['level'],
                    'icon' => $categoryData['icon'],
                    'color_theme' => $categoryData['color_theme'],
                    'description' => $categoryData['description'],
                ])->save();

                $difficulty = self::DIFFICULTY_BY_LEVEL[$categoryData['level']] ?? 'basic';

                foreach ($this->parseRows($categoryData['words']) as $row) {
                    $key = $this->wordKey($row['word'], $row['part_of_speech']);
                    $existing = $existingWords->get($key);

                    if ($existing !== null && $existing->category_id !== $category->id) {
                        continue;
                    }

                    $attributes = $row + [
                        'category_id' => $category->id,
                        'pronunciation_tip' => 'Dengarkan dulu pelafalan penutur asli, lalu tirukan perlahan: '.$row['phonetic'],
                        'difficulty' => $difficulty,
                    ];

                    if ($existing !== null) {
                        $existing->update($attributes);

                        continue;
                    }

                    $existingWords->put($key, Vocabulary::create($attributes));
                }
            }
        }
    }

    /**
     * @return list<array{word: string, phonetic: string, part_of_speech: string, translation: string, example_sentence: string, example_translation: string}>
     */
    private function parseRows(string $rows): array
    {
        $parsed = [];

        foreach (preg_split('/\R/', trim($rows)) as $line) {
            $columns = array_map('trim', explode('|', $line));

            if (count($columns) !== 6) {
                throw new \UnexpectedValueException("Format baris kosakata tidak valid: {$line}");
            }

            [$word, $phonetic, $partOfSpeech, $translation, $example, $exampleTranslation] = $columns;

            $parsed[] = [
                'word' => $word,
                'phonetic' => $phonetic,
                'part_of_speech' => $partOfSpeech,
                'translation' => $translation,
                'example_sentence' => $example,
                'example_translation' => $exampleTranslation,
            ];
        }

        return $parsed;
    }

    private function wordKey(string $word, string $partOfSpeech): string
    {
        return mb_strtolower($word).'|'.mb_strtolower($partOfSpeech);
    }
}
