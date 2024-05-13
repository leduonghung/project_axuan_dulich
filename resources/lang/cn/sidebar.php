<?php
return [
    [
        'name' => ['用户'],
        'title' => '管理会员',
        'icon' => 'mdi mdi-note-multiple',
        'subModule' => [
            [
                'title' => '会员管理',
                'route' => 'admin.user'
            ],
            [
                'title' => '添加新成员',
                'route' => 'admin.user.create'
            ],
        ]
    ],
    [
        'name' => ['帖子'],
        'title' => '文章管理',
        'icon' => 'mdi mdi-note-multiple',
        'subModule' => [
            [
                'title' => '文章类别',
                'route' => 'admin.post.catalogue'
            ],
            [
                'title' => '添加新文章组',
                'route' => 'admin.post.catalogue.create'
            ],
            [
                'title' => '文章',
                'route' => 'admin.post'
            ],
            [
                'title' => '添加新帖子',
                'route' => 'admin.post.create'
            ],
        ]
    ],
    [
        'name' => ['设置'],
        'title' => '通用配置',
        'icon' => 'mdi mdi-note-multiple',
        'subModule' => [
            [
                'title' => '语言管理',
                'route' => 'admin.setting.language'
            ],
            [
                'title' => '文章',
                'route' => 'admin.post'
            ],
        ]
    ]
];
