<?php

/**
 * @property mixed NewEntity
 * @property mixed User
 * @property mixed LocationCommon
 * @property mixed FileCommon
 * @property mixed Location
 * @property mixed Category
 */
class PagesController extends AppController
{
    public $uses = array('Page', 'Category', 'User');
    public $components = array('FileCommon');

    public function beforeRender()
    {
        parent::beforeRender();
        $this->set('entity', $this->NewEntity);
    }

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->setInit();
    }

    public function index()
    {
        $this->checkAuth();

        $options = [
            'order' => array('modified' => 'DESC')
        ];

        $this->setSearchConds($options);
        $this->Paginator->settings = $options;

        $list_data = $this->Paginator->paginate($this->modelClass, [], ['order', 'modified', 'user', 'name', 'source']);
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
                    'label' => 'Danh sách Pages',
                )
            ],
            'list_data' => $list_data
        ]);
    }

    public function add()
    {
        $this->checkAuth();

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->saveNewData();
        }

        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => 'Danh sách Pages',
                ),
                array(
                    'url' => Router::url(array('action' => __FUNCTION__)),
                    'label' => __('add_action_title'),
                )
            ]
        ]);
    }

    public function edit($id = null)
    {
        $this->checkAuth();
        if (!$this->{$this->modelClass}->exists($id)) {
            throw new NotFoundException(__('invalid_data'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {

            $save_data = $this->request->data[$this->modelClass];

            // upload file
            $this->FileCommon->autoProcess($save_data, '', array(), false);

            $edit_id = new MongoId($id);
            $config_langs = $this->langCodes;
            foreach ($config_langs as $lang_key => $lang_value) {
                if (isset($save_data[$lang_key]) && count($save_data[$lang_key]) > 0) {
                    if (isset($save_data[$lang_key]['name']) && !empty($save_data[$lang_key]['name'])) {
                        $save_data[$lang_key]['name'] = preg_replace('/([^\pL\.\:\0-9\ ]+)/u', '', $save_data[$lang_key]['name']);
                        $save_data[$lang_key]['name_ascii'] = $this->convert_vi_to_en($save_data[$lang_key]['name']);
                        $save_data[$lang_key]['short_description_ascii'] = $this->convert_vi_to_en($save_data[$lang_key]['short_description']);
                    }
                } else {
                    $save_data[$lang_key] = null;
                }
            }
            $save_data['id'] = $edit_id;
            unset($save_data['lang_code']);
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
                    'label' => 'Danh sách Pages',
                ),
                array(
                    'url' => Router::url(array('action' => __FUNCTION__)),
                    'label' => __('edit_action_title'),
                )
            ]
        ]);

        $this->render('add');
    }

    protected function setSearchConds(&$options)
    {

        if (isset($this->request->query['lang_code']) && strlen(trim($this->request->query['lang_code']))) {
            $this->request->query['lang_code'] = trim($this->request->query['lang_code']);
            $this->request->query['name'] = trim($this->request->query['name']);
            $name = $this->request->query['name'];
            $lang_code = $this->request->query['lang_code'];
            $options['conditions'][$lang_code . '.name_ascii']['$regex'] = new MongoRegex("/" . mb_strtolower($this->convert_vi_to_en($name)) . "/i");
        }
        if (isset($this->request->query['status']) && strlen($this->request->query['status']) > 0) {
            $status = (int)$this->request->query['status'];
            $this->request->query['status'] = $status;
            $options['conditions']['status']['$eq'] = $status;
        }
    }

    protected function setInit()
    {
        $options = array(
            'conditions' => array(
                'object_type_code' => 'pages',
            ),
        );
        $this->set('controller', $this->name);
        $this->set('controller_name', $this->name);
        $this->set('model_name', $this->modelClass);
        $this->set('status', Configure::read('sysconfig.App.status'));
        $this->set('page_title', 'Danh sách Pages');

        $lang_code = $this->Session->read('lang_code');
        if ((empty($lang_code))) {
            $lang_code = Configure::read('S.Lang_code_default');
        }
        $this->set('langCodes', $this->langCodes);
    }

    protected function checkAuth()
    {
        // nếu không có quyền truy cập, thì buộc user phải đăng xuất
        if (!$this->isAllow()) {
            return $this->redirect($this->Auth->loginRedirect);
        }
    }

    private function saveNewData()
    {
        $save_data = $this->request->data[$this->modelClass];

        // upload file
        $this->FileCommon->autoProcess($save_data, '', array(), false);
        $save_data[$save_data['lang_code']]['name'] = preg_replace('/([^\pL\.\:\0-9\ ]+)/u', '', $save_data[$save_data['lang_code']]['name']);
        $config_langs = $this->langCodes;
        foreach ($config_langs as $lang_key => $lang_value) {
            if (isset($save_data[$lang_key]) && count($save_data[$lang_key]) > 0) {
                if (isset($save_data[$lang_key]['name']) && !empty($save_data[$lang_key]['name'])) {
                    $save_data[$lang_key]['name'] = preg_replace('/([^\pL\.\:\0-9\ ]+)/u', '', $save_data[$lang_key]['name']);
                    $save_data[$lang_key]['name_ascii'] = $this->convert_vi_to_en($save_data[$lang_key]['name']);
                    $save_data[$lang_key]['short_description_ascii'] = $this->convert_vi_to_en($save_data[$lang_key]['short_description']);
                    if (!empty($save_data['meta_title'])) {
                        $meta_title = $save_data['meta_title'];
                    }
                    if (!empty($meta_title)) {
                        $save_data[$lang_key]['meta_title'] = $meta_title;
                    } else {
                        $save_data[$lang_key]['meta_title'] = $save_data[$lang_key]['name'];
                    }
                    if (isset($save_data['meta_description'])) {
                        $meta_description = $save_data['meta_description'];
                    }
                    if (!empty($meta_description)) {
                        $save_data[$lang_key]['meta_description'] = $meta_description;
                    } else {
                        $save_data[$lang_key]['meta_description'] = $save_data[$lang_key]['short_description'];
                    }

                }
            } else {
                $save_data[$lang_key] = null;
            }
        }
        unset($save_data['lang_code']);
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
    private
    function setRequestData($id, $clone = false)
    {
        $data = $this->{$this->modelClass}->find('first', array(
            'conditions' => array(
                'id' => new MongoId($id),
            ),
        ));

        $this->FileCommon->autoSetFiles($data[$this->modelClass], array(), false);
        $this->request->data = $data;

        if ($clone && isset($this->request->data[$this->modelClass]['id'])) {
            $this->request->data[$this->modelClass]['ref_id'] = $this->request->data[$this->modelClass]['id'];
            unset($this->request->data[$this->modelClass]['id']);
        }
    }

    /**
     *
     */

    public function display()
    {
        $path = func_get_args();

        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        $page = $subpage = $title_for_layout = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        if (!empty($path[$count - 1])) {
            $title_for_layout = Inflector::humanize($path[$count - 1]);
        }
        $this->set(compact('page', 'subpage', 'title_for_layout'));

        try {
            $this->render(implode('/', $path));
        } catch (MissingViewException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }

}
