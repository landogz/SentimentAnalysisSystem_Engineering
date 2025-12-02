<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Survey;
use App\Models\Subject;
use App\Models\SurveyResponse;
use App\Models\SurveyQuestion;
use Faker\Factory as Faker;

class SurveySeeder extends Seeder
{
    private $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing surveys and responses
        SurveyResponse::query()->delete();
        Survey::query()->delete();
        $this->command->info('Cleared existing surveys and responses...');

        $subjects = Subject::all();
        $questions = SurveyQuestion::active()->get();

        if ($subjects->isEmpty()) {
            $this->command->info('No subjects found. Please run SubjectSeeder first.');
            return;
        }

        if ($questions->isEmpty()) {
            $this->command->info('No survey questions found. Please run SurveyQuestionSeeder first.');
            return;
        }

        // Sample feedback texts for different sentiments
        // POSITIVE: clearly positive language, strong positive tokens
        $positiveFeedbacks = [
            'This engineering course is excellent. The instructor is very clear, very helpful, and the lessons are extremely well organized.',
            'The overall experience in this course is outstanding. The instructor explains every topic very clearly and supports students very well.',
            'This is a great engineering class. The examples are very practical and the instructor is highly supportive and encouraging.',
            'The course is amazing. The instructor is very engaging, very patient, and always provides helpful feedback.',
            'I am very satisfied with this course. The teaching is excellent, the materials are very useful, and the instructor is highly professional.',
            'This subject is very well taught. The instructor is knowledgeable, organized, and always willing to help.',
            'The engineering lessons are very clear and very interesting. The instructor creates a positive and motivating learning environment.',
            'This course provides an excellent learning experience. The instructor is passionate, supportive, and explains difficult topics very well.',
            'I feel very positive about this class. The structure is strong, the activities are meaningful, and the instructor is very effective.',
            'Overall, this is an outstanding course. The instructor shows great expertise and makes the subject enjoyable and easy to follow.'
        ];

        // NEGATIVE: clearly negative language, strong negative tokens
        $negativeFeedbacks = [
            'This engineering course is poor. The explanations are unclear and the overall support for students is very weak.',
            'The course experience is disappointing. The instructor is often unprepared and the lessons feel very confusing.',
            'This subject is very difficult to follow. The instructions are unclear and the organization of the topics is bad.',
            'The course is frustrating. There is little guidance, the schedule is disorganized, and questions are not answered properly.',
            'Overall, this class feels very unhelpful. The instructor rarely explains concepts clearly and the materials are poorly prepared.',
            'The learning experience is negative. The course is stressful, the workload is heavy, and support from the instructor is limited.',
            'This course is badly organized. Important topics are rushed, instructions are confusing, and feedback is not given in a helpful way.',
            'I am not satisfied with this class. The lectures are boring, the explanations are unclear, and it is hard to learn effectively.',
            'The engineering course feels like a waste of time. The teaching style is ineffective and there is almost no practical support.',
            'The overall quality of this subject is poor. The instructor is not responsive, the content is disorganized, and the class is very discouraging.'
        ];

        // NEUTRAL: balanced language, no strong positive or negative tokens
        $neutralFeedbacks = [
            'This engineering course is acceptable. The content covers the required topics and the overall experience is average.',
            'The course is okay. Some parts are clear while other parts feel a bit rushed, but it still meets the basic expectations.',
            'Overall, the class is moderate in quality. The lessons are standard and the learning pace is normal.',
            'The course provides a typical learning experience. It is neither very strong nor very weak in any specific area.',
            'This subject is reasonable. The teaching style is simple and the activities are ordinary, without major problems.',
            'The engineering course is neutral in impact. The explanations are sometimes clear and sometimes unclear, but generally acceptable.',
            'My experience with this class is mixed. Some sessions are helpful while others feel routine and unremarkable.',
            'The course runs as expected. It follows the syllabus and delivers the required information without many issues.',
            'The overall impression of this subject is average. It functions correctly but does not stand out in a positive or negative way.',
            'This course is neither very good nor very bad. It provides a normal learning environment with standard results.'
        ];

        $totalSurveys = 0;
        $targetSurveys = 100;

