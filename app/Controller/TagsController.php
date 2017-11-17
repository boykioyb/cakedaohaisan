<?php
class TagsController extends AppController{
    public $uses = array(
        'Tag',
        'ObjectType',
    );
    public $object_type_code = null;
    public function index(){
        $this->set('model_name', $this->modelClass);
        $options = [
            'order' => array('modified' => 'DESC')
        ];

        $this->setSearchConds($options);

        $this->Paginator->settings = $options;
        $list_data = $this->Paginator->paginate($this->modelClass, [], [ 'name', 'modified', 'user']);
        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => 'Tag',
                )
            ],
            'list_data' => $list_data
        ]);
    }

    public function setSearchConds(&$options){
        if (isset($this->request->query['name']) && strlen(trim($this->request->query['name'])) > 0) {
            $name = trim($this->request->query['name']);
            $this->request->query['name'] = $name;
            $options['conditions']['name']['$regex'] = new MongoRegex("/" . mb_strtolower($name) . "/i");
        }
    }
}