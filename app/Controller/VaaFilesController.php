<?php

class VaaFilesController extends AppController {

    public $uses = array(
        'VaaFile'
    );
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

        foreach ($list_data as $index => $data) {
            $this->setListOtherNames($list_data[$index][$this->modelClass]);
        }
        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('file_title_index'),
                )
            ],
            'list_data' => $list_data,
        ]);
    }

    public function ajaxChangeStatus() {
        $this->checkAuth();
        $this->autoRender = FALSE;
        $state = 0;
        $status = $this->request->data['status'];
        $id = $this->request->data['id'];
        if (!$this->{$this->modelClass}->exists($id)) {
            throw new NotFoundException(__('invalid_data'));
        }
        $idMongo = new MongoID($id);
        $data = array('id' => $idMongo, 'status' => $status);
        if ($this->{$this->modelClass}->save($data)) {
            $state = 1;
        }
        return json_encode($state);
    }

    public function infoFiles($id = null) {
        $this->checkAuth();
        $this->{$this->modelClass}->id = new MongoID($id);
        $file = $this->{$this->modelClass}->find('first', array('conditions' => array('_id' => $id)));

        $this->setRequestData($id, TRUE);
        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('file_title_info'),
                )
            ]
        ]);


        $this->set('file', $file);


        $this->render('info');
    }

    protected function setSearchConds(&$options) {
        if (isset($this->request->query['id']) && strlen($this->request->query['id']) > 0) {
            $id = $this->request->query['id'];
            $this->request->query['id'] = $id;
            $options['conditions']['id'] = trim($id);
        }
        if (isset($this->request->query['name']) && strlen($this->request->query['name']) > 0) {
            $name = (string) $this->request->query['name'];
            $names = trim($name);
            $options['conditions']['name'] = new MongoRegex("/$names/i");
        }
        if (isset($this->request->query['uri']) && strlen($this->request->query['uri']) > 0) {
            $uri = trim($this->request->query['uri']);
            $options['conditions']['uri'] = new MongoRegex("/$uri/i");
        }
        if (isset($this->request->query['min']) && isset($this->request->query['max'])) {
            $min = trim($this->request->query['min']);
            $max = trim($this->request->query['max']);
            $options['conditions']['size']['$gte'] = (int) $min;
            $options['conditions']['size']['$lt'] = (int) $max;
        }

        if (isset($this->request->query['module']) && strlen($this->request->query['module']) > 0) {
            $module = $this->request->query['module'];
            $options['conditions']['module'] = trim($module);
        }
        if (isset($this->request->query['mime']) && strlen($this->request->query['mime']) > 0) {
            $mime = $this->request->query['mime'];
            switch ($mime) {
                case 0:
                    $options['conditions']['mime'] = 'image/png';
                    break;
                case 1:
                    $options['conditions']['mime'] = 'image/jpg';
                    break;
                case 2:
                    $options['conditions']['mime'] = 'image/jpeg';
                    break;
                case 3:
                    $options['conditions']['mime'] = 'image/gif';
                    break;
                case 4:
                    $options['conditions']['mime'] = 'image/tiff';
                    break;
                case 5:
                    $options['conditions']['mime'] = 'image/bmp';
                    break;
            }
        }
        if (isset($this->request->query['status']) && strlen($this->request->query['status']) > 0) {
            $status = $this->request->query['status'];
            $options['conditions']['status'] = (int) trim($status);
        }
        if (isset($this->request->query['start']) && strlen($this->request->query['start']) > 0) {
            $dateStart = $this->request->query['start'];
            $start = new MongoDate(strtotime($dateStart));
            $options['conditions']['created']['$gte'] = $start;
        }
        if (isset($this->request->query['end']) && strlen($this->request->query['end']) > 0) {
            $dateEnd = $this->request->query['end'];

            $end = new MongoDate(strtotime($dateEnd));
            $options['conditions']['created']['$lt'] = $end;
        }
    }

    protected function setInit() {
        $this->set('model_name', $this->modelClass);
        $this->set('gender', Configure::read('sysconfig.VaaMembers.gender'));
        $this->set('mime', Configure::read('sysconfig.VaaFiles.image_format'));
        $this->set('status', Configure::read('sysconfig.VaaMembers.status'));
        $this->set('page_title', __('Danh sách các File'));
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

}
