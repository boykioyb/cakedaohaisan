<?php

/**
 * @property mixed NewEntity
 * @property mixed User
 * @property mixed LocationCommon
 * @property mixed FileCommon
 * @property mixed Location
 * @property mixed Category
 */
class NotebooksController extends AppController {

    public $uses = array('Notebook', 'Category', 'User', 'Country');
    public $components = array('FileCommon');

    public function beforeRender() {
        parent::beforeRender();
        $this->set('entity', $this->NewEntity);
    }

    public function beforeFilter() {
        parent::beforeFilter();
        $this->setInit();
    }

    public function index() {
        $this->checkAuth();

        $options = [
            'order' => array('modified' => 'DESC')
        ];

        $this->setSearchConds($options);
        $this->Paginator->settings = $options;

        $list_data = $this->Paginator->paginate($this->modelClass, [], ['order', 'modified', 'user', 'name',]);
        $this->setUserInfoInList($list_data);
        $lang_code = $this->Session->read('lang_code');
        if (empty($lang_code)) {
            $lang_code = Configure::read('S.Lang_code_default');
        }
        $this->set('lang_code', $lang_code);
        foreach ($list_data as $index => $data) {
            $this->setListOtherNames($list_data[$index][$this->modelClass]);
        }
        $this->set([
            'users' => $this->User->getListName(),
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('notebook_title'),
                )
            ],
            'list_data' => $list_data
        ]);
    }

    public function add() {
        $this->checkAuth();

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->saveNewData();
        }

        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('notebook_title'),
                ),
                array(
                    'url' => Router::url(array('action' => __FUNCTION__)),
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

        if ($this->request->is('post') || $this->request->is('put')) {
            $save_data = $this->request->data[$this->modelClass];
            // upload file
            $this->FileCommon->autoProcess($save_data, '', array(), false);
            if ($this->{$this->modelClass}->save($save_data)) {
                $this->Session->setFlash(__('save_successful_message'), 'default', array(), 'good');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('save_error_message'), 'default', array(), 'bad');
            }
        } else {
            $this->setRequestData($id);
        }

        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('notebook_title'),
                ),
                array(
                    'url' => Router::url(array('action' => __FUNCTION__)),
                    'label' => __('edit_action_title'),
                )
            ]
        ]);

        $this->render('add');
    }

    protected function setSearchConds(&$options) {
        if (isset($this->request->query['name']) && strlen(trim($this->request->query['name'])) > 0) {
            if (isset($this->request->query['lang_code']) && $this->request->query['lang_code'] != null) {
                $lang_code = $this->request->query['lang_code'];
            }
            $name = trim($this->request->query['name']);
            $this->request->query['name'] = $name;
            $options['conditions'][$lang_code.'.name_ascii']['$regex'] = new MongoRegex("/" . mb_strtolower($this->convert_vi_to_en($name)) . "/i");
        }
        if (isset($this->request->query['lang_code']) && $this->request->query['lang_code'] != null) {
            $lang_code = $this->request->query['lang_code'];
            if ($lang_code == 'vi'){
                $options['conditions']['vi']['$ne'] = null;
            }else{
                $options['conditions']['en']['$ne'] = null;
            }
        }
        if (isset($this->request->query['status']) && strlen($this->request->query['status']) > 0) {
            $status = (int) $this->request->query['status'];
            $this->request->query['status'] = $status;
            $options['conditions']['status']['$eq'] = $status;
        }
        if (isset($this->request->query['categories']) && strlen($this->request->query['categories']) > 0) {
            $catagories = $this->request->query['categories'];
            $options['conditions']['categories'] = ['$eq' => $catagories];
        }

    }

    protected function setInit() {
        $this->set('controller', $this->name);
        $this->set('controller_name', $this->name);
        $this->set('model_name', $this->modelClass);
        $this->set('status', Configure::read('sysconfig.App.status'));
        $this->set('is_hot', Configure::read('sysconfig.App.is_hot'));
        $this->set('feature', Configure::read('sysconfig.App.feature'));
        $categories = $this->Category->getListCateName($this->object_type_code);
        $this->set('categories', $categories);
        $this->set('page_title', __('notebook_title'));

        $lang_code = $this->Session->read('lang_code');
        if ((empty($lang_code))) {
            $lang_code = Configure::read('S.Lang_code_default');
        }
        $this->set('langCodes', $this->langCodes);
        $this->set('lang_code', $lang_code);
    }

    protected function checkAuth() {
        // nếu không có quyền truy cập, thì buộc user phải đăng xuất
        if (!$this->isAllow()) {
            return $this->redirect($this->Auth->loginRedirect);
        }
    }

    private function saveNewData() {
        $save_data = $this->request->data[$this->modelClass];
        // upload file
        $this->FileCommon->autoProcess($save_data);
        $this->{$this->modelClass}->create();
        if ($this->{$this->modelClass}->save($save_data)) {
            $this->Session->setFlash(__('save_successful_message'), 'default', array(), 'good');
            $this->redirect(array('action' => 'index'));
        } else {
            $this->Session->setFlash(__('save_error_message'), 'default', array(), 'bad');
        }
    }

    /**
     * @param $id
     * @param bool $clone
     */
    private function setRequestData($id, $clone = false) {
        $data = $this->{$this->modelClass}->find('first', array(
            'conditions' => array(
                'id' => new MongoId($id),
            ),
        ));
        $this->FileCommon->autoSetFiles($data[$this->modelClass]);
        $this->request->data = $data;
    }
}
