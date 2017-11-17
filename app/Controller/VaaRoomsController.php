<?php

class VaaRoomsController extends AppController {

    public $uses = array(
        'VaaRoom',
        'VaaMember',
        'FileManaged',
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

        $this->setSearchConds($options);
        $this->Paginator->settings = $options;
        $list_data = $this->Paginator->paginate($this->modelClass);

        $getListIdsOwner = $this->{$this->modelClass}->getOwnerIds($list_data, 'owner');
        $owner_ids_pretty = Hash::extract($getListIdsOwner, '{n}.$id');
        $getHashByIds = $this->VaaMember->getHashByIds($owner_ids_pretty);
        $owner = $this->Common->getInfoFromIds($getHashByIds, $getListIdsOwner);

        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('room_title_index'),
                )
            ],
            'list_data' => $list_data,
            'owner' => isset($owner) ? $owner : [],
        ]);
    }

    public function infoRoom($id = null) {
        $this->checkAuth();
        $this->{$this->modelClass}->id = new MongoID($id);
        $room = $this->{$this->modelClass}->find('first', array('conditions' => array('_id' => array('$eq' => $this->{$this->modelClass}->id))));

        $getIdMembers = !empty($room[$this->modelClass]['members']) ? $room[$this->modelClass]['members'] : [];
        $extract_members = Hash::extract($getIdMembers, '{n}.$id');

        $getIdHiddenBy = !empty($room[$this->modelClass]['hidden_by']) ? $room[$this->modelClass]['hidden_by'] : [];
        $extract_hidden_by = Hash::extract($getIdHiddenBy, '{n}.$id');

        $getIdDisable = !empty($room[$this->modelClass]['disable_pushes']) ? $room[$this->modelClass]['disable_pushes'] : [];
        $extract_disable_pushes = Hash::extract($getIdDisable, '{n}.$id');

        $getIdSocket = !empty($room[$this->modelClass]['socket_ids']) ? $room[$this->modelClass]['socket_ids'] : [];
        $extract_socket_ids = Hash::extract($getIdSocket, '{n}.$id');



        $this->set([
            'value_member' => $extract_members,
            'value_hidden_by' => $extract_hidden_by,
            'value_disable_pushes' => $extract_disable_pushes,
            'value_socket_ids' => $extract_socket_ids,
            'room' => $room
        ]);

        $this->setRequestData($id, TRUE);
        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('room_title_info'),
                )
            ]
        ]);
        $this->render('info');
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

    protected function setSearchConds(&$options) {

        if (isset($this->request->query['id']) && strlen($this->request->query['id']) > 0) {
            $id = $this->request->query['id'];
            $this->request->query['id'] = $id;
            $options['conditions']['id'] = trim($id);
        }

        if (isset($this->request->query['status']) && strlen($this->request->query['status']) > 0) {
            $status = $this->request->query['status'];
            $options['conditions']['status'] = (int) trim($status);
        }
        if (isset($this->request->query['online']) && strlen($this->request->query['online']) > 0) {
            $online = $this->request->query['online'];
            $options['conditions']['online'] = (int) trim($online);
        }
        if (isset($this->request->query['owner']) && strlen($this->request->query['owner']) > 0) {
            $owner_name = trim($this->request->query['owner']);

            $options['conditions']['owner'] = new MongoID($owner_name);
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
        $this->set('status', Configure::read('sysconfig.VaaMembers.status'));
        $this->set('status_online', Configure::read('sysconfig.VaaRooms.status_online'));
        $this->set('owner_id', $this->VaaMember->findCode());
        $this->set('members', $this->VaaMember->findCode());
        $this->set('page_title', __('room_title_index'));
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
    }

    private function saveNewData() {
        if ($this->request->is('post') || $this->request->is('put')) {
            $save_data = $this->request->data[$this->modelClass];

            $this->FileCommon->autoProcess($save_data);
            if (isset($save_data) && count($save_data) > 0) {
                if (isset($save_data['content']) && !empty($save_data['content'])) {
                    $save_data['content'] = preg_replace('/([^\pL\.\:\0-9\ ]+)/u', '', $save_data['content']);
                }
            } else {
                $save_data = null;
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
