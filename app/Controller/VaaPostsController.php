<?php

class VaaPostsController extends AppController {

    public $uses = array(
        'VaaPost',
        'VaaMember',
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

        $getListIdsOwner = $this->{$this->modelClass}->getOwnerIds($list_data, 'owner');
        $owner_ids_pretty = Hash::extract($getListIdsOwner, '{n}.$id');
        $getHashByIds = $this->VaaMember->getHashByIds($owner_ids_pretty);
        $owner = $this->Common->getInfoFromIds($getHashByIds, $getListIdsOwner);

        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('post_title_index'),
                )
            ],
            'list_data' => $list_data,
            'owner' => isset($owner) ? $owner : [],
        ]);
    }

    public function add() {
        $this->checkAuth();

        $this->saveNewData();
        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('post_title_add'),
                ),
                array(
                    'url' => Router::url(array('action' => __FUNCTION__)),
                    'label' => __('add_action_title'),
                )
            ]
        ]);
    }

    public function infoPost($id = null) {
        $this->checkAuth();
        $this->{$this->modelClass}->id = new MongoID($id);
        $post = $this->{$this->modelClass}->find('first', array('conditions' => array('_id' => array('$eq' => $this->{$this->modelClass}->id))));

        $check_data = !empty($post[$this->modelClass]['with_members']) ? $post[$this->modelClass]['with_members'] : [];

        $extract_members = Hash::extract($check_data, '{n}.$id');

        $discussion = $this->Discussion->find('first', array('conditions' => array('_id' => array('$eq' => $post[$this->modelClass]['discussion']))));

        $check_data_discussion = !empty($discussion['Discussion']['join_members']) ? $discussion['Discussion']['join_members'] : [];

        $extract_members_discussion = Hash::extract($check_data_discussion, '{n}.$id');

        $members_get_hash = $this->VaaMember->getHashByIds($extract_members_discussion);
        $result = [];
        foreach ($members_get_hash as $key => $val) {
            if ($val['status'] == 1) {
                $result[$key] = $val['name'];
            }
        }
        $hash_extract = isset($post[$this->modelClass]['files']['attach']) ?
                Hash::extract($post[$this->modelClass]['files']['attach'], '{n}.$id') : array();
        $match_image = $this->Common->getInfoFromIds($post[$this->modelClass]['file_uris']['attach'], $hash_extract);

        $this->set([
            'value_member' => $extract_members,
            'with_member' => $result,
            'match_image' => $match_image,
            'post' => $post
        ]);

        $this->setRequestData($id, TRUE);
        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('post_title_info'),
                )
            ]
        ]);
        $this->render('info');
    }

    public function ajaxGetWithMemberFromDiscussion() {
        $this->checkAuth();
        $this->autoRender = FALSE;
        $id = $this->request->data['id'];
        $discussion_id = $this->Discussion->find('first', array('conditions' => array('_id' => array('$eq' => $id))));
        $with_members = $discussion_id['Discussion']['join_members'];

        $extract = Hash::extract($with_members, '{n}.$id');
        $getHashByIds = $this->VaaMember->getHashByIds($extract);
        $getDiscusstionInfoFromIds = $this->Common->getInfoFromIds($getHashByIds, $extract);
        $checkStatus = [];

        foreach ($getDiscusstionInfoFromIds as $val) {
            if ($val['status'] === 1) {
                $checkStatus[] = $val;
            }
        }

        return json_encode($checkStatus);
    }

    public function edit($id = null) {
        $this->checkAuth();
        if (!$this->{$this->modelClass}->exists($id)) {
            throw new NotFoundException(__('invalid_data'));
        }
        $this->{$this->modelClass}->id = new MongoID($id);
        $members = $this->{$this->modelClass}->find('first', array('conditions' => array('_id' => array('$eq' => $this->{$this->modelClass}->id))));

        $check_data = !empty($members[$this->modelClass]['with_members']) ? $members[$this->modelClass]['with_members'] : [];

        $extract_members = Hash::extract($check_data, '{n}.$id');

        $discussion = $this->Discussion->find('first', array('conditions' => array('_id' => array('$eq' => $members[$this->modelClass]['discussion']))));

        $check_data_discussion = !empty($discussion['Discussion']['join_members']) ? $discussion['Discussion']['join_members'] : [];

        $extract_members_discussion = Hash::extract($check_data_discussion, '{n}.$id');

        $members_get_hash = $this->VaaMember->getHashByIds($extract_members_discussion);
        $result = [];
        foreach ($members_get_hash as $key => $val) {
            if ($val['status'] == 1) {
                $result[$key] = $val['name'];
            }
        }
        $this->saveNewData();

        $this->setRequestData($id);
        $this->set('value_member', $extract_members);
        $this->set('with_member', $result);
        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('post_title_index'),
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
        $this->set('discussion', $this->Discussion->findCode());
        $this->set('page_title', __('post_title_index'));
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
