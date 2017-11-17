<?php

class VaaPostLike extends AppModel {

    public $actsAs = array('Common');
    public $useTable = 'post_likes';
    public $useDbConfig = 'vaaChat';

    public function findCode() { {
            $options = array(
                'fields' => array('id', 'name'),
                'conditions' => array('status' => 1)
            );
            return $this->find('list', $options);
        }
    }

}
