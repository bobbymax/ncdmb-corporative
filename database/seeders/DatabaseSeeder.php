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
        // \App\Models\User::factory(10)->create();
        \App\Models\Member::factory(1)->create();
        \App\Models\Budget::factory(1)->create();
        \App\Models\Category::factory(2)->create();
        \App\Models\Contribution::factory(1)->create();
        \App\Models\Expenditure::factory(3)->create();
        \App\Models\Wallet::factory(1)->create();
        // \App\Models\Group::factory(3)->create();
        \App\Models\Loan::factory(1)->create();
        // \App\Models\Guarantor::factory(3)->create();
        // \App\Models\Investment::factory(3)->create();
        \App\Models\Kin::factory(1)->create();
        // \App\Models\Permission::factory(3)->create();
        \App\Models\Role::factory(1)->create();
        // \App\Models\Schedule::factory(3)->create();
        // \App\Models\Service::factory(3)->create();
        // \App\Models\Specification::factory(3)->create();
    }
}
