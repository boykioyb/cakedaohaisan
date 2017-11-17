<?php
class Contact extends AppModel
{
    public $useTable = 'contacts';
    public $customSchema = array(
        'id' => null,
        'name' => '',
        'email' => '',
        'phone' => '',
        'content' => '',
        'created' => null,
        'modified' => null,
    );
}