<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SurveyQuestion;

class SurveyQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete existing questions
        SurveyQuestion::query()->delete();

        // Part 1: Instructor Evaluation (Outstanding, Very Satisfactory, Satisfactory, Fair, Poor)
        $part1Questions = [
            // Section A: Commitment
            [
                'question_text' => 'The lessons in my major subjects are clear and easy to understand',
                'question_type' => 'option',
                'part' => 'part1',
                'order_number' => 1,
                'is_active' => true
            ],
            [
                'question_text' => 'My major subjects encourage me to think critically and solve problems',
                'question_type' => 'option',
                'part' => 'part1',
                'order_number' => 2,
                'is_active' => true
            ],
            [
                'question_text' => 'I feel motivated to study and perform well in my major subjects',
                'question_type' => 'option',
                'part' => 'part1',
                'order_number' => 3,
                'is_active' => true
            ],
            [
                'question_text' => 'I can see the relevance of my major subjects in real life applications',
                'question_type' => 'option',
                'part' => 'part1',
                'order_number' => 4,
                'is_active' => true
            ],
            [
                'question_text' => 'The workload in my major subjects is manageable',
                'question_type' => 'option',
                'part' => 'part1',
                'order_number' => 5,
                'is_active' => true
            ],
            
            // Section B: Academic Challenges
            [
                'question_text' => 'I find my major subjects too difficult to understand',
                'question_type' => 'option',
                'part' => 'part1',
                'order_number' => 6,
                'is_active' => true
            ],
            [
                'question_text' => 'I feel pressured by the workload in my major subjects',
                'question_type' => 'option',
                'part' => 'part1',
                'order_number' => 7,
                'is_active' => true
            ],
            [
                'question_text' => 'I often experiences stress when studying for my major subjects',
                'question_type' => 'option',
                'part' => 'part1',
                'order_number' => 8,
                'is_active' => true
            ],
            [
                'question_text' => 'I struggle to balance my major subjects with other academic requirements',
                'question_type' => 'option',
                'part' => 'part1',
                'order_number' => 9,
                'is_active' => true
            ],
            [
                'question_text' => 'Do you feel there is a good balance between theoretical and practical instruction in your major',
                'question_type' => 'option',
                'part' => 'part1',
                'order_number' => 10,
                'is_active' => true
            ],
            
            // Section C: Learning Experiences
            [
                'question_text' => 'My instructor explain major subjects clearly and effectively',
                'question_type' => 'option',
                'part' => 'part1',
                'order_number' => 11,
                'is_active' => true
            ],
            [
                'question_text' => 'The teaching strategies used in major subjects help me learn better',
                'question_type' => 'option',
                'part' => 'part1',
                'order_number' => 12,
                'is_active' => true
            ],
            [
                'question_text' => 'The learning materials provided are helpful in understand the lessons',
                'question_type' => 'option',
                'part' => 'part1',
                'order_number' => 13,
                'is_active' => true
            ],
            [
                'question_text' => 'My Major subjects encourage me to think critically and solve problems',
                'question_type' => 'option',
                'part' => 'part1',
                'order_number' => 14,
                'is_active' => true
            ],
            [
                'question_text' => 'I feel comfortable asking questions or clarifying topics in my major subjects',
                'question_type' => 'option',
                'part' => 'part1',
                'order_number' => 15,
                'is_active' => true
            ],
            
            // Section D: Assignments and Exams
            [
                'question_text' => 'How difficult is it to complete homework or assignments in your major subjects?',
                'question_type' => 'option',
                'part' => 'part1',
                'order_number' => 16,
                'is_active' => true
            ],
            [
                'question_text' => 'How challenging do you find preparing for exams or quizzes in your major subject?',
                'question_type' => 'option',
                'part' => 'part1',
                'order_number' => 17,
                'is_active' => true
            ],
            [
                'question_text' => 'How difficult is it to manage multiple assignments from different subjects at the same time?',
                'question_type' => 'option',
                'part' => 'part1',
                'order_number' => 18,
                'is_active' => true
            ],
            [
                'question_text' => 'How difficult do you find answering questions that require critical thinking or problem-solving?',
                'question_type' => 'option',
                'part' => 'part1',
                'order_number' => 19,
                'is_active' => true
            ],
            [
                'question_text' => 'How difficult is it to meet the academic expectations of your instructors?',
                'question_type' => 'option',
                'part' => 'part1',
                'order_number' => 20,
                'is_active' => true
            ]
        ];

        // Part 2: Difficulty Level (Very Difficult, Difficult, Slightly Difficult, Not Difficult, Very Not Difficult)
        $part2Questions = [
            [
                'question_text' => 'How would you rate the difficulty of understanding the concepts taught in the CCIT subject?',
                'question_type' => 'option',
                'part' => 'part2',
                'order_number' => 1,
                'is_active' => true
            ],
            [
                'question_text' => 'How would you rate the difficulty of completing CCIT assignments and projects?',
                'question_type' => 'option',
                'part' => 'part2',
                'order_number' => 2,
                'is_active' => true
            ],
            [
                'question_text' => 'How would you rate the difficulty of preparing for CCIT quizzes and exams?',
                'question_type' => 'option',
                'part' => 'part2',
                'order_number' => 3,
                'is_active' => true
            ],
            [
                'question_text' => 'How would you rate the difficulty of applying CCIT concepts in practical activities or exercises?',
                'question_type' => 'option',
                'part' => 'part2',
                'order_number' => 4,
                'is_active' => true
            ],
            [
                'question_text' => 'How would you rate the difficulty of keeping up with the pace of lessons in CCIT?',
                'question_type' => 'option',
                'part' => 'part2',
                'order_number' => 5,
                'is_active' => true
            ]
        ];

        // Part 3: Open Comments
        $part3Questions = [
            [
                'question_text' => 'How do your major subjects influence your interest and motivation in pursuing your chosen engineering program?',
                'question_type' => 'comment',
                'part' => 'part3',
                'order_number' => 1,
                'is_active' => true
            ],
            [
                'question_text' => 'What do you find most challenging about your major subjects, and how do you usually cope with these challenges?',
                'question_type' => 'comment',
                'part' => 'part3',
                'order_number' => 2,
                'is_active' => true
            ],
            [
                'question_text' => 'In your own words, describe your overall experience and feelings toward your major subjects, what factors positively or negatively affect your attitude, motivation and performance in these subjects?',
                'question_type' => 'comment',
                'part' => 'part3',
                'order_number' => 3,
                'is_active' => true
            ]
        ];

        // Insert all questions
        foreach ($part1Questions as $question) {
            SurveyQuestion::create($question);
        }

        foreach ($part2Questions as $question) {
            SurveyQuestion::create($question);
        }

        foreach ($part3Questions as $question) {
            SurveyQuestion::create($question);
        }

        $this->command->info('Survey questions seeded successfully with 3 parts structure!');
        $this->command->info('Part 1: Student Evaluation (20 questions) - Sections A: Commitment, B: Academic Challenges, C: Learning Experiences, D: Assignments and Exams');
        $this->command->info('Part 2: Difficulty Level (5 questions)');
        $this->command->info('Part 3: Open Comments (3 questions)');
    }
}
