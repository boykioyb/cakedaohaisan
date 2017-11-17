<?php

class MembersController extends AppController {

    public $uses = array(
        'Member',
        'Country',
        'Category',
        'Region',
        'FileManaged',
    );
    public $components = array(
        'FileCommon',
    );
    public $helpers = array('TreeCommon');
    public $object_type_code = null;

    public function index() {
//        $this->checkAuth();
        $options = [
            'order' => array('order' => 'ASC'),
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
                    'label' => 'Thành viên của hiệp hội',
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
                    'label' => __('Thành viên của hiệp hội'),
                ),
                array(
                    'url' => Router::url(array('action' => __FUNCTION__)),
                    'label' => __('add_action_title'),
                )
            ]
        ]);
    }

    public function edit($id = null) {
//        $this->checkAuth();
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
                    'label' => __('Thành viên của hiệp hội'),
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
                    'label' => __('Thành viên của hiệp hội'),
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
        $this->set('status', Configure::read('sysconfig.App.status_member'));
        $this->set('languages', Configure::read('sysconfig.App.languages'));
        $this->set('page_title', __('Thành viên của hiệp hội'));
        $this->set('region_codes', $this->Region->findCode());
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
        if ($this->request->data) {
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
            $config_langs = $this->langCodes;
            foreach ($config_langs as $lang_key => $lang_value) {
                if (isset($save_data[$lang_key]) && count($save_data[$lang_key]) > 0) {
                    if (isset($save_data[$lang_key]['name']) && !empty($save_data[$lang_key]['name'])) {
                        $save_data[$lang_key]['name'] = preg_replace('/([^\pL\.\:\0-9\ ]+)/u', '', $save_data[$lang_key]['name']);
                        $first_letter = substr(trim($save_data[$lang_key]['name']), 0, 1);
                        $save_data[$lang_key]['first_letter'] = strtoupper($first_letter);
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

    public function import() {
        $this->checkAuth();
        $cityList = $this->Region->find('list', array(
            'conditions' => array(
                'status' => 1
            ),
            'fields' => 'code, id'
        ));
        $cityListBySlug = array();
        foreach ($cityList as $key => $item) {
            $cityListBySlug[$this->convert_vi_to_en($key)] = $item;
        }
        if ($this->request->is('post')) {
            $requestData = $this->request->data;
            $this->FileCommon->autoProcess($requestData);
            $requestData['file_uris'] = $this->parseFileUris($requestData['files']);
            $errors = array();
            if (!empty($requestData['file_uris']['files'])) {
                $file_imported = new File(APP . array_values($requestData['file_uris']['files'])[0]);
                // read file excel
                App::import('Vendor', 'php-excel-reader/excel_reader2');
                $data = new Spreadsheet_Excel_Reader($file_imported->path, true, "UTF-8");
                $data = $data->dumptoarray();
                array_shift($data);

                // generate saveData
                foreach ($data as $item) {
                    $saveData = array(
                        'vi' => array(
                            'name' => !empty($item['name']) ? $item['name'] : '',
                            'address' => !empty($item['address']) ? $item['address'] : '',
                            'contact_name' => !empty($item['contact_name']) ? $item['contact_name'] : '',
                        ),
                        'mobile' => !empty($item['mobile']) ? $item['mobile'] : '',
                        'website' => !empty($item['website']) ? $item['website'] : '',
                        'contact_email' => !empty($item['contact_email']) ? $item['contact_email'] : '',
                        'contact_mobile' => !empty($item['contact_mobile']) ? $item['contact_mobile'] : '',
                        'region' => !empty($cityListBySlug[$this->convert_vi_to_en($item['city'])]) ? $cityListBySlug[$this->convert_vi_to_en($item['city'])] : null,
                        'status' => 0
                    );

                    $this->{$this->modelClass}->create();
                    if (!$this->{$this->modelClass}->save($saveData)) {
                        $errors[] = __('The record %s cannot be saved', json_encode($saveData));
                    }
                }
            }
            if (!empty($errors)) {
                $this->Session->setFlash(json_encode($errors), 'default', array(), 'bad');
            } else {
                $this->Session->setFlash(__('save_successful_message'), 'default', array(), 'good');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    protected function parseFileUris($files) {
        $filesUri = array();
        foreach ($files as $k => $v) {

            if (!is_array($v) || empty($v)) {

                continue;
            }

            foreach ($v as $vv) {
                $file = $this->FileManaged->find('first', array(
                    'conditions' => array(
                        'id' => $vv,
                    ),
                ));
                $file_id = (string) $vv;
                if (empty($file)) {
                    continue;
                }

                $filesUri[$k][$file_id] = $file['FileManaged']['uri'];
            }
        }

        return $filesUri;
    }

}
