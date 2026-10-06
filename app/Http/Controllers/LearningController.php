<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\LearningCategory;
use App\Models\UserLearningRecord;
use App\Models\Vocabulary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LearningController extends Controller
{
    /**
     * Render the main English Mobile Web App.
     */
    public function index(Request $request): View
    {
        $sessionId = $request->session()->getId();

        $categories = LearningCategory::withCount('vocabularies')
            ->orderBy('sort_order')
            ->get();

        $allVocabularies = Vocabulary::with('category:id,name,level')
            ->orderBy('id')
            ->get(['id', 'category_id', 'word', 'phonetic', 'part_of_speech', 'translation', 'example_sentence', 'example_translation', 'pronunciation_tip', 'difficulty']);
        $conversations = Conversation::all();

        $userRecords = UserLearningRecord::where('session_id', $sessionId)
            ->get()
            ->keyBy('vocabulary_id');

        $totalWords = $allVocabularies->count();
        $masteredWords = $userRecords->where('is_mastered', true)->count();
        $practicedWords = $userRecords->count();
        $avgScore = $userRecords->whereNotNull('pronunciation_score')->avg('pronunciation_score') ?? 0;

        return view('englishub', [
            'categories' => $categories,
            'vocabularies' => $allVocabularies,
            'conversations' => $conversations,
            'userRecords' => $userRecords,
            'levelWordCounts' => $allVocabularies->countBy(fn (Vocabulary $vocabulary): string => $vocabulary->category->level),
            'stats' => [
                'total_words' => $totalWords,
                'mastered_words' => $masteredWords,
                'practiced_words' => $practicedWords,
                'avg_score' => round($avgScore),
                'xp' => ($masteredWords * 25) + ($practicedWords * 10),
            ],
            'sessionId' => $sessionId,
        ]);
    }

    /**
     * Return list of categories with vocabulary count.
     */
    public function getCategories(): JsonResponse
    {
        $categories = LearningCategory::withCount('vocabularies')
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }

    /**
     * Return vocabularies filtered by category, level, or search term.
     */
    public function getVocabularies(Request $request): JsonResponse
    {
        $query = Vocabulary::with('category');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('level')) {
            $level = $request->input('level');
            $query->whereHas('category', function ($q) use ($level) {
                $q->where('level', $level);
            });
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->input('difficulty'));
        }

        if ($request->filled('search')) {
            $search = '%'.$request->input('search').'%';
            $query->where(function ($q) use ($search) {
                $q->where('word', 'like', $search)
                    ->orWhere('translation', 'like', $search)
                    ->orWhere('example_sentence', 'like', $search);
            });
        }

        $vocabularies = $query->orderBy('id')->get();

        return response()->json([
            'success' => true,
            'data' => $vocabularies,
        ]);
    }

    /**
     * Return conversations.
     */
    public function getConversations(Request $request): JsonResponse
    {
        $query = Conversation::query();

        if ($request->filled('level')) {
            $query->where('level', $request->input('level'));
        }

        $conversations = $query->get();

        return response()->json([
            'success' => true,
            'data' => $conversations,
        ]);
    }

    /**
     * Record study or pronunciation score for a vocabulary word.
     */
    public function recordProgress(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'vocabulary_id' => ['required', 'integer', 'exists:vocabularies,id'],
            'is_mastered' => ['nullable', 'boolean'],
            'pronunciation_score' => ['nullable', 'integer', 'min:0', 'max:100'],
        ]);

        $sessionId = $request->session()->getId();

        $record = UserLearningRecord::firstOrNew([
            'session_id' => $sessionId,
            'vocabulary_id' => $validated['vocabulary_id'],
        ]);

        $record->review_count = ($record->review_count ?? 0) + 1;
        $record->last_reviewed_at = now();

        if (isset($validated['is_mastered'])) {
            $record->is_mastered = (bool) $validated['is_mastered'];
        }

        if (isset($validated['pronunciation_score'])) {
            // Keep the best score or update
            $currentScore = $record->pronunciation_score ?? 0;
            $record->pronunciation_score = max($currentScore, (int) $validated['pronunciation_score']);
            if ($record->pronunciation_score >= 80) {
                $record->is_mastered = true;
            }
        }

        $record->save();

        $allRecords = UserLearningRecord::where('session_id', $sessionId)->get();
        $masteredCount = $allRecords->where('is_mastered', true)->count();
        $avgScore = $allRecords->whereNotNull('pronunciation_score')->avg('pronunciation_score') ?? 0;

        return response()->json([
            'success' => true,
            'record' => $record,
            'stats' => [
                'mastered_words' => $masteredCount,
                'practiced_words' => $allRecords->count(),
                'avg_score' => round($avgScore),
                'xp' => ($masteredCount * 25) + ($allRecords->count() * 10),
            ],
        ]);
    }

    /**
     * Get learning statistics for the current session.
     */
    public function getStats(Request $request): JsonResponse
    {
        $sessionId = $request->session()->getId();
        $allRecords = UserLearningRecord::where('session_id', $sessionId)->get();
        $totalWords = Vocabulary::count();
        $masteredCount = $allRecords->where('is_mastered', true)->count();
        $avgScore = $allRecords->whereNotNull('pronunciation_score')->avg('pronunciation_score') ?? 0;

        return response()->json([
            'success' => true,
            'data' => [
                'total_words' => $totalWords,
                'mastered_words' => $masteredCount,
                'practiced_words' => $allRecords->count(),
                'avg_score' => round($avgScore),
                'xp' => ($masteredCount * 25) + ($allRecords->count() * 10),
            ],
        ]);
    }
}
