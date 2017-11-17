<?php

App::uses('AppModel', 'Model');

class Country extends AppModel {

    public $useTable = 'countries';
//    public $actsAs = array('TagCommon',);
    public $validate = [
        'name' => [
            'rule' => 'isUnique',
            'message' => 'country_name_duplicate'
        ]
    ];

    public function getCountryCodeByCountryId($id) {
        $country = $this->find('first', ['conditions' => ['_id' => $id]]);

        return isset($country['Country']['code']) ? $country['Country']['code'] : NULL;
    }

    /**
     * get list country name + country code which have status equal two
     * @return array
     */
//    public function getListCountryCode() {
//        $conditions = [
//            'status' => 1
//        ];
//        if (isset($_GET['lang_code']) && $_GET['lang_code']) {
//            $conditions[$_GET['lang_code']] = ['$ne'=> null];
//        }
//        $options = ['conditions' => $conditions, 'fields' => ['code', Configure::read('S.Lang_code_default').'.name']];
//        $country = $this->find('list', $options);
//
//        return $country;
//    }

    public function getCountryIdByCountryCode($code) {
        $country = $this->find('first', ['conditions' => ['code' => $code]]);

        return isset($country['Country']['id']) ? $country['Country']['id'] : null;
    }

    public function afterFind($results, $primary = false) {
        return parent::afterFind($results, $primary); // TODO: Change the autogenerated stub
    }

    public function beforeSave($options = array()) {
        parent::beforeSave($options);

        if (isset($this->data[$this->alias]['status'])) {
            $this->data[$this->alias]['status'] = (int) $this->data[$this->alias]['status'];
        }
        if (isset($this->data[$this->alias]['order'])) {
            $this->data[$this->alias]['order'] = (int) $this->data[$this->alias]['order'];
        }
    }

    public function getListCountryCode($lang_code = false) {
        $arr_result = array();
        if (!$lang_code) {
            $lang_code = Configure::read('S.Lang_code_default');
        }

        $list_data = $this->find('all');
        if (empty($list_data)) {
            return $arr_result;
        }
        //debug($list_data);
        //die;
        foreach ($list_data as $item) {
            if (isset($item['Country'][$lang_code])) {
                $arr_result[$item['Country']['code']] = $item['Country'][$lang_code]['name'];
            }
        }
        return $arr_result;
    }

    public function getListLangCode() {
        $arr_result = array();
        $lang_code = CakeSession::read('lang_code');
        if (empty($lang_code)) {
            $lang_code = Configure::read('S.Lang_code_default');
        }
        $list_data = $this->find('all', array('order' => ['order' => 'ASC']));
        if (empty($list_data)) {
            return Configure::read('S.Lang');
        }

        foreach ($list_data as $item) {
            if (isset($item['Country']['language_code']) && !empty($item['Country']['language_code'])) {
                $arr_result[$item['Country']['language_code']] = isset($item['Country'][$lang_code]['name']) ? $item['Country'][$lang_code]['name'] : $item['Country']['language_code'];
            }
        }
        if (count($arr_result) == 0) {
            return Configure::read('S.Lang');
        }
        return $arr_result;
    }

    public $customSchema = array(
        'id' => null,
        'code' => '',//mã quốc gia
        'language_code' => '',//mã ngôn ngữ
        'dial_code' => '',
        'data_locale' => [
            'name' => '',
            'description' => '',
            'tags' => '',
            'tags_ascii' => '',
        ],
        'order' => 0,
        'status' => 0,
        'user_created'        => null,
        'user_modified'        => null,
        'created'     => null,
        'modified'    => null,
    );

}