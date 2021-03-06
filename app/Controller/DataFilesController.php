<?php

App::uses('AppController', 'Controller');

/**
 * DataFilesController
 * controller chịu trách nhiệm hiện thị các file đã được upload lên server
 * các file này nằm trong thư mục data_files
 */
class DataFilesController extends AppController
{

    public $file_path = '';

    public function index()
    {
        $file_path = $this->file_path;

        $file = new File(APP . $file_path, false);

        if ($file->exists()) {

            $this->response->file(APP . $file_path);
        } else {

            $this->response->header('HTTP/1.0 404 Not Found');
            $this->response->file(WEBROOT_DIR . DS . 'img/404.png');
        }

        // hiện thị file
        return $this->response;
    }

    public function beforeFilter()
    {

        parent::beforeFilter();

        $this->Auth->allow('index');

        $data_file_root = Configure::read('sysconfig.App.data_file_root');

        // trích xuất đường dẫn tới file dựa vào router
        $file_path = $data_file_root . '/';

        if (empty($this->passedArgs)) {

            $this->response->header('HTTP/1.0 404 Not Found');
            $this->response->file(WEBROOT_DIR . DS . 'img/404.png');
            exit();
        }

        $toEnd = count($this->passedArgs);

        foreach ($this->passedArgs as $value) {

            if ($value != $data_file_root) {

                $file_path .= $value;
            }

            if (0 !== --$toEnd) {

                $file_path .= DS;
            }
        }

        $this->file_path = $file_path;
    }

}
