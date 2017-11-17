<?php

class TagCommonBehavior extends ModelBehavior {

    public function afterSave(\Model $model, $created, $options = array()) {
        parent::afterSave($model, $created, $options);
        $config_lang = CakeSession::read('List_lang_code');

        foreach ($config_lang as $code => $lang) {
            if (
                    isset($model->data[$model->alias]['status']) &&
                    isset($model->data[$model->alias][$code]['tags']) &&
                    is_array($model->data[$model->alias][$code]['tags']) &&
                    !empty($model->data[$model->alias][$code]['tags'])
            ) {

                App::import('Lib', 'Html2TextUtility');
                App::uses('Tag', 'Model');
                $Tag = new Tag();
                foreach ($model->data[$model->alias][$code]['tags'] as $v) {

                    $v = trim($v);
                    if (!strlen($v)) {

                        continue;
                    }

                    // thực hiện lưu trữ Tag
                    $Tag->store($model->alias, $v, $model->data[$model->alias]['status']);
                }
            }
        }
        return true;
    }

    public function beforeSave(\Model $model, $options = array()) {
        parent::beforeSave($model, $options);

        $config_lang = Configure::read('S.Lang');
        foreach ($config_lang as $lang_code => $lang) {
            //Begin TungPT --> Thêm tên tào tags trong trường hợp trường tên chưa có trong tags
            if (isset($model->data[$model->alias][$lang_code]['name_origin']) && !empty($model->data[$model->alias][$lang_code]['name_origin'])) {
                if (isset($model->data[$model->alias][$lang_code]['tags']) &&
                        is_array($model->data[$model->alias][$lang_code]['tags']) &&
                        !empty($model->data[$model->alias][$lang_code]['tags'])
                ) {
                    $check_exits_tag = array_search(trim($model->data[$model->alias][$lang_code]['name_origin']), $model->data[$model->alias][$lang_code]['tags']);
                    if (!is_numeric($check_exits_tag)) {
                        array_push($model->data[$model->alias][$lang_code]['tags'], trim($model->data[$model->alias][$lang_code]['name_origin']));
                    }
                } else {
                    $model->data[$model->alias][$lang_code]['tags'] = array();
                    $model->data[$model->alias][$lang_code]['tags'] = array(trim($model->data[$model->alias][$lang_code]['name_origin']));
                }
            }
            
            if (isset($model->data[$model->alias][$lang_code]['actors']) && is_array($model->data[$model->alias][$lang_code]['actors']) && !empty($model->data[$model->alias][$lang_code]['actors'])) {
                if (isset($model->data[$model->alias][$lang_code]['tags']) &&
                        is_array($model->data[$model->alias][$lang_code]['tags']) &&
                        !empty($model->data[$model->alias][$lang_code]['tags'])
                ) {
                    foreach ($model->data[$model->alias][$lang_code]['actors'] as $actors) {
                        $check_exits_tag = array_search(trim($actors), $model->data[$model->alias][$lang_code]['tags']);
                        if (!is_numeric($check_exits_tag)) {
                            array_push($model->data[$model->alias][$lang_code]['tags'], trim($actors));
                        }
                    }
                } else {
                    $model->data[$model->alias][$lang_code]['tags'] = array();
                    foreach ($model->data[$model->alias][$lang_code]['actors'] as $actors) {
                        if (!is_numeric($check_exits_tag)) {
                            array_push($model->data[$model->alias][$lang_code]['tags'], trim($actors));
                        }
                    }
                }
            }
            if (isset($model->data[$model->alias][$lang_code]['directors']) && is_array($model->data[$model->alias][$lang_code]['directors']) && !empty($model->data[$model->alias][$lang_code]['directors'])) {
                if (isset($model->data[$model->alias][$lang_code]['tags']) &&
                        is_array($model->data[$model->alias][$lang_code]['tags']) &&
                        !empty($model->data[$model->alias][$lang_code]['tags'])
                ) {
                    foreach ($model->data[$model->alias][$lang_code]['directors'] as $directors) {
                        $check_exits_tag = array_search(trim($directors), $model->data[$model->alias][$lang_code]['tags']);
                        if (!is_numeric($check_exits_tag)) {
                            array_push($model->data[$model->alias][$lang_code]['tags'], trim($directors));
                        }
                    }
                } else {
                    $model->data[$model->alias][$lang_code]['tags'] = array();
                    foreach ($model->data[$model->alias][$lang_code]['directors'] as $directors) {
                        if (!is_numeric($check_exits_tag)) {
                            array_push($model->data[$model->alias][$lang_code]['tags'], trim($directors));
                        }
                    }
                }
            }
            //End TungPT

            if (
                    isset($model->data[$model->alias][$lang_code]['tags']) &&
                    is_array($model->data[$model->alias][$lang_code]['tags']) &&
                    !empty($model->data[$model->alias][$lang_code]['tags'])
            ) {

                App::import('Lib', 'Html2TextUtility');
                $tags = $model->data[$model->alias][$lang_code]['tags'];
                $model->data[$model->alias][$lang_code]['tags_ascii'] = array();
                $model->data[$model->alias][$lang_code]['tags'] = array();
                $tag_index = 0;
                $tags_ascii_index = 0;
                foreach ($tags as $v) {

                    $v = trim($v);
                    if (!strlen($v)) {

                        continue;
                    }
                    $model->data[$model->alias][$lang_code]['tags'][$tag_index] = $v;

                    // thực hiện tạo ra tags_ascii
                    $content = Html2TextUtility::getText($v);
                    $tags_ascii = strtolower($model->convert_vi_to_en($content));
                    if (
                            isset($model->data[$model->alias][$lang_code]['tags_ascii']) &&
                            is_array($model->data[$model->alias][$lang_code]['tags_ascii']) &&
                            !empty($model->data[$model->alias][$lang_code]['tags_ascii'])
                    ) {
                        $check_exits_tagsascii = array_search(trim($tags_ascii), $model->data[$model->alias][$lang_code]['tags_ascii']);
                        if (!is_numeric($check_exits_tagsascii)) {
                            $model->data[$model->alias][$lang_code]['tags_ascii'][$tags_ascii_index] = trim($tags_ascii);
                            $tags_ascii_index ++;
                        }
                    } else {
                        $model->data[$model->alias][$lang_code]['tags_ascii'][$tags_ascii_index] = trim($tags_ascii);
                        $tags_ascii_index ++;
                    }
                    $tag_index++;
                }
            }

            // khi user thực hiện edit, bỏ tag đã gán ra khỏi content
            if (!empty($model->data[$model->alias][$lang_code]['id']) && isset($model->data[$model->alias][$lang_code]['tags'])) {

                // đọc lại thông tin
                $get_back = $model->find('first', array(
                    'conditions' => array(
                        'id' => new MongoId($model->data[$model->alias][$lang_code]['id']),
                    ),
                ));

                // nếu content trước đó chưa được gán tag
                if (empty($get_back[$model->alias][$lang_code]['tags']) || !is_array($get_back[$model->alias][$lang_code]['tags'])) {

                    return true;
                }

                $tags = $get_back[$model->alias][$lang_code]['tags'];
                $current_tags = $model->data[$model->alias][$lang_code]['tags'];

                // thực hiện so sánh các tags đã gán với tags đang được gán hiện tại
                // để tìm ra các tags đã bị bỏ gán khỏi content
                $this->minusTags($tags, $current_tags, $model);
            }
            unset($model->data[$model->alias][$lang_code]['lang_code']);
        }
        return true;
    }

