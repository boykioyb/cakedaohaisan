<?php

class Slideshow extends AppModel
{

    public $useTable = 'slideshows';
    public $actsAs = array('TagCommon', 'FileCommon', 'ContentPermission');

    public $customSchema = array(
        'id' => null,
        'ref_type' => '',
        'ref_id' => null,
        'data_locale' => [//các trường mà phụ thuộc ngôn ngữ + quốc gia thì đưa vào đây
            'name' => '',
            'name_ascii' => '',
            'description' => '',
        ],
        'files' => null,
        'file_uris' => null,
        'url' => '',
        'type' => '',
        'target' => '',
        'weight' => 0,
        'status' => 0,
        'user_created' => null,
        'user_modified' => null,
        'created' => null,
        'modified' => null,
    );
}
