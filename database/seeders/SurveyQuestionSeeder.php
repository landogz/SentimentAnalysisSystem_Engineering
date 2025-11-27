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
        // Disable foreign key checks temporarily
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        SurveyQuestion::query()->delete();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Part 2: Course Evaluation
        // Section A: Home School and Environment Support (Questions 1-5)
        // Section B: Exposure to Resources and Motivation (Questions 6-10)
        // Section C: Other Questions (Questions 11-15)
        $part2Questions = [
            // Section A: Home School and Environment Support
            [
                'question_text' => 'How supportive is your home environment for your studies?',
                'question_type' => 'option',
                'part' => 'part2',
                'order_number' => 1,
                'is_active' => true
            ],
            [
                'question_text' => 'How would you rate the support you receive from your family regarding your education?',
                'question_type' => 'option',
                'part' => 'part2',
                'order_number' => 2,
                'is_active' => true
            ],
            [
                'question_text' => 'How conducive is your home environment for studying and completing assignments?',
                'question_type' => 'option',
                'part' => 'part2',
                'order_number' => 3,
                'is_active' => true
            ],
            [
                'question_text' => 'How would you rate the emotional support you receive from your family?',
                'question_type' => 'option',
                'part' => 'part2',
                'order_number' => 4,
                'is_active' => true
            ],
            [
                'question_text' => 'How would you rate the overall home environment in supporting your academic goals?',
                'question_type' => 'option',
                'part' => 'part2',
                'order_number' => 5,
                'is_active' => true
            ],
            
            // Section B: Exposure to Resources and Motivation
            [
                'question_text' => 'How would you rate your access to learning resources (books, internet, library)?',
                'question_type' => 'option',
                'part' => 'part2',
                'order_number' => 6,
                'is_active' => true
            ],
            [
                'question_text' => 'How would you rate your access to technology and digital resources for learning?',
                'question_type' => 'option',
                'part' => 'part2',
                'order_number' => 7,
                'is_active' => true
            ],
            [
                'question_text' => 'How motivated are you to excel in your studies?',
                'question_type' => 'option',
                'part' => 'part2',
                'order_number' => 8,
                'is_active' => true
            ],
            [
                'question_text' => 'How would you rate your exposure to educational opportunities and programs?',
                'question_type' => 'option',
                'part' => 'part2',
                'order_number' => 9,
                'is_active' => true
            ],
            [
                'question_text' => 'How would you rate the availability of study materials and resources you need?',
                'question_type' => 'option',
                'part' => 'part2',
                'order_number' => 10,
                'is_active' => true
            ],
            
            // Section C: Other Questions
            [
                'question_text' => 'How would you rate your overall satisfaction with the course?',
                'question_type' => 'option',
                'part' => 'part2',
                'order_number' => 11,
                'is_active' => true
            ],
            [
                'question_text' => 'How would you rate the relevance of the course content to your future career?',
                'question_type' => 'option',
                'part' => 'part2',
                'order_number' => 12,
                'is_active' => true
            ],
            [
                'question_text' => 'How would you rate the course organization and structure?',
                'question_type' => 'option',
                'part' => 'part2',
                'order_number' => 13,
                'is_active' => true
            ],
            [
                'question_text' => 'How would you rate the overall learning experience in this course?',
                'question_type' => 'option',
                'part' => 'part2',
                'order_number' => 14,
                'is_active' => true
            ],
            [
                'question_text' => 'How would you rate your overall performance and progress in this course?',
                'question_type' => 'option',
                'part' => 'part2',
                'order_number' => 15,
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
        foreach ($part2Questions as $question) {
            SurveyQuestion::create($question);
        }

        foreach ($part3Questions as $question) {
            SurveyQuestion::create($question);
        }

        $this->command->info('Survey questions seeded successfully!');
        $this->command->info('Part 2: Course Evaluation (15 questions) - Sections A: Home School and Environment Support (1-5), B: Exposure to Resources and Motivation (6-10), C: Other Questions (11-15)');
        $this->command->info('Part 3: Open Ended Questions (3 questions)');
    }
}