        // Create exactly 100 surveys
        for ($i = 0; $i < $targetSurveys; $i++) {
            // Randomly select subject
            $subject = $subjects->random();

            // Determine sentiment distribution (60% positive, 25% neutral, 15% negative)
            $sentimentRand = rand(1, 100);
            if ($sentimentRand <= 60) {
                $sentiment = 'positive';
                $rating = $this->faker->randomFloat(1, 4.0, 5.0);
                $part2Rating = $this->faker->randomFloat(1, 3.0, 4.5);
                $feedbackText = $positiveFeedbacks[array_rand($positiveFeedbacks)];
            } elseif ($sentimentRand <= 85) {
                $sentiment = 'neutral';
                $rating = $this->faker->randomFloat(1, 3.0, 3.9);
                $part2Rating = $this->faker->randomFloat(1, 3.0, 4.0);
                $feedbackText = $neutralFeedbacks[array_rand($neutralFeedbacks)];
            } else {
                $sentiment = 'negative';
                $rating = $this->faker->randomFloat(1, 1.5, 2.9);
                $part2Rating = $this->faker->randomFloat(1, 3.5, 5.0); // Higher difficulty for negative
                $feedbackText = $negativeFeedbacks[array_rand($negativeFeedbacks)];
            }

            // Ensure ratings are within valid range
            $rating = max(1.0, min(5.0, round($rating, 1)));
            $part2Rating = max(1.0, min(5.0, round($part2Rating, 1)));

            // Generate student data
            $studentName = $this->faker->name();
            $studentEmail = strtolower(str_replace(' ', '.', $studentName)) . '@prmsu.edu.ph';
            $ipAddress = $this->faker->ipv4();

            // Create survey (without teacher_id)
            $survey = Survey::create([
                'subject_id' => $subject->id,
                'rating' => $rating,
                'sentiment' => $sentiment,
                'feedback_text' => $feedbackText,
                'student_name' => $studentName,
                'student_email' => $studentEmail,
                'ip_address' => $ipAddress,
                'created_at' => $this->faker->dateTimeBetween('-6 months', 'now')
            ]);

            // Create survey responses for each part (only Part 2 and Part 3)
            $surveyData = [
                'part2_rating' => $part2Rating,
                'part3_sentiment' => $sentiment
            ];
            $this->createSurveyResponses($survey, $questions, $surveyData);
            
            $totalSurveys++;
        }

        // Create 5 surveys with perfect 5.0 ratings
        $this->command->info("Creating 5 surveys with perfect 5.0 ratings...");
        
        $perfectFeedbacks = [
            'Outstanding engineering course! The instructor is absolutelyr exceptional. Every concept is explained with perfect clarity and enthusiasm. The practical applications and real-world examples make this the best learning experience I have ever had. Highly recommended!',
            'Perfect teaching methodology! The instructor demonstrates exceptional expertise and passion. The course structure is flawless, with excellent resources and support. This is exactly what engineering education should be - inspiring, practical, and comprehensive.',
            'Exceptional course delivery! The instructor shows remarkable dedication and makes complex engineering concepts incredibly accessible. The learning materials are outstanding, and the support provided is second to none. Truly an amazing experience!',
            'Absolutely brilliant engineering course! The instructor is phenomenal - clear, engaging, and extremely knowledgeable. The practical approach and real-world applications are perfect. This course has exceeded all my expectations in every way possible.',
            'Perfect engineering education experience! The instructor is outstanding in every aspect - communication, expertise, and support. The course is excellently organized with fantastic resources. This is the gold standard for engineering courses!'
        ];

        for ($i = 0; $i < 5; $i++) {
            // Randomly select subject
            $subject = $subjects->random();

            // Generate student data
            $studentName = $this->faker->name();
            $studentEmail = strtolower(str_replace(' ', '.', $studentName)) . '@prmsu.edu.ph';
            $ipAddress = $this->faker->ipv4();

            // Create survey with perfect 5.0 rating (without teacher_id)
            $survey = Survey::create([
                'subject_id' => $subject->id,
                'rating' => 5.0,
                'sentiment' => 'positive',
                'feedback_text' => $perfectFeedbacks[$i],
                'student_name' => $studentName,
                'student_email' => $studentEmail,
                'ip_address' => $ipAddress,
                'created_at' => $this->faker->dateTimeBetween('-6 months', 'now')
            ]);

            // Create survey responses with perfect ratings
            // Part 2 (Course Evaluation): All 5.0 ratings
            // Part 3 (Open Ended Questions): Very positive comments to get 5.0 sentiment score
            $surveyData = [
                'part2_rating' => 5.0, // All Course Evaluation questions = 5.0
                'part3_sentiment' => 'positive' // Will be converted to 4.5, but with high intensity can reach 5.0
            ];
            $this->createSurveyResponses($survey, $questions, $surveyData, true); // Pass true for perfect rating
            
            $totalSurveys++;
        }

