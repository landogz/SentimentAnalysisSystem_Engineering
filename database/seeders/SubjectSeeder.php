<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use App\Models\Teacher;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = Teacher::all();
        
        $subjects = [
            [
                'subject_code' => 'CE101',
                'name' => 'Engineering Mechanics',
                'description' => 'Fundamental principles of statics and dynamics for engineering applications.',
                'teacher_ids' => [1, 2] // Civil and Mechanical Engineering
            ],
            [
                'subject_code' => 'CE201',
                'name' => 'Structural Analysis',
                'description' => 'Analysis of structural systems, loads, and design principles.',
                'teacher_ids' => [1]
            ],
            [
                'subject_code' => 'ME101',
                'name' => 'Thermodynamics',
                'description' => 'Principles of energy conversion and thermodynamic cycles.',
                'teacher_ids' => [2]
            ],
            [
                'subject_code' => 'ME201',
                'name' => 'Fluid Mechanics',
                'description' => 'Study of fluid behavior and hydraulic systems.',
                'teacher_ids' => [2, 7] // Mechanical and Environmental
            ],
            [
                'subject_code' => 'EE101',
                'name' => 'Circuit Analysis',
                'description' => 'Fundamental electrical circuits and network analysis.',
                'teacher_ids' => [3]
            ],
            [
                'subject_code' => 'EE201',
                'name' => 'Electronics',
                'description' => 'Electronic devices and circuit design principles.',
                'teacher_ids' => [3, 4] // Electrical and Computer Engineering
            ],
            [
                'subject_code' => 'CPE101',
                'name' => 'Computer Architecture',
                'description' => 'Digital logic design and computer system organization.',
                'teacher_ids' => [4]
            ],
            [
                'subject_code' => 'CPE201',
                'name' => 'Embedded Systems',
                'description' => 'Design and programming of microcontroller-based systems.',
                'teacher_ids' => [4]
            ],
            [
                'subject_code' => 'CHE101',
                'name' => 'Chemical Process Principles',
                'description' => 'Fundamental principles of chemical engineering processes.',
                'teacher_ids' => [5]
            ],
            [
                'subject_code' => 'CHE201',
                'name' => 'Unit Operations',
                'description' => 'Chemical engineering unit operations and equipment design.',
                'teacher_ids' => [5, 8] // Chemical and Materials Engineering
            ],
            [
                'subject_code' => 'IE101',
                'name' => 'Operations Research',
                'description' => 'Mathematical optimization and decision-making methods.',
                'teacher_ids' => [6]
            ],
            [
                'subject_code' => 'IE201',
                'name' => 'Quality Control',
                'description' => 'Statistical quality control and process improvement.',
                'teacher_ids' => [6]
            ],
            [
                'subject_code' => 'ENVE101',
                'name' => 'Environmental Engineering',
                'description' => 'Environmental systems and pollution control principles.',
                'teacher_ids' => [7]
            ],
            [
                'subject_code' => 'ENVE201',
                'name' => 'Water Treatment',
                'description' => 'Water purification and wastewater treatment technologies.',
                'teacher_ids' => [7]
            ],
            [
                'subject_code' => 'MATE101',
                'name' => 'Materials Science',
                'description' => 'Structure-property relationships in engineering materials.',
                'teacher_ids' => [8]
            ],
            [
                'subject_code' => 'MATE201',
                'name' => 'Nanomaterials',
                'description' => 'Advanced materials and nanotechnology applications.',
                'teacher_ids' => [8]
            ],
            [
                'subject_code' => 'AE101',
                'name' => 'Aerodynamics',
                'description' => 'Principles of flight and aerodynamic design.',
                'teacher_ids' => [9]
            ],
            [
                'subject_code' => 'AE201',
                'name' => 'Aircraft Design',
                'description' => 'Aircraft configuration and performance analysis.',
                'teacher_ids' => [9]
            ],
            [
                'subject_code' => 'BME101',
                'name' => 'Biomechanics',
                'description' => 'Mechanical principles applied to biological systems.',
                'teacher_ids' => [10]
            ],
            [
                'subject_code' => 'BME201',
                'name' => 'Medical Device Design',
                'description' => 'Design principles for healthcare technology and devices.',
                'teacher_ids' => [10]
            ],
            [
                'subject_code' => 'PE101',
                'name' => 'Reservoir Engineering',
                'description' => 'Petroleum reservoir characterization and management.',
                'teacher_ids' => [11]
            ],
            [
                'subject_code' => 'PE201',
                'name' => 'Drilling Technology',
                'description' => 'Oil and gas drilling operations and well design.',
                'teacher_ids' => [11]
            ],
            [
                'subject_code' => 'MINE101',
                'name' => 'Mining Methods',
                'description' => 'Surface and underground mining techniques.',
                'teacher_ids' => [12]
            ],
            [
                'subject_code' => 'MINE201',
                'name' => 'Mineral Processing',
                'description' => 'Ore beneficiation and mineral extraction processes.',
                'teacher_ids' => [12]
            ]
        ];

        foreach ($subjects as $subjectData) {
            $teacherIds = $subjectData['teacher_ids'];
            unset($subjectData['teacher_ids']);
            
            $subject = Subject::create($subjectData);
            
            // Attach teachers to the subject
            $pivotData = [];
            foreach ($teacherIds as $index => $teacherId) {
                $pivotData[$teacherId] = [
                    'is_primary' => ($index === 0), // First teacher is primary
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            
            $subject->teachers()->attach($pivotData);
        }
    }
}
