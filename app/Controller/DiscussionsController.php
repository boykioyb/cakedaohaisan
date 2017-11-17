<?php

class DiscussionsController extends AppController {

    public $uses = array(
        'Discussion',
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
            'order' => array('created' => 'DESC'),
        ];

        $this->setSearchConds($options);
        $this->Paginator->settings = $options;
        $list_data = $this->Paginator->paginate($this->modelClass);
        $getListIdsDiscusstion = $this->{$this->modelClass}->getOwnerIds($list_data, 'owner');
        $discusstion_ids_pretty = Hash::extract($getListIdsDiscusstion, '{n}.$id');
        $getHashByIds = $this->VaaMember->getHashByIds($discusstion_ids_pretty);
        $getDiscusstionInfoFromIds = $this->Common->getInfoFromIds($getHashByIds, $getListIdsDiscusstion);
        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('discussion_title_index'),
                )
            ],
            'list_data' => $list_data,
            'owner' => isset($getDiscusstionInfoFromIds) ? $getDiscusstionInfoFromIds : []
        ]);
    }

    public function add() {
        $this->checkAuth();
        $this->saveNewData();
        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('discussion_title_add'),
                ),
                array(
                    'url' => Router::url(array('action' => __FUNCTION__)),
                    'label' => __('add_action_title'),
                )
            ]
        ]);
    }

    public function edit($id = null) {
        $this->checkAuth();
        if (!$this->{$this->modelClass}->exists($id)) {
            throw new NotFoundException(__('invalid_data'));
        }
        $this->{$this->modelClass}->id = new MongoID($id);

        $join_members = $this->{$this->modelClass}->find('first', array('conditions' => array('_id' => array('$eq' => $this->{$this->modelClass}->id))));
        $check_data = !empty($join_members[$this->modelClass]['join_members']) ? $join_members[$this->modelClass]['join_members'] : [];
        $extract_members = Hash::extract($check_data, '{n}.$id');
        $this->saveNewData();
        $this->setRequestData($id);
        $this->set('value_member', $extract_members);
        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('discussion_title_index'),
                ),
                array(
                    'url' => Router::url(array('action' => __FUNCTION__, $id)),
                    'label' => __('edit_action_title'),
                )
            ]
        ]);
        $this->render('add');
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
        if (isset($this->request->query['name']) && strlen($this->request->query['name']) > 0) {
            $name = (string) $this->request->query['name'];
            $names = trim($name);
            $options['conditions']['name'] = new MongoRegex("/$names/i");
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
        $this->set('status', Configure::read('sysconfig.VaaMembers.status'));
        $this->set('members', $this->VaaMember->findCode());
        $this->set('page_title', __('discussion_title_index'));
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

    protected function _updateDiscusstionToIdsMembers($array = array()) {
        $result = FALSE;
        $mongo = $this->VaaMember->getDataSource();
        $mongoCollectionObject = $mongo->getMongoCollection($this->VaaMember);

        foreach ($array as $val) {
            $result = $mongoCollectionObject->update(
                    array('_id' => $val), array(
                '$push' => array(
                    'discussions' => $this->{$this->modelClass}->id)), array(
                'upsert' => true)
            );
        }

        return $result;
    }

    protected function _removeDiscusstionToIdsMembers($array = array()) {
        $mongo = $this->VaaMember->getDataSource();
        $result_remove_discus = FALSE;
        $mongoCollectionObject = $mongo->getMongoCollection($this->VaaMember);
        foreach ($array as $val) {

            $result_remove_discus = $mongoCollectionObject->update(
                    array('_id' => $val), array(
                '$pull' => array(
                    'discussions' => $this->{$this->modelClass}->id)), array(
                'upsert' => TRUE)
            );
        }
        return $result_remove_discus;
    }

    private function checkDiffDiscussion($data = array()) {
        $mongo = $this->{$this->modelClass}->find('first', array('conditions' => array('_id' => array('$eq' => $this->{$this->modelClass}->id))));
        if (!empty($mongo)) {
            $extrart = $mongo[$this->modelClass]['join_members'];
            $array_diff_remove = array_diff($extrart, $data); // lay phan tu xoa
            if (!empty($array_diff_remove)) {
                $this->_removeDiscusstionToIdsMembers($array_diff_remove);
            }
        }
    }

    private function saveNewData() {
        if ($this->request->is('post') || $this->request->is('put')) {
            $check_empty_data = !empty($this->request->data[$this->modelClass]['join_members']) ? $this->request->data[$this->modelClass]['join_members'] : [];
            $data_convert = $this->Common->convertToMongoIds($check_empty_data);
            $this->checkDiffDiscussion($data_convert);
            $save_data = $this->request->data[$this->modelClass];

            $this->FileCommon->autoProcess($save_data);
            if (isset($save_data) && count($save_data) > 0) {
                if (isset($save_data['name']) && !empty($save_data['name'])) {
                    $save_data['name'] = preg_replace('/([^\pL\.\:\0-9\ ]+)/u', '', $save_data['name']);
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
