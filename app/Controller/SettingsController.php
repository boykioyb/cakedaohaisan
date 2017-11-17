<?php

/**
 * @property mixed User
 * @property mixed LocationCommon
 * @property mixed FileCommon
 * @property mixed Location
 */
class SettingsController extends AppController {

    public $uses = array('Setting', 'User', 'Category');
    public $components = array(
        'FileCommon'
    );

    public function index() {
        $options = [
            'order' => array('modified' => 'DESC')
        ];

        $this->setSearchConds($options);
        $this->Paginator->settings = $options;

        $list_data = $this->Paginator->paginate($this->modelClass, [], [ 'name', 'modified', 'user']);
        $this->setUserInfoInList($list_data);

        $this->set([
            'users' => $this->User->getListName(),
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('website_nav_title'),
                )
            ],
            'list_data' => $list_data
        ]);
    }

    public function add() {
        $options = [
            'conditions' => array(
                'type' => 'WEB'
            ),
            'order' => array('modified' => 'DESC'),
        ];

        $this->setSearchConds($options);

        $list_data = $this->{$this->modelClass}->find('first', $options);
        if(!empty($list_data)){
            $id = $list_data['Setting']['id'];
            $this->redirect(array('controller'=>'Settings','action'=>'edit',$id));
        }else{
            $this->saveNewData();
            $this->set([
                'breadcrumb' => [
                    array(
                        'url' => Router::url(array('action' => 'index')),
                        'label' => __('setting_title'),
                    ),
                    array(
                        'url' => Router::url(array('action' => __FUNCTION__)),
                        'label' => __('add_action_title'),
                    )
                ]
            ]);
        }
    }

    public function edit($id = null) {
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
                    'label' => __('setting_title'),
                ),
                array(
                    'url' => Router::url(array('action' => __FUNCTION__, $id)),
                    'label' => __('edit_action_title'),
                )
            ]
        ]);

        $this->render('add');
    }

    protected function setSearchConds(&$options) {

        if (isset($this->request->query['name'
                ]) && strlen(trim($this->request->query ['name'])) > 0) {
            $name = trim($this->request->query['name']);
            $this->request->query['name'] = $name;
            $options['conditions']['name']['$regex'] = new MongoRegex("/" . mb_strtolower($name) . "/i");
        }

        if (isset($this->request->query['position']) && strlen($this->request->query ['position']) > 0) {
            $position = (int) $this->request->query['position'];
            $this->request->query['position'] = $position;
            $options['conditions']['position']['$eq'] = $position;
        }

        if (isset($this->request->query['status']) && strlen($this->request->query ['status']) > 0) {
            $status = (int) $this->request->query['status'];
            $this->request->query['status'] = $status;
            $options['conditions']['status']['$eq'] = $status;
        }
        $this->commonSearchCondition($options);
    }

    protected function setInit() {
        $this->set('controller_name', $this->name);
        $this->set('model_name', $this->modelClass);
        $this->set('categories', $this->Category->getListCateName('news'));
        $this->set('status', Configure::read('sysconfig.App.status'));
        $this->set('page_title', __('website_nav_title'));
    }

    public function beforeFilter() {
        parent::beforeFilter();
        $this->setInit();
    }

    private function saveNewData() {
        if ($this->request->is('post') || $this->request->is('put')) {
            $save_data = $this->request->data[$this->modelClass];
            $this->FileCommon->autoProcess($save_data);
            if ($this->{$this->modelClass}->save($save_data)) {

                $this->Session->setFlash(__('save_successful_message'), 'default', array(), 'good');
                $this->redirect(array('action' => 'add'));
            } else {

                $this->Session->setFlash(__('save_error_message'), 'default', array(), 'bad');
            }
        }

    }

    /**
     * @param $id
     * @internal param bool $clone
     */
    private function setRequestData($id) {
        $data = $this->{$this->modelClass}->find('first', array(
            'conditions' => array(
                'id' => new MongoId($id),
            ),
        ));

        $this->FileCommon->autoSetFiles($data[$this->modelClass]);
        $this->request->data = $data;
    }
}