        $this->command->info("Surveys created successfully!");
        $this->command->info("Total surveys created: $totalSurveys");
        $this->command->info("Total responses created: " . SurveyResponse::count());
    }

    /**
     * Create survey responses for all parts (only Part 2 and Part 3)
     */
    private function createSurveyResponses($survey, $questions, $surveyData, $perfectRating = false)
    {
        // Group questions by part (only Part 2 and Part 3)
        $part2Questions = $questions->where('part', 'part2'); // Course Evaluation
        $part3Questions = $questions->where('part', 'part3'); // Open Ended Questions

        // Part 2: Course Evaluation (1-5 scale)
        foreach ($part2Questions as $question) {
            $rating = $perfectRating ? 5 : $this->generatePart2Rating($surveyData['part2_rating']);
            SurveyResponse::create([
                'survey_id' => $survey->id,
                'survey_question_id' => $question->id,
                'answer' => $rating
            ]);
        }

        // Part 3: Open Ended Questions
        foreach ($part3Questions as $question) {
            if ($perfectRating) {
                // Use extremely positive comments for perfect ratings
                $comment = $this->generatePerfectComment($question);
            } else {
                $comment = $this->generatePart3Comment($question, $surveyData['part3_sentiment']);
            }
            SurveyResponse::create([
                'survey_id' => $survey->id,
                'survey_question_id' => $question->id,
                'answer' => $comment
            ]);
        }
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

    /**
     * Generate perfect comments for 5.0 rating surveys
     */
    private function generatePerfectComment($question)
    {
        $perfectComments = [
            'How do your major subjects influence your interest and motivation in pursuing your chosen engineering program?' => [
                'My major subjects have absolutely transformed my passion for engineering! The exceptional teaching methods, outstanding practical applications, and incredible real-world relevance have made me incredibly excited and motivated about my future engineering career. This is the best educational experience I have ever had!',
                'These subjects have dramatically increased my commitment to engineering! The instructor is absolutely phenomenal, providing excellent examples and making every concept incredibly clear. I can see exactly how this knowledge directly applies to solving real engineering problems. Outstanding experience!',
                'My major subjects have tremendously motivated me to pursue advanced engineering studies! The instructor\'s exceptional enthusiasm, brilliant practical examples, and outstanding teaching approach are absolutely inspiring. This is perfect engineering education!'
            ],
            'What do you find most challenging about your major subjects, and how do you usually cope with these challenges?' => [
                'The mathematical complexity is challenging, but the instructor provides absolutely excellent support and guidance! I cope extremely well by seeking help from this outstanding instructor and practicing regularly with the fantastic resources provided. The support system is perfect!',
                'Understanding theoretical concepts is challenging, but the instructor makes it incredibly manageable! I cope excellently by attending the amazing extra sessions and forming study groups with classmates. The instructor\'s support is absolutely exceptional!',
                'The workload is challenging, but the instructor provides perfect guidance! I cope very well by organizing my time effectively and using the instructor\'s excellent office hours for clarification. The support is outstanding!'
            ],
            'In your own words, describe your overall experience and feelings toward your major subjects, what factors positively or negatively affect your attitude, motivation and performance in these subjects?' => [
                'I have an absolutely perfect and exceptional experience with my major subjects! The instructor\'s outstanding explanations, brilliant practical examples, and incredible supportive attitude tremendously motivate me to perform excellently. This is the best learning environment possible!',
                'My experience is absolutely outstanding and perfect! The instructor\'s exceptional passion for engineering, outstanding real-world applications, and brilliant interactive teaching methods tremendously and positively impact my motivation and performance. This is exceptional!',
                'I feel incredibly motivated and extremely engaged! The instructor\'s outstanding expertise, perfect practical approach, and excellent encouragement create an absolutely positive and exceptional learning environment that tremendously enhances my performance. This is perfect!'
            ]
        ];

        $questionText = $question->question_text;
        $comments = $perfectComments[$questionText] ?? ['This is an absolutely outstanding and perfect experience! The instructor is exceptional in every way possible!'];
        
        return $comments[array_rand($comments)];
    }
} 