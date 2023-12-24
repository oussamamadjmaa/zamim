<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        School::create([
            'email' => 'school@zamim.test',
            'password' => bcrypt('secret'),

            'city' => 'الرياض',
            'name' => 'مدرسة الهدى',
            'accreditation_number' => fake('ar_SA')->companyIdNumber(),
            'mod_name' => 'أسامة مجمع',
            'id_number' => fake('ar_SA')->idNumber(),
        ]);
    }
}
