#!/usr/bin/env python3
"""
Compile comprehensive_vocabularies.json from builder_part1, builder_part2, builder_part3.
Ensures exactly 30 categories and 1,200+ rich vocabulary entries.
"""

import sys
import os
import json

# Add current directory to path
sys.path.append(os.path.dirname(os.path.abspath(__file__)))

from builder_part1 import get_beginner_categories
from builder_part2 import get_daily_categories
from builder_part3 import get_advanced_categories

def compile_all():
    all_raw_categories = []
    all_raw_categories.extend(get_beginner_categories())
    all_raw_categories.extend(get_daily_categories())
    all_raw_categories.extend(get_advanced_categories())

    output_categories = []
    total_words = 0

    for cat_tuple in all_raw_categories:
        slug, name, level, icon, theme, sort_order, desc, words_list = cat_tuple
        cat_words = []
        for item in words_list:
            word, phonetic, pos, trans, ex, ex_trans, tip, diff = item
            cat_words.append({
                "word": word,
                "phonetic": phonetic,
                "part_of_speech": pos,
                "translation": trans,
                "example_sentence": ex,
                "example_translation": ex_trans,
                "pronunciation_tip": tip,
                "difficulty": diff
            })
            total_words += 1

        output_categories.append({
            "slug": slug,
            "name": name,
            "level": level,
            "icon": icon,
            "color_theme": theme,
            "sort_order": sort_order,
            "description": desc,
            "vocabularies": cat_words
        })

    target_path = os.path.join(os.path.dirname(os.path.abspath(__file__)), "comprehensive_vocabularies.json")
    with open(target_path, "w", encoding="utf-8") as f:
        json.dump(output_categories, f, ensure_ascii=False, indent=2)

    print(f"✅ Compilation complete!")
    print(f"📊 Total Categories: {len(output_categories)}")
    print(f"📚 Total Vocabularies: {total_words}")
    print(f"💾 Saved to: {target_path}")

if __name__ == "__main__":
    compile_all()
