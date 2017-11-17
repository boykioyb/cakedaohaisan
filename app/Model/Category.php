<?php

class Category extends AppModel {

    public $useTable = 'categories';
    public $actsAs = array('TreeCommon', 'FileCommon');
    public $validate = array(
        'url_alias' => array(
            'rule' => 'isUnique',
            'message' => 'Mã danh mục đã tồn tại. Vui lòng nhập mã danh mục khác'
        )
    );

    public function beforeSave($options = array()) {
        parent::beforeSave($options);
    }
    
    //lucnn get type code category
    public function getListCategoriesObjectTypeCode($object_type_code, $options = array()) {
        $conditions = [
            'status' => 1,
            'object_type_code' => $object_type_code
        ];
        $langCodeDefault = CakeSession::read('lang_code');
        if (empty($langCodeDefault)) {
            $langCodeDefault = Configure::read('S.Lang_code_default');
        }

        $default_options = array(
            'fields' => array(
                'code', $langCodeDefault,
            ),
            'order' => array(
                'order' => 'ASC',
            ),
            'conditions' => $conditions
        );

        $options = Hash::merge($default_options, $options);
        $return = array();
        $list_data = $this->find('all', $options);
        if (count($list_data) > 0) {
            foreach ($list_data as $key => $value) {
                $value = $value['Category'];
                $return[$value['code']] = isset($value[$langCodeDefault]['name']) ? $value[$langCodeDefault]['name'] : '';
            }
        }
        return $return;
    }


    //khangdn get type name category
    public function getListCateName($object_type_code, $options = array()) {
        $options = [
            'order' => array(
                'order' => 'ASC',
            ),
            'conditions' => array(
                'status' => 1,
                'object_type_code' => $object_type_code
            )
        ];
        $langCodeDefault = CakeSession::read('lang_code');
        if (empty($langCodeDefault)) {
            $langCodeDefault = Configure::read('S.Lang_code_default');
        }

        $return = array();
        $list_data = $this->find('all', $options);
        if (count($list_data) > 0) {
            foreach ($list_data as $key => $value) {
                $value = $value['Category'];
                $return[$value['id']] = isset($value[$langCodeDefault]['name']) ? $value[$langCodeDefault]['name'] : '';
            }
        }
        return $return;
    }
    public function getListCateNameDocuments($options = array()) {
        $options = [
            'order' => array(
                'order' => 'ASC',
            ),
            'conditions' => array(
                'status' => 1,
                'object_type_code' => 'documents',
            )

        ];
        $langCodeDefault = CakeSession::read('lang_code');
        if (empty($langCodeDefault)) {
            $langCodeDefault = Configure::read('S.Lang_code_default');
        }

        $return = array();
        $list_data = $this->find('all', $options);
        if (count($list_data) > 0) {
            foreach ($list_data as $key => $value) {
                $value = $value['Category'];
                $return[$value['id']] = isset($value[$langCodeDefault]['name']) ? $value[$langCodeDefault]['name'] : '';
            }
        }
        return $return;
    } 
    public function getListCateNameFaqs($options = array()) {
        $options = [
            'order' => array(
                'order' => 'ASC',
            ),
            'conditions' => array(
                'status' => 1,
                'object_type_code' => 'faqs',
            )

        ];
        $langCodeDefault = CakeSession::read('lang_code');
        if (empty($langCodeDefault)) {
            $langCodeDefault = Configure::read('S.Lang_code_default');
        }

        $return = array();
        $list_data = $this->find('all', $options);
        if (count($list_data) > 0) {
            foreach ($list_data as $key => $value) {
                $value = $value['Category'];
                $return[$value['id']] = isset($value[$langCodeDefault]['name']) ? $value[$langCodeDefault]['name'] : '';
            }
        }
        return $return;
    }

    public function getListName($object_type_id, $options = array()) {
        $conditions = [
            'status' => Configure::read('sysconfig.App.constants.STATUS_APPROVED')
        ];
        if (isset($_GET['lang_code']) && $_GET['lang_code']) {
            $conditions['lang_code'] = $_GET['lang_code'];
        }
        $default_options = array(
            'fields' => array(
                'code', 'name',
            ),
            'order' => array(
                'order' => 'ASC',
            ),
            'conditions' => $conditions
        );

        $options = Hash::merge($default_options, $options);
        $options['conditions']['object_type'] = new MongoId($object_type_id);

        $list_data = $this->find('list', $options);
        return $list_data;
    }

    public $customSchema = array(
        'id' => null,
        'object_type' => null,
        'object_type_code' => null,
        'parent_id' => null,
        'data_locale' => [
            'name' => '',
            'name_ascii' => '',
            'url_alias' => '',
            'short_description' => '',
            'short_description_ascii' => '',
            'meta_title' => '',
            'meta_description' => '',
            'meta_tags' => '',
        ],
        'weight' => 0,
        'status' => 0,
        'user_created' => null,
        'user_modified' => null,
        'created' => null,
        'modified' => null,
    );
    public $asciiFields = array(
        'data_locale.name',
        'data_locale.short_description',
    );
    public function getListCategory($langCode = 'vi') {
        $options = array(
            'fields' => array('id', $langCode),
        );
        $parent = $this->find('all', $options);
        $return = array();
        if(count($parent) > 0){
            foreach ($parent as $cate){
                $return[$cate['Category']['id']] = isset($cate['Category'][$langCode]['name'])?$cate['Category'][$langCode]['name']:'';
            }
        }
        return $return;
    }
}
