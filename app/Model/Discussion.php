<?php

class Discussion extends AppModel {

    public $actsAs = array('Common');
    public $useTable = 'discussions';
    public $useDbConfig = 'vaaChat';
    public $asciiFields = array(
        'name',
    );
    public $customSchema = array(
        'id' => null,
        'name' => '',
        'name_ascii' => '',
        'description' => '',
        'join_members' => null,
        'files' => null,
        'file_uris' => null,
        'owner' => '',
        'status' => 0,
        'created' => null,
        'modified' => null,
    );

    public function beforeSave($options = array()) {
        parent::beforeSave($options);

        if (isset($this->data[$this->alias]['status']) && strlen($this->data[$this->alias]['status'])) {
            $this->data[$this->alias]['status'] = (int) $this->data[$this->alias]['status'];
        }
        if (!empty($this->data[$this->alias]['owner'])) {
            $this->data[$this->alias]['owner'] = new MongoId($this->data[$this->alias]['owner']);
        } else {
            $this->data[$this->alias]['owner'] = null;
        }
        $array = array();
        if (isset($this->data[$this->alias]['join_members']) && !empty($this->data[$this->alias]['join_members'])) {

            $join_members = $this->data[$this->alias]['join_members'];
            foreach ($join_members as $val) {
                $array[] = new MongoId($val);
            }
            $this->data[$this->alias]['join_members'] = $array;
        } else {
            $this->data[$this->alias]['join_members'] = $array;
        }
        if (isset($this->data[$this->alias]['publish_time']) && strtotime($this->data[$this->alias]['publish_time'])) {
            $this->data[$this->alias]['publish_time'] = new MongoDate(strtotime($this->data[$this->alias]['publish_time']));
            if ($this->data[$this->alias]['status'] == Configure::read('sysconfig.App.constants.STATUS_SCHEDULE')) {
                $this->data[$this->alias]['created'] = $this->data[$this->alias]['publish_time'];
            }
        }
    }

    public function findCode() { {
            $options = array(
                'fields' => array('id', 'name'),
                'conditions' => array('status' => 1)
            );
            return $this->find('list', $options);
        }
    }

}
