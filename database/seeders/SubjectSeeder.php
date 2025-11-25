<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data - delete from pivot table first due to foreign key constraints
        DB::table('teacher_subject')->delete();
        DB::table('subjects')->delete();
        
        $subjects = [
            // ELECTRICAL ENGINEERING
            [
                'subject_code' => 'EE101',
                'name' => 'Fundamental Engineering Mathematics',
                'program' => 'Electrical Engineering',
                'description' => 'Fundamental mathematical concepts and techniques for electrical engineering applications.',
                'is_active' => true
            ],
            [
                'subject_code' => 'EE102',
                'name' => 'Engineering Data Analysis',
                'program' => 'Electrical Engineering',
                'description' => 'Statistical methods and data analysis techniques for engineering problems.',
                'is_active' => true
            ],
            [
                'subject_code' => 'EE103',
                'name' => 'Fluid Mechanics',
                'program' => 'Electrical Engineering',
                'description' => 'Principles of fluid behavior and hydraulic systems in electrical engineering context.',
                'is_active' => true
            ],
            [
                'subject_code' => 'EE104',
                'name' => 'Electrical Systems Design',
                'program' => 'Electrical Engineering',
                'description' => 'Design principles and methodologies for electrical power systems.',
                'is_active' => true
            ],
            [
                'subject_code' => 'EE105',
                'name' => 'Illumination Engineering Design',
                'program' => 'Electrical Engineering',
                'description' => 'Lighting system design, photometry, and illumination engineering principles.',
                'is_active' => true
            ],
            
            // COMPUTER ENGINEERING
            [
                'subject_code' => 'CPE101',
                'name' => 'Computer Engineering as a Discipline',
                'program' => 'Computer Engineering',
                'description' => 'Introduction to computer engineering field, scope, and professional practice.',
                'is_active' => true
            ],
            [
                'subject_code' => 'CPE102',
                'name' => 'Fundamentals of Electrical Circuits',
                'program' => 'Computer Engineering',
                'description' => 'Basic electrical circuit theory and analysis for computer engineers.',
                'is_active' => true
            ],
            [
                'subject_code' => 'CPE103',
                'name' => 'Fundamental of Mixed Signals and Sensors',
                'program' => 'Computer Engineering',
                'description' => 'Analog and digital signal processing, sensor technologies, and mixed-signal systems.',
                'is_active' => true
            ],
            [
                'subject_code' => 'CPE104',
                'name' => 'Computer Architecture and Organization',
                'program' => 'Computer Engineering',
                'description' => 'Computer system architecture, organization, and design principles.',
                'is_active' => true
            ],
            [
                'subject_code' => 'CPE105',
                'name' => 'Embedded System',
                'program' => 'Computer Engineering',
                'description' => 'Design and development of embedded systems and microcontroller applications.',
                'is_active' => true
            ],
            
            // MECHANICAL ENGINEERING
            [
                'subject_code' => 'ME101',
                'name' => 'Engineering Drawing',
                'program' => 'Mechanical Engineering',
                'description' => 'Technical drawing, CAD, and engineering graphics for mechanical design.',
                'is_active' => true
            ],
            [
                'subject_code' => 'ME102',
                'name' => 'Basic Electrical Engineering',
                'program' => 'Mechanical Engineering',
                'description' => 'Fundamental electrical principles and applications for mechanical engineers.',
                'is_active' => true
            ],
            [
                'subject_code' => 'ME103',
                'name' => 'DC and AC Machinery',
                'program' => 'Mechanical Engineering',
                'description' => 'Direct current and alternating current machines, motors, and generators.',
                'is_active' => true
            ],
            [
                'subject_code' => 'ME104',
                'name' => 'Power Plant Design with Renewable Energy',
                'program' => 'Mechanical Engineering',
                'description' => 'Power plant design incorporating renewable energy sources and sustainable practices.',
                'is_active' => true
            ],
            [
                'subject_code' => 'ME105',
                'name' => 'Industrial Plant Engineering',
                'program' => 'Mechanical Engineering',
                'description' => 'Industrial facility design, plant layout, and manufacturing systems engineering.',
                'is_active' => true
            ],
            
            // MINING ENGINEERING
            [
                'subject_code' => 'MINE101',
                'name' => 'Fundamental Engineering Mathematics',
                'program' => 'Mining Engineering',
                'description' => 'Mathematical foundations and applications in mining engineering.',
                'is_active' => true
            ],
            [
                'subject_code' => 'MINE102',
                'name' => 'Underground Mining',
                'program' => 'Mining Engineering',
                'description' => 'Underground mining methods, techniques, and safety practices.',
                'is_active' => true
            ],
            [
                'subject_code' => 'MINE103',
                'name' => 'Mechanics of Deformable Bodies',
                'program' => 'Mining Engineering',
                'description' => 'Stress, strain, and deformation analysis of materials and structures.',
                'is_active' => true
            ],
            [
                'subject_code' => 'MINE104',
                'name' => 'Mine Research and Study',
                'program' => 'Mining Engineering',
                'description' => 'Research methodologies and case studies in mining engineering.',
                'is_active' => true
            ],
            [
                'subject_code' => 'MINE105',
                'name' => 'Mine Management',
                'program' => 'Mining Engineering',
                'description' => 'Mining operations management, planning, and optimization strategies.',
                'is_active' => true
            ],
            
            // CIVIL ENGINEERING
            [
                'subject_code' => 'CE101',
                'name' => 'Structural Engineering',
                'program' => 'Civil Engineering',
                'description' => 'Analysis and design of structures, load calculations, and structural systems.',
                'is_active' => true
            ],
            [
                'subject_code' => 'CE102',
                'name' => 'Geotechnical Engineering',
                'program' => 'Civil Engineering',
                'description' => 'Soil mechanics, foundation design, and geotechnical analysis.',
                'is_active' => true
            ],
            [
                'subject_code' => 'CE103',
                'name' => 'Construction Management',
                'program' => 'Civil Engineering',
                'description' => 'Project management, scheduling, and construction operations management.',
                'is_active' => true
            ],
            [
                'subject_code' => 'CE104',
                'name' => 'Surveying and Transportation Engineering',
                'program' => 'Civil Engineering',
                'description' => 'Land surveying techniques and transportation infrastructure design.',
                'is_active' => true
            ],
            [
                'subject_code' => 'CE105',
                'name' => 'Surveying and Survey Camp',
                'program' => 'Civil Engineering',
                'description' => 'Practical surveying exercises and field survey camp activities.',
                'is_active' => true
            ],
        ];

        foreach ($subjects as $subjectData) {
            Subject::create($subjectData);
        }
    }
}
