<?php

App::uses('AppModel', 'Model');

class Feedback extends AppModel
{
    public $useTable = 'feedbacks';
    public $validate = array(
        'name' => array(
            'rule' => 'isUnique',
            'message' => 'This name has already been taken.'
        ),
    );

    public $customSchema = array(
        'id'=>'',
        'name' => '',
        'name_ascii' => '',
        'email' => '',
        'mobile' => '',
        'content' => '',
        'status' => 0,
        'user_created' => null,
        'user_modified' => null,
        'created' => '',
        'modified' => '',
    );
    public $asciiFields = array(
        'name',
    );
    

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
