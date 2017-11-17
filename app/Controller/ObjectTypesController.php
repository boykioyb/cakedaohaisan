<?php

class ObjectTypesController extends AppController {

    public $uses = array('ObjectType');
    public $components = array(
        'FileCommon',
    );

    public function index() {
        if (!$this->isAllow()) {
            return $this->redirect($this->Auth->loginRedirect);
        }

        $this->setInit();

        $breadcrumb = array();
        $breadcrumb[] = array(
            'url' => Router::url(array('action' => 'index')),
            'label' => __('object_type_title'),
        );
        $this->set('breadcrumb', $breadcrumb);
        $this->set('page_title', __('object_type_title'));

        $options = array();
        $options['order'] = array('modified' => 'DESC');

        $this->Paginator->settings = $options;

        $list_data = $this->Paginator->paginate($this->modelClass);
        $this->set('list_data', $list_data);
    }

    public function add() {
        if (!$this->isAllow()) {
            return $this->redirect($this->Auth->loginRedirect);
        }

        $this->setInit();

        $location_relations = $this->getList('ObjectType');
        $this->set('location_relations', $location_relations);

        $breadcrumb = array();
        $breadcrumb[] = array(
            'url' => Router::url(array('action' => 'index')),
            'label' => __('object_type_title'),
        );
        $breadcrumb[] = array(
            'url' => Router::url(array('action' => __FUNCTION__)),
            'label' => __('add_action_title'),
        );
        $this->set('breadcrumb', $breadcrumb);
        $this->set('page_title', __('object_type_title'));

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

    public function edit($id = null) {
        if (!$this->isAllow()) {
            return $this->redirect($this->Auth->loginRedirect);
        }

        $this->{$this->modelClass}->id = $id;
        if (!$this->{$this->modelClass}->exists()) {

            throw new NotFoundException(__('invalid_data'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {

            $this->add();
        } else {

            $this->setInit();

            $opts_location_ralations = array();
            $opts_location_ralations['conditions']['id']['$ne'] = $id;
            $location_relations = $this->getList('ObjectType', 'name', $opts_location_ralations);
            $this->set('location_relations', $location_relations);

            $breadcrumb = array();
            $breadcrumb[] = array(
                'url' => Router::url(array('action' => 'index')),
                'label' => __('object_type_title'),
            );
            $breadcrumb[] = array(
                'url' => Router::url(array('action' => __FUNCTION__, $id)),
                'label' => __('edit_action_title'),
            );
            $this->set('breadcrumb', $breadcrumb);
            $this->set('page_title', __('object_type_title'));

//                        $this->request->data = $this->{$this->modelClass}->read(null, $id);
            $data = $this->{$this->modelClass}->find('first', array(
                'conditions' => array(
                    'id' => new MongoId($id),
                ),
            ));
//            $this->FileCommon->autoSetFiles($data[$this->modelClass]);
            $this->request->data = $data;
        }

        $this->render('add');
    }

    protected function setInit() {

        $this->set('model_name', $this->modelClass);
        $this->set('status', Configure::read('sysconfig.App.status'));

        $status_approved = Configure::read('sysconfig.App.constants.STATUS_APPROVED');
        // lấy ra danh sách parent
        $parent = $this->{$this->modelClass}->find('list', array(
            'conditions' => array(
                '$or' => array(
                    array(
                        'parent_id' => '',
                    ),
                    array(
                        'parent_id' => array(
                            '$exists' => false,
                        ),
                    ),
                ),
                'status' => $status_approved,
            ),
            'order' => array(
                'order' => 'ASC',
            ),
            'fields' => ['id', 'name']
        ));
        $this->set('parent', $parent);
    }

}
