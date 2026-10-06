<?php

use App\Http\Controllers\LearningController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LearningController::class, 'index'])->name('home');

Route::prefix('api/learning')->name('learning.')->group(function () {
    Route::get('/categories', [LearningController::class, 'getCategories'])->name('categories');
    Route::get('/vocabularies', [LearningController::class, 'getVocabularies'])->name('vocabularies');
    Route::get('/conversations', [LearningController::class, 'getConversations'])->name('conversations');
    Route::post('/progress', [LearningController::class, 'recordProgress'])->name('progress');
    Route::get('/stats', [LearningController::class, 'getStats'])->name('stats');
});
