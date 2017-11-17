<?php

class Video extends AppModel {

    public $useTable = 'videos';
    public $actsAs = array('TagCommon', 'FileCommon', 'ContentPermission');
    public $customSchema = array(
        'id' => null,
        'data_locale' => [//các trường mà phụ thuộc ngôn ngữ + quốc gia thì đưa vào đây
            'name' => '',
            'name_ascii' => '',
            'description' => '',
            'url_alias' => '',
        ],
        'files' => null,
        'is_hot' => 0,
        'file_uris' => null,
        'view_count' => 0,
        'weight' => 0,
        'status' => 0,
        'user_created' => null,
        'user_modified' => null,
        'created' => null,
        'modified' => null,
    );

}
