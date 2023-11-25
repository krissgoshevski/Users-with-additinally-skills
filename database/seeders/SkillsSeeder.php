<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class SkillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = ["PHP", "HTML", "CSS", "Javascript", "Python", "Laravel"];
        foreach ($skills as $skill) {   
            \DB::table("skills")->insert([
                "name"=> $skill,
            ]);

        }
    }
}
