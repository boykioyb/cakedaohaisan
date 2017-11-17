<?php
class Tag extends AppModel
{
    public $useTable = 'tags';
    public $customSchema = array(
        'id' => null,
        'object_type' => null,
        'object_type_code' => '',
        'object_id' => null,
        'count' => 0,
        'name' => '',
        'name_ascii' => '',
        'lang_code' => '',
        'user_created' => null,
        'created' => null,
        'modified' => null,
    );
    public $asciiFields = array(
        'name',
    );

    /**
     * store
     * Lưu trữ, tạo mới và đồng bộ trạng thái Tag
     *
     * @param string $model_name
     * @param string $raw_name
     *
     * @param $status
     * @return mixed
     * @throws Exception
     */
    public function store($model_name, $raw_name, $status) {

        $name = trim($raw_name);
        if (!strlen($name)) {

            return false;
        }

        $object_type_code = Inflector::tableize($model_name);

        $check_exist = $this->checkExist($name, $object_type_code);

        // nếu đã tồn tại thì cập nhật đồng bộ trạng thái
        if (!empty($check_exist)) {

            $count_exist = $this->countExist($model_name, $name);
            if ($count_exist <= 1) {

                return $this->save(array(
                    'id' => $check_exist[$this->alias]['id'],
                    'status' => $status,
                    'count' => $count_exist,
                ));
            } elseif ($count_exist > 1 && $status == Configure::read('sysconfig.App.constants.STATUS_APPROVED')) {

                return $this->save(array(
                    'id' => $check_exist[$this->alias]['id'],
                    'status' => $status,
                    'count' => $count_exist,
                ));
            } else {

                // thực hiện đếm số content đang ở trạng thái công khai được gán vào tag
                $count_public = $this->countExist($model_name, $name, array(
                    'conditions' => array(
                        'status' => Configure::read('sysconfig.App.constants.STATUS_APPROVED'),
                    )));

                // nếu không có
                if (empty($count_public)) {

                    return $this->save(array(
                        'id' => $check_exist[$this->alias]['id'],
                        'status' => $status,
                        'count' => $count_exist,
                    ));
                }

                // nếu có tồn tại, thì chỉ thực hiện update số lượng count
                return $this->save(array(
                    'id' => $check_exist[$this->alias]['id'],
                    'count' => $count_exist,
                    'status' => Configure::read('sysconfig.App.constants.STATUS_APPROVED'),
                ));
            }
        }
        // nếu chưa tồn tại thì tạo mới
        else {

            $this->create();
            return $this->save(array(
                'name' => mb_strtolower($name),
                'status' => $status,
                'count' => 1,
                'object_type_code' => $object_type_code,
            ));
        }
    }

    /**
     * checkExist
     * Kiểm tra sự tồn tại của Tag
     *
     * @param string $name
     * @param string $object_type_code
     *
     * @return mixed
     */
    public function checkExist($name, $object_type_code) {

        $check_exist = $this->find('first', array(
            'conditions' => array(
                'name' => array(
                    '$regex' => new MongoRegex("/^" . mb_strtolower($name) . "$/i"),
                ),
                'object_type_code' => $object_type_code,
            ),
        ));

        return !empty($check_exist) ? $check_exist : false;
    }

    /**
     * countExist
     * thực hiện đếm số content được gán vào Tag
     *
     * @param string $model_name
     * @param string $name
     * @param array $options
     * @return int
     * @internal param string $object_type_code
     */
    public function countExist($model_name, $name, $options = array()) {

        App::uses($model_name, 'Model');
        $model = new $model_name();

        $default_options = array(
            'conditions' => array(
                'tags' => array(
                    '$regex' => new MongoRegex("/^" . mb_strtolower($name) . "$/i"),
                ),
            ),
            'fields' => 'id',
        );

        $options = Hash::merge($default_options, $options);
        $count_exist = $model->find('count', $options);

        return $count_exist;
    }
}