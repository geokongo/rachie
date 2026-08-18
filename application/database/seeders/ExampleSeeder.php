<?php namespace Seeders;

use Rackage\Seeder;
use Rackage\Security;
// use Models\UserModel;  // Uncomment and import your models

/**
 * Example Seeder
 *
 * This is an example seeder showing common patterns.
 * Copy this file and rename it for your own seeders.
 *
 * Naming Convention:
 *   File: {Name}Seeder.php (e.g., UsersSeeder.php, PostsSeeder.php)
 *   Class: {Name}Seeder (match filename)
 *
 * Usage:
 *   php roline db:seed Example         Run this seeder only
 *   php roline db:seed                 Run all seeders (via DatabaseSeeder)
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 1.0.0
 */
class ExampleSeeder extends Seeder
{
    /**
     * Run the seeder
     *
     * Insert sample data into your database tables.
     * Use truncate() to clear existing data for idempotent seeding.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing data (makes seeder idempotent - safe to run multiple times)
        // $this->truncate('users');
        // $this->truncate(['users', 'posts']);  // Multiple tables

        // Insert sample records
        // UserModel::save([
        //     'username' => 'admin',
        //     'email' => 'admin@example.com',
        //     'password' => Security::hash('password123'),
        //     'role' => 'admin'
        // ]);

        // UserModel::save([
        //     'username' => 'john',
        //     'email' => 'john@example.com',
        //     'password' => Security::hash('password123'),
        //     'role' => 'user'
        // ]);

        // Use transaction for related data
        // $this->transaction(function() {
        //     $userId = UserModel::save(['name' => 'Jane']);
        //     PostModel::save(['user_id' => $userId, 'title' => 'First Post']);
        // });

        // Loop for bulk data
        // for ($i = 1; $i <= 10; $i++) {
        //     UserModel::save([
        //         'username' => 'user' . $i,
        //         'email' => 'user' . $i . '@example.com',
        //         'password' => Security::hash('password123')
        //     ]);
        // }
    }
}
