<?php

class VaaMessage extends AppModel {

    public $actsAs = array('Common');
    public $useTable = 'messages';
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
