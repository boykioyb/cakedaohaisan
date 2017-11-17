<?php
// sử dụng công cụ soạn thảo
echo $this->element('js/chosen');
// sử dụng upload file
echo $this->element('JqueryFileUpload/basic_plus_ui_assets');
echo $this->element('js/datetimepicker');
echo $this->Html->css('plugins/bootstrap-tagsinput/bootstrap-tagsinput');
echo $this->Html->script('plugins/bootstrap-tagsinput/bootstrap-tagsinput');
echo $this->Html->script('location');
echo $this->element('js/validate');
echo $this->Html->script('search');
echo $this->Html->script('plugins/slugify/jquery.slugify');
echo $this->element('js/languages');
$user = CakeSession::read('Auth.User');
$permissions = $user['permissions'];

$unique = isset($key) ? $key : uniqid();
$lang_configs = Configure::read('S.Lang');
?>
<script>
    $('document').ready(function () {
        $('#slug').slugify('#title');
        $('.bootstrap-tagsinput').addClass('col-sm-12');
    });
</script>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <?php
                echo $this->Form->create($model_name, array(
                    'class' => 'form-horizontal',
                    'url' => array(
                        '?' => $this->request->query,
                        'controller' => 'Documents',
                    ),
                ));
                ?>
                <?php
                ?>
                <?php
                echo $this->Form->hidden('id');
                echo $this->Form->hidden('view_count');
                echo $this->Form->hidden('download_count');
                ?>
                <!-- ngon ngu-->
                <?php
                echo $this->Form->hidden('id');
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
                            'options' => $lang_configs,
                        ));
                        ?>
                    </div>
                    <div class="col-sm-2">
                        <button class="btn btn-success" id="add_lang" type="button"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <!-- end ngon ngu-->

                <div id="wrap-add-lang">
                    <?php if(isset($this->request->data['Document']) && count($this->request->data['Document']) > 0){  ?>
                        <?php foreach($this->request->data['Document'] as $data_key => $data_value){
                            if(isset($langCodes[$data_key]) && !empty($data_value)){
                                echo $this->element('../Documents/add_lang', array('lang_code' => $data_key, 'country' => $langCodes[$data_key], 'request_data' => $data_value));
                                ?>
                            <?php }
                        } ?>
                    <?php } ?>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label
                        class="col-sm-2 control-label"><?php echo 'Danh mục' ?> </label>
                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.categories', array(
                            'class' => 'form-control chosen-select',
                            'div' => false,
                            'label' => false,
                            'multiple'=>true,
                            'options' => $categories,
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('blog_weight') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.weight', array(
                            'type' => 'number',
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
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
                    <label class="col-sm-2 control-label"><?php echo __('release_time') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.release_time', array(
                            'class' => 'form-control datepicker',
                            'type' => 'text',
                            'required' => true,
                            'div' => false,
                            'label' => false,
                            'value' => isset($this->data['Document']['release_time']) ? $this->Common->parseDateTime($this->data['Document']['release_time']) : ''
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('effect_time') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.effect_time', array(
                            'class' => 'form-control datepicker',
                            'type' => 'text',
                            'required' => true,
                            'div' => false,
                            'label' => false,
                            'value' => isset($this->data['Document']['effect_time']) ? $this->Common->parseDateTime($this->data['Document']['effect_time']) : ''
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('expire_time') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.expire_time', array(
                            'class' => 'form-control datepicker',
                            'type' => 'text',
                            'div' => false,
                            'label' => false,
                            'value' => isset($this->data['Document']['expire_time']) ? $this->Common->parseDateTime($this->data['Document']['expire_time']) : ''
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo 'File' ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->element('JqueryFileUpload/basic_plus_ui', array(
                            'name' => $model_name . '.files.attack',
                            'options' => array(
                                'id' => 'attack',
                            ),
                            'upload_options' => array(
                                'maxNumberOfFiles' => 1,
                                'acceptFileTypes' => 'docx|doc|pdf|xlsx'
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <?php
                // ẩn edit status đối với user có type là CONTENT_EDITOR
                if (in_array('Topics_edit_status_field', $permissions)):
                    ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('blog_status') ?></label>

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
                    <?php
                endif;
                ?>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <a href="<?php echo Router::url(array('action' => 'index', '?' => array('object_type_code' => $this->request->query('object_type_code')))) ?>"
                           class="btn btn-white"><i class="fa fa-ban"></i> <span><?php echo __('cancel_btn') ?></span>
                        </a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                            <span><?php echo __('save_btn') ?></span></button>
                    </div>
                </div>
                <?php
                echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>
</div>