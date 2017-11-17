<?php

class Page extends AppModel
{

    public $useTable = 'pages';
    public $actsAs = array('TagCommon', 'FileCommon', 'ContentPermission');

    public $customSchema = array(
        'id' => null,
        'data_locale' => [//các trường mà phụ thuộc ngôn ngữ + quốc gia thì đưa vào đây
            'name' => '',
            'name_ascii' => '',
            'short_description' => '',
            'short_description_ascii' => '',
            'description' => '',
            'meta_title' => '',
            'meta_description' => '',
            'meta_tags' => '',
            'url_alias' => '',
        ],
        'files' => null,
        'file_uris' => null,
        'weight' => 0,
        'status' => 0,
        'user_created' => null,
        'user_modified' => null,
        'created' => null,
        'modified' => null,
    );
}
