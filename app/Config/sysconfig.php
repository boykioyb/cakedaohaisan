<?php

//Đặc quyền
if (!defined("USER_TYPE_SUPER_ADMIN"))
    define("USER_TYPE_SUPER_ADMIN", "1");
// Toàn quyền trừ đặc biệt
if (!defined("USER_TYPE_ADMIN"))
    define("USER_TYPE_ADMIN", "2");
//chỉ có quyền trong data và User của mình
if (!defined("USER_TYPE_USER_ADMIN"))
    define("USER_TYPE_USER_ADMIN", "3");
//User thường
if (!defined("USER_TYPE_USER"))
    define("USER_TYPE_USER", "4");
//Visitor
if (!defined("USER_TYPE_VISITOR"))
    define("USER_TYPE_VISITOR", "5");
if (!defined("EXTERNAL_LINK"))
    define("EXTERNAL_LINK", 'CustomLink');
if (!defined("FILE_MANAGER_SECRET")) {
    define("FILE_MANAGER_SECRET", 'aa12DZW#$a!@');
}

$config['sysconfig'] = array(
    'App' => array(
        'search_status' => array(
            '0' => __('Không thành công'),
            '1' => __('Thành công'),
            '2' => __('Lỗi'),
        ),
        'password_length' => 6,
        'day_per_month' => 30,
        'status' => array(
            0 => 'Chưa công bố',
            1 => 'Xuất bản',
        ),
        'max_video_file_size_upload' => 200000000, // 200mb
        'video_upload_types' => 'mp4|ogg',
        'is_hot' => array(
            0 => 'Không',
            1 => 'Có'
        ),
        'feature' => array(
            0 => 'Không',
            1 => 'Có'
        ),
        'status_full' => array(
            -1 => __('status_rejected'),
            0 => __('status_hidden'),
            1 => __('status_wait_review'),
            2 => __('status_approved'),
            3 => __('status_schedule'),
        ),
        'status_regions' => array(
            0 => 'Chờ duyệt',
            1 => 'Đã duyệt',
            2 => 'Không duyệt',
        ),
        'status_missions' => array(
            0 => 'Chưa công bố',
            1 => 'Xuất bản'
        ),
        'status_member' => array(
            0 => 'Chưa công bố',
            1 => 'Xuất bản',
            2 => 'Blocked',
        ),
        'status_on' => array(
            0 => 'Tắt',
            1 => 'Bật',
        ),
        'status_register' => array(
            0 => __('status_register_rejected'),
            1 => __('status_register_approved'),
            2 => __('status_register_wait_review'),
        ),
        'sent_mail_register' => array(
            0 => __('status_sent_mail_rejected'),
            1 => __('status_sent_mail_approved'),
            2 => __('status_sent_mail_wait_review'),
        ),
        'name' => 'Vaa',
        'max_file_size_upload' => 50 * 1000 * 1000,
        'constants' => array(
            'TELCO' => 'MOBIFONE',
            'VINAPHONE_TELCO' => 'VINAPHONE',
            'STATUS_APPROVED' => 1,
            'STATUS_FILE_UPLOAD_TO_TMP' => 0,
            'STATUS_FILE_UPLOAD_COMPLETED' => 1,
            'STATUS_SUBSCRIBER_NON_REGISTER' => 0,
            'STATUS_ACTIVE' => 1,
            'STATUS_NEW_SUBSCRIBER' => 2,
            'STATUS_CANCEL' => 3,
            'STATUS_PROHITBITED' => 4,
            'STATUS_SYS_CANCEL' => 5,
            'STATUS_TELCO_CANCEL' => 6,
            'STATUS_DEBIT' => 7,
            'STATUS_DEBT_CHARGE' => 8,
            'STATUS_WAIT_REVIEW' => 1,
            'STATUS_HIDDEN' => 0,
            'STATUS_DELETE' => -1,
            'STATUS_SCHEDULE' => 3,
            'ARRAY_ACTIVE_STATUS' => array(1, 7, 8),
            'DEBIT_TIME' => '+3 days',
        ),
        'file_types' => array(
            'banner',
            'logo',
            'icon',
            'thumbnails',
            'screen_shots',
            'binary',
            'text',
            'video',
            'audio',
            'trailer',
        ),
        'data_file_root' => 'data_files',
        'languages' => ['vi' => __('Vietnamese'), 'en' => __('English')],
        'type_menu' => array(
            'MENU_MAIN' => 'Menu Main',
            'MENU_TOP' => 'Menu Top',
            'MENU_FOOTER' => 'Menu Footer',
            'APP_LEFT_MENU' => 'Menu App Left',
        ),
    ),
    'weekdays' => array(
        '0' => 'Chủ Nhật',
        '1' => 'Thứ 2',
        '2' => 'Thứ 3',
        '3' => 'Thứ 4',
        '4' => 'Thứ 5',
        '5' => 'Thứ 6',
        '6' => 'Thứ 7',
    ),
    'News' => array(
        'router' => 'tin-tuc',
        'data_file_root' => 'news_files',
        'collections' => [__('New'), __('Hot'), __('Top')],
        'categories' => [__('New'), __('Hot'), __('Top')],
    ),
    'Blocks' => array(
        'code' => array(
            'CATEGORIES' => 'Danh mục',
            'MOST_VIEWED' => 'Tin xem nhiều',
            'ADS_1' => 'Quảng cáo 1',
            'FB' => 'Fanpage',
            'ADS_2' => 'Quảng cáo 2',
            'VISITOR_COUNTER' => 'Thống kê người dùng truy cập',
        )
    ),
    'Ads' => array(
        'region' => array(
            'ADS_1' => 'QC 1',
            'ADS_2' => 'QC 2',
        ),
        'data_file_root' => 'banners_files',
        'collections' => [__('Ad'), __('Hot'), __('Top')],
        'categories' => [__('Ad'), __('Hot'), __('Top')],
    ),
    'Videos' => array(
        'data_file_root' => 'videos_files',
        'collections' => [__('Video'), __('Hot'), __('Top')],
        'categories' => [__('Video'), __('Hot'), __('Top')],
    ),
    'Settings' => array(
        'collections' => [__('Setting'), __('Hot'), __('Top')],
        'categories' => [__('Setting'), __('Hot'), __('Top')],
    ),
    'SlideShows' => array(
        'data_file_root' => 'slideshows_files',
        'collections' => [__('slideshow'), __('Hot'), __('Top')],
        'categories' => [__('slideshow'), __('Hot'), __('Top')],
        'code' => array(
            'HOME' => 'SLIDE HOME'
        ),
        'types_on_slideshow' => array(
            null => 'Chosen 1 type',
            'news' => 'Tin tức',
            'notebooks' => 'Sổ tay',
            'videos' => 'Video',
        )
    ),
    'Members' => array(
        'default_file' => 'defaults/danh_sach_hoi_vien.xls'
    ),
    'Menus' => array(
        'status' => array(
            0 => 'Tắt',
            1 => 'Bật'
        )
    ),
    'UserGroups' => array(
        'status' => array(
            0 => __('status_inactive'),
            1 => __('status_active'),
        ),
    ),
    'Users' => array(
        'status' => array(
            0 => __('status_inactive'),
            1 => __('status_active'),
        ),
        'type' => array(
            'BACKEND' => 'Backend user',
            'CONTENT_EDITOR' => 'Content editor',
            'CONTENT_REVIEWER' => 'Content reviewer',
            'CONTENT_ADMIN' => 'Content admin',
        ),
        'home_url' => array(
            'BACKEND' => array('controller' => 'Tours', 'action' => 'index'),
            'CONTENT_EDITOR' => array('controller' => 'Tours', 'action' => 'index'),
            'CONTENT_REVIEWER' => array('controller' => 'Tours', 'action' => 'index'),
        ),
        'gender' => array(
            '0' => __('Female'),
            '1' => __('Male'),
        ),
        'time_zone' => array(
            1 => "UTC−12:00",
            2 => "UTC−11:00",
            3 => "UTC−10:00",
            4 => "UTC−09:30",
            5 => "UTC−09:00",
            6 => "UTC−08:00",
            7 => "UTC−07:00",
            8 => "UTC−06:00",
            9 => "UTC−05:00",
            10 => "UTC−04:30",
            11 => "UTC−04:00",
            12 => "UTC−03:30",
            13 => "UTC−03:00",
            14 => "UTC−02:00",
            15 => "UTC−01:00",
            16 => "UTC±00:00",
            17 => "UTC+01:00",
            18 => "UTC+02:00",
            19 => "UTC+03:00",
            20 => "UTC+03:30",
            21 => "UTC+04:00",
            22 => "UTC+04:30",
            23 => "UTC+05:00",
            24 => "UTC+05:30",
            25 => "UTC+05:45",
            26 => "UTC+06:00",
            27 => "UTC+06:30",
            28 => "UTC+07:00",
            29 => "UTC+08:00",
            30 => "UTC+08:45",
            31 => "UTC+09:00",
            32 => "UTC+09:30",
            33 => "UTC+10:00",
            34 => "UTC+10:30",
            35 => "UTC+11:00",
            36 => "UTC+11:30",
            37 => "UTC+12:00",
            38 => "UTC+12:45",
            39 => "UTC+13:00",
            40 => "UTC+14:00",
        )
    ),
    'status_class' => array(
        0 => 'label label-danger',
        1 => 'label label-primary',
        2 => 'label label-info',
        3 => 'label label-warning',
        4 => 'label label-danger',
        5 => 'label label-warning',
        6 => 'label label-danger',
        7 => 'label label-default',
        8 => 'label label-default',
    ),
    'type_slideshow' => array(
        0 => 'Mặc định',
        1 => 'Liên hệ',
//        2 => '',
        3 => 'Trang chủ App',
    ),
    'VaaMembers' => array(
        'gender' => array(
            0 => 'Nữ',
            1 => 'Nam',
            3 => 'Khác'
        ),
        'status' => array(
            0 => 'Ngừng hoạt động',
            1 => 'Đang hoạt động',
        ),
    ),
    'VaaFiles' => array(
        'image_format' => array(
            0 => 'PNG',
            1 => 'JPG',
            2 => 'JPEG',
            3 => 'GIF',
            4 => 'TIFF',
            5 => 'BMP'
        ),
        'status' => array(
            0 => 'Ngừng hoạt động',
            1 => 'Đang hoạt động',
        ),
    ),
    'VaaRooms' => array(
        'status_online' => array(
            0 => 'offline',
            1 => 'online'
        )
    )
);

