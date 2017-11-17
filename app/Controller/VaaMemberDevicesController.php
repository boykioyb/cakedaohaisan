<?php

class VaaMemberDevicesController extends AppController {

    public $uses = array(
        'VaaMemberDevice',
        'VaaMember'
    );
    public $components = array(
        'FileCommon',
        'Common'
    );

    public function index() {
        $this->checkAuth();
        $options = [
            'order' => array('modified' => 'DESC')
        ];
        $result = [];
        $this->setSearchConds($options);
        $this->Paginator->settings = $options;
        $list_data = $this->Paginator->paginate($this->modelClass);
        foreach ($list_data as $val) {
            if (isset($val[$this->modelClass]['member']) && !empty($val[$this->modelClass]['member']) && $val[$this->modelClass]['member'] !== null) {
                $result[] = $val[$this->modelClass]['member'];
            }
        }
        if (isset($result) && !empty($result) && $result !== null) {
            $extract = Hash::extract($result, '{n}.$id');
            $get_id_members = $this->VaaMember->getHashByIds($extract);
            $get_data = $this->Common->getInfoFromIds($get_id_members, $result);
        }
        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('membersdevices_title_index'),
                )
            ],
            'list_data' => $list_data,
            'members' => $get_data[0]
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

    public function infoMembers($id = null) {
        $this->checkAuth();
        $this->{$this->modelClass}->id = new MongoID($id);
        $member = $this->{$this->modelClass}->find('first', array('conditions' => array('_id' => $id)));

        $this->setRequestData($id, TRUE);
        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('membersdevices_title_info'),
                )
            ]
        ]);

        $get_id_members = $this->VaaMember->find('first', array('conditions' => array('_id' => $member[$this->modelClass]['member'])));

        $this->set(['info_member' => $member, 'members_name' => $get_id_members['VaaMember']['name']]);

        $this->render('info');
    }

    protected function setSearchConds(&$options) {
        if (isset($this->request->query['id']) && strlen($this->request->query['id']) > 0) {
            $id = $this->request->query['id'];
            $this->request->query['id'] = $id;
            $options['conditions']['id'] = trim($id);
        }
        if (isset($this->request->query['platform']) && strlen($this->request->query['platform']) > 0) {
            $platform = (string) $this->request->query['platform'];
            $platforms = trim($platform);
            $options['conditions']['platform'] = strtoupper($platforms);
        }
        if (isset($this->request->query['client_ip']) && strlen($this->request->query['client_ip']) > 0) {
            $client_ip = $this->request->query['client_ip'];
            $options['conditions']['client_ip'] = new MongoRegex("/$client_ip/i");
        }
        if (isset($this->request->query['uuid']) && strlen($this->request->query['uuid']) > 0) {
            $uuid = trim($this->request->query['uuid']);
            $options['conditions']['uuid'] = new MongoRegex("/$uuid/i");
        }
        if (isset($this->request->query['push_reg_id']) && strlen($this->request->query['push_reg_id']) > 0) {
            $push_reg_id = $this->request->query['push_reg_id'];
            $options['conditions']['push_reg_id'] = trim($push_reg_id);
        }
        if (isset($this->request->query['push_reg_type']) && strlen($this->request->query['push_reg_type']) > 0) {
            $push_reg_type = $this->request->query['push_reg_type'];
            $options['conditions']['push_reg_type'] = strtoupper(trim($push_reg_type));
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
        $this->set('status', Configure::read('sysconfig.VaaMembers.status'));
        $this->set('page_title', __('membersdevices_title_index'));
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
