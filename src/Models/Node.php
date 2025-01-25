<?php

namespace Crumbls\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Node extends Model
{
    use NodeTrait;

    protected $table = 'infrastructure_nodes';

    protected $fillable = [
        'name',
        'type',
        'status',
        'metadata',
        'parent_id'
    ];

    protected $casts = [
        'metadata' => 'array',
        'status' => 'string'
    ];

    public function parents()
    {
        return $this->belongsToMany(Node::class, 'infrastructure_node_relations', 'child_id', 'parent_id');
    }

    public function children()
    {
        return $this->belongsToMany(Node::class, 'infrastructure_node_relations', 'parent_id', 'child_id');
    }
}
