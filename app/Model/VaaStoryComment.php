<?php

class VaaStoryComment extends AppModel {

    public $actsAs = array('Common');
    public $useTable = 'story_comments';
    public $useDbConfig = 'vaaChat';

}
