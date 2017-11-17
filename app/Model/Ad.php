<?php

App::uses('AppModel', 'Model');

class Ad extends AppModel
{
    public $useTable = 'ads';
    public $validate = array(
        'name' => array(
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'This name has already been taken.'
            ),
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'This name is not empty'
            ),
        ),
        'paths' => array(
            'rule' => 'checkEmpty',
            'message' => 'Vui lòng nhập thêm path.'
        ),
    );

    public $customSchema = array(
        'id'=>'',
        'name' => '',
        'name_ascii' => '',
        'description' => '',
        'code' => '',
        'url'=>'',
        'region' => null,
        'paths' =>null,
        'files' => array(
            'banner' => ''
        ),
        'file_uris' => array(
            'banner' => ''
        ),
        'weight' => 0,
        'status' => 0,
        'user_created' => null,
        'user_modified' => null,
        'created' => '',
        'modified' => '',
    );
    public $asciiFields = array(
        'name',
    );

    public function checkEmpty(){
        if(!empty($this->data['Ad']['paths'])){
            return true;
        }
        return false;
    }

    public function findListName($id = null)
    {
        $result = $this->find('list', ['fields' => ['id', 'name']]);
        if (isset($id, $result[$id])) {
            unset($result[$id]);
        }
        return $result;
    }

    public function beforeSave($options = array())
    {
//        debug($this->data);die;
        parent::beforeSave($options);
        if (isset($this->data[$this->alias]['weight']) && strlen($this->data[$this->alias]['weight'])) {
            $this->data[$this->alias]['weight'] = (int)$this->data[$this->alias]['weight'];
        }
    }

    public function afterSave($created, $options = array())
    {
        parent::afterSave($created, $options);
        // check case create or update
    }

    public function afterDelete()
    {
        parent::afterDelete();
    }

}
