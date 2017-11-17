<?php

/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Model', 'Model');
App::uses('Country', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

    public $actsAs = array('SeoRoute', 'SeoContent', 'TagCommon', 'ValidationUrlAlias');
    
//    public $object_type_id = null;
//
//    public function beforeValidate($options = array()) {
//        parent::beforeValidate($options);
//        $user = CakeSession::read('Auth.User');
//        if (!empty($user) && empty($this->data[$this->alias]['id']) && !isset($this->data[$this->alias]['user_created'])) {
//            $this->data[$this->alias]['user_created'] = new MongoId($user['id']);
//            $this->data[$this->alias]['user_modified'] = new MongoId($user['id']);
//        }
//        if (!empty($user) && !empty($this->data[$this->alias]['id']) && !isset($this->data[$this->alias]['user_modified'])) {
//            $this->data[$this->alias]['user_modified'] = new MongoId($user['id']);
//        }
//        if (isset($this->data[$this->alias]['status'])) {
//            $this->data[$this->alias]['status'] = (int) $this->data[$this->alias]['status'];
//        }
//        if (isset($this->data[$this->alias]['weight'])) {
//            $this->data[$this->alias]['weight'] = (int) $this->data[$this->alias]['weight'];
//        }
//        if (
//            isset($this->data[$this->alias]['order']) &&
//            strlen($this->data[$this->alias]['order']) > 0
//        ) {
//            $this->data[$this->alias]['order'] = (int) $this->data[$this->alias]['order'];
//        }
//
//        $this->parseFileUrisAfterSave();
//
//        // nếu có định nghĩa schema, bắt chặt dữ liệu theo cấu trúc của schema chi khi create
//        // đồng thời tự tạo ra các fields nếu trong $this->data đầu vào không tồn tại
//        //        if (!empty($this->customSchema) && empty($this->data[$this->alias]['id'])) {
//        //
//        //            $schema_data = $this->mergeCustomSchema($this->customSchema, $this->data[$this->alias]);
//        //            $this->data[$this->alias] = $schema_data;
//        //        }
//        //HoangNN: Kiểm tra kiểu dữ liệu để set giá trị mặc định cho đúng kiểu
//        //Chú ý:
//        // - chỉ kiểm tra 3 cấp, nên khi thiết kế DB chỉ đc thiết kế tối đa 3 cấp
//        // - Trường hợp thêm mới: Kiểm tra toàn bộ các trường trong customSchema để thiết lập đủ trường
//        // - Trường hợp Sửa: Chỉ kiểm tra các trường trên request để thiết lập chuẩn dữ liệu
//        //
//        //1. Lặp các trường để check datatype
//        //2. Nếu là kiểu số
//        //      - trên request là rỗng thì thiết lập về 0
//        //      - trên request là khác rỗng thì ép kiểu về số
//        //3. Nếu là kiểu string: bỏ qua
//        //4. Nếu là kiểu dãy(array): Lặp dãy để check như bước 1
//        if (!empty($this->customSchema)) {
//
//            $country = new Country();
//            $arrQuery = [
//                'fields' => ['language_code'],
//                'conditions' => [
//                    '$and' => [['language_code' => ['$ne' => null]], ['language_code' => ['$ne' => ""]]]
//                ]];
//            $arrCountry = $country->find('all', $arrQuery);
//
//            /**
//             * Kiểm tra các param trong POST có tồn tại trong Schema không, nếu thừa thì xóa các đi
//             * - Kiểm tra cả trong trường file ngôn ngữ
//             */
//            foreach ($this->data[$this->alias] as $key => $value) {
//                /**
//                 * Nếu không tồn tại Key ở level 1, thì phải check xem có phải là trường ngôn ngữ ko mới xóa
//                 */
//                if (!array_key_exists($key, $this->customSchema)) {
//                    $isExisted = false;
//                    if (!empty($arrCountry)) {
//                        foreach ($arrCountry as $country) {
//                            $language_code = $country['Country']['language_code'];
//                            if ($key == $language_code) {
//                                $isExisted = true;
//                                break;
//                            }
//                        }
//                    }
//                    if (!$isExisted) {
//                        unset($this->data[$this->alias][$key]);
//                    }
//                }
//            }
//
//
//            /* /***************************** CHUẨN HÓA DỮ LIỆU *********************************
//             *
//             * Trường hợp Add
//             */
//            if (empty($this->data[$this->alias]['id'])) {
//            //Cấp 1
//                foreach ($this->customSchema as $key => $value) {
//                    $datatype = gettype($value);
//                    switch ($datatype) {
//                        case "integer":
//                            if (empty($this->data[$this->alias][$key])) {
//                                $this->data[$this->alias][$key] = $value;
//                            } else {
//                                $this->data[$this->alias][$key] = (int) $this->data[$this->alias][$key];
//                            }
//                            break;
//                        case "double":
//                            if (empty($this->data[$this->alias][$key])) {
//                                $this->data[$this->alias][$key] = $value;
//                            } else {
//                                $this->data[$this->alias][$key] = (double) $this->data[$this->alias][$key];
//                            }
//                            break;
//                        case "string" :
//                            if (empty($this->data[$this->alias][$key])) {
//                                $this->data[$this->alias][$key] = '';
//                            } else if ($key != "password") {
//                                $this->data[$this->alias][$key] = trim($this->data[$this->alias][$key]);
//                            }
//                            break;
//
//                        case "array" ://Cấp 2
//                            if ($key == "data_locale") {
//                                if (!empty($arrCountry)) {
//                                    foreach ($arrCountry as $country) {
//                                        $language_code = $country['Country']['language_code'];
//                                        if (empty($this->data[$this->alias][$language_code])) {
//                                            continue;
//                                        }
//                                        $this->processAddLevel2($value, $language_code);
//                                    }
//                                }
//                            } else {
//                                $this->processAddLevel2($value, $key);
//                            }
//                            break;  //END Cấp 2
//
//                        default:
//                            if (empty($this->data[$this->alias][$key])) {
//                                $this->data[$this->alias][$key] = $value;
//                            }
//                            break;
//                    }
//                }
//            } else { //Trường hợp Edit
//            //Cấp 1
//                foreach ($this->customSchema as $key => $value) {
//                    $datatype = gettype($value);
//                    switch ($datatype) {
//                        case "integer":
//                            if (!empty($this->data[$this->alias][$key])) {
//                                $this->data[$this->alias][$key] = (int) $this->data[$this->alias][$key];
//                            } else if (isset ($this->data[$this->alias][$key])) {
//                                $this->data[$this->alias][$key] = 0;
//                            }
//                            break;
//                        case "double":
//                            if (!empty($this->data[$this->alias][$key])) {
//                                $this->data[$this->alias][$key] = (double) $this->data[$this->alias][$key];
//                            } else if (isset ($this->data[$this->alias][$key])) {
//                                $this->data[$this->alias][$key] = 0.0;
//                            }
//                            break;
//                        case "string" :
////                            $this->data[$this->alias][$key] = trim($this->data[$this->alias][$key]);
//                            break;
//
//                        case "array" ://Cấp 2: dữ liệu đầu vào phải đầy đủ key=>value, nếu thiếu sẽ bị đè mất trường
//                            if ($key == "data_locale") {
//                                if (!empty($arrCountry)) {
//                                    foreach ($arrCountry as $country) {
//                                        $language_code = $country['Country']['language_code'];
//                                        if (empty($this->data[$this->alias][$language_code])) {
//                                            unset($this->data[$this->alias][$language_code]);
//                                            continue;
//                                        }
//                                        $this->processEditLevel2($value, $language_code);
//                                    }
//                                }
//                            } else {
//                                $this->processEditLevel2($value, $key);
//                            }
//
//                            break;  //END Cấp 2
//
//                        default:
//                            break;
//                    }
//                }
//            }
//        }
//
//        // nếu định nghĩa $asciiFields, thực hiện convert string gốc sang dạng ascii
//        if (!empty($this->asciiFields)) {
//
//            $this->convertFieldsToAscii($this->asciiFields, $this->data[$this->alias]);
//        }
//
//        if (isset($this->data[$this->alias][''])) {
//            unset($this->data[$this->alias]['']);
//        }
//        return true;
//    }
//
//    /**
//     * Xử lý chuẩn hóa dữ liệu cho form Edit từ level 2 trở đi
//     * @param type $value
//     * @param type $key
//     * @author: HoangNN
//     */
//    private function processEditLevel2($value, $key) {
//        if ($key == 'rating') {//Các trường mà chỉ để tương tác người dùng thì ko được update
//            unset($this->data[$this->alias][$key]);
//        } else if ($key == 'permission_specials') {//Các trường mà chỉ để tương tác người dùng thì ko được update
//            $user = CakeSession::read('Auth.User');
//            if ($user['type'] != USER_TYPE_SUPER_ADMIN) {
//                unset($this->data[$this->alias][$key]);
//            }
//        } else if (empty($this->data[$this->alias][$key])) {
//            $this->data[$this->alias][$key] = [];
//        }
//        //Trường hợp dùng mã gói làm key ['data_package' => [param1=>value1,...]]
//        else if (isset($value['data_package'])) {
//            foreach ($this->data[$this->alias][$key] as $key1 => $package) {
//
//                //Kiểm tra từng phần tử của mảng cấp 3 trong schema
//                foreach ($value['data_package'] as $key2 => $value2) {
//                    $datatype2 = gettype($value2);
//                    switch ($datatype2) {
//                        case "integer":
//                            if (!empty($this->data[$this->alias][$key][$key1][$key2])) {
//                                $this->data[$this->alias][$key][$key1][$key2] = (int) $this->data[$this->alias][$key][$key1][$key2];
//                            } else if (isset ($this->data[$this->alias][$key][$key1][$key2])) {
//                                $this->data[$this->alias][$key][$key1][$key2] = 0;
//                            }
//                            break;
//                        case "double":
//                            if (!empty($this->data[$this->alias][$key][$key1][$key2])) {
//                                $this->data[$this->alias][$key][$key1][$key2] = (double) $this->data[$this->alias][$key][$key1][$key2];
//                            } else if (isset ($this->data[$this->alias][$key][$key1][$key2])) {
//                                $this->data[$this->alias][$key][$key1][$key2] = 0.0;
//                            }
//                            break;
//                        case "string" :
//                            if (!empty($this->data[$this->alias][$key][$key1][$key2]) && $key2 != "password") {
//                                $this->data[$this->alias][$key][$key1][$key2] = trim($this->data[$this->alias][$key][$key1][$key2]);
//                            } else if ($key2 != "password" && isset ($this->data[$this->alias][$key][$key1][$key2])) {
//                                $this->data[$this->alias][$key][$key1][$key2] = $value2;
//                            }
//                            break;
//                        default:
//                            if (empty($this->data[$this->alias][$key][$key1][$key2]) && isset($this->data[$this->alias][$key][$key1][$key2])) {
//                                $this->data[$this->alias][$key][$key1][$key2] = $value2;
//                            }
//                            break;
//                    }
//                }
//            }
//        } else {
//            if (!empty($value[0]) && $value[0] == ',') {
//                $arrNewVal = [];
//                foreach ($this->data[$this->alias][$key] as $strComma) {
//                    $arrDelimiter = array_map("trim", explode(',', $strComma));
//                    $arrNewVal = array_merge($arrNewVal, $arrDelimiter);
//                }
//                $this->data[$this->alias][$key] = $arrNewVal;
//            }
//
//            //Trường hợp phải tách dữ liệu cách nhau bởi dấu phẩy ","  và giá trị là kiểu số
//            else if (!empty($value[0]) && $value[0] == 1) {
//                $arrNewVal = [];
//                foreach ($this->data[$this->alias][$key] as $strComma) {
//                    $arrNewVal[] = (int) $strComma;
//                }
//                $this->data[$this->alias][$key] = $arrNewVal;
//            } else {
//                foreach ($value as $key1 => $value1) {
//                    $datatype1 = gettype($value1);
//                    switch ($datatype1) {
//                        case "integer":
//                            if (!empty($this->data[$this->alias][$key][$key1])) {
//                                $this->data[$this->alias][$key][$key1] = (int) $this->data[$this->alias][$key][$key1];
//                            } else if (isset ($this->data[$this->alias][$key][$key1])) {
//                                $this->data[$this->alias][$key][$key1] = 0;
//                            }
//                            break;
//                        case "double":
//                            if (!empty($this->data[$this->alias][$key][$key1])) {
//                                $this->data[$this->alias][$key][$key1] = (double) $this->data[$this->alias][$key][$key1];
//                            } else if (isset ($this->data[$this->alias][$key][$key1])) {
//                                $this->data[$this->alias][$key][$key1] = 0.0;
//                            }
//                            break;
//                        case "string" :
////                            $this->data[$this->alias][$key][$key1] = trim($this->data[$this->alias][$key][$key1]);
//                            break;
//                        case "array" ://Cấp 3: dữ liệu đầu vào phải đầy đủ key=>value, nếu thiếu sẽ bị đè mất trường
//
//                            if (empty($this->data[$this->alias][$key][$key1])) {
//                                $this->data[$this->alias][$key][$key1] = [];
//                            } else {
//
//                                //Trường hợp phải tách dữ liệu cách nhau bởi dấu phẩy ","
//                                if (!empty($value1[0]) && $value1[0] == ',') {
//                                    $arrNewVal = [];
//                                    foreach ($this->data[$this->alias][$key][$key1] as $strComma) {
//                                        $arrDelimiter = array_map("trim", explode(',', $strComma));
//                                        $arrNewVal = array_merge($arrNewVal, $arrDelimiter);
//                                    }
//
//                                    $this->data[$this->alias][$key][$key1] = $arrNewVal;
//                                }
//                                //Trường hợp phải tách dữ liệu cách nhau bởi dấu phẩy "," và dữ liệu phải là kiểu số
//                                else if (!empty($value1[0]) && $value1[0] == 0) {
//                                    $arrNewVal = [];
//                                    foreach ($this->data[$this->alias][$key][$key1] as $strComma) {
//                                        $arrNewVal[] = (int) $strComma;
//                                    }
//
//                                    $this->data[$this->alias][$key][$key1] = $arrNewVal;
//                                } else {
//                                    foreach ($value1 as $key2 => $value2) {
//                                        $datatype2 = gettype($value2);
//                                        switch ($datatype2) {
//                                            case "integer":
//                                                if (!empty($this->data[$this->alias][$key][$key1][$key2])) {
//                                                    $this->data[$this->alias][$key][$key1][$key2] = (int) $this->data[$this->alias][$key][$key1][$key2];
//                                                } else if (isset ($this->data[$this->alias][$key][$key1][$key2])){
//                                                    $this->data[$this->alias][$key][$key1][$key2] = 0;
//                                                }
//                                                break;
//                                            case "double":
//                                                if (!empty($this->data[$this->alias][$key][$key1][$key2])) {
//                                                    $this->data[$this->alias][$key][$key1][$key2] = (double) $this->data[$this->alias][$key][$key1][$key2];
//                                                } else if (isset ($this->data[$this->alias][$key][$key1][$key2])){
//                                                    $this->data[$this->alias][$key][$key1][$key2] = 0.0;
//                                                }
//                                                break;
//                                            case "string" :
////                                                $this->data[$this->alias][$key][$key1][$key2] = trim($this->data[$this->alias][$key][$key1][$key2]);
//                                                break;
//                                            default:
//                                                break;
//                                        }
//                                    }
//                                }
//                            }
//                            break; //END Cấp 3
//                        default:
//                            break;
//                    }
//                }
//            }
//        }
//    }
//
//    /**
//     * Xử lý chuẩn hóa dữ liệu cho form Add từ level 2 trở đi
//     * @param type $value
//     * @param type $key
//     * @author: HoangNN
//     */
//    private function processAddLevel2($value, $key) {
//        if (empty($this->data[$this->alias][$key])) {
//            if (empty($value)) {
//                $this->data[$this->alias][$key] = [];
//            } elseif (!empty($value[0]) && $value[0] == ',') {
//                $this->data[$this->alias][$key] = [];
//            } elseif (!empty($value[0]) && $value[0] == 1) {
//                $this->data[$this->alias][$key] = [];
//            } elseif (isset($value['data_package'])) {
//                $this->data[$this->alias][$key] = NULL;
//            } else {
//                $this->data[$this->alias][$key] = $value;
//            }
//        } else {
//
//            //Trường hợp dùng mã gói làm key ['data_package' => [param1=>value1,...]]
//            if (isset($value['data_package'])) {
//                foreach ($this->data[$this->alias][$key] as $key1 => $package) {
//
//                    //Kiểm tra từng phần tử của mảng cấp 3 trong schema
//                    foreach ($value['data_package'] as $key2 => $value2) {
//                        $datatype2 = gettype($value2);
//                        switch ($datatype2) {
//                            case "integer":
//                                if (empty($this->data[$this->alias][$key][$key1][$key2])) {
//                                    $this->data[$this->alias][$key][$key1][$key2] = 0;
//                                } else {
//                                    $this->data[$this->alias][$key][$key1][$key2] = (int) $this->data[$this->alias][$key][$key1][$key2];
//                                }
//                                break;
//                            case "double":
//                                if (empty($this->data[$this->alias][$key][$key1][$key2])) {
//                                    $this->data[$this->alias][$key][$key1][$key2] = 0.0;
//                                } else {
//                                    $this->data[$this->alias][$key][$key1][$key2] = (double) $this->data[$this->alias][$key][$key1][$key2];
//                                }
//                                break;
//                            case "string" :
//                                if (empty($this->data[$this->alias][$key][$key1][$key2])) {
//                                    $this->data[$this->alias][$key][$key1][$key2] = $value2;
//                                } else if ($key2 != "password") {
//                                    $this->data[$this->alias][$key][$key1][$key2] = trim($this->data[$this->alias][$key][$key1][$key2]);
//                                }
//                                break;
//                            default:
//                                if (empty($this->data[$this->alias][$key][$key1][$key2])) {
//                                    $this->data[$this->alias][$key][$key1][$key2] = $value2;
//                                }
//                                break;
//                        }
//                    }
//                }
//            }
//            //Trường hợp phải tách dữ liệu cách nhau bởi dấu phẩy ","
//            else if (!empty($value[0]) && $value[0] == ',') {
//                if (!empty($this->data[$this->alias][$key])) {
//                    $arrNewVal = [];
//                    foreach ($this->data[$this->alias][$key] as $strComma) {
//                        $arrDelimiter = array_map("trim", explode(',', $strComma));
//                        $arrNewVal = array_merge($arrNewVal, $arrDelimiter);
//                    }
//                    $this->data[$this->alias][$key] = $arrNewVal;
//                }
//                //Trường hợp phải tách dữ liệu cách nhau bởi dấu phẩy "," và dữ liệu phải là kiểu số
//            } else if (!empty($value[0]) && $value[0] == 1) {
//                if (!empty($this->data[$this->alias][$key])) {
//                    $arrNewVal = [];
//                    foreach ($this->data[$this->alias][$key] as $strComma) {
//                        $arrNewVal[] = (int) $strComma;
//                    }
//                    $this->data[$this->alias][$key] = $arrNewVal;
//                }
//            } else {
//                foreach ($value as $key1 => $value1) {
//                    $datatype1 = gettype($value1);
//                    switch ($datatype1) {
//                        case "integer":
//                            if (empty($this->data[$this->alias][$key][$key1])) {
//                                $this->data[$this->alias][$key][$key1] = $value1;
//                            } else {
//                                $this->data[$this->alias][$key][$key1] = (int) $this->data[$this->alias][$key][$key1];
//                            }
//                            break;
//                        case "double":
//                            if (empty($this->data[$this->alias][$key][$key1])) {
//                                $this->data[$this->alias][$key][$key1] = $value1;
//                            } else {
//                                $this->data[$this->alias][$key][$key1] = (double) $this->data[$this->alias][$key][$key1];
//                            }
//                            break;
//                        case "string" :
//                            if (empty($this->data[$this->alias][$key][$key1])) {
//                                $this->data[$this->alias][$key][$key1] = $value1;
//                            } else if ($key1 != "password" && $key1 != "thumbnails" && $key1 != "banner" && $key1 != "tags") {
//                                $this->data[$this->alias][$key][$key1] = trim($this->data[$this->alias][$key][$key1]);
//                            }
//                            break;
//                        case "array" ://Cấp 3
//
//                            if (empty($this->data[$this->alias][$key][$key1])) {
//                                $this->data[$this->alias][$key][$key1] = [];
//                            } else {
//
//                                //Trường hợp phải tách dữ liệu cách nhau bởi dấu phẩy ","
//                                if (!empty($value1[0]) && $value1[0] == ',') {
//                                    $arrNewVal = [];
//                                    foreach ($this->data[$this->alias][$key][$key1] as $strComma) {
//                                        $arrDelimiter = array_map("trim", explode(',', $strComma));
//                                        $arrNewVal = array_merge($arrNewVal, $arrDelimiter);
//                                    }
//                                    $this->data[$this->alias][$key][$key1] = $arrNewVal;
//                                }
//                                //Trường hợp phải tách dữ liệu cách nhau bởi dấu phẩy ","  và giá trị là kiểu số
//                                else if (!empty($value1[0]) && $value1[0] == 0) {
//                                    $arrNewVal = [];
//                                    foreach ($this->data[$this->alias][$key][$key1] as $strComma) {
//                                        $arrNewVal[] = (int) $strComma;
//                                    }
//                                    $this->data[$this->alias][$key][$key1] = $arrNewVal;
//                                } else {
//                                    //Kiểm tra từng phần tử của mảng cấp 3 trong schema
//                                    foreach ($value1 as $key2 => $value2) {
//                                        $datatype2 = gettype($value2);
//                                        switch ($datatype2) {
//                                            case "integer":
//                                                if (empty($this->data[$this->alias][$key][$key1][$key2])) {
//                                                    $this->data[$this->alias][$key][$key1][$key2] = 0;
//                                                } else {
//                                                    $this->data[$this->alias][$key][$key1][$key2] = (int) $this->data[$this->alias][$key][$key1][$key2];
//                                                }
//                                                break;
//                                            case "double":
//                                                if (empty($this->data[$this->alias][$key][$key1][$key2])) {
//                                                    $this->data[$this->alias][$key][$key1][$key2] = 0.0;
//                                                } else {
//                                                    $this->data[$this->alias][$key][$key1][$key2] = (double) $this->data[$this->alias][$key][$key1][$key2];
//                                                }
//                                                break;
//                                            case "string" :
//                                                if (empty($this->data[$this->alias][$key][$key1][$key2])) {
//                                                    $this->data[$this->alias][$key][$key1][$key2] = $value2;
//                                                } else if ($key2 != "password") {
//                                                    $this->data[$this->alias][$key][$key1][$key2] = trim($this->data[$this->alias][$key][$key1][$key2]);
//                                                }
//                                                break;
//                                            default:
//                                                if (empty($this->data[$this->alias][$key][$key1][$key2])) {
//                                                    $this->data[$this->alias][$key][$key1][$key2] = $value2;
//                                                }
//                                                break;
//                                        }
//                                    }
//                                }
//                            }
//
//                            break; //END Cấp 3
//                        default:
//                            if (empty($this->data[$this->alias][$key][$key1])) {
//                                $this->data[$this->alias][$key][$key1] = $value1;
//                            }
//                            break;
//                    }
//                }
//            }
//        }
//    }
//
//    /**
//     * convertFieldsToAscii
//     * thực hiện convert dữ liệu string tương ứng với field sang dạng ascii
//     *
//     * @param array $fields
//     * @param reference array $data
//     */
//    protected function convertFieldsToAscii($fields, &$data, $suffix = '_ascii') {
//
//        App::import('Lib', 'Html2TextUtility');
//        foreach ($fields as $v) {
//
//            // nếu là trường field không phân cấp
//            if (strpos($v, '.') === false && isset($data[$v])) {
//
//                // nếu giá trị value của trường không phải là multiple-select
//                if (!is_array($data[$v])) {
//
//                    $content = Html2TextUtility::getText($data[$v]);
//                    $data[$v . $suffix] = $this->convert_vi_to_en($content);
//                }
//                // nếu giá trị value là multiple-select, tức là 1 mảng array
//                else {
//
//                    if (empty($data[$v])) {
//
//                        continue;
//                    }
//                    foreach ($data[$v] as $kk => $vv) {
//
//                        $content = Html2TextUtility::getText($vv);
//                        $data[$v . $suffix][$kk] = $this->convert_vi_to_en($content);
//                    }
//                }
//            }
//            // nếu là field trường phân cấp
//            elseif (strpos($v, '.') !== false) {
//                $explode = explode('.', $v);
//                $key = $explode[0];
//                if ($key == 'data_locale') { // Đối với trường hợp phân cấp có ngôn ngữ
//                    $langCodes = Configure::read('S.Lang');
//                    foreach ($langCodes as $code => $lang) {
//                        $v = $code. '.' . $explode[1];
//
//                        $index = $this->makeIndexArray($v);
//                        $evaluate = eval('return isset($data' . $index . ');');
//                        if (!$evaluate) {
//
//                            continue;
//                        }
//                        $index_ascii = $this->makeIndexArray($v, $suffix);
//                        eval('$evaluate_value = $data' . $index . ';');
//
//                        // nếu giá trị value của trường không phải là multiple-select
//                        if (!is_array($evaluate_value)) {
//
//                            eval('$content = Html2TextUtility::getText($data' . $index . ');');
//                            eval('$data' . $index_ascii . ' = $this->convert_vi_to_en($content);');
//                        }
//                        // nếu giá trị value là multiple-select, tức là 1 mảng array
//                        else {
//
//                            if (empty($evaluate_value)) {
//
//                                continue;
//                            }
//                            foreach ($evaluate_value as $kk => $vv) {
//
//                                $kk = $this->makeIndexArray($kk);
//
//                                eval('$content = Html2TextUtility::getText($vv);');
//                                eval('$data' . $index_ascii . $kk . ' = $this->convert_vi_to_en($content);');
//                            }
//                        }
//                    }
//                } else {
//                    $index = $this->makeIndexArray($v);
//                    $evaluate = eval('return isset($data' . $index . ');');
//                    if (!$evaluate) {
//
//                        continue;
//                    }
//                    $index_ascii = $this->makeIndexArray($v, $suffix);
//                    eval('$evaluate_value = $data' . $index . ';');
//
//                    // nếu giá trị value của trường không phải là multiple-select
//                    if (!is_array($evaluate_value)) {
//
//                        eval('$content = Html2TextUtility::getText($data' . $index . ');');
//                        eval('$data' . $index_ascii . ' = $this->convert_vi_to_en($content);');
//                    }
//                    // nếu giá trị value là multiple-select, tức là 1 mảng array
//                    else {
//
//                        if (empty($evaluate_value)) {
//
//                            continue;
//                        }
//                        foreach ($evaluate_value as $kk => $vv) {
//
//                            $kk = $this->makeIndexArray($kk);
//
//                            eval('$content = Html2TextUtility::getText($vv);');
//                            eval('$data' . $index_ascii . $kk . ' = $this->convert_vi_to_en($content);');
//                        }
//                    }
//                }
//            }
//        }
//    }
//
//    protected function makeIndexArray($path, $suffix = null) {
//
//        if (!strlen($path)) {
//
//            return;
//        }
//
//        $extract = explode('.', $path);
//        $index_path = '';
//        $counter = 1;
//        foreach ($extract as $v) {
//
//            if ($counter == count($extract)) {
//
//                $v = $v . $suffix;
//            }
//            if (is_numeric($v)) {
//
//                $index_path .= '[' . $v . ']';
//            } else {
//
//                $index_path .= '["' . $v . '"]';
//            }
//            $counter++;
//        }
//
//        return $index_path;
//    }
//
//    /**
//     * mergeCustomSchema
//     * Thực hiện merge schema với dữ liệu data input đầu vào
//     * Đảm bảo các fields trong schema, luôn được lưu vào trong database
//     * Đảm bảo những fields thừa trong data input đầu vào, sẽ bị loại bỏ, không lưu vào trong database
//     *
//     * @param array $customSchema
//     * @param reference array $data
//     * @return array
//     */
//    protected function mergeCustomSchema($customSchema, $data) {
//
//        App::import('Lib', 'ExtendedUtility');
//        $reduce = ExtendedUtility::array_intersect_key_recursive($data, $customSchema);
//        $map = Hash::merge($customSchema, $reduce);
//        $data = $map;
//
//        return $data;
//    }
//
//    /**
//     * recoverCustomSchema
//     * Thực hiện reset lại schema đối với toàn bộ dữ liệu
//     *
//     * @param array $options
//     * @return mixed
//     */
//    public function recoverCustomSchema($options = array()) {
//
//        $items = $this->find('all', $options);
//        if (empty($items)) {
//
//            return;
//        }
//        if (empty($this->customSchema)) {
//
//            throw new NotImplementedException(__('Can not recover schema, because %s model does not define customSchema property', $this->alias));
//        }
//        foreach ($items as $item) {
//
//            $id = $item[$this->alias]['id'];
//            $recover_data = $this->mergeCustomSchema($this->customSchema, $item[$this->alias]);
//            $this->mongoNoSetOperator = true;
//            $this->save($recover_data);
//        }
//    }
//
//    public function notWhiteSpace($check) {
//
//        $check = array_values($check);
//        $value = trim($check[0]);
//
//        if (strpos($value, ' ') !== false) {
//            return false;
//        }
//
//        return true;
//    }
//
//    /**
//     * Returns false if any fields passed match any (by default, all if $or = false) of their matching values.
//     *
//     * Can be used as a validation method. When used as a validation method, the `$or` parameter
//     * contains an array of fields to be validated.
//     *
//     * @param array $fields Field/value pairs to search (if no values specified, they are pulled from $this->data)
//     * @param bool|array $or If false, all fields specified must match in order for a false return value
//     * @return bool False if any records matching any fields are found
//     */
//    public function isUnique($fields, $or = true) {
//        if (is_array($or)) {
//            $isRule = (
//                array_key_exists('rule', $or) &&
//                array_key_exists('required', $or) &&
//                array_key_exists('message', $or)
//            );
//            if (!$isRule) {
//                $args = func_get_args();
//                $fields = $args[1];
//                $or = isset($args[2]) ? $args[2] : true;
//            }
//        }
//        if (!is_array($fields)) {
//            $fields = func_get_args();
//            $fieldCount = count($fields) - 1;
//            if (is_bool($fields[$fieldCount])) {
//                $or = $fields[$fieldCount];
//                unset($fields[$fieldCount]);
//            }
//        }
//
//        foreach ($fields as $field => $value) {
//            if (is_numeric($field)) {
//                unset($fields[$field]);
//
//                $field = $value;
//                $value = null;
//                if (isset($this->data[$this->alias][$field])) {
//                    $value = $this->data[$this->alias][$field];
//                }
//            }
//
//            if (strpos($field, '.') === false) {
//                unset($fields[$field]);
//                $fields[$this->alias . '.' . $field]['$regex'] = new MongoRegex("/^" . $value . "$/i"); // sửa lại cho tương thích với Mongodb
//            }
//        }
//
//        if ($or) {
//            $fields = array('$or' => array($fields)); // sửa lại cho tương thích với Mongodb
//        }
//
//        if (!empty($this->id)) {
//            $fields[$this->alias . '.' . $this->primaryKey]['$ne'] = $this->id; // sửa lại cho tương thích với Mongodb
//        }
//
//        return !$this->find('count', array('conditions' => $fields, 'recursive' => -1));
//    }
//
//    /**
//     * convert_vi_to_en method
//     * hàm chuyền đổi tiếng việt có dấu sang tiếng việt không dấu
//     * @param string $str
//     * @return string
//     */
//    public function convert_vi_to_en($str) {
//
//        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
//        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
//        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
//        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
//        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
//        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
//        $str = preg_replace("/(đ)/", 'd', $str);
//        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
//        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
//        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
//        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
//        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
//        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
//        $str = preg_replace("/(Đ|Ð)/", 'D', $str);
//
//        return $str;
//    }
//
//    /**
//     * forceConvertASCII
//     *
//     * @param string $str
//     * @return string
//     */
//    public function forceConvertASCII($str) {
//
//        try {
//
//            $ascii_str = @iconv("UTF-8", "us-ascii//TRANSLIT", $str);
//        } catch (Exception $e) {
//
//            $this->log($e, 'notice');
//            $this->log($str, 'notice');
//        }
//        return $ascii_str;
//    }
//
//    /**
//     * isASCII
//     * Thực hiện kiểm tra chuỗi string có phải là ASCII k?
//     *
//     * @param string $str
//     * @return boolean
//     */
//    public function isASCII($str) {
//
//        return mb_detect_encoding($str, 'ASCII', true);
//    }
//
//    /**
//     * In the event of ambiguous results returned (multiple top level results, with different parent_ids)
//     * top level results with different parent_ids to the first result will be dropped
//     *
//     * @param string $state Either "before" or "after".
//     * @param array $query Query.
//     * @param array $results Results.
//     * @return array Threaded results
//     */
//    protected function _findThreaded($state, $query, $results = array()) {
//        if ($state === 'before') {
//            return $query;
//        }
//
//        $parent = 'parent_id';
//        if (isset($query['parent'])) {
//            $parent = $query['parent'];
//        }
//
//        if (!empty($results)) {
//
//            foreach ($results as $k => $v) {
//
//                if (!empty($v[$this->alias][$parent]) && $v[$this->alias][$parent] instanceof MongoId) {
//
//                    $results[$k][$this->alias][$parent] = (string) $v[$this->alias][$parent];
//                }
//            }
//        }
//
//        return Hash::nest($results, array(
//            'idPath' => '{n}.' . $this->alias . '.' . $this->primaryKey,
//            'parentPath' => '{n}.' . $this->alias . '.' . $parent
//        ));
//    }
//
//    protected function _findDailyCollection($state, $query, $results = array()) {
//        return $results;
//    }
//
//    protected function parseFileUrisAfterSave() {
//
//        // cache lại file_uris vào bảng content
//        if (
//            isset($this->data[$this->alias]['files']) &&
//            is_array($this->data[$this->alias]['files']) &&
//            !empty($this->data[$this->alias]['files'])
//        ) {
//            $this->data[$this->alias]['file_uris'] = array();
//
//            App::import('Model', 'FileManaged');
//            foreach ($this->data[$this->alias]['files'] as $k => $v) {
//
//                if (!is_array($v) || empty($v)) {
//
//                    continue;
//                }
//
//                foreach ($v as $vv) {
//
//                    $FileManaged = new FileManaged();
//                    $file = $FileManaged->find('first', array(
//                        'conditions' => array(
//                            'id' => $vv,
//                        ),
//                    ));
//                    $file_id = (string) $vv;
//                    if (empty($file)) {
//
//                        continue;
//                    }
//
//                    $this->data[$this->alias]['file_uris'][$k][$file_id] = $file['FileManaged']['uri'];
//                }
//            }
//        }
//    }
}
