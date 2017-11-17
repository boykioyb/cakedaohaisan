<?php

$config['S'] = [
    'Menus' => [
        [// Dashboard
            'name' => __('Dashboard'),
            'icon' => 'fa fa-th-large',
            'controller' => 'Dashboard',
            'action' => 'index'
        ],
        [// Settings
            'name' => __('Settings'),
            'icon' => 'fa fa-cogs',
            'child' => [
                [// Configuration
                    'name' => __('Configure'),
                    'controller' => 'Settings',
                    'action' => 'add'
                ],
                [// Blocks
                    'name' => 'Module sidebar',
                    'controller' => 'Blocks',
                    'action' => 'index'
                ],
                [// slideshow
                    'name' => 'Slider',
                    'controller' => 'Slideshows',
                    'action' => 'index'
                ],
                [// videos
                    'name' => 'Videos',
                    'controller' => 'Videos',
                    'action' => 'index'
                ],
                [// ads
                    'name' => 'Ads',
                    'controller' => 'Ads',
                    'action' => 'index'
                ],
                [// Menus
                    'name' => __('Menus'),
                    'controller' => 'MenuNodes',
                    'action' => 'index'
                ],
                [// Country
                    'name' => __('Countries'),
                    'controller' => 'Countries',
                    'action' => 'index'
                ],
                [// Danh sách các tỉnh thành phố
                    'name' => 'Regions',
                    'controller' => 'Regions',
                    'action' => 'index'
                ],
                [// Danh sách liên hệ
                    'name' => 'Liên hệ',
                    'controller' => 'Contacts',
                    'action' => 'index'
                ],
            ]
        ],
        [// Tin Tức
            'name' => 'Quản lý tin tức',
            'icon' => 'fa fa-newspaper-o',
            'child' => [
                [// Topic
                    'name' => 'Danh mục',
                    'controller' => 'Categories',
                    'action' => 'index',
                    '?' => array(
                        'object_type_code' => 'news'
                    )
                ],
                [// Blog
                    'name' => 'Danh sách tin tức',
                    'controller' => 'News',
                    'action' => 'index'
                ],
                [// feedbacks
                    'name' => 'Danh sách Feedback',
                    'controller' => 'Feedbacks',
                    'action' => 'index'
                ],
            ]
        ],
        [// So tay quang cao
            'name' => 'Sổ tay quảng cáo',
            'icon' => 'fa fa-book',
            'child' => [
                [// Topic
                    'name' => 'Danh mục',
                    'controller' => 'Categories',
                    'action' => 'index',
                    '?' => array(
                        'object_type_code' => 'notebooks'
                    )
                ],
                [// Blog
                    'name' => 'Danh sách sổ tay quảng cáo',
                    'controller' => 'Notebooks',
                    'action' => 'index'
                ],
            ]
        ],
        [// Văn bản chính quy
            'name' => 'Văn bản chính quy',
            'icon' => 'fa fa-file-word-o',
            'child' => [
                [// Topic
                    'name' => 'Danh mục',
                    'controller' => 'Categories',
                    'action' => 'index',
                    '?' => array(
                        'object_type_code' => 'documents'
                    )
                ],
                [// Blog
                    'name' => 'Danh sách Văn bản chính quy',
                    'controller' => 'Documents',
                    'action' => 'index'
                ],
            ]
        ],
        [// Hiệp hội
            'name' => 'Hiệp hội',
            'icon' => 'fa fa-university',
            'child' => [
                [// Nhiệm vụ
                    'name' => 'Nhiệm vụ',
                    'controller' => 'Missions',
                    'action' => 'index'
                ],
                [// Thành viên
                    'name' => 'Thành viên',
                    'controller' => 'Members',
                    'action' => 'index'
                ],
            ]
        ],
        [// page
            'name' => 'Quản lý Page',
            'icon' => 'fa fa-bars',
            'child' => [
                [// Danh sách cán bộ
                    'name' => 'Danh sách page',
                    'controller' => 'Pages',
                    'action' => 'index'
                ],
            ]
        ],
        [// user
            'name' => __('User Manager'),
            'icon' => 'fa fa-user',
            'child' => [
                [// User
                    'name' => __('User'),
                    'controller' => 'Users',
                    'action' => 'index'
                ],
                [// User Group
                    'name' => __('User Group'),
                    'controller' => 'UserGroups',
                    'action' => 'index'
                ],
                [// User Group Permission
                    'name' => __('User Group Permission'),
                    'controller' => 'UserGroupPermissions',
                    'action' => 'index'
                ],
            ]
        ],
        [// VaaMembers
            'name' => __('member_manager'),
            'icon' => 'fa fa-user',
            'child' => [
                [// User
                    'name' => __('member_manager'),
                    'controller' => 'VaaMembers',
                    'action' => 'index'
                ],
                [
                    'name' => __('member_devices_manager'),
                    'controller' => 'VaaMemberDevices',
                    'action' => 'index'
                ]
            ]
        ],
        [// Discussions
            'name' => __('discussion_manager'),
            'icon' => 'fa fa-comments',
            'child' => [
                [// User
                    'name' => __('discussion_manager'),
                    'controller' => 'Discussions',
                    'action' => 'index'
                ]
            ]
        ],
        [// Files
            'name' => __('file_manager'),
            'icon' => 'fa fa-file',
            'child' => [
                [// User
                    'name' => __('file_manager'),
                    'controller' => 'VaaFiles',
                    'action' => 'index'
                ]
            ]
        ],
        [// Post
            'name' => __('post_manager'),
            'icon' => 'fa fa-book',
            'child' => [
                [// User
                    'name' => __('post_manager'),
                    'controller' => 'VaaPosts',
                    'action' => 'index'
                ],
                [
                    'name' => __('post_like_manager'),
                    'controller' => 'VaaPostLikes',
                    'action' => 'index'
                ],
                [
                    'name' => __('post_share_manager'),
                    'controller' => 'VaaPostShares',
                    'action' => 'index'
                ],
                [
                    'name' => __('post_comment_manager'),
                    'controller' => 'VaaPostComments',
                    'action' => 'index'
                ],
            ]
        ],
        [// stories
            'name' => __('stories_manager'),
            'icon' => 'fa fa-info-circle',
            'child' => [
                [// stories
                    'name' => __('stories_manager'),
                    'controller' => 'VaaStories',
                    'action' => 'index'
                ],
                [// stories like
                    'name' => __('stories_like_manager'),
                    'controller' => 'VaaStoryLikes',
                    'action' => 'index'
                ],
                [// stories share
                    'name' => __('stories_share_manager'),
                    'controller' => 'VaaStoryShares',
                    'action' => 'index'
                ],
                [// stories comment
                    'name' => __('stories_comment_manager'),
                    'controller' => 'VaaStoryComments',
                    'action' => 'index'
                ],
            ]
        ],
        [// stories
            'name' => __('room_manager'),
            'icon' => 'fa fa-users',
            'child' => [
                [// stories
                    'name' => __('room_manager'),
                    'controller' => 'VaaRooms',
                    'action' => 'index'
                ],
            ]
        ],
        [// stories
            'name' => __('message_manager'),
            'icon' => 'fa fa-users',
            'child' => [
                [// stories
                    'name' => __('message_manager'),
                    'controller' => 'VaaMessages',
                    'action' => 'index'
                ],
            ]
        ],
    ],
    'Lang' => [
        'vi' => __('Vietnamese'),
        'en' => __('English'),
    ],
    'Lang_code_default' => 'vi',
];