    protected function minusTags($tags, $current_tags, $model) {

        App::uses('Tag', 'Model');
        $Tag = new Tag();

        // nếu tags hiện tại đã bị bỏ gán hoàn toàn
        if (empty($current_tags)) {

            foreach ($tags as $v) {

                $this->minusTagCount($Tag, $v, $model);
            }
        } else {

            foreach ($tags as $k => $v) {

                $tags[$k] = mb_strtolower($v);
            }

            foreach ($current_tags as $k => $v) {

                $current_tags[$k] = mb_strtolower($v);
            }

            // tìm ra các tag đã bị bỏ gán khỏi content
            $minus_tags = array_diff($tags, $current_tags);
            if (empty($minus_tags)) {

                return;
            }

            foreach ($minus_tags as $v) {

                $this->minusTagCount($Tag, $v, $model);
            }
        }
    }

    /**
     * minusTagCount
     * giảm số lượt Tag count
     * 
     * @param Model $Tag
     * @param string $name
     * @param Model $model
     * 
     * @return mixed
     */
    protected function minusTagCount($Tag, $name, $model) {

        $tag_exist = $Tag->checkExist($name, $model->useTable);
        if (empty($tag_exist)) {

            return;
        }
//        $tag_count = (int) $tag_exist['Tag']['count'];
        $tag_count = $Tag->countExist($model->alias, $name);
        if ($tag_count - 1 <= 0) {

            $Tag->save(array(
                'id' => $tag_exist['Tag']['id'],
                'count' => 0,
                'status' => Configure::read('sysconfig.App.constants.STATUS_DELETE'),
            ));
        } else {

            // đếm tổng số content đang public được gán vào tag
            $tag_public_count = $Tag->countExist($model->alias, $name, array(
                'conditions' => array(
                    'status' => Configure::read('sysconfig.App.constants.STATUS_APPROVED'),
                    'id' => array(
                        '$ne' => new MongoId($model->data[$model->alias]['id']),
                    ),
                ),
            ));

            if ($tag_public_count > 0) {

                $Tag->save(array(
                    'id' => $tag_exist['Tag']['id'],
                    'count' => $tag_count - 1,
                    'status' => Configure::read('sysconfig.App.constants.STATUS_APPROVED'),
                ));
            } else {

                $Tag->save(array(
                    'id' => $tag_exist['Tag']['id'],
                    'count' => $tag_count - 1,
                    'status' => Configure::read('sysconfig.App.constants.STATUS_HIDDEN'),
                ));
            }
        }
    }

