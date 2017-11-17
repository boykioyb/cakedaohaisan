<?php

App::uses('AppModel', 'Model');

/**
 * @property  objectModel
 */
class ObjectType extends AppModel {

    public $useTable = 'object_types';
    public $customSchema = array(
        'id' => null,
        'parent_id' => null,
        'name' => '',
        'code' => '',
        'description' => null,
        'order' => 0, // thứ tự xuất hiện
        'status' => 0, // 1 là active, 0 unactive 
        'user' => null, // user tạo
        'created' => null, // thời điểm tạo
        'modified' => null, // thời điểm chỉnh sửa
    );

    public function afterFind($results, $primary = false) {
        parent::afterFind($results, $primary);

        if (!empty($results)) {

            foreach ($results as $k => $v) {
                if (
                        isset($v[$this->alias]['parent_id']) &&
                        !empty($v[$this->alias]['parent_id']) &&
                        $v[$this->alias]['parent_id'] instanceof MongoId
                ) {

                    $v[$this->alias]['parent_id'] = (string) $v[$this->alias]['parent_id'];
                }
            }
        }

        return $results;
    }

    public function getObjectTypeId($code) {

        $object_type = $this->find('first', array(
            'conditions' => array(
                'code' => $code,
            ),
        ));

        return !empty($object_type) ? $object_type[$this->alias]['id'] : null;
    }

    public function getList() {
        $conditions['conditions'] = [
            'status' => Configure::read('sysconfig.App.constants.STATUS_APPROVED')
        ];

        if (isset($_GET['lang_code'])) {
            $conditions['conditions']['lang_code'] = $_GET['lang_code'];
        }

        return $this->find('list', [
                    $conditions,
                    'fields' => ['id', 'name']
        ]);
    }

    public function reqObjectByObjectType($request) {
        $object = [];
        $objectType = $this->findById($request['object_type_id']);

        $objectModel = Inflector::classify($objectType['ObjectType']['code']);
        App::import('Model', $objectModel);

        if (class_exists($objectModel)) {
            $this->objectModel = new $objectModel;
            $conditions = [
                'status' => Configure::read('sysconfig.App.constants.STATUS_APPROVED')
            ];
            if (isset($request['lang_code'])) {
                $conditions['lang_code'] = $request['lang_code'];
            }
            $object = $this->objectModel->find('list', [
                'conditions' => $conditions,
                'fields' => ['id', 'name']
            ]);
        }
        return $object;
    }

    /**
     * createNew kiểm tra xem object type đã tồn tại chưa? nếu có trả về id
     * nếu chưa thì tạo mới và trả về id
     */
    public function createNew($code) {

        $exist = $this->getObjectTypeId($code);
        if (!empty($exist)) {

            return $exist;
        }

        $this->create();
        $save_data = array(
            'name' => Inflector::humanize($code),
            'code' => $code,
        );
        $this->save($save_data);

        return $this->getLastInsertID();
    }

    /**
     * Get list object_type_code
     */
    public function getAllObjectTypeCode($options = false) {
        $object_options = array(
            'fields' => ['code', 'name']
        );
        if ($options) {
            $object_options = Hash::merge($object_options, $options);
        }
        return $this->find('list', $object_options);
    }

    public function getObjectTypeCodebyType($type_code) {
        $options = array(
            'conditions' => array(
                'type' => $type_code,
            ),
            'fields' => ['code', 'name'],
        );
        $arr_result = $this->find('list', $options);
        return $arr_result;
    }

}
