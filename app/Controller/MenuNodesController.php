<?php

App::uses('AppController', 'Controller');

/**
 * @property mixed MenuNode
 * @property mixed FileCommon
 */
class MenuNodesController extends AppController {

    public $uses = array(
        'MenuNode',
        'Menu',
        'Page',
        'Category',
    );
    public $components = array(
        'FileCommon',
    );
    public $menuCode = null;

    public function beforeFilter() {
        parent::beforeFilter();
        // nếu không có quyền truy cập, thì buộc user phải đăng xuất
        if (!$this->isAllow()) {
            return $this->redirect($this->Auth->loginRedirect);
        }
    }

    public function index() {
        if ($this->request->is('post')) {
            $dataMenu = $this->request->data['Menu'];

            $this->menuCode = $dataMenu['menu_code'];
            $menuNodes = json_decode($dataMenu['menu_nodes'], true);

            /* Deleted nodes */
            $deletedNodes = explode(' ', trim($dataMenu['deleted_nodes']));
            foreach ($deletedNodes as $deletedNode) {
                $this->MenuNode->delete($deletedNode);
            }

            $this->_recursiveSaveMenu($menuNodes, 0);
        }

        $this->request->data['Menu']['deleted_nodes'] = '';

        $menuType = Configure::read('sysconfig.App.type_menu');
        if ($menuType) {
            $this->menuCode = array_keys($menuType)[0];
        }

        if (isset($this->request->query['menu_code'])) {
            $this->menuCode = $this->request->query['menu_code'];
        }
        if (isset($this->request->query['lang_code'])) {
            $this->Session->write('lang_code', $this->request->query['lang_code']);
            $this->langCodeDefault = $this->request->query['lang_code'];
        }

        $menuList = $this->_getMenu();
        $pages = $this->Page->find('all', array(
            'conditions' => array(
                'status' => 1,
                $this->langCodeDefault => array(
                    '$exists' => true
                )
            )
        ));

        $categories = $this->Category->find('all', array(
            'conditions' => array(
                'status' => 1,
                $this->langCodeDefault => array(
                    '$exists' => true
                )
            )
        ));

        $cates = [];
        foreach ($categories as $category) {
            $objectType = $category['Category']['object_type_code'];
            if (!isset($cates[$category['Category']['object_type_code']])) {
                $cates[$objectType] = array(
                    $category['Category']
                );
            } else {
                $cates[$objectType][] = $category['Category'];
            }
        }

        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => 'Danh sách Menu',
                )
            ],
            'page_title' => 'Danh sách Menu',
            'pages' => $pages,
            'categories' => $cates,
            'menu' => $menuType,
            'menuChoice' => $this->menuCode,
            'menuList' => $menuList,
            'lang_code' => $this->langCodeDefault
        ]);
    }

    public function addNodeToMenu() {
        $this->autoRender = $this->layout = false;
        $request = $this->request->data;
        $type = $request['type'];
        if (empty($request['value'])) {
            return false;
        }
        $menuList = [];
        switch ($type) {
            case EXTERNAL_LINK:
                $menuList[] = array(
                    'type' => $type,
                    'id' => '',
                    'related_id' => '',
                    'link' => $request['value']['url'],
                    $this->langCodeDefault => array(
                        'name' => $request['value']['name']
                    )
                );
                break;
            case 'Pages':
                $pages = array();
                foreach ($request['value'] as $item) {
                    $pages[] = $this->Page->findById($item);
                }
                foreach ($pages as $page) {
                    $page = $page['Page'];
                    $menuList[] = array(
                        'type' => $type,
                        'id' => '',
                        'related_id' => $page['id'],
                        'link' => '',
                        $this->langCodeDefault => array(
                            'name' => $page[$this->langCodeDefault]['name']
                        )
                    );
                }
                break;
            default:
                $categories = array();
                foreach ($request['value'] as $item) {
                    $categories[] = $this->Category->findById($item);
                }

                foreach ($categories as $category) {
                    $category = $category['Category'];
                    $menuList[] = array(
                        'type' => $type,
                        'id' => '',
                        'related_id' => $category['id'],
                        'link' => '',
                        $this->langCodeDefault => array(
                            'name' => $category[$this->langCodeDefault]['name']
                        )
                    );
                }
        }

        $this->set(compact('menuList'));

        return $this->renderView('../Elements/MenuNestable/_nestable-item');
    }

    protected function _getMenu($parentId = null) {
        $conditions = array(
            'status' => 1,
            'menu_code' => $this->menuCode,
        );
        if ($parentId) {
            $conditions['parent_id'] = $parentId;
        } else {
            $conditions['$or'] = array(
                array('parent_id' => 0),
                array('parent_id' => null),
                array('parent_id' => ''),
            );
        }

        $menuList = $this->MenuNode->find('all', array(
            'conditions' => $conditions,
            'order' => array('order' => 'ASC')
        ));
        $menus = [];
        foreach ($menuList as $key => $item) {
            $item = $item['MenuNode'];
            $item['children'] = $this->_getMenu($item['id']);
            $menus[] = $item;
        }

        return $menus;
    }

    protected function _recursiveSaveMenu($menuArray, $parent_id) {
        foreach ($menuArray as $key => $row) {
            $parent = $this->_saveMenuNode($row, $parent_id, $key);
            if ($parent != null) {
                if (!empty($row['children'])) {
                    $this->_recursiveSaveMenu($row['children'], $parent);
                }
            }
        }
    }

    protected function _saveMenuNode($node, $parent_id, $position) {
        $listType = [
            'Pages', 'PagesCategories',
            'NewsCategories', 'News',
            'DocumentsCategories', 'Documents',
            'NotebooksCategories', 'Notebooks'];

        if ($this->request->data['Menu']['menu_code'] === 'APP_LEFT_MENU' && in_array($node['type'], $listType)
        ) {
            $node['customurl'] = lcfirst($node['type']) . '/' . $node['relatedid'];
        }
        if (!empty($parent_id)) {
            $parent_id = $parent_id;
        }
        $data = [
            'id' => (isset($node['id'])) ? $node['id'] : 0,
            $this->langCodeDefault => array(
                'name' => (isset($node['name'])) ? $node['name'] : '',
            ),
            'menu_code' => $this->menuCode,
            'status' => 1,
            'link' => (isset($node['customurl'])) ? $node['customurl'] : '',
            'target' => (isset($node['target'])) ? $node['target'] : '',
            'type' => (isset($node['type'])) ? $node['type'] : '',
            'parent_id' => $parent_id,
            'order' => $position
        ];
        switch ($node['type']) {
            case EXTERNAL_LINK: {
                    $data['related_id'] = 0;
                }
                break;
            default: {
                    $data['related_id'] = new MongoId($node['relatedid']);
                }
                break;
        }

        if (empty($data['id'])) {
            $this->MenuNode->create();
        }
        $node = $this->MenuNode->save($data);

        return $node['MenuNode']['id'];
    }

    public function edit($id = null) {
        $this->setInit();
        $this->{$this->modelClass}->id = $id;
        if (!$this->{$this->modelClass}->exists()) {
            throw new NotFoundException(__('invalid_data'));
        }

        $breadcrumb = array(
            array(
                'url' => Router::url(array('action' => 'index')),
                'label' => __('menu_title'),
            ),
            array(
                'url' => Router::url(array('action' => __FUNCTION__, $id)),
                'label' => __('edit_action_title'),
            )
        );
        $this->set(array(
            'breadcrumb' => $breadcrumb,
            'page_title' => __('menu_title')
        ));

        if ($this->request->is('post') || $this->request->is('put')) {
            $save_data = $this->request->data[$this->modelClass];
            if ($this->{$this->modelClass}->save($save_data)) {
                $this->FileCommon->autoProcess($save_data);
                $this->{$this->modelClass}->save($save_data);
                $this->Session->setFlash(__('save_successful_message'), 'default', array(), 'good');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('save_error_message'), 'default', array(), 'bad');
            }
        } else {
            $data = $this->{$this->modelClass}->find('first', array(
                'conditions' => array(
                    'id' => new MongoId($id),
                ),
            ));

            $this->request->data = $data;
        }
    }

    protected function setInit() {
        $lang_code = $this->Session->read('lang_code');
        if ((empty($lang_code))) {
            $lang_code = Configure::read('S.Lang_code_default');
        }
        $this->set('lang_code', $lang_code);
        $this->set('langCodes', $this->langCodes);
        $this->set('model_name', $this->modelClass);
        $this->set('listMenu', $this->Menu->find('all'));
        $this->set('status', Configure::read('sysconfig.App.status_on'));
        $this->set('type', Configure::read('sysconfig.App.type_menu'));
        $parents = $this->Menu->find('all', array(
            'conditions' => array(
                'status' => 1,
                $lang_code => array(
                    '$exists' => true
                )
            )
        ));
        $temp = [];
        foreach ($parents as $parent) {
            $temp[$parent['Menu']['id']] = $parent['Menu'][$lang_code]['name'];
        }
        $this->set('parents', $temp);
    }

}
