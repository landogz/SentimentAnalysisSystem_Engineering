<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Survey;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\SurveyResponse;
use App\Models\SurveyQuestion;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing surveys and responses
        SurveyResponse::query()->delete();
        Survey::query()->delete();
        $this->command->info('Cleared existing surveys and responses...');

        $teachers = Teacher::all();
        $subjects = Subject::all();
        $questions = SurveyQuestion::active()->get();

        if ($teachers->isEmpty() || $subjects->isEmpty()) {
            $this->command->info('No teachers or subjects found. Please run TeacherSeeder and SubjectSeeder first.');
            return;
        }

        if ($questions->isEmpty()) {
            $this->command->info('No survey questions found. Please run SurveyQuestionSeeder first.');
            return;
        }

        // Sample survey data with part-specific analysis for Engineering students
        $sampleSurveys = [
            [
                'rating' => 4.6,
                'sentiment' => 'positive',
                'part1_rating' => 4.7, // Student Evaluation
                'part2_rating' => 4.1, // Difficulty Level
                'part3_sentiment' => 'positive',
                'feedback_text' => 'Excellent engineering course! The instructor makes complex engineering concepts easy to understand. Very practical approach to learning.',
                'student_name' => 'Carlos Santos',
                'student_email' => 'carlos.santos@engineering.edu'
            ],
            [
                'rating' => 4.1,
                'sentiment' => 'positive',
                'part1_rating' => 4.3,
                'part2_rating' => 3.8,
                'part3_sentiment' => 'positive',
                'feedback_text' => 'Great course structure for engineering students. The instructor provides excellent real-world examples and applications.',
                'student_name' => 'Maria Gonzales',
                'student_email' => 'maria.gonzales@engineering.edu'
            ],
            [
                'rating' => 4.4,
                'sentiment' => 'positive',
                'part1_rating' => 4.5,
                'part2_rating' => 4.0,
                'part3_sentiment' => 'positive',
                'feedback_text' => 'Very knowledgeable engineering instructor. Makes theoretical concepts practical and engaging for students.',
                'student_name' => 'Ahmed Hassan',
                'student_email' => 'ahmed.hassan@engineering.edu'
            ],
            [
                'rating' => 2.8,
                'sentiment' => 'negative',
                'part1_rating' => 3.0,
                'part2_rating' => 4.6,
                'part3_sentiment' => 'negative',
                'feedback_text' => 'Engineering course needs improvement in communication. The subject is very challenging and lacks proper guidance.',
                'student_name' => 'Jennifer Lee',
                'student_email' => 'jennifer.lee@engineering.edu'
            ],
            [
                'rating' => 3.3,
                'sentiment' => 'neutral',
                'part1_rating' => 3.4,
                'part2_rating' => 3.2,
                'part3_sentiment' => 'neutral',
                'feedback_text' => 'Average engineering course, could be better organized. The difficulty level is appropriate for engineering students.',
                'student_name' => 'David Kim',
                'student_email' => 'david.kim@engineering.edu'
            ],
            [
                'rating' => 4.9,
                'sentiment' => 'positive',
                'part1_rating' => 5.0,
                'part2_rating' => 4.2,
                'part3_sentiment' => 'positive',
                'feedback_text' => 'Outstanding engineering instructor! Very passionate about engineering and makes complex topics accessible.',
                'student_name' => 'Isabella Martinez',
                'student_email' => 'isabella.martinez@engineering.edu'
            ],
            [
                'rating' => 3.7,
                'sentiment' => 'neutral',
                'part1_rating' => 3.8,
                'part2_rating' => 3.5,
                'part3_sentiment' => 'neutral',
                'feedback_text' => 'Decent engineering course, some improvements needed. The instructor is knowledgeable but could be more engaging.',
                'student_name' => 'Ryan Thompson',
                'student_email' => 'ryan.thompson@engineering.edu'
            ],
            [
                'rating' => 4.2,
                'sentiment' => 'positive',
                'part1_rating' => 4.4,
                'part2_rating' => 3.7,
                'part3_sentiment' => 'positive',
                'feedback_text' => 'Good engineering learning experience. The instructor is professional and the course is well-structured for practical applications.',
                'student_name' => 'Sofia Rodriguez',
                'student_email' => 'sofia.rodriguez@engineering.edu'
            ],
            [
                'rating' => 2.1,
                'sentiment' => 'negative',
                'part1_rating' => 2.3,
                'part2_rating' => 4.9,
                'part3_sentiment' => 'negative',
                'feedback_text' => 'Poor engineering course experience. The instructor lacks clarity and the course is extremely difficult without proper support.',
                'student_name' => 'Kevin Chen',
                'student_email' => 'kevin.chen@engineering.edu'
            ],
            [
                'rating' => 4.8,
                'sentiment' => 'positive',
                'part1_rating' => 4.9,
                'part2_rating' => 3.4,
                'part3_sentiment' => 'positive',
                'feedback_text' => 'Amazing engineering instructor! Very passionate about teaching engineering and makes learning enjoyable and practical.',
                'student_name' => 'Ana Silva',
                'student_email' => 'ana.silva@engineering.edu'
            ],
            [
                'rating' => 3.9,
                'sentiment' => 'positive',
                'part1_rating' => 4.0,
                'part2_rating' => 3.6,
                'part3_sentiment' => 'positive',
                'feedback_text' => 'Good engineering course with practical focus. The instructor provides valuable industry insights and real-world applications.',
                'student_name' => 'Miguel Torres',
                'student_email' => 'miguel.torres@engineering.edu'
            ],
            [
                'rating' => 2.9,
                'sentiment' => 'negative',
                'part1_rating' => 3.1,
                'part2_rating' => 4.3,
                'part3_sentiment' => 'negative',
                'feedback_text' => 'Engineering course needs better organization. The instructor could improve communication and provide more practical examples.',
                'student_name' => 'Lisa Wang',
                'student_email' => 'lisa.wang@engineering.edu'
            ]
        ];

        $totalSurveys = 0;

        foreach ($teachers as $teacher) {
            // Get subjects for this teacher
            $teacherSubjects = $teacher->subjects;
            
            if ($teacherSubjects->isEmpty()) {
                // If no subjects assigned, assign a random subject
                $randomSubject = $subjects->random();
                $teacher->subjects()->attach($randomSubject->id, ['is_primary' => true]);
                $teacherSubjects = collect([$randomSubject]);
            }

            // Create 3-6 surveys for each teacher
            $numSurveys = rand(3, 6);
            
            for ($i = 0; $i < $numSurveys; $i++) {
                $surveyData = $sampleSurveys[array_rand($sampleSurveys)];
                $subject = $teacherSubjects->random();
                
                // Create survey
                $survey = Survey::create([
                    'teacher_id' => $teacher->id,
                    'subject_id' => $subject->id,
                    'rating' => $surveyData['rating'],
                    'sentiment' => $surveyData['sentiment'],
                    'feedback_text' => $surveyData['feedback_text'],
                    'student_name' => $surveyData['student_name'],
                    'student_email' => $surveyData['student_email'],
                    'ip_address' => '127.0.0.1',
                    'created_at' => now()->subDays(rand(1, 60))
                ]);

                // Create survey responses for each part
                $this->createSurveyResponses($survey, $questions, $surveyData);
                
                $totalSurveys++;
            }
        }

        $this->command->info("Sample surveys created successfully!");
        $this->command->info("Total surveys created: $totalSurveys");
        $this->command->info("Total responses created: " . SurveyResponse::count());
    }

    /**
     * Create survey responses for all parts
     */
    private function createSurveyResponses($survey, $questions, $surveyData)
    {
        // Group questions by part
        $part1Questions = $questions->where('part', 'part1'); // Instructor Evaluation
        $part2Questions = $questions->where('part', 'part2'); // Difficulty Level
        $part3Questions = $questions->where('part', 'part3'); // Open Comments

        // Part 1: Instructor Evaluation (1-5 scale)
        foreach ($part1Questions as $question) {
            $rating = $this->generatePart1Rating($surveyData['part1_rating']);
            SurveyResponse::create([
                'survey_id' => $survey->id,
                'survey_question_id' => $question->id,
                'answer' => $rating
            ]);
        }

        // Part 2: Difficulty Level (1-5 scale)
        foreach ($part2Questions as $question) {
            $rating = $this->generatePart2Rating($surveyData['part2_rating']);
            SurveyResponse::create([
                'survey_id' => $survey->id,
                'survey_question_id' => $question->id,
                'answer' => $rating
            ]);
        }

        // Part 2: Open Comments
        foreach ($part3Questions as $question) {
            $comment = $this->generatePart3Comment($question, $surveyData['part3_sentiment']);
            SurveyResponse::create([
                'survey_id' => $survey->id,
                'survey_question_id' => $question->id,
                'answer' => $comment
            ]);
        }
    }

    /**
     * Generate Part 1 rating based on target rating
     */
    private function generatePart1Rating($targetRating)
    {
        // Generate rating with some variation around the target
        $variation = rand(-2, 2) / 10; // ±0.2 variation
        $rating = max(1, min(5, $targetRating + $variation));
        return round($rating);
    }

    /**
     * Generate Part 2 rating based on target rating
     */
    private function generatePart2Rating($targetRating)
    {
        // Generate rating with some variation around the target
        $variation = rand(-2, 2) / 10; // ±0.2 variation
        $rating = max(1, min(5, $targetRating + $variation));
        return round($rating);
    }

    /**
     * Generate Part 2 comment based on sentiment for Engineering students
     */
    private function generatePart3Comment($question, $sentiment)
    {
        $comments = [
            'positive' => [
                'How do your major subjects influence your interest and motivation in pursuing your chosen engineering program?' => [
                    'My major subjects have greatly increased my passion for engineering. The practical applications and real-world relevance make me excited about my future career.',
                    'These subjects have strengthened my commitment to engineering. I can see how the knowledge directly applies to solving real engineering problems.',
                    'My major subjects have motivated me to pursue advanced engineering studies. The instructor\'s enthusiasm and practical examples are inspiring.'
                ],
                'What do you find most challenging about your major subjects, and how do you usually cope with these challenges?' => [
                    'The mathematical complexity is challenging, but I cope by seeking help from the instructor and practicing regularly with the provided resources.',
                    'Understanding theoretical concepts is challenging, but I manage by attending extra sessions and forming study groups with classmates.',
                    'The workload is challenging, but I cope by organizing my time well and using the instructor\'s office hours for clarification.'
                ],
                'In your own words, describe your overall experience and feelings toward your major subjects, what factors positively or negatively affect your attitude, motivation and performance in these subjects?' => [
                    'I have a very positive experience with my major subjects. The instructor\'s clear explanations, practical examples, and supportive attitude greatly motivate me to perform well.',
                    'My experience is excellent. The instructor\'s passion for engineering, real-world applications, and interactive teaching methods positively impact my motivation and performance.',
                    'I feel very motivated and engaged. The instructor\'s expertise, practical approach, and encouragement create a positive learning environment that enhances my performance.'
                ]
            ],
            'negative' => [
                'How do your major subjects influence your interest and motivation in pursuing your chosen engineering program?' => [
                    'My major subjects have somewhat decreased my enthusiasm for engineering due to poor teaching methods and lack of practical applications.',
                    'These subjects have made me question my engineering choice. The instructor doesn\'t make the material engaging or relevant.',
                    'My major subjects have negatively impacted my motivation. I struggle to see the connection between theory and practical engineering work.'
                ],
                'What do you find most challenging about your major subjects, and how do you usually cope with these challenges?' => [
                    'The lack of clear explanations is most challenging. I try to cope by reading textbooks, but it\'s difficult without proper guidance.',
                    'Understanding complex concepts without adequate support is challenging. I cope by seeking help from other students, but this isn\'t ideal.',
                    'The overwhelming difficulty without proper resources is challenging. I struggle to cope effectively due to poor instructor support.'
                ],
                'In your own words, describe your overall experience and feelings toward your major subjects, what factors positively or negatively affect your attitude, motivation and performance in these subjects?' => [
                    'My experience is frustrating. The instructor\'s unclear explanations, lack of practical examples, and poor communication negatively affect my motivation and performance.',
                    'I feel discouraged and unmotivated. The instructor\'s disorganized approach, lack of engagement, and insufficient support create a negative learning environment.',
                    'My overall feeling is negative. The instructor\'s poor teaching methods, lack of clarity, and unprofessional attitude significantly impact my performance and motivation.'
                ]
            ],
            'neutral' => [
                'How do your major subjects influence your interest and motivation in pursuing your chosen engineering program?' => [
                    'My major subjects have a neutral effect on my engineering motivation. They\'re neither particularly inspiring nor discouraging.',
                    'These subjects have a moderate influence on my engineering interest. I can see some relevance but it could be better presented.',
                    'My major subjects have a mixed impact on my motivation. Some aspects are interesting while others could be improved.'
                ],
                'What do you find most challenging about your major subjects, and how do you usually cope with these challenges?' => [
                    'The moderate difficulty level is challenging but manageable. I cope by using available resources and seeking occasional help.',
                    'Understanding some concepts is challenging. I cope by studying independently and asking questions when needed.',
                    'The workload is moderately challenging. I cope by managing my time and using standard study methods.'
                ],
                'In your own words, describe your overall experience and feelings toward your major subjects, what factors positively or negatively affect your attitude, motivation and performance in these subjects?' => [
                    'My experience is average. The instructor is adequate but could be more engaging. Some factors help while others could be improved.',
                    'I have mixed feelings about my major subjects. The instructor is competent but not inspiring. My motivation and performance are acceptable but not exceptional.',
                    'My overall experience is neutral. The instructor provides basic instruction but lacks enthusiasm. This affects my motivation and performance moderately.'
                ]
            ]
        ];

        $questionText = $question->question_text;
        $sentimentComments = $comments[$sentiment][$questionText] ?? ['No comment available.'];
        
        return $sentimentComments[array_rand($sentimentComments)];
    }
} 