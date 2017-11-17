<?php
App::uses('AppModel', 'Model');
class Test extends AppModel {
    public $pattern = '%s';

    public function getData($data) {
        if (!empty($data['model'])) {
            $model = 'news';
        }
        if (!empty($data['size'])) {
            $size = 500;
        }
        if (!empty($data['field'])) {
            $field  = 'description';
        }
        if (!empty($data['lang_code'])) {
            $lang_code  = 'vi';
        }

        $this->useTable = sprintf($this->pattern, strtolower($model));
        $this->table = sprintf($this->pattern, strtolower($model));

    	$options = array(
			'fields' => [$lang_code],
        	);
            
    	$result = $this->find('all', $options);
        foreach ($result as $k => $v) {
            if ((mb_strlen($v['Test'][$lang_code][$field], 'UTF-8') / 1000) > 1000) {
                $new_arr[] = $v['Test'];
            }
        }
        foreach ($new_arr as $key => $value) {
            $data_res[$key]['STT'] = $key + 1;
            $data_res[$key]['Model'] = $model;
            $data_res[$key]['ID'] = $value['id'];
            $data_res[$key]['NAME'] = $value[$lang_code]['name'];
            $data_res[$key]['FIELD'] = $field;
            $data_res[$key]['LANG_CODE'] = $lang_code;
            $data_res[$key]['SIZE'] = mb_strlen($value[$lang_code][$field], 'UTF-8') / 1000;
        }
        return $data_res;
    }
}