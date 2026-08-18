<?php namespace Seeders;

use Rackage\Seeder;
use Models\ListModel;

class ListSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data for idempotent seeding
        $this->truncate('lists');

        // Insert sample list items
        ListModel::save([
            'title' => 'Complete project documentation',
            'description' => 'Write comprehensive docs for the new seeder functionality',
            'status' => 'pending',
            'priority' => 'high'
        ]);

        ListModel::save([
            'title' => 'Review pull requests',
            'description' => 'Review and merge outstanding PRs from team members',
            'status' => 'pending',
            'priority' => 'medium'
        ]);

        ListModel::save([
            'title' => 'Update dependencies',
            'description' => 'Update composer packages to latest stable versions',
            'status' => 'completed',
            'priority' => 'low'
        ]);

        ListModel::save([
            'title' => 'Write unit tests',
            'description' => 'Add test coverage for new Seeder base class',
            'status' => 'pending',
            'priority' => 'high'
        ]);

        ListModel::save([
            'title' => 'Deploy to staging',
            'description' => null,
            'status' => 'pending',
            'priority' => 'medium'
        ]);
    }
}
