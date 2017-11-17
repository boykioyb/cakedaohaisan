<?php

App::uses('AppController', 'Controller');

class RegionsController extends AppController {

    public $uses = array(
        'Region',
        'Country',
        'ObjectType',
        'Topic',
        'Category'
    );
    public $components = array(
        'FileCommon',
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->setInit();
    }

    public function index() {
//        if (!$this->isAllow()) {
//            return $this->redirect($this->Auth->loginRedirect);
//        }
        $options = [
            'order' => array('modified' => 'DESC')
        ];

        $this->setSearchConds($options);
        $this->Paginator->settings = $options;
        $list_data = $this->Paginator->paginate($this->modelClass);

        foreach ($list_data as $index => $data) {
            $this->setListOtherNames($list_data[$index][$this->modelClass]);
        }

        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('region_title'),
                )
            ],
            'page_title' => __('region_title'),
            'list_data' => $list_data
        ]);
    }

    public function add() {
//        if (!$this->isAllow()) {
//            return $this->redirect($this->Auth->loginRedirect);
//        }
        $this->saveNewData();

        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('region_title'),
                ),
                array(
                    'url' => Router::url(array('action' => __FUNCTION__)),
                    'label' => __('add_action_title'),
                )
            ],
            'page_title' => __('region_title')
        ]);
    }

    public function edit($id = null) {
//        if (!$this->isAllow()) {
//            return $this->redirect($this->Auth->loginRedirect);
//        }
        if (!$this->{$this->modelClass}->exists($id)) {
            throw new NotFoundException(__('invalid_data'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $save_data = $this->request->data[$this->modelClass];
            $this->FileCommon->autoProcess($save_data);

            if ($this->{$this->modelClass}->save($save_data)) {
                $this->addTagByFullName($save_data, $this->modelClass);
                $this->Session->setFlash(__('save_successful_message'), 'default', array(), 'good');
                $this->redirect(array('action' => 'index'));
            } else {

                $this->Session->setFlash(__('save_error_message'), 'default', array(), 'bad');
            }
        }

        $this->setRequestData($id);

        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('region_title'),
                ),
                array(
                    'url' => Router::url(array('action' => __FUNCTION__, $id)),
                    'label' => __('edit_action_title'),
                )
            ],
            'page_title' => __('region_title')
        ]);

        $this->render('add');
    }

    /**
     * @param $options
     */
    protected function setSearchConds(&$options) {
        if (isset($this->request->query['lang_code']) && strlen(trim($this->request->query['lang_code']))) {
            $this->request->query['lang_code'] = trim($this->request->query['lang_code']);
            $this->request->query['name'] = trim($this->request->query['name']);
            $name = $this->request->query['name'];
            $lang_code = $this->request->query['lang_code'];
            $options['conditions'][$lang_code . '.name_ascii']['$regex'] = new MongoRegex("/" . mb_strtolower($this->convert_vi_to_en($name)) . "/i");
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
        $this->set('model_name', $this->modelClass);
        $this->set('status', Configure::read('sysconfig.App.status_regions'));
        $this->set('objectTypeId', $this->object_type_id);

        $lang_code = $this->Session->read('lang_code');
        if (!isset($this->request->data[$this->modelClass]['lang_code']) && !empty($this->request->data[$this->modelClass]['lang_code'])) {
            $lang_code = $this->request->data[$this->modelClass]['lang_code'];
        }
        if (empty($lang_code)) {
            $lang_code = Configure::read('S.Lang_code_default');
        }
        $this->set('lang_code', $lang_code);
        $this->set('langCodes', $this->langCodes);
        $this->set('country', $this->Country->getListCountryCode($lang_code));
    }

    private function saveNewData() {
        if ($this->request->is('post') || $this->request->is('put')) {

            $save_data = $this->request->data[$this->modelClass];
            $config_langs = $this->langCodes;
            foreach ($config_langs as $lang_key => $lang_value) {
                if (isset($save_data[$lang_key]) && count($save_data[$lang_key]) > 0) {
                    if (isset($save_data[$lang_key]['name']) && !empty($save_data[$lang_key]['name'])) {
                        $save_data[$lang_key]['name'] = preg_replace('/([^\pL\.\:\0-9\ ]+)/u', '', $save_data[$lang_key]['name']);
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

    /**
     * @param $id
     * @param bool $clone
     */
    private function setRequestData($id, $clone = false) {
        $request_data = $this->{$this->modelClass}->find('first', array(
            'conditions' => array(
                'id' => new MongoId($id),
            ),
        ));
        $this->request->data = $request_data;

        if ($clone && isset($this->request->data[$this->modelClass]['id'])) {
            $this->request->data[$this->modelClass]['ref_id'] = $this->request->data[$this->modelClass]['id'];
            unset($this->request->data[$this->modelClass]['id']);
        }
    }

    /**
     *
     */
    public function addLangRegions() {
        $this->layout = 'ajax';
        $lang_code = $this->request->query['lang_code'];
        if (empty($lang_code)) {
            die('100');
        }
        $config_lang = $this->langCodes;
        if (isset($config_lang[$lang_code])) {
            $this->set('lang_code', $lang_code);
            $this->set('country', $config_lang[$lang_code]);
        } else {
            die('404');
        }
    }
}
