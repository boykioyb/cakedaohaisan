<?php

class Setting extends AppModel {

    public $useTable = 'settings';

    public function findListName() {
        return $this->find('list', ['fields' => ['name']]);
    }

    public $customSchema = array(
        'id' => null,
        'data_locale' => [//các trường mà phụ thuộc ngôn ngữ + quốc gia thì đưa vào đây
            'title' => '',
            'description' => '',
            'address' => '',
            'copyright' => '',
            'meta_title' => '',
            'meta_description' => '',
            'meta_keyword' =>  '',
        ],
        'email' => '',
        'type' => '',
        'phone' => '',
        'fax' => '',
        'script_head' => '',
        'files' => null,
        'file_uris' => null,
        'link_fb' => '',
        'link_tw' => '',
        'link_in' => '',
        'link_gg' => '',
        'cate_news' => '',
        'cate_notify' => '',
        'cate_activity' => '',
        'cate_event' => '',
        'cate_list' => '',
        'off_site' => 0,
        'user_created' => null,
        'user_modified' => null,
        'created' => null,
        'modified' => null,
    );

    public function beforeSave($options = array()) {
        parent::beforeSave($options);

        if (empty($this->data[$this->alias]['type'])) {
            $this->data[$this->alias]['type'] = 'WEB';
        }
    }

    public function afterSave($created, $options = array()) {
        parent::afterSave($created, $options);
    }

}
