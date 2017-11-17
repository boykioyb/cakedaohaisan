<?php

class SeoRouteBehavior extends ModelBehavior {

    public function afterSave(\Model $model, $created, $options = array()) {
        parent::afterSave($model, $created, $options);
        $config_lang = Configure::read('S.Lang');

        foreach ($config_lang as $code => $lang) {
            if (
                    isset($model->data[$model->alias]['status']) &&
                    !empty($model->data[$model->alias][$code]['url_alias'])
            ) {
                $seoRouterModel = ClassRegistry::init('SeoRoute');
                $id = isset($model->id) ? $model->id : $model->getLastInsertID();
                if (!is_object($id)) {
                    $id = new MongoId($id);
                }
                // get old data
                $status = isset($model->data[$model->alias]['status']) ? $model->data[$model->alias]['status'] : 0;

                $data = $seoRouterModel->find('first', array(
                    'conditions' => array(
                        'object_id' => $id,
                        'lang_code' => $code
                    )
                ));
                $save = array(
                    'object_type_code' => $model->useTable,
                    'object_id' => $id,
                    'lang_code' => $code,
                    'url' => $model->data[$model->alias][$code]['url_alias'],
                    'status' => $status,
                );
                if ($data) {
                    // update
                    $seoRouterModel->id = new MongoId($data[$seoRouterModel->alias]['id']);
                } else {
                    // insert new record
                    $seoRouterModel->create();
                }
                // save vào bảng seo_routers
                $seoRouterModel->save($save);
            }
        }
        return true;
    }

    public function afterDelete(\Model $model) {
        parent::afterDelete($model);

        $seoRouterModel = ClassRegistry::init('SeoRoute');
        if (!empty($model->id)) {
            $id = $model->id;
            if (!is_object($id)) {
                $id = new MongoId($id);
            }
            $seoRouterModel->deleteAll(array('object_id' => $id));
        }

        return true;
    }

}
