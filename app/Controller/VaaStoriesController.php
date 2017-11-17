<?php

class VaaStoriesController extends AppController {

    public $uses = array(
        'VaaStory',
        'VaaMember',
        'Feeling',
        'Discussion',
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
        //owner
        $getListIdsOwner = $this->{$this->modelClass}->getOwnerIds($list_data, 'owner');
        $owner_ids_pretty = Hash::extract($getListIdsOwner, '{n}.$id');
        $getHashByIds = $this->VaaMember->getHashByIds($owner_ids_pretty);
        $owner = $this->Common->getInfoFromIds($getHashByIds, $getListIdsOwner);
        //feeding
        $getListIdsFeeling = $this->{$this->modelClass}->getOwnerIds($list_data, 'feeling');
        $feeding_ids_pretty = Hash::extract($getListIdsFeeling, '{n}.$id');
        $getHashByIdsFeeling = $this->Feeling->getHashByIds($feeding_ids_pretty);
        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('stories_title_index'),
                )
            ],
            'list_data' => $list_data,
            'owner' => isset($owner) ? $owner : [],
            'feeling' => isset($getHashByIdsFeeling) ? $getHashByIdsFeeling : [],
        ]);
    }

    public function infoStory($id = null) {
        $this->checkAuth();
        $this->{$this->modelClass}->id = new MongoID($id);
        $stories = $this->{$this->modelClass}->find('all', array('conditions' => array('_id' => array('$eq' => $this->{$this->modelClass}->id))));
        //feeding
        $getListIdsFeeling = $this->{$this->modelClass}->getOwnerIds($stories, 'feeling');
        $feeding_ids_pretty = Hash::extract($getListIdsFeeling, '{n}.$id');
        $getHashByIdsFeeling = $this->Feeling->getHashByIds($feeding_ids_pretty);
        $feeling = $this->Common->getInfoFromIds($getHashByIdsFeeling, $getListIdsFeeling);
        //with_member

        $check_data = !empty($stories[0][$this->modelClass]['with_members']) ? $stories[0][$this->modelClass]['with_members'] : [];
        $extract_members = Hash::extract($check_data, '{n}.$id');
        $members_get_hash = $this->VaaMember->getHashByIds($extract_members);

        $result = [];
        foreach ($members_get_hash as $key => $val) {
            if ($val['status'] == 1) {
                $result[$key] = $val['name'];
            }
        }
        $this->set([
            'stories' => $stories[0],
            'with_member' => $result,
            'value_member' => $extract_members
        ]);
        $this->setRequestData($id, TRUE);
        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('stories_title_info'),
                )
            ],
            'feeling' => isset($feeling) && !empty($feeling) ? $feeling[0]['vi']['name'] : null
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
        $this->set('owner_id', $this->VaaMember->findCode());
        $this->set('members', $this->VaaMember->findCode());
        $this->set('page_title', __('stories_title_index'));
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
