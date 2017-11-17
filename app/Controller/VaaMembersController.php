<?php

class VaaMembersController extends AppController {

    public $uses = array(
        'VaaMember',
        'Discussion',
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

        foreach ($list_data as $index => $data) {
            $this->setListOtherNames($list_data[$index][$this->modelClass]);
        }
        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('members_title_index'),
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

    public function infoMembers($id = null) {
        $this->checkAuth();
        $this->{$this->modelClass}->id = new MongoID($id);
        $member = $this->{$this->modelClass}->find('first', array('conditions' => array('_id' => $id)));

        $this->setRequestData($id, TRUE);
        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('members_title_info'),
                )
            ]
        ]);
        $blacklist_member_ids = [];
        $friend_member_ids = [];
        if (isset($member[$this->modelClass]['friends']) && !empty($member[$this->modelClass]['friends'])) {
            $friend_member_ids = $this->_getMemberIds($member, 'friends');
        }

        if (isset($member[$this->modelClass]['blacklists']) && !empty($member[$this->modelClass]['blacklists'])) {
            $blacklist_member_ids = $this->_getMemberIds($member, 'blacklists');
        }

        $member_ids = array_merge($friend_member_ids, $blacklist_member_ids);
        $array_values = array_values(array_unique($member_ids));
        $member_ids_pretty = Hash::extract($array_values, '{n}.$id');
        $members = $this->{$this->modelClass}->getHashByIds($member_ids_pretty);
        $friends = $this->Common->getInfoFromIds($members, $friend_member_ids);
        $blacklists = $this->Common->getInfoFromIds($members, $blacklist_member_ids);
        if (isset($member[$this->modelClass]['discussions']) && !empty($member[$this->modelClass]['discussions'])) {
            $discussion_id = $this->_getMemberIds($member, 'discussions');
            $discussion_ids_pretty = Hash::extract($discussion_id, '{n}.$id');
            $discussions = $this->Discussion->getHashByIds($discussion_ids_pretty);
            $discussion = $this->Common->getInfoFromIds($discussions, $discussion_ids_pretty);
        }
        $this->set('member', $member);
        $this->set('friend', isset($friends) ? $friends : []);
        $this->set('blacklists', isset($blacklists) ? $blacklists : []);
        $this->set('discussions', isset($discussion) ? $discussion : []);

        $this->render('info');
    }

    protected function _getMemberIds($member, $value) {
        $arr = [];
        $friend = $member[$this->modelClass][$value];
        if (isset($friend) && !empty($friend) && $friend !== null) {
            for ($i = 0; $i < count($friend); $i++) {
                array_push($arr, $friend[$i]);
            }
        }
        return $arr;
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
        if (isset($this->request->query['username']) && strlen($this->request->query['username']) > 0) {
            $username = trim($this->request->query['username']);
            $options['conditions']['username'] = new MongoRegex("/$username/i");
        }
        if (isset($this->request->query['email']) && strlen($this->request->query['email']) > 0) {
            $email = $this->request->query['email'];
            $emails = trim($email);
            $options['conditions']['email'] = new MongoRegex("/$emails/i");
        }
        if (isset($this->request->query['mobile']) && strlen($this->request->query['mobile']) > 0) {
            $mobile = $this->request->query['mobile'];
            $options['conditions']['mobile'] = trim($mobile);
        }
        if (isset($this->request->query['birthday']) && strlen($this->request->query['birthday']) > 0) {
            $birthday = $this->request->query['birthday'];
            $format = date('Ymd', strtotime($birthday));
            $options['conditions']['birthday'] = (int) trim($format);
        }
        if (isset($this->request->query['gender']) && strlen($this->request->query['gender']) > 0) {
            $gender = $this->request->query['gender'];
            $options['conditions']['gender'] = (int) trim($gender);
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
        $this->set('page_title', __('members_title_index'));
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
