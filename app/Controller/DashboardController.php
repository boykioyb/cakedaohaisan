<?php

/**
 * Created by PhpStorm.
 * User: huongnx
 * Date: 05/01/2017
 * Time: 17:09
 * @property mixed ObjectType
 */
class DashboardController extends AppController
{
    public $uses = array('ObjectType', 'News', 'Document', 'Page', 'Notebook');

    public function index()
    {
        $this->layout = 'dashboard';

    }
}