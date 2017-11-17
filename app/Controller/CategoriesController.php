<?php

App::uses('AppController', 'Controller');

class CategoriesController extends AppController {

    public $uses = array(
        'Category',
        'ObjectType',
        'Country'
    );
    public $components = array('FileCommon');
    public $helpers = array('TreeCommon');
    public $object_type_code = null;

    public function index() {
        $this->checkAuth();
        if ($this->request->is('post') || $this->request->is('put')) {

            if ($this->{$this->modelClass}->saveSerialize($save_data)) {

                $this->Session->setFlash(__('save_successful_message'), 'default', array(), 'good');
            } else {

                $this->Session->setFlash(__('save_error_message'), 'default', array(), 'bad');
            }
        }
        //$object_type_code=films
        $options = [
            'order' => array('order' => 'ASC'),
            'conditions' => [
                'object_type_code' => $this->object_type_code
            ]
        ];

        $list_data = $this->{$this->modelClass}->find('threaded', $options);
        $this->setUserInfoInList($list_data);
        foreach ($list_data as $index => $data) {
            $this->setListOtherNames($list_data[$index][$this->modelClass]);
        }

        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array(
                        'action' => 'index',
                        '?' => $this->request->query,
                    )),
                    'label' => __('category_title'),
                )
            ],
            'list_data' => $list_data
        ]);
    }

    public function add() {

        $this->checkAuth();

        $parent = $this->{$this->modelClass}->generateTreeList(array(
            'order' => array(
                'order' => 'ASC',
            ),
            'conditions' => array(
                'parent_id' => '',
                'object_type_code' => $this->object_type_code,
            ),
        ));

        $this->saveRequestData();

        $this->set([
            'parent' => $parent,
            'breadcrumb' => [
                array(
                    'url' => Router::url(array(
                        'action' => 'index',
                        '?' => $this->request->query,
                    )),
                    'label' => __('category_title'),
                ),
                array(
                    'url' => Router::url(array(
                        'action' => __FUNCTION__,
                        '?' => $this->request->query,
                    )),
                    'label' => __('add_action_title'),
                )
            ]
        ]);
    }

    public function edit($id = null) {

        $this->checkAuth();

        if (!$this->{$this->modelClass}->exists($id)) {
            throw new NotFoundException(__('invalid_data'));
        }

        $this->saveRequestData();
        $this->setRequestData($id);

        $parent = $this->{$this->modelClass}->generateTreeList(array(
            'order' => array(
                'order' => 'ASC',
            ),
            'conditions' => array(
                'parent_id' => "",
                'id' => array(
                    '$ne' => $id,
                ),
                'object_type_code' => $this->object_type_code,
            ),
        ));

        $this->set([
            'parent' => $parent,
            'object_type_id' => $id,
            'breadcrumb' => [
                array(
                    'url' => Router::url(array(
                        'action' => 'index',
                        '?' => $this->request->query,
                    )),
                    'label' => __('category_title'),
                ),
                array(
                    'url' => Router::url(
                        array('action' => __FUNCTION__, $id,
                            '?' => $this->request->query,
                        )),
                    'label' => __('edit_action_title'),
                )
            ]
        ]);

        $this->render('add');
    }

    protected function setInit() {
        $this->set('status', Configure::read('sysconfig.App.status_on'));
        $this->set('category_code', Configure::read('sysconfig.App.category_code'));
        $object_type_code = $this->request->query('object_type_code');
        $this->set('page_title', __($object_type_code . '_category_title'));

        if (empty($object_type_code)) {
            throw new NotFoundException(__('invalid_data'));
        }
        $this->object_type_code = $object_type_code;

        $object_type = $this->ObjectType->find('first', array(
            'conditions' => array(
                'code' => $object_type_code,
                'status' => 1,
            ),
        ));

        if (empty($object_type)) {
            throw new NotFoundException(__('invalid_data'));
        }

        $this->set('object_type_code', $this->object_type_code);
        $this->set('model_name', $this->modelClass);

        $lang_code = $this->Session->read('lang_code');
        if ((empty($lang_code))) {
            $lang_code = Configure::read('S.Lang_code_default');
        }
        $this->set('langCodes', $this->Country->getListLangCode($lang_code));
    }

    private function checkAuth() {
        // nếu không có quyền truy cập, thì buộc user phải đăng xuất
        if (!$this->isAllow()) {
            return $this->redirect($this->Auth->loginRedirect);
        }
        $this->setInit();
    }

    private function saveRequestData() {
        if ($this->request->is('post') || $this->request->is('put')) {
            $save_data = $this->request->data[$this->modelClass];

            //không cho sửa code_category
            if (!empty($save_data['id'])) {
                unset($save_data['code']);
            }
            $lang_code = $save_data['lang_code'];


            if (!empty($save_data['name'])){
                $save_data[$lang_code]['name'] = $save_data['name'];
            }
            $save_data[$lang_code]['name_ascii'] = $this->convert_vi_to_en($save_data[$lang_code]['name']);

            if (!empty($save_data['short_description'])){
                $save_data[$lang_code]['short_description'] = $save_data['short_description'];
            }
            $save_data[$lang_code]['short_description_ascii'] = $this->convert_vi_to_en($save_data[$lang_code]['short_description']);
            if (empty($save_data[$lang_code]['meta_title'])){
            $save_data[$lang_code]['meta_title'] = $save_data[$lang_code]['name'];
            }
            if (empty($save_data[$lang_code]['meta_description'])){
                $save_data[$lang_code]['meta_description'] = $save_data[$lang_code]['short_description'];
            }
            $this->FileCommon->autoProcess($save_data, null, array(), true);

            if ($this->{$this->modelClass}->save($save_data)) {
                $this->Session->setFlash(__('save_successful_message'), 'default', array(), 'good');
                $this->redirect(array(
                    'action' => 'index',
                    '?' => $this->request->query,
                ));
            } else {
                $this->Session->setFlash(__('save_error_message'), 'default', array(), 'bad');
            }
        }
    }

    /**
     * @param $id
     * @param bool $clone
     */
    private function setRequestData($id, $clone = false) {
        $this->request->data = $this->{$this->modelClass}->find('first', array(
            'conditions' => array(
                'id' => new MongoId($id),
            ),
        ));
//        $this->FileCommon->autoSetFiles($save_data);

        if ($clone && isset($save_data['id'])) {
            $save_data['ref_id'] = $save_data['id'];
            unset($save_data['id']);
        }
    }

}
