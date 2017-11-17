<?php

class DocumentsController extends AppController {

    public $uses = array(
        'Document',
        'Country',
        'Category',
        'CategoryDocument',
    );
    public $components = array(
        'FileCommon',
    );
    public $helpers = array('TreeCommon');
    public $object_type_code = null;

    public function index() {
//        $this->checkAuth();
        $this->set('categories', $this->Category->getListCateNameDocuments());
        $options = [
            'order' => array('order' => 'ASC'),
//            'conditions' => [
//                'object_type_code' => $this->object_type_code
//            ]
        ];

        $this->setSearchConds($options);
        $this->Paginator->settings = $options;
        $list_data = $this->Paginator->paginate($this->modelClass);
        $lang_code = $this->Session->read('lang_code');
        foreach ($list_data as $index => $data) {
            $this->setListOtherNames($list_data[$index][$this->modelClass]);
        }
        if (empty($lang_code)) {
            $lang_code = Configure::read('S.Lang_code_default');
        }
        $this->set('lang_code', $lang_code);
        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => 'Văn bản chính quy',
                )
            ],
            'list_data' => $list_data,
        ]);
    }

    public function add() {
        $this->set('categories', $this->Category->getListCateNameDocuments());
        $this->saveNewData();
        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('Văn bản chính quy'),
                ),
                array(
                    'url' => Router::url(array('action' => __FUNCTION__)),
                    'label' => __('add_action_title'),
                )
            ]
        ]);
    }

    public function edit($id = null) {
        $this->set('categories', $this->Category->getListCateNameDocuments());
        $this->checkAuth();
        if (!$this->{$this->modelClass}->exists($id)) {
            throw new NotFoundException(__('invalid_data'));
        }
        $this->{$this->modelClass}->id = new MongoID($id);
        $lang_code = $this->Session->read('lang_code');
        if (empty($lang_code)) {
            $lang_code = Configure::read('S.Lang_code_default');
        }
        $this->set('lang_code', $lang_code);
        $this->saveNewData();

        $this->setRequestData($id);

        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('blog_title'),
                ),
                array(
                    'url' => Router::url(array('action' => __FUNCTION__, $id)),
                    'label' => __('edit_action_title'),
                )
            ]
        ]);
        $this->set('parent', $this->{$this->modelClass}->findListName($id));
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
                    'label' => __('blog_title'),
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

        if (isset($this->request->query['lang_code']) && strlen(trim($this->request->query['lang_code']))) {
            $this->request->query['lang_code'] = trim($this->request->query['lang_code']);
            $this->request->query['name'] = trim($this->request->query['name']);
            $name = $this->request->query['name'];
            $lang_code = $this->request->query['lang_code'];
            $options['conditions'][$lang_code . '.name_ascii']['$regex'] = new MongoRegex("/" . mb_strtolower($this->convert_vi_to_en($name)) . "/i");
        }

        if (isset($this->request->query['categories']) && strlen($this->request->query['categories']) > 0) {
            $catagories = $this->request->query['categories'];
            $options['conditions']['categories'] = ['$eq' => $catagories];
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

        if (isset($this->request->query['parent']) && strlen($this->request->query['parent']) > 0) {
            $parentId = $this->request->query['parent'];
            $this->request->query['parent'] = $parentId;
            $options['conditions']['parent']['$eq'] = new MongoId($parentId);
        }
    }

    protected function setInit() {
        $this->set('model_name', $this->modelClass);
        $this->set('status', Configure::read('sysconfig.App.status_on'));
        $this->set('languages', Configure::read('sysconfig.App.languages'));
        $this->set('page_title', __('blog_title'));
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
        if($this->request->data) {
            return;
        }
        $data = $this->{$this->modelClass}->find('first', array(
            'conditions' => array(
                'id' => $id,
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
            $save_data['release_time'] = new MongoDate(strtotime($save_data['release_time']));
            $save_data['effect_time'] = new MongoDate(strtotime($save_data['effect_time']));
            $save_data['expire_time'] = new MongoDate(strtotime($save_data['expire_time']));
            $config_langs = $this->langCodes;
            foreach ($config_langs as $lang_key => $lang_value) {
                if (isset($save_data[$lang_key]) && count($save_data[$lang_key]) > 0) {
                    if (isset($save_data[$lang_key]['name']) && !empty($save_data[$lang_key]['name'])) {
                        $save_data[$lang_key]['name'] = preg_replace('/([^\pL\.\:\0-9\ ]+)/u', '', $save_data[$lang_key]['name']);
                        if (!empty($save_data['description'])){
                            $save_data[$lang_key]['description'] = $save_data['description'];
                        }
                        if (!empty($save_data['url_alias'])){
                            $save_data[$lang_key]['url_alias'] = $save_data['url_alias'];
                        }
                    }
                } else {
                    $save_data[$lang_key] = null;
                }
            }
            if ($this->{$this->modelClass}->save($save_data)) {
                $this->Session->setFlash(__('save_successful_message'), 'default', array(), 'good');
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Session->setFlash(__('save_error_message'), 'default', array(), 'bad');
            }
        }
    }

}
