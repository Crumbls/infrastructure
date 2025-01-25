<?php

return [
    // Layout wrapper for the infrastructure map view
    'view' => [
        'layout' => 'layouts.app',  // Default Laravel layout
        'section' => 'content',     // Content section name
        'standalone' => false       // If true, uses no layout wrapper
    ],

    'layout' => [
        // Layout engine: 'force', 'hierarchical', 'circular'
        'type' => 'force',

        'force' => [
            'gravitationalConstant' => -2000,
            'springLength' => 150,
            'springConstant' => 0.04,
            'damping' => 0.09,
        ],

        'hierarchical' => [
            'direction' => 'UD', // UD = Up-Down, DU = Down-Up, LR = Left-Right
            'sortMethod' => 'directed',
            'levelSeparation' => 150,
            'nodeSpacing' => 100
        ],

        'circular' => [
            'radius' => null, // Auto-calculated if null
            'rotationAngle' => 0,
            'nodeSpacing' => 100
        ]
    ],

    'nodes' => [
        'types' => [
            'server' => [
                'shape' => 'box',
                'size' => 25,
                'color' => '#1a73e8'
            ],
            'database' => [
                'shape' => 'database',
                'size' => 25,
                'color' => '#34a853'
            ],
            'site' => [
                'shape' => 'dot',
                'size' => 16,
                'color' => '#4285f4'
            ]
        ],

        'statuses' => [
            'operational' => '#00ff00',
            'warning' => '#ffff00',
            'error' => '#ff0000',
            'maintenance' => '#ffa500'
        ]
    ]
];
