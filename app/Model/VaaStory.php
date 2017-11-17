<?php

class VaaStory extends AppModel {

    public $actsAs = array('Common');
    public $useTable = 'stories';
    public $useDbConfig = 'vaaChat';
    public $asciiFields = array(
        'content',
    );

}
