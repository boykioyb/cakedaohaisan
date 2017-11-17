<?php

class VaaPostComment extends AppModel {

    public $actsAs = array('Common');
    public $useTable = 'post_comments';
    public $useDbConfig = 'vaaChat';

}
