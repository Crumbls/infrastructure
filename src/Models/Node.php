<?php

namespace Crumbls\Infrastructure\Models;

use Crumbls\Infrastructure\Database\Factories\NodeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Node extends Model
{
    use NodeTrait,
        HasFactory;

    // Specify custom table name for infrastructure nodes
    protected $table = 'infrastructure_nodes';

    // Attributes that can be mass-assigned
    protected $fillable = [
        'name',       // Node's name/identifier
        'type',       // Type of node (e.g., server, database, site)
        'status',     // Current status of the node
        'metadata',   // Additional node-specific information
        'parent_id'   // ID of the parent node
    ];

    // Cast certain attributes to specific types
    protected $casts = [
        'metadata' => 'array',  // Store metadata as a JSON array
        'status' => 'string'    // Ensure status is always a string
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return NodeFactory
     */
    protected static function newFactory()
    {
        return NodeFactory::new();
    }

    /**
     * Many-to-many relationship with parent nodes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function parents()
    {
        // Relationship through infrastructure_node_relations pivot table
        return $this->belongsToMany(Node::class, 'infrastructure_node_relations', 'child_id', 'parent_id');
    }

    /**
     * Many-to-many relationship with child nodes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function children()
    {
        // Relationship through infrastructure_node_relations pivot table
        return $this->belongsToMany(Node::class, 'infrastructure_node_relations', 'parent_id', 'child_id');
    }
}
