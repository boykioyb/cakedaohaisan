<?php

class VaaPost extends AppModel {

    public $actsAs = array('Common');
    public $useTable = 'posts';
    public $useDbConfig = 'vaaChat';
    public $asciiFields = array(
        'content',
    );
    public $validate = array(
        'content' => array(
            'between' => array(
                'rule' => array('lengthBetween', 3, 5000),
                'message' => 'Between 3 to 5000 characters'
            ),
            'notEmpty' => 'notEmpty',
        ),
        'lat' => array(
            'range' => array(
                'rule' => array('range', -90, 90),
                'message' => 'Please enter a number between -90 and 90',
            ),
            'notEmpty' => 'notEmpty',
        ),
        'lng' => array(
            'range' => array(
                'rule' => array('range', -180, 180),
                'message' => 'Please enter a number between -180 and 180',
            ),
            'notEmpty' => 'notEmpty',
        ),
        'attach' => array(
            'notEmpty' => 'notEmpty',
            'rule' => array('isEncodedBase64Image'),
            'message' => 'Please enter a valid encoded base64 image string.'
        ),
    );
    public $mongoSchema = array(
        'discussion' => array('type' => 'objectid'),
        'content' => array('type' => 'string'),
        'content_ascii' => array('type' => 'string'),
        'with_members' => array(),
        'feeling' => array('type' => 'objectid'),
        'loc' => array(),
        'loc_address' => array('type' => 'string'),
        'files' => array(
            'attach' => null,
        ),
        'file_uris' => array(
            'attach' => null,
        ),
        'owner' => array('type' => 'objectid', 'default' => null),
        'status' => array('type' => 'integer', 'default' => 1),
        'like_count' => array('type' => 'integer', 'default' => 0),
        'comment_count' => array('type' => 'integer', 'default' => 0),
        'share_count' => array('type' => 'integer', 'default' => 0),
        'created' => array('type' => 'datetime'),
        'modified' => array('type' => 'datetime'),
    );

    public function beforeSave($options = array()) {
        parent::beforeSave($options);

        if (isset($this->data[$this->alias]['status']) && strlen($this->data[$this->alias]['status'])) {
            $this->data[$this->alias]['status'] = (int) $this->data[$this->alias]['status'];
        }
        if (!empty($this->data[$this->alias]['discussion'])) {
            $this->data[$this->alias]['discussion'] = new MongoId($this->data[$this->alias]['discussion']);
        } else {
            $this->data[$this->alias]['discussion'] = null;
        }
        if (isset($this->data[$this->alias]['lat']) && isset($this->data[$this->alias]['lng'])) {
            $this->data[$this->alias]['loc'] = array(
                'type' => 'Point',
                'coordinates' => array(
                    (float) $this->data[$this->alias]['lat'],
                    (float) $this->data[$this->alias]['lng'],
                ),
            );
        }
        if (!empty($this->data[$this->alias]['owner'])) {
            $this->data[$this->alias]['owner'] = new MongoId($this->data[$this->alias]['owner']);
        } else {
            $this->data[$this->alias]['owner'] = null;
        }
        if (!empty($this->data[$this->alias]['with_members'])) {

            $with_members = $this->data[$this->alias]['with_members'];
            $array = [];
            foreach ($with_members as $val) {
                $array[] = new MongoId($val);
            }
            $this->data[$this->alias]['with_members'] = $array;
        } else {
            $this->data[$this->alias]['with_members'] = null;
        }
        if (isset($this->data[$this->alias]['publish_time']) && strtotime($this->data[$this->alias]['publish_time'])) {
            $this->data[$this->alias]['publish_time'] = new MongoDate(strtotime($this->data[$this->alias]['publish_time']));
            if ($this->data[$this->alias]['status'] == Configure::read('sysconfig.App.constants.STATUS_SCHEDULE')) {
                $this->data[$this->alias]['created'] = $this->data[$this->alias]['publish_time'];
            }
        }
    }

}