    public function beforeDelete(\Model $model, $cascade = true) {
        parent::beforeDelete($model, $cascade);

        $get_back = $model->find('first', array(
            'conditions' => array(
                'id' => new MongoId($model->id),
            ),
        ));
        if (empty($get_back[$model->alias]['tags']) || !is_array($get_back[$model->alias]['tags'])) {

            return true;
        }

        $tags = $get_back[$model->alias]['tags'];

        App::uses('Tag', 'Model');
        $Tag = new Tag();

        foreach ($tags as $v) {

            $check_exist = $Tag->checkExist($v, $model->useTable);
            if (empty($check_exist)) {

                continue;
            }

//            $count = $check_exist['Tag']['count'];
            $count = $Tag->countExist($model->alias, $v);

            // nếu tag được gán vào nhiều hơn 1 content, thì giảm số lượng gán đi -1
            if ($count > 1) {

                $count_public = $Tag->countExist($model->alias, $v, array(
                    'conditions' => array(
                        'status' => Configure::read('sysconfig.App.constants.STATUS_APPROVED'),
                        'id' => array(
                            '$ne' => new MongoId($model->id),
                        ),
                    ),
                ));

                if ($count_public > 0) {

                    $Tag->save(array(
                        'id' => $check_exist['Tag']['id'],
                        'count' => $count - 1,
                        'status' => Configure::read('sysconfig.App.constants.STATUS_APPROVED'),
                    ));
                } else {

                    $Tag->save(array(
                        'id' => $check_exist['Tag']['id'],
                        'count' => $count - 1,
                        'status' => Configure::read('sysconfig.App.constants.STATUS_HIDDEN'),
                    ));
                }
            }
            // nếu tag được gán vào nhỏ hơn 1 content, thì thực hiện set cờ xóa
            else {

                $Tag->save(array(
                    'id' => $check_exist['Tag']['id'],
                    'count' => 0,
                    'status' => Configure::read('sysconfig.App.constants.STATUS_DELETE'),
                ));
            }
        }

        return true;
    }

}
