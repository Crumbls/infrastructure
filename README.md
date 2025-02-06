# Crumbls Infrastructure Mapping Tool

## Overview
A Laravel package for mapping and visualizing infrastructure relationships using Vis.js Newton Graph.

## Features
- Dynamic infrastructure node management
- Server, database, and site type support
- Nested relationship tracking
- Filament admin interface
- Livewire integration
- Visual infrastructure mapping

## Requirements
- Laravel 9+
- Filament
- Livewire
- Vis.js

## Installation
```bash
composer require crumbls/infrastructure
php artisan migrate
php artisan vendor:publish --provider="Crumbls\Infrastructure\InfrastructureServiceProvider"
```

## Usage
I recommend looking at InfrastructureSeeder
### Creating Nodes
```php
use Crumbls\Infrastructure\Models\Node;

$server = Node::create([
    'name' => 'Web Server 01',
    'type' => 'server',
    'status' => 'operational'
]);
```

### Visualizing Infrastructure
Access the infrastructure map through the Filament admin panel.

## License
MIT License

## Author
Chase C. Miller  
[Crumbls](https://crumbls.com)  
chase@crumbls.com

## Contributing
Contributions welcome. Please submit pull requests or open issues on our GitHub repository.
