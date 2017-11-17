<?php

class VaaStoryCommentsController extends AppController {

    public $uses = array(
        'VaaStoryComment',
        'VaaMember',
        'VaaStory'
    );
    public $components = array(
        'FileCommon',
        'Common',
    );

    public function index() {
        $this->checkAuth();
        $options = [
            'order' => array('modified' => 'DESC')
        ];

        $this->setSearchConds($options);
        $this->Paginator->settings = $options;
        $list_data = $this->Paginator->paginate($this->modelClass);
        // List story
        $getListIdsStory = $this->{$this->modelClass}->getOwnerIds($list_data, 'story');
        $story_ids_pretty = Hash::extract($getListIdsStory, '{n}.$id');
        $getHashByIdsStory = $this->VaaStory->getHashByIds($story_ids_pretty);
        $getStoryInfoFromIds = $this->Common->getInfoFromIds($getHashByIdsStory, $getListIdsStory);
        // List Owner
        $getListIdsOwner = $this->{$this->modelClass}->getOwnerIds($list_data, 'owner');
        $owner_ids_pretty = Hash::extract($getListIdsOwner, '{n}.$id');
        $getHashByIds = $this->VaaMember->getHashByIds($owner_ids_pretty);
        $owner_ids_prettyInfoFromIds = $this->Common->getInfoFromIds($getHashByIds, $getListIdsOwner);

        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('stories_comment_title_index'),
                )
            ],
            'list_data' => $list_data,
            'owner' => isset($owner_ids_prettyInfoFromIds) ? $owner_ids_prettyInfoFromIds : [],
            'story' => isset($getStoryInfoFromIds) ? $getStoryInfoFromIds : []
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

    public function infoStory($id = null) {
        $this->checkAuth();
        $this->{$this->modelClass}->id = new MongoID($id);
        $story = $this->{$this->modelClass}->find('all', array('conditions' => array('_id' => $id)));

        // List discussion
        $getListIdsStory = $this->{$this->modelClass}->getOwnerIds($story, 'story');
        $story_ids_pretty = Hash::extract($getListIdsStory, '{n}.$id');
        $getHashByIdsStory = $this->VaaStory->getHashByIds($story_ids_pretty);
        $getStoryInfoFromIds = $this->Common->getInfoFromIds($getHashByIdsStory, $getListIdsStory);
        // List Owner
        $getListIdsOwner = $this->{$this->modelClass}->getOwnerIds($story, 'owner');
        $owner_ids_pretty = Hash::extract($getListIdsOwner, '{n}.$id');
        $getHashByIds = $this->VaaMember->getHashByIds($owner_ids_pretty);
        $owner_ids_prettyInfoFromIds = $this->Common->getInfoFromIds($getHashByIds, $getListIdsOwner);

        $this->setRequestData($id, TRUE);
        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => __('stories_share_title_info'),
                )
            ]
        ]);

        $this->set([
            'story' => $story[0],
            'owner' => isset($owner_ids_prettyInfoFromIds[0]) ? $owner_ids_prettyInfoFromIds[0] : [],
            'story_id' => isset($getStoryInfoFromIds[0]) ? $getStoryInfoFromIds[0] : [],
        ]);


        $this->render('info');
    }

    protected function setSearchConds(&$options) {
        if (isset($this->request->query['id']) && strlen($this->request->query['id']) > 0) {
            $id = $this->request->query['id'];
            $this->request->query['id'] = $id;
            $options['conditions']['id'] = trim($id);
        }
        if (isset($this->request->query['owner']) && strlen($this->request->query['owner']) > 0) {
            $owner_name = trim($this->request->query['owner']);

            $options['conditions']['owner'] = new MongoID($owner_name);
        }
        if (isset($this->request->query['story']) && strlen($this->request->query['story']) > 0) {
            $story = trim($this->request->query['story']);
            $options['conditions']['story'] = new MongoID($story);
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
        $this->set('owner_id', $this->VaaMember->findCode());
        $this->set('page_title', __('stories_comment_title_index'));
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

}
