<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = [
            [
                'name' => 'kaii',
                'major' => 'Informatika',
                'age' => 20,
                'course' => ['Pemrograman Web', 'Database', 'Cloud Computing']
            ],
            [
                'name' => 'younglex',
                'major' => 'Sistem Informasi',
                'age' => 21,
                'course' => ['UI/UX Designer', 'Manajemen Proyek', 'IoT']
            ],
        ];

        return view('students.index', compact('students'));
    }
}

