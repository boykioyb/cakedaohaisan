<?php

class CommonBehavior extends ModelBehavior {

    public function getHashByIds(\Model $model, $mongoids) {
        $getByIds = $model->find('all', array(
            'conditions' => array(
                '_id' => array(
                    '$in' => $mongoids
                ),
            ),
        ));
        return !empty($getByIds) ?
                Hash::combine($getByIds, '{n}.' . $model->alias . '.id', '{n}.' . $model->alias) : array();
    }

    public function getOwnerIds(\Model $model, $array, $value) {
        $arr = [];
        for ($i = 0; $i < count($array); $i++) {
            if (isset($array[$i][$model->alias][$value]) && !empty($array[$i][$model->alias][$value]) && $array[$i][$model->alias][$value] !== null) {
                $array_discusstion = $array[$i][$model->alias][$value];
                $arr[] = $array_discusstion;
            }
        }
        return $arr;
    }

}
