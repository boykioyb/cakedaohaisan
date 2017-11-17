<?php

App::uses('AppModel', 'Model');

class Region extends AppModel {

    public $useTable = 'regions';
    public $customSchema = array(
        'id' => null,
        'parent_id' => null,
        'code' => '',
        'data_locale' => [//các trường mà phụ thuộc ngôn ngữ + quốc gia thì đưa vào đây
            'name' => '',
            'name_ascii' => '',
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
    );

    public function findListName() {
        $conditions = [];
        if (isset($_GET['lang_code']) && $_GET['lang_code']) {
            $conditions['lang_code'] = $_GET['lang_code'];
        }
        $conditions['status'] = 1;

        return $this->find('list', ['conditions' => $conditions, 'fields' => ['name'], 'order' => ['order' => 'ASC', 'name' => 'ASC']]);
    }

    /**
     * Get list Regions theo country_code
     * @param $countryCode
     * @return array|null
     */
    public function findListByCountryCode($countryCode) {
        $conditions = [];

        $conditions['country_code'] = $countryCode;
//        $conditions['status'] = 1;

        $arr_result = array();
        $lang_code = CakeSession::read('lang_code');
        if (empty($lang_code)) {
            $lang_code = Configure::read('S.Lang_code_default');
        }
        if (empty($countryCode)) {
            return array();
        }

        $list_data = $this->find('all', ['conditions' => $conditions, 'order' => ['order' => 'ASC', 'name' => 'ASC']]);

        if (count($list_data) > 0) {
            foreach ($list_data as $key => $item) {
                if (!empty($item['Region'][$lang_code])) {
                    $arr_result[$item['Region']['id']] = $item['Region'][$lang_code]['name'];
                }
            }
            return $arr_result;
        }else{
            return array();
        }
    }
    
    public function findCode(){
        {
            $options = array(
                'fields' => array('id', 'code'),
                'conditions' => array('status' => 1)
            );
            return $this->find('list', $options);
        }
    }
    
    public function findNameById($id) {
        $result = $this->find('first', ['fields' => ['name'], 'conditions' => ['id' => $id]]);

        return isset($result['Region']['name']) ? $result['Region']['name'] : '';
    }

    public function beforeSave($options = array()) {
        parent::beforeSave($options);

        if (isset($this->data[$this->alias]['status'])) {
            $this->data[$this->alias]['status'] = (int) $this->data[$this->alias]['status'];
        }
        if (isset($this->data[$this->alias]['weight'])) {
            $this->data[$this->alias]['weight'] = (int) $this->data[$this->alias]['weight'];
        }
    }

}