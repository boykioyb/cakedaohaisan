<?php
echo $this->element('js/chosen');
// sử dụng công cụ soạn thảo
// sử dụng upload file
echo $this->element('JqueryFileUpload/basic_plus_ui_assets');
echo $this->element('js/validate');
echo $this->element('js/languages');
echo $this->Html->css('plugins/bootstrap-tagsinput/bootstrap-tagsinput');
echo $this->Html->script('plugins/bootstrap-tagsinput/bootstrap-tagsinput');
echo $this->Html->script('location');
echo $this->Html->script('search');
echo $this->Html->script('plugins/slugify/jquery.slugify');

echo $this->element('js/datetimepicker');
$user = CakeSession::read('Auth.User');
$permissions = $user['permissions'];

$unique = isset($key) ? $key : uniqid();
$lang_configs = $listLangCodeDefault;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="tabs-container">
                    <?php
                    echo $this->Form->create($model_name, array(
                        'class' => 'form-horizontal',
                        'id' => 'form_add'
                    ));
                    ?>

                    <!--                ngon ngu-->
                    <?php
                    echo $this->Form->hidden('id');
                    echo $this->Form->hidden('view_count');
                    ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('lang_code') ?></label>

                        <div class="col-sm-8">
                            <?php
                            if (isset($this->request->data) && isset($_GET['lang_code'])) {
                                $this->request->data[$model_name]['lang_code'] = $_GET['lang_code'];
                            }
                            echo $this->Form->input($model_name . '.lang_code', array(
                                'class' => 'form-control update-lang',
                                'id' => 'update_lang',
                                'div' => false,
                                'label' => false,
                                'default' => isset($_GET['lang_code']) ? $_GET['lang_code'] : '',
                                'options' => $langCodes,
                            ));
                            ?>
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-success" id="add_lang" type="button"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <!--                end ngon ngu-->
                    <div id="wrap-add-lang">
                        <?php if (isset($this->request->data['Notebook']) && count($this->request->data['Notebook']) > 0) { ?>
                            <?php
                            foreach ($this->request->data['Notebook'] as $data_key => $data_value) {
                                if (isset($lang_configs[$data_key]) && !empty($data_value['name'])) {
                                    echo $this->element('../Notebooks/add_lang', array('lang_code' => $data_key, 'country' => $lang_configs[$data_key], 'request_data' => $data_value));
                                }
                            }
                            ?>
                        <?php } ?>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('news_categories') ?></label>
                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->input($model_name . '.categories', array(
                                'div' => false,
                                'class' => 'form-control chosen-select',
                                'label' => false,
                                'multiple' => true,
                                'options' => $categories,
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('feature') ?></label>

                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->input($model_name . '.feature', array(
                                'class' => 'form-control',
                                'options' => $feature,
                                'div' => false,
                                'label' => false,
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo 'Xuất hiện ở trang chủ' ?></label>

                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->input($model_name . '.is_hot', array(
                                'class' => 'form-control',
                                'div' => false,
                                'label' => false,
                                'default' => 0,
                                'options' => $is_hot,
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('news_order') ?></label>

                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->input($model_name . '.weight', array(
                                'class' => 'form-control',
                                'div' => false,
                                'label' => false,
                                'type' => 'number',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('region_status') ?></label>

                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->input($model_name . '.status', array(
                                'class' => 'form-control',
                                'div' => false,
                                'label' => false,
                                'default' => 1,
                                'options' => $status,
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('Logo') ?></label>

                        <div class="col-sm-10">
                            <label><?php echo 'Kích thước ảnh phù hợp: 100x100px' ;?></label>
                            <?php
                            echo $this->element('JqueryFileUpload/basic_plus_ui', array(
                                'name' => $model_name . '.files.logo',
                                'options' => array(
                                    'id' => 'logo',
                                ),
                                'upload_options' => array(
                                    'maxNumberOfFiles' => 1,
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('Banner file') ?></label>

                        <div class="col-sm-10">
                            <label><?php echo 'Kích thước ảnh phù hợp: 570x300px' ;?></label>
                            <?php
                            echo $this->element('JqueryFileUpload/basic_plus_ui', array(
                                'name' => $model_name . '.files.banner',
                                'options' => array(
                                    'id' => 'banner',
                                ),
                                'upload_options' => array(
                                    'maxNumberOfFiles' => 1,
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <!--thumbnails-->
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo 'Thumbnails' ?></label>

                        <div class="col-sm-10">
                            <label><?php echo 'Kích thước ảnh phù hợp: 570x300px' ;?></label>

                            <?php
                            $options = array(
                                'name' => $model_name . '.files.thumbnails',
                                'options' => array(
                                    'id' => 'thumbnails',
                                    'multiple' => true,
                                ),
                                'upload_options' => array(
                                    'maxNumberOfFiles' => 50,
                                ),
                            );
                            if(isset($request_data['files']['thumbnails'])){
                                $options['request_data_file'] = $request_data['files']['thumbnails'];
                            }
                            echo $this->element('JqueryFileUpload/basic_plus_ui', $options);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="panel-body">
                            <div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a href="<?php echo Router::url(array('action' => 'index')) ?>" class="btn btn-white"><i class="fa fa-ban"></i> <span><?php echo __('cancel_btn') ?></span> </a>
                                        <button type="button" id="submit_form" class="btn btn-primary"><i class="fa fa-save"></i> <span><?php echo __('save_btn') ?></span> </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    echo $this->Form->end();
                    ?>
                </div>               
            </div>
        </div>
    </div>
</div>