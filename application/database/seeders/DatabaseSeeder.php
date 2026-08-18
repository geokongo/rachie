<?php namespace Seeders;

use Rackage\Seeder;

/**
 * Database Seeder
 *
 * Master seeder that orchestrates all other seeders.
 * This seeder runs first when you execute: php roline db:seed
 *
 * Use the call() method to run your seeders in dependency order.
 * For example, if posts need users to exist, call UsersSeeder first.
 *
 * Usage:
 *   php roline db:seed                 Run this DatabaseSeeder
 *   php roline db:seed Users           Run UsersSeeder only
 *
 * @author Geoffrey Okongo <code@rachie.dev>
 * @copyright Copyright (c) 2015 - 2030 Geoffrey Okongo
 * @license http://opensource.org/licenses/MIT MIT License
 * @version 1.0.0
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeders
     *
     * Call your seeders here in dependency order.
     * Uncomment the examples below and add your own seeders.
     *
     * @return void
     */
    public function run()
    {
        // Call seeders in order
        // Example: Users must exist before posts

        // $this->call(UsersSeeder::class);
        // $this->call(CategoriesSeeder::class);
        // $this->call(PostsSeeder::class);
        // $this->call(CommentsSeeder::class);

        // Or use transactions for related data
        // $this->transaction(function() {
        //     UserModel::save(['name' => 'Admin']);
        //     PostModel::save(['user_id' => 1, 'title' => 'First Post']);
        // });
    }
}
