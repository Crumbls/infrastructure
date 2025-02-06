<?php

namespace Crumbls\Infrastructure\Database\Seeders;

use Crumbls\Infrastructure\Models\Node;
use Illuminate\Database\Seeder;

class
InfrastructureSeeder extends Seeder
{
    /**
     * Seed the database with infrastructure-related nodes.
     *
     * This seeder does the following:
     * 1. Creates 3 server nodes
     * 2. Creates 3 database nodes
     * 3. Creates 10 new site nodes
     * 4. Attaches random server and database nodes to each site
     * 5. Propagates site status to parent nodes if not operational
     */
    public function run()
    {
        // Create 3 server nodes using the Node factory
        $servers = Node::factory()->count(3)->server()->create();

        // Create 3 database nodes using the Node factory
        $databases = Node::factory()->count(3)->database()->create();

        // Create 10 new site nodes and set up their relationships
        Node::factory()->count(10)->site()->create()->each(function($site) use ($servers, $databases) {
            // Attach a random server and database to each site
            $site->parents()->attach([
                $servers->random()->id,
                $databases->random()->id
            ]);

            // If the site is not operational, update the status of its parent nodes
            if ($site->status !== 'operational') {
                $parents = $site->parents;
                $parents->each(function($parent) use ($site) {
                    // Propagate the site's non-operational status to its parent nodes
                    $parent->status = $site->status;
                    $parent->save();
                });
            }
        });
    }
}
