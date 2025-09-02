<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Teacher;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = [
            [
                'name' => 'Dr. Carlos Santos',
                'email' => 'carlos.santos@prmsu.edu',
                'department' => 'Civil Engineering',
                'phone' => '+63-912-345-6789',
                'bio' => 'Expert in structural engineering and construction management with 18 years of teaching and industry experience.',
                'is_active' => true
            ],
            [
                'name' => 'Prof. Maria Gonzales',
                'email' => 'maria.gonzales@prmsu.edu',
                'department' => 'Mechanical Engineering',
                'phone' => '+63-912-345-6790',
                'bio' => 'Specializes in thermodynamics, fluid mechanics, and machine design. Published researcher with 25+ engineering papers.',
                'is_active' => true
            ],
            [
                'name' => 'Dr. Ahmed Hassan',
                'email' => 'ahmed.hassan@prmsu.edu',
                'department' => 'Electrical Engineering',
                'phone' => '+63-912-345-6791',
                'bio' => 'Power systems and electronics expert with expertise in renewable energy and smart grid technologies.',
                'is_active' => true
            ],
            [
                'name' => 'Prof. Jennifer Lee',
                'email' => 'jennifer.lee@prmsu.edu',
                'department' => 'Computer Engineering',
                'phone' => '+63-912-345-6792',
                'bio' => 'Computer architecture and embedded systems specialist with focus on IoT and AI applications.',
                'is_active' => true
            ],
            [
                'name' => 'Dr. David Kim',
                'email' => 'david.kim@prmsu.edu',
                'department' => 'Chemical Engineering',
                'phone' => '+63-912-345-6793',
                'bio' => 'Process engineering and materials science expert with research in sustainable chemical processes.',
                'is_active' => true
            ],
            [
                'name' => 'Prof. Isabella Martinez',
                'email' => 'isabella.martinez@prmsu.edu',
                'department' => 'Industrial Engineering',
                'phone' => '+63-912-345-6794',
                'bio' => 'Operations research and systems optimization specialist with extensive industry collaboration experience.',
                'is_active' => true
            ],
            [
                'name' => 'Dr. Ryan Thompson',
                'email' => 'ryan.thompson@prmsu.edu',
                'department' => 'Environmental Engineering',
                'phone' => '+63-912-345-6795',
                'bio' => 'Environmental systems and sustainability expert with focus on water treatment and pollution control.',
                'is_active' => true
            ],
            [
                'name' => 'Prof. Sofia Rodriguez',
                'email' => 'sofia.rodriguez@prmsu.edu',
                'department' => 'Materials Engineering',
                'phone' => '+63-912-345-6796',
                'bio' => 'Advanced materials and nanotechnology researcher with expertise in composite materials and biomaterials.',
                'is_active' => true
            ],
            [
                'name' => 'Dr. Kevin Chen',
                'email' => 'kevin.chen@prmsu.edu',
                'department' => 'Aerospace Engineering',
                'phone' => '+63-912-345-6797',
                'bio' => 'Aerodynamics and flight mechanics specialist with experience in aircraft design and propulsion systems.',
                'is_active' => true
            ],
            [
                'name' => 'Prof. Ana Silva',
                'email' => 'ana.silva@prmsu.edu',
                'department' => 'Biomedical Engineering',
                'phone' => '+63-912-345-6798',
                'bio' => 'Medical device design and biomechanics expert with focus on healthcare technology innovation.',
                'is_active' => true
            ],
            [
                'name' => 'Dr. Miguel Torres',
                'email' => 'miguel.torres@prmsu.edu',
                'department' => 'Petroleum Engineering',
                'phone' => '+63-912-345-6799',
                'bio' => 'Reservoir engineering and drilling technology specialist with extensive oil and gas industry experience.',
                'is_active' => true
            ],
            [
                'name' => 'Prof. Lisa Wang',
                'email' => 'lisa.wang@prmsu.edu',
                'department' => 'Mining Engineering',
                'phone' => '+63-912-345-6800',
                'bio' => 'Mining operations and mineral processing expert with focus on sustainable mining practices.',
                'is_active' => true
            ]
        ];

        foreach ($teachers as $teacher) {
            Teacher::create($teacher);
        }
    }
}
