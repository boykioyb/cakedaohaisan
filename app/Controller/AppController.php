<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array(
        'Session',
        'Paginator',
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'Users',
                'action' => 'login',
            ),
            'loginRedirect' => array('controller' => 'dashboard', 'action' => 'index'),
            'logoutRedirect' => array('controller' => 'Users', 'action' => 'login'),
            'authenticate' => array(
                'Form' => array(
                    'userModel' => 'User',
                    'fields' => array('username' => 'username', 'password' => 'password')
                )
            )
        ),
        'DebugKit.Toolbar' => array(
            'panels' => array(
                'history' => false,
            ),
        ),
//        'Security' => array(
//            'csrfUseOnce' => true,
//            'csrfExpires' => '+1 hour',
//            'blackHoleCallback' => 'blackhole',
//        ),
    );
    public $helpers = array('Common');
    public $paginate = array(
        'limit' => 20,
        'order' => 'modified'
    );
   
    public $specialModel = ['Atm'];
   
  
  
    public function reqUpload() {

        $this->autoRender = false;
        App::import('Vendor', 'CustomUploadHandler', array('file' => 'jQueryFileUpload/server/php' . DS . 'CustomUploadHandler.php'));

        $upload_handler = new CustomUploadHandler();
        $result = $upload_handler->post(false);

        if (empty($result['files'][0])) {

            $this->log(__('Quá trình upload file gặp lỗi'));
            $this->log($result);

            echo json_encode($result);
            return;
        }

        if (!isset($this->FileManaged)) {

            $this->loadModel('FileManaged');
        }

        $status_file_upload_to_tmp = Configure::read('sysconfig.App.constants.STATUS_FILE_UPLOAD_TO_TMP');

        $file = &$result['files'][0];
        if (empty($file->type)) {

            $file->type = $this->getMimeType($file->name);
        }
        $save_data = array(
            'name' => $file->name,
            'size' => $file->size,
            'mime' => $file->type,
            'status' => $status_file_upload_to_tmp,
            'uri' => WEBROOT_DIR . DS . 'tmp' . DS . $file->name,
        );

        $this->FileManaged->create();
        $this->FileManaged->save($save_data);
        $file_id = $this->FileManaged->getLastInsertID();

        // đọc lại thông tin file
        $file_obj = $this->FileManaged->find('first', array(
            'conditions' => array(
                'id' => new MongoId($file_id),
            ),
            'fields' => array(
                'name', 'size', 'mime', 'status', 'uri',
            ),
        ));

        // chuỗi hóa thông tin về file
        $file->fileSerialize = json_encode($file_obj['FileManaged']);

        // thực hiện ghi đè lại deleteUrl
        $deleteUrl = Router::url(array(
                    'action' => 'reqDeleteFile',
                    '?' => array(
                        'id' => $file_id,
        )));
        $file->deleteUrl = $deleteUrl;

        echo json_encode($result);
        return;
    }

    public function reqDeleteFile() {

        $this->autoRender = false;
        if ($this->request->is('delete') || $this->request->is('post')) {

            $file_id = $this->request->query('id');
            $result = array(
                'success' => true
            );

            if (!isset($this->FileManaged)) {

                $this->loadModel('FileManaged');
            }

            $status_file_upload_to_tmp = Configure::read('sysconfig.App.constants.STATUS_FILE_UPLOAD_TO_TMP');

            $get_file = $this->FileManaged->find('first', array(
                'conditions' => array(
                    'id' => new MongoId($file_id),
//					'status' => $status_file_upload_to_tmp, // chỉ được phép xóa file tạm
                )
            ));

            // nếu file không tồn tại
            if (empty($get_file)) {

                echo json_encode($result);
                return;
            }

            // nếu file là file nằm trong thự mục tmp (file tạm) - thực hiện xóa vật lý
            if ($get_file['FileManaged']['status'] == $status_file_upload_to_tmp) {

                $uri = $get_file['FileManaged']['uri'];

                if ($this->FileManaged->delete($file_id, false)) {

                    $file = new File(APP . $uri, false);
                    $file->delete();

                    echo json_encode($result);
                    return;
                } else {

                    $location = __CLASS__ . ':' . __FUNCTION__ . ':' . __LINE__;
                    $this->log(__($location . ': ' . __('Can not delete a file, the file as below')));
                    $this->log($get_file);

                    echo json_encode(array(
                        'success' => false,
                        'message' => __('delete_file_error_message'),
                    ));
                }
            }
            // nếu file đã được sử dụng - chỉ thực hiện set cờ
            else {

//                                $update_data = array(
//                                    'id' => $file_id,
//                                    'status' => $status_file_upload_to_tmp,
//                                    'uri' => $get_file['FileManaged']['uri'],
//                                );
//                                if ($this->FileManaged->save($update_data)) {
//
                echo json_encode($result);
                return;
//                                } else {
//
//                                        $location = __CLASS__ . ':' . __FUNCTION__ . ':' . __LINE__;
//                                        $this->log(__($location . ': ' . __('Can not set a file as deleted, the file as below')));
//                                        $this->log($get_file);
//
//                                        echo json_encode(array(
//                                            'success' => false,
//                                            'message' => __('delete_file_error_message'),
//                                        ));
//                                }
            }
        }
    }

    /**
     * Delete a record
     *
     * @author trungnq
     * @param type $id
     */
    public function reqDelete($id = null) {

        $this->autoRender = false;
        $res = array(
            'error_code' => 0,
            'message' => __('delete_successful_message'),
        );
        if (!$this->request->is('post')) {

            $res = array(
                'error_code' => 1,
                'message' => __('invalid_data'),
            );
            echo json_encode($res);
            return;
        }
        $model_name = $this->request->data('model_name');
        if (empty($model_name) && in_array($model_name, $this->specialModel)) {
            if (isset($this->request->query['objectTypeId'], $this->request->query['objectId'])) {
                $this->loadModel('ObjectType');
                $object = $this->ObjectType->find('first', ['conditions' => [
                        'id' => new MongoId($this->request->query['objectTypeId']),
                        'status' => 2,
                ]]);
                if (!$object) {
                    throw new NotFoundException(__('invalid_data'));
                }
                $model_name = $object['ObjectType']['name'] . $this->modelClass;
            } else {
                $model_name = $this->modelClass;
            }
        } else {
            $model_name = isset($this->request->query['model_name']) ? $this->request->query['model_name'] : $this->modelClass;
        }
        if (!$this->$model_name) {
            $this->loadModel($model_name);
        }

        $check_exist = $this->$model_name->find('first', array(
            'conditions' => array(
                'id' => array(
                    '$eq' => $id,
                ),
            ),
        ));
        if (empty($check_exist)) {

            $res = array(
                'error_code' => 2,
                'message' => __('invalid_data'),
            );
            echo json_encode($res);
            return;
        }

        if ($this->$model_name->delete($id)) {

//                        $this->Session->setFlash(__('delete_successful_message'), 'default', array(), 'good');
            echo json_encode($res);
        } else {

            $res = array(
                'error_code' => 3,
                'message' => __('delete_error_message'),
            );
            echo json_encode($res);
            return;
        }
    }

    /**
     * save multi record
     *
     * @author ungnv
     * @param type $id
     */
    public function reqDeleteALl() {

        $this->autoRender = false;
        $res = array(
            'error_code' => 0,
            'message' => __('Xóa thành công.'),
        );
        if (!$this->request->is('post')) {

            $res = array(
                'error_code' => 1,
                'message' => __('invalid_data'),
            );
            echo json_encode($res);
            return;
        }
        $model_name = $this->request->data('model_name');
        if (empty($model_name)) {

            $model_name = $this->modelClass;
        }

        if (!$this->$model_name) {
            $this->loadModel($model_name);
        }

        $idArr = $this->request->data;

        if ($this->$model_name->deleteAll(array('id' => ['$in' => array_keys($idArr)]))) {
            $this->Session->setFlash(__('Xóa thành công.'), 'default', array(), 'good');
            echo json_encode($res);
        } else {
            $res = array(
                'error_code' => 3,
                'message' => __('Xóa không thành công.'),
            );
            echo json_encode($res);
            return;
        }
    }

    public function reqNew($id = null) {
        $created = new MongoDate();
        $this->reqEdit($id, $created);
    }

    /**
     * Delete a record
     *
     * @author trungnq
     * @param type $id
     */
    public function reqEdit($id = null, $created = null) {
        $this->autoRender = false;
        $res = array(
            'error_code' => 0,
            'message' => __('save_successful_message'),
        );
        if (!$this->request->is('post')) {

            $res = array(
                'error_code' => 1,
                'message' => __('invalid_data'),
            );
            echo json_encode($res);
            return;
        }
        $model_name = $this->request->data('model_name');
        if (empty($model_name) && in_array($model_name, $this->specialModel)) {
            if (isset($this->request->query['objectTypeId'], $this->request->query['objectId'])) {
                $this->loadModel('ObjectType');
                $object = $this->ObjectType->find('first', ['conditions' => [
                        'id' => new MongoId($this->request->query['objectTypeId']),
                        'status' => 2,
                ]]);
                if (!$object) {
                    throw new NotFoundException(__('invalid_data'));
                }
                $model_name = Inflector::classify($object['ObjectType']['code']) . $this->modelClass;
            } else {
                $model_name = $this->modelClass;
            }
        } else {
            $model_name = $this->request->query('model_name') ? $this->request->query('model_name') : $this->modelClass;
        }

        if (!$this->$model_name) {
            $this->loadModel($model_name);
        }
        $check_exist = $this->$model_name->find('first', array(
            'conditions' => array(
                'id' => array(
                    '$eq' => $id,
                ),
            ),
        ));
        if (empty($check_exist)) {

            $res = array(
                'error_code' => 2,
                'message' => __('invalid_data'),
            );
            echo json_encode($res);
            return;
        }

        $this->request->data['id'] = $id;
        $save_data = $this->request->data;

        $options['conditions'] = array(
            '_id' => new MongoId($save_data['id'])
        );
        $data_edit = $this->$model_name->find('first', $options);
        $data_edit = $data_edit[$model_name];
        $arrLangCode = array();
        if (count($this->langCodes) > 0) {
            foreach ($this->langCodes as $keyLang => $valueLang) {
                $arrLangCode[] = $keyLang;
            }
        }
        foreach ($save_data as $key_edit => $value_edit) {
            if (in_array($key_edit, $arrLangCode) && isset($save_data[$key_edit]['status'])) {
                $data_edit[$key_edit]['status'] = (int) $save_data[$key_edit]['status'];
            } else {
                $data_edit[$key_edit] = $save_data[$key_edit];
            }
        }
        $save_data = $data_edit;
        if (isset($save_data['status'])) {
            $save_data['status'] = (int) $save_data['status'];
        }
        if (!empty($created)) {
            $save_data['created'] = $created;
        }
        unset($save_data['modified']);
        unset($save_data['password']);
        if ($this->$model_name->save($save_data)) {

            $this->Session->setFlash(__('save_successful_message'), 'default', array(), 'good');
            echo json_encode($res);
        } else {
//            debug($this->$model_name->validationErrors);
            $res = array(
                'error_code' => 3,
                'message' => __('save_error_message'),
            );
            echo json_encode($res);
            return;
        }
    }

   
    public function getMimeType($filename, $mimePath = '../Config') {
        $fileext = substr(strrchr($filename, '.'), 1);
        if (empty(
                        $fileext))
            return (false);
        $regex = "/^([\w\+\-\.\/]+)\s+(\w+\s)*($fileext\s)/i";
        $lines = file("$mimePath/mime.types");
        foreach ($lines as $line) {
            if (substr($line, 0, 1) == '#')
                continue; // skip comments
            $line = rtrim($line) . " ";
            if (!preg_match($regex, $line, $matches))
                continue; // no match to the extension
            return ($matches[1]);
        }
        return (false); // no match at all
    }

  
    /**
     * isJson
     * kiểm tra xem chuỗi string có phải là json k?
     *
     * @param string $string
     * @return bool
     */
    protected function isJson($string) {

        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

 
    protected function logAnyFile($content, $file_name) {

        CakeLog::config($file_name, array(
            'engine' => 'File',
            'types' => array($file_name),
            'file' => $file_name,
        ));

        $this->log($content, $file_name);
    }

  
    protected function trimData($data) {
        if (is_array($data)) {
            foreach ($data as $num => $ndata) {
                $data[$num] = trim($ndata);
            }
        } else {
            $data = trim($data);
        }
        return $data;
    }

    public function getMenus() {
        $user = $this->Auth->user();
        if (!$user) {
            return;
        }
        //get all menus from configure file
        $allMenus = Configure::read('S.Menus');
        $menuToView = [];

        foreach ($allMenus as $menu) {
            if (!isset($menu['child'])) { // is single
                if (in_array($menu['controller'] . '/' . $menu['action'], $pers)) {
                    $menuToView[$menu['name']] = [
                        'icon' => $menu['icon'],
                        'url' => [
                            'controller' => $menu['controller'],
                            'action' => $menu['action'],
                            '?' => isset($menu['?']) ? $menu['?'] : null
                        ]
                    ];
                }
            } else { // if menu has child
                $menuChild = [];
                foreach ($menu['child'] as $child) {
                    if (!in_array($child['controller'] . '/' . $child['action'], $pers))
                        continue;
                    $menuChild = array_merge($menuChild, [
                        $child['name'] => [
                            'url' => [
                                'controller' => $child['controller'],
                                'action' => $child['action'],
                                '?' => isset($child['?']) ? $child['?'] : null
                            ]
                        ]
                    ]);
                }
                if ($menuChild) {
                    $menuToView[$menu['name']] = [
                        'icon' => $menu['icon'],
                        'url' => '#',
                        'child' => $menuChild
                    ];
                }
            }
        }
        $this->set('menus', $menuToView);
    }

    protected function renderView($viewFile) {
        $view = new View($this, false);
        $this->layout = false;

        $html = $view->render($viewFile);
        return $html;
    }

}
