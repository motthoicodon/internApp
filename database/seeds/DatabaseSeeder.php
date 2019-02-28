<?php

use Illuminate\Database\Seeder;
use App\Model\Project;
use App\Model\Member;
use App\Model\WorksOn;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        \App\User::truncate();
        Member::truncate();
        Project::truncate();
        DB::table('works_on')->truncate();

        $projectsQuantity = 50;
        $membersQuantity = 150;
        $worksOnQuantity = 300;

        factory(Project::class, $projectsQuantity)->create();
        factory(Member::class, $membersQuantity)->create();
        factory(WorksOn::class, $worksOnQuantity)->create();

    }
}
