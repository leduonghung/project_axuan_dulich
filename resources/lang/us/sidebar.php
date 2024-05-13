<?php
return [
    [
        'name' => ['user'],
        'title' => 'Manage members',
        'icon' => 'mdi mdi-note-multiple',
        'subModule' => [
            [
                'title' => 'Membership Management',
                'route' => 'admin.user'
            ],
            [
                'title' => 'Add new member',
                'route' => 'admin.user.create'
            ],
        ]
    ],
    [
        'name' => ['post'],
        'title' => 'Article management',
        'icon' => 'mdi mdi-note-multiple',
        'subModule' => [
            [
                'title' => 'Article category',
                'route' => 'admin.post.catalogue'
            ],
            [
                'title' => 'Add new article group',
                'route' => 'admin.post.catalogue.create'
            ],
            [
                'title' => 'Article',
                'route' => 'admin.post'
            ],
            [
                'title' => 'Add new post',
                'route' => 'admin.post.create'
            ],
        ]
    ],
    [
        'name' => ['setting'],
        'title' => 'General configuration',
        'icon' => 'mdi mdi-note-multiple',
        'subModule' => [
            [
                'title' => 'Language Management',
                'route' => 'admin.setting.language'
            ],
            [
                'title' => 'Article',
                'route' => 'admin.post'
            ],
        ]
    ]
];
