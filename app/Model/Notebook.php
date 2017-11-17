<?php

class Notebook extends AppModel {

    public $useTable = 'notebooks';
    public $actsAs = array('FileCommon', 'ContentPermission');
    public $validate = array(
        'url_alias' => array(
            'rule' => 'isUnique',
            'message' => 'This url_alias has already been taken.'
        ),
    );
    public $customSchema = array(
        'id' => null,
        'data_locale' => [//các trường mà phụ thuộc ngôn ngữ + quốc gia thì đưa vào đây
            'name' => '',
            'name_ascii' => '',
            'url_alias' => '',
            'short_description' => '',
            'short_description_ascii' => '',
            'description' => '',
            'meta_title' => '',
            'meta_description' => '',
            'meta_tags' => '',
            'tags' => [],
            'tags_ascii' => [],
        ],
        'categories' => null,
        'files' => null,
        'file_uris' => null,
        'is_hot' => 0,
        'feature' => 0,
        'weight' => 0,
        'view_count' => 0,
        'status' => 0,
        'user' => null,
        'user_modified' => null,
        'created' => null,
        'modified' => null,
    );
    public $asciiFields = array(
        'data_locale.name',
        'data_locale.short_description',
        'data_locale.tags',
    );


    public function setUniqueSlug($slug, $id = null) {
        $i = 1;
        $baseSlug = $slug;

        while ($this->isExistsSlug($slug, $id)) {
            $slug = $baseSlug . "-" . $i++;
        }
        return $slug;
    }

    public function isExistsSlug($slug, $id = null) {
        if ($id == null) {//truong hop add
            $rs = $this->getBySlug($slug);

            if (!empty($rs))
                return true;
            else
                return false;
        }else {//truong hop edit
            $by_id = $this->getById($id);

            $_slug = (isset($by_id[$this->alias]['slug'])) ? $by_id[$this->alias]['slug'] : "";
            if ($slug == $_slug) { //truong hop edit ko sua slug
                return false;
            } else { // truong hop edit co sua slug
                $rs = $this->getBySlug($slug);

                if (!empty($rs))
                    return true;
                else
                    return false;
            }
        }
    }

    public function getById($id) {
        return $this->find('first', array(
            'conditions' => array(
                'id' => new MongoId($id)
            )
        ));
    }

    public function getBySlug($slug) {
        return $this->find('first', array(
            'conditions' => array(
                'slug' => $slug
            )
        ));
    }

    public function beforeSave($options = array()) {
        parent::beforeSave($options);

        if (isset($this->data[$this->alias]['status'])) {
            $this->data[$this->alias]['status'] = (int) $this->data[$this->alias]['status'];
        }
    }

    /*
     * get list news id
     * @param $options
     * @param $lang_code
     */

    public function getListNewsIdByName($name, $lang_code = false) {
        $arr_list_news_name = array();
        if ($lang_code && empty($lang_code)) {
            return $arr_list_news_name;
        }
        $default_options['conditions'][$lang_code . '.tags_ascii']['$regex'] = new MongoRegex("/" . $name . "/i");
        $default_options['fields'] = array('id');
        $arr_news = $this->find('list', $default_options);
        if (empty($arr_news)) {
            return $arr_news;
        }
        foreach ($arr_news as $index => $news_id) {
            $arr_news[$index] = new MongoId($news_id);
        }

        return array_values($arr_news);
    }

    /*
     * get list news name
     * @param $options
     * @param $lang_code
     */

    public function getListNewsName($options = false, $lang_code = false) {
        $arr_list_news_name = array();
        if ($lang_code && empty($lang_code)) {
            return $arr_list_news_name;
        }
        $default_options = array();
        if ($options) {
            $default_options = Hash::merge($default_options, $options);
        }

        $arr_news = $this->find('all', $default_options);
        if (empty($arr_news)) {
            return $arr_list_news_name;
        }
        foreach ($arr_news as $news) {
            if (isset($news['News'][$lang_code])) {
                $arr_list_news_name[$news['News']['id']] = $news['News'][$lang_code]['name'];
            }
        }
        return $arr_list_news_name;
    }

    public function findNameById($id) {
        $result = $this->find('first',array('conditions' => ['id' => new MongoId($id)]));
        return isset($result['News']['vi']['name']) ? $result['News']['vi']['name'] : '---';
    }

}
