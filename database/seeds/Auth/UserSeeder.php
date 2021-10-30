<?php

use App\Domains\Auth\Models\User;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder.
 */
class UserSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Add the master administrator, user id of 1
        User::create([
            'id' => 1,
            'type' => 'user',
            'username' => 'admin',
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'password' => 'admin123',
            'email_verified_at' => now(),
            'active' => true,
        ]);
        // $this->enableForeignKeys();
    }
}
