<?php

class MenuNode extends AppModel {

    public $useTable = 'menus';

    public $customSchema = array(
        'id' => '',
        'parent_id' => null,
        'menu_code' => '',
        'related_id' => null,
        'data_locale' => [//các trường mà phụ thuộc ngôn ngữ + quốc gia thì đưa vào đây
            'name' => '',
            'description' => '',
        ],
        'files' => null,
        'file_uris' => null,
        'link' => '',
        'target' => '',
        'attr' => '',
        'type' => '',
        'order' => 0,
        'status' => 0,
        'user_created' => null,
        'user_modified' => null,
        'created' => null,
        'modified' => null,
    );
}
