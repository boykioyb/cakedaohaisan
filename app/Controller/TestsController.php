<?php
class TestsController extends AppController{
    public $uses = array(
        'Test',
    );
    public function index(){

        $this->set('model_name', $this->modelClass);
        $this->set([
            'breadcrumb' => [
                array(
                    'url' => Router::url(array('action' => 'index')),
                    'label' => 'check dung lượng field data',
                )
            ],
        ]);
        if ($this->request->is('post') || $this->request->is('put')) {
            $post_data = $this->request->data[$this->modelClass];
            $result = $this->{$this->modelClass}->getData($post_data);

            if ($this->array2csv($result)) {
                $this->Session->setFlash(__('save_successful_message'), 'default', array(), 'good');
                $this->redirect(array('action' => 'index'));
            }
        }
    }
    public function array2csv(array &$array)
    {
       if (count($array) == 0) {
         return null;
       }
       $folder_path = APP . 'file.csv';
       ob_start();
       $df = fopen($folder_path, 'w');
       fputcsv($df, array_keys(reset($array)));
       foreach ($array as $row) {
          fputcsv($df, $row);
       }
       fclose($df);
    }
}