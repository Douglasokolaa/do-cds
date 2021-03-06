<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StateSeeder::class);
        $this->call(LgaSeeder::class);
        $this->call(AclSeeder::class);
        $this->call(ProspectSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProjectSeeder::class);

        if (!app()->environment('production')) {
            $this->call(StateMemberSeeder::class);
            $this->call(ArticleSeeder::class);
            $this->call(EmployerSeeder::class);
            $this->call(EmploymentSeeder::class);
            $this->call(TrainingSeeder::class);
            $this->call(TrainingAttendanceSeeder::class);
            $this->call(TicketSeeder::class);
            $this->call(ProjectMemberSeeder::class);
            $this->call(AnnouncementSeeder::class);
        }
    }
}
