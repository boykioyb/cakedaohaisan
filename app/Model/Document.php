<?php
class Document extends AppModel{
    public $useTable ='documents';

    public $validate = array(
        'slug' => array(
            'rule' => 'isUnique',
            'message' => 'This name has already been taken.'
        ),
        'url_alias' => array(
            'rule' => 'isUnique',
            'message' => 'This url_alias has already been taken.'
        ),
    );

    public $customSchema = array(
        'id' => null,
        'data_locale' => [//các trường mà phụ thuộc ngôn ngữ + quốc gia thì đưa vào đây
            'name' => '',
            'name_ascii' => '',
            'url_alias' => '',
            'description' => '',
        ],
        'categories' => null,
        'files' => null,
        'file_uris' => null,
        'release_time' => null,
        'effect_time' => null,
        'expire_time' => null,
        'view_count' => 0,
        'download_count' => 0,
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

    public function beforeSave($options = array())
    {
        parent::beforeSave($options);

        if (isset($this->data[$this->alias]['status']) && strlen($this->data[$this->alias]['status'])){
            $this->data[$this->alias]['status'] = (int)$this->data[$this->alias]['status'];
        }
        if (isset($this->data[$this->alias]['weight']) && strlen($this->data[$this->alias]['weight'])){
            $this->data[$this->alias]['weight'] = (int)$this->data[$this->alias]['weight'];
        }
        if (!empty($this->data[$this->alias]['document_type_id'])) {
            $this->data[$this->alias]['document_type_id'] = new MongoId($this->data[$this->alias]['document_type_id']);
        }else{
            $this->data[$this->alias]['document_type_id'] = null;
        }
        if (isset($this->data[$this->alias]['publish_time']) && strtotime($this->data[$this->alias]['publish_time'])) {
            $this->data[$this->alias]['publish_time'] = new MongoDate(strtotime($this->data[$this->alias]['publish_time']));
            if ($this->data[$this->alias]['status'] == Configure::read('sysconfig.App.constants.STATUS_SCHEDULE')) {
                $this->data[$this->alias]['created'] = $this->data[$this->alias]['publish_time'];
            }
        }
    }

    public function findListName($id = null)
    {
        $result = $this->find('list', ['fields' => ['id', 'name']]);
        if (isset($id, $result[$id])) {
            unset($result[$id]);
        }
        return $result;
    }
}
