# Crumbls Infrastructure

A Laravel package for creating and visualizing infrastructure maps with support for multi-parent hierarchies.

## Installation

```bash
composer require crumbls/infrastructure
```

## Features

- Multi-parent node hierarchies
- Infrastructure status tracking
- Visual infrastructure mapping
- Nested set implementation
- Flexible node metadata storage

## Basic Usage

```php
use Crumbls\Infrastructure\Models\Node;

// Create a server node
$server = Node::create([
    'name' => 'Primary Server',
    'type' => 'server',
    'status' => 'operational',
    'metadata' => [
        'ip' => '192.168.1.1',
        'location' => 'us-east-1'
    ]
]);

// Add child nodes
$database = Node::create([
    'name' => 'Main Database',
    'type' => 'database',
    'status' => 'operational'
]);

$server->children()->attach($database->id);
```

## Configuration

Publish the configuration:

```bash
php artisan vendor:publish --provider="Crumbls\Infrastructure\InfrastructureServiceProvider"
```

## License

MIT License
