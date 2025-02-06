<?php
return [
    'view' => [
        'standalone' => true
    ],

    'layout' => [
        'type' => 'hierarchical',
        'force' => [
            'gravitationalConstant' => -2000,
            'springLength' => 150,
            'springConstant' => 0.04,
            'damping' => 0.09,
        ],
        'hierarchical' => [
            'direction' => 'LR',
            'sortMethod' => 'directed',
            'levelSeparation' => 250,
            'nodeSpacing' => 100
        ],
        'circular' => [
            'radius' => null,
            'rotationAngle' => 0,
            'nodeSpacing' => 100
        ]
    ],

    'visualization' => [
        'height' => '70vh',
        'border' => '1px solid rgb(var(--gray-200))',
        'borderRadius' => '0.5rem',

        'nodes' => [
            'font' => [
                'color' => '#000000',
                'size' => 14
            ],
            'borderWidth' => 2,
            'shadow' => true
        ],

        'edges' => [
            'width' => 2,
            'smooth' => [
                'type' => 'cubicBezier',
                'forceDirection' => 'horizontal'
            ]
        ],

        'physics' => [
    'enabled' => false,  // Disable physics for hierarchical layout
            'stabilization' => false
        ],

        'layout' => [
    'hierarchical' => [
        'enabled' => true,
        'direction' => 'LR',
        'sortMethod' => 'directed',
        'levelSeparation' => 250,
        'nodeSpacing' => 100,
        'treeSpacing' => 200
    ]
],

        'interaction' => [
    'hover' => true,
    'multiselect' => true,
    'dragNodes' => true
]
    ],

    'nodes' => [
    'types' => [
        'server' => [
            'shape' => 'box',
            'size' => 30
        ],
        'database' => [
            'shape' => 'database',
            'size' => 30
        ],
        'site' => [
            'shape' => 'dot',
            'size' => 20
        ]
    ],
    'statuses' => [
        'operational' => '#10b981',
        'warning' => '#eab308',
        'error' => '#ef4444',
        'maintenance' => '#6366f1'
    ]
]
];
