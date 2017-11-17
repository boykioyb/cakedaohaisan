<?php

class SeoRoute extends AppModel {

    public $useTable = 'url_alias';
    
    public $customSchema = array(
        'id' => '',
        'object_id' => null,
        'object_type_code' => '',
        'url' => '',
        'lang_code' => '',
        'status' => '',
        'user' => '',
        'user_modified' => '',
        'created' => '',
        'modified' => '',
    );
}
