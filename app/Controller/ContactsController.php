<?php 
class ContactsController extends AppController{
    public function index(){
        $this->set('model_name', $this->modelClass);
        $options = [
            'order' => array('modified' => 'DESC')
        ];

//        $this->setSearchConds($options);
        $this->Paginator->settings = $options;

        $list_data = $this->Paginator->paginate($this->modelClass, [], [ 'name', 'modified', 'user']);
        $this->setUserInfoInList($list_data);
        $this->set([
//            'users' => $this->User->getListName(),
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => 'Liên hệ',
                )
            ],
            'list_data' => $list_data
        ]);
    }
}