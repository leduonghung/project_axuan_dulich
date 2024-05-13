<?php
return [
    [
        'name' => ['user'],
        'title' => 'Quản lý thành viên',
        'icon'=>'mdi mdi-note-multiple',
        'subModule'=>[
            [
                'title'=>'Quản lý thành viên',
                'route'=>'admin.user'
            ],
            [
                'title'=>'Thêm mới thành viên',
                'route'=>'admin.user.create'
            ],
        ]
    ],
    [
        'name' =>['post'],
        'title'=>'QL bài viết',
        'icon'=>'mdi mdi-note-multiple',
        'subModule'=>[
            [
                'title'=>'Danh mục bài viết',
                'route'=>'admin.post.catalogue'
            ],
            [
                'title'=>'Thêm mới nhóm bài viết',
                'route'=>'admin.post.catalogue.create'
            ],
            [
                'title'=>'Bài viết',
                'route'=>'admin.post'
            ],
            [
                'title'=>'Thêm mới bài viết',
                'route'=>'admin.post.create'
            ],
        ]
    ],
    [
        'name' =>['setting'],
        'title'=>'Cấu hình chung',
        'icon'=>'mdi mdi-note-multiple',
        'subModule'=>[
            [
                'title'=>'QL ngôn ngữ',
                'route'=>'admin.setting.language'
            ],
            [
                'title'=>'Bài viết',
                'route'=>'admin.post'
            ],
        ]
    ]
];
