<?php

class CommonComponent extends Component {

    public function getInfoFromIds($array_1, $array_2) {
        $result = array();
        foreach ($array_2 as $v) {
            $array_id = (string) $v;
            $result[] = !empty($array_1[$array_id]) ? $array_1[$array_id] : [];
        }
        return $result;
    }

    public function convertToMongoIds($array = array()) {
        $result = [];

        foreach ($array as $val) {
            $result[] = new MongoId($val);
        }
        return $result;
    }

}
