<?php

namespace Crumbls\Infrastructure\Database\Factories;

use Crumbls\Infrastructure\Models\Node;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory for creating infrastructure nodes with proper parent-child relationships
 */
class NodeFactory extends Factory
{
    protected $model = Node::class;

    /**
     * Default state creates a server node
     */
    public function definition()
    {
        return [
            'name' => fake()->domainName(),
            'type' => 'server',
            'status' => 'operational',
            'metadata' => []
        ];
    }

    /**
     * Configure the model factory
     * Automatically creates child sites for infrastructure nodes
     */
    public function configure()
    {
        return $this->afterCreating(function (Node $node) {
            // Only create child sites for infrastructure nodes (servers/databases)
            if ($node->type === 'server' || $node->type === 'database') {
                // Create 3-5 random sites connected to this infrastructure
                Node::factory()
                    ->count(fake()->numberBetween(3, 5))
                    ;
            }
        });
    }

    /**
     * Create a site node
     * 90% chance of operational status, 10% chance of warning/error
     */
    public function site()
    {
        return $this->state(function (array $attributes) {
            $isOperational = fake()->boolean(90);
            $errorMessages = [
                'Error 503: Service Unavailable',
                'SSL Certificate Expired',
                'Error 504: Gateway Timeout',
                'DNS Resolution Failed',
                'Connection Refused',
                'Database Connection Error',
                'Memory Limit Exceeded',
                'CPU Usage Critical'
            ];

            return [
                'name' => 'site-' . fake()->domainName(),
                'type' => 'site',
                'status' => $isOperational ? 'operational' : (fake()->boolean() ? 'error' : 'warning'),
                'metadata' => $isOperational ? [] : ['error' => fake()->randomElement($errorMessages)]
            ];
        });
    }

    /**
     * Create a server node with server-specific metadata
     */
    public function server()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'server-' . fake()->word() . '-' . fake()->numberBetween(1, 999),
                'type' => 'server',
                'metadata' => [
                    'ip' => fake()->ipv4(),
                    'location' => fake()->city(),
                    'cpu_cores' => fake()->numberBetween(4, 32),
                    'ram_gb' => fake()->randomElement([16, 32, 64, 128])
                ]
            ];
        });
    }

    /**
     * Create a database node with database-specific metadata
     */
    public function database()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'db-' . fake()->word() . '-' . fake()->numberBetween(1, 999),
                'type' => 'database',
                'metadata' => [
                    'engine' => fake()->randomElement(['MySQL', 'PostgreSQL', 'MongoDB']),
                    'version' => fake()->semver(),
                    'size_gb' => fake()->numberBetween(100, 1000)
                ]
            ];
        });
    }
}
