<?php

class ContentPermissionBehavior extends ModelBehavior
{
    public function beforeFind(\Model $model, $query) {
        parent::beforeFind($model, $query);

        $user = CakeSession::read('Auth.User');

        // đối với user nhập content, thì chỉ nhìn thấy content của mình
//         &&
//                !empty($user['content_provider_code'])
        if ($user['type'] == USER_TYPE_USER) {

            $query['conditions']['user_created'] = new MongoId($user['id']);
        }
        // đối với content admin, thì nhìn thấy được hết content thuộc vào content provider
        // mà user đó thuộc vào
        elseif ($user['type'] == USER_TYPE_USER_ADMIN &&
                !empty($user['content_provider_code'])) {

//            App::import('Model', 'User');
//            $User = new User();
//            $user_ids = $User->getUserIdsByCPcode($user['content_provider_code']);
            $query['conditions']['provider_code'] = $user['content_provider_code'];
        } elseif ($user['type'] == USER_TYPE_USER_ADMIN &&
                !empty($user['partner_code'])) {

            App::import('Model', 'User');
            $User = new User();
            $user_ids = $User->getUserIdsByPartnerCode($user['partner_code']);
            $query['conditions']['user_created']['$in'] = $user_ids;
        } else {
            //Trường hợp còn lại là User hệ thống
        }
        return $query;
    }
}