<?php

class SeoContentBehavior extends ModelBehavior {

    public function beforeSave(\Model $model, $options = array()) {
        parent::beforeSave($model, $options);
        $config_lang = Configure::read('S.Lang');

        foreach ($config_lang as $code => $lang) {
            if (isset($model->data[$model->alias][$code]['meta_tags']) && empty($model->data[$model->alias][$code]['meta_tags']) && !empty($model->data[$model->alias][$code]['tags'])) {
                $model->data[$model->alias][$code]['meta_tags'] = implode(', ', $model->data[$model->alias][$code]['tags']);
            }
            if (isset($model->data[$model->alias][$code]['meta_title']) && empty($model->data[$model->alias][$code]['meta_title'])) {
                $model->data[$model->alias][$code]['meta_title'] = !empty($model->data[$model->alias][$code]['title']) ? $model->data[$model->alias][$code]['title'] : (!empty($model->data[$model->alias][$code]['name']) ? $model->data[$model->alias][$code]['name'] : '');
            }
            if (isset($model->data[$model->alias][$code]['meta_description']) && empty($model->data[$model->alias][$code]['meta_description'])) {
                $model->data[$model->alias][$code]['meta_description'] = !empty($model->data[$model->alias][$code]['description']) ? $model->data[$model->alias][$code]['description'] : '';
            }
        }
        return true;
    }
}
