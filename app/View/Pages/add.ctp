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
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true"> Thông tin</a></li>
                    </ul>
                    <?php
                    echo $this->Form->create($model_name, array(
                        'class' => 'form-horizontal',
                        'id' => 'form_add'
                    ));
                    ?>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
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
<!--                                <div class="hr-line-dashed"></div>-->
                                <!--                end ngon ngu-->

                                <div class="row" id="wrap-add-lang">
                                    <?php if (isset($this->request->data['Page']) && count($this->request->data['Page']) > 0) { ?>
                                        <?php
                                        foreach ($this->request->data['Page'] as $data_key => $data_value) {
                                            if (isset($lang_configs[$data_key]) && !empty($data_value['name'])) {
                                                echo $this->element('../Pages/add_lang', array('lang_code' => $data_key, 'country' => $lang_configs[$data_key], 'request_data' => $data_value));
                                            }
                                        }
                                        ?>
                                    <?php } ?>
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
                                    <label class="col-sm-2 control-label"><?php echo __('Logo file') ?></label>

                                    <div class="col-sm-10">
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
                            </div>
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