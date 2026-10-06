<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('learning_categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('level'); // beginner, daily, advanced
            $table->string('icon')->default('📖');
            $table->string('color_theme')->default('indigo');
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('vocabularies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('learning_categories')->cascadeOnDelete();
            $table->string('word');
            $table->string('phonetic')->nullable();
            $table->string('part_of_speech')->default('Word');
            $table->string('translation');
            $table->text('example_sentence')->nullable();
            $table->text('example_translation')->nullable();
            $table->string('pronunciation_tip')->nullable();
            $table->string('difficulty')->default('basic'); // basic, daily, advanced
            $table->timestamps();
        });

        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('learning_categories')->nullOnDelete();
            $table->string('title');
            $table->string('level')->default('daily'); // beginner, daily, advanced
            $table->string('scenario_tag')->default('Daily Life');
            $table->text('description');
            $table->json('dialogue_script'); // array of [{speaker, role, text, translation, tips}]
            $table->timestamps();
        });

        Schema::create('user_learning_records', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->index();
            $table->foreignId('vocabulary_id')->constrained('vocabularies')->cascadeOnDelete();
            $table->boolean('is_mastered')->default(false);
            $table->unsignedTinyInteger('pronunciation_score')->nullable();
            $table->unsignedInteger('review_count')->default(0);
            $table->timestamp('last_reviewed_at')->nullable();
            $table->timestamps();

            $table->unique(['session_id', 'vocabulary_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_learning_records');
        Schema::dropIfExists('conversations');
        Schema::dropIfExists('vocabularies');
        Schema::dropIfExists('learning_categories');
    }
};
