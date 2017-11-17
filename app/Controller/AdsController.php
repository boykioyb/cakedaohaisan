<?php

class AdsController extends AppController {

    public $uses = array('Ad');
    public $components = array(
        'FileCommon',
    );

    public function index() {
        $this->checkAuth();

        $options = [
            'order' => array('modified' => 'DESC')
        ];

        $this->setSearchConds($options);
        $this->Paginator->settings = $options;

        $list_data = $this->Paginator->paginate($this->modelClass);

        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => 'Danh sách Ads',
                )
            ],
            'list_data' => $list_data,
        ]);
    }

    public function add() {
        $this->saveNewData();

        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => 'Danh sách Ads',
                ),
                array(
                    'url' => Router::url(array('action' => __FUNCTION__)),
                    'label' => __('add_action_title'),
                )
            ]
        ]);
    }

    public function addPathAd() {
        $number = $this->request->data('number');
        $this->set('request_data', $this->request->query);
        $this->layout = false;
        $this->autoRender = false;
        $this->set('number', $number);
        return $this->render('add_path_ad');
    }

    public function edit($id = null) {
        $this->checkAuth();
        if (!$this->{$this->modelClass}->exists($id)) {
            throw new NotFoundException(__('invalid_data'));
        }
        $this->{$this->modelClass}->id = new MongoID($id);
        $this->saveNewData();

        $this->setRequestData($id);

        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => 'Danh sách Ads',
                ),
                array(
                    'url' => Router::url(array('action' => __FUNCTION__, $id)),
                    'label' => __('edit_action_title'),
                )
            ]
        ]);

        $this->render('add');
    }

    public function cloneRecord($id = null) {
        $this->checkAuth();
        if (!$this->{$this->modelClass}->exists($id)) {
            throw new NotFoundException(__('invalid_data'));
        }

        $this->saveNewData();

        $this->setRequestData($id, true);

        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => 'Danh sách Ads',
                ),
                array(
                    'url' => Router::url(array('action' => __FUNCTION__, $id)),
                    'label' => __('clone_action_title'),
                )
            ]
        ]);

        $this->render('add');
    }

    protected function setSearchConds(&$options) {

        if (isset($this->request->query['name']) && strlen(trim($this->request->query['name'])) > 0) {
            $name = trim($this->request->query['name']);
            $this->request->query['name'] = $name;
            $options['conditions']['name_ascii']['$regex'] = new MongoRegex("/" . mb_strtolower($this->convert_vi_to_en($name)) . "/i");
        }
        if (isset($this->request->query['code']) && strlen(trim($this->request->query['code'])) > 0) {
            $code = trim($this->request->query['code']);
            $this->request->query['code'] = $code;
            $options['conditions']['code']['$regex'] = new MongoRegex("/" . mb_strtolower($code) . "/i");
        }
        if (isset($this->request->query['region']) && strlen(trim($this->request->query['region'])) > 0) {
            $region = trim($this->request->query['region']);
            $this->request->query['region'] = $region;
            $options['conditions']['region']['$regex'] = new MongoRegex("/" . mb_strtolower($region) . "/i");
        }

        if (isset($this->request->query['status']) && strlen($this->request->query['status']) > 0) {
            $status = (int) $this->request->query['status'];
            $this->request->query['status'] = $status;
            $options['conditions']['status']['$eq'] = $status;
        }

        if (isset($this->request->query['weight']) && strlen($this->request->query['weight']) > 0) {
            $order = (int) $this->request->query['weight'];
            $this->request->query['weight'] = $order;
            $options['conditions']['weight']['$eq'] = $order;
        }
    }

    protected function setInit() {

        $this->set('regions', Configure::read('sysconfig.Ads.region'));
        $this->set('model_name', $this->modelClass);
        $this->set('status', Configure::read('sysconfig.App.status'));
        $this->set('page_title', 'Ads');
    }

    private function checkAuth() {
        // nếu không có quyền truy cập, thì buộc user phải đăng xuất
        if (!$this->isAllow()) {

            return $this->redirect($this->Auth->loginRedirect);
        }
    }

    public function beforeFilter() {
        parent::beforeFilter();
        $this->setInit();
    }

    /**
     * @param $id
     * @param bool $clone
     */
    private function setRequestData($id, $clone = false) {
        if ($this->request->data) {
            return;
        }
        $data = $this->{$this->modelClass}->find('first', array(
            'conditions' => array(
                'id' => new MongoId($id),
            ),
        ));
        $this->FileCommon->autoSetFiles($data[$this->modelClass]);
        $this->request->data = $data;
        if ($clone && isset($this->request->data[$this->modelClass]['id'])) {
            $this->request->data[$this->modelClass]['ref_id'] = $this->request->data[$this->modelClass]['id'];
            unset($this->request->data[$this->modelClass]['id']);
        }
    }

    private function saveNewData() {
        if ($this->request->is('post') || $this->request->is('put')) {
            $save_data = $this->request->data[$this->modelClass];
            $this->FileCommon->autoProcess($save_data);
            if ($this->{$this->modelClass}->save($save_data)) {
                $this->Session->setFlash(__('save_successful_message'), 'default', array(), 'good');
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Session->setFlash(__('save_error_message'), 'default', array(), 'bad');
            }
        }
    }

}
