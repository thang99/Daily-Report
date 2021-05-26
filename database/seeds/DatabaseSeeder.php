<?php

use Illuminate\Database\Seeder;
use App\Models\Division;
use App\Models\Follow;
use App\Models\Position;
use App\Models\Report;
use App\Models\User;
use App\Models\PositionDivision;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([RoleSeeder::class]);
        factory(Division::class, 10)->create();
        factory(Position::class, 10)->create();
        factory(PositionDivision::class, 10)->create();
        factory(User::class, 10)->create();
        factory(Report::class, 10)->create();
        factory(Follow::class, 10)->create();

    }
}
