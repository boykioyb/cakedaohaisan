<?php
echo $this->element('js/chosen');
// sử dụng công cụ soạn thảo
echo $this->element('js/tinymce');
// sử dụng upload file
echo $this->element('JqueryFileUpload/basic_plus_ui_assets');
echo $this->element('js/validate');
echo $this->element('js/datetimepicker');
echo $this->element('js/languages');

$user = CakeSession::read('Auth.User');
$permissions = $user['permissions'];

$unique = isset($key) ? $key : uniqid();
$lang_configs = Configure::read('S.Lang');
?>
<div class="row">
    <div class="col-lg-12" style="background: #fff;">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="tabs-container">
                    <?php
                    echo $this->Form->create($model_name, array(
                        'class' => 'form-horizontal',
                        'id' => 'form_add'
                    ));
                    echo $this->Form->hidden('type');
                    ?>
                    <div class="information">
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
                            <?php if(isset($this->request->data['Setting']) && count($this->request->data['Setting']) > 0){  ?>
                                <?php foreach($this->request->data['Setting'] as $data_key => $data_value){
                                    if(isset($langCodes[$data_key]) && !empty($data_value)){
                                        echo $this->element('../Settings/add_lang', array('lang_code' => $data_key, 'country' => $langCodes[$data_key], 'request_data' => $data_value));
                                        ?>
                                    <?php }
                                } ?>
                            <?php } ?>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?php echo 'Logo Header' ?></label>
                            <div class="col-sm-10">
                                <?php
                                echo $this->element('JqueryFileUpload/basic_plus_ui', array(
                                    'name' => $model_name . '.files.logo_header',
                                    'options' => array(
                                        'id' => 'logo_header',
                                    ),
                                    'upload_options' => array(
                                        'maxNumberOfFiles' => 1,
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?php echo 'Logo Footer' ?></label>
                            <div class="col-sm-10">
                                <?php
                                echo $this->element('JqueryFileUpload/basic_plus_ui', array(
                                    'name' => $model_name . '.files.logo_footer',
                                    'options' => array(
                                        'id' => 'logo_footer',
                                    ),
                                    'upload_options' => array(
                                        'maxNumberOfFiles' => 1,
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div id="module-setting">
                            <?php echo $this->element('../Settings/module'); ?>
                        </div>
                        
                        <!--PHONE-->
                        <?php
                        $phone_err = $this->Form->error($model_name . '.phone');
                        $phone_err_class = !empty($phone_err) ? 'has-error' : '';
                        ?>
                        <div class="form-group <?php echo $phone_err_class ?>">
                            <label class="col-sm-2 control-label"><?php echo __('phone_Setting') ?> <?php echo $this->element('required') ?></label>

                            <div class="col-sm-10">
                                <?php
                                echo $this->Form->input($model_name . '.phone', array(
                                    'class' => 'form-control',
                                    'div' => false,
                                    'label' => false,
                                    'type' => 'number',
                                    'required' => true,
                                    'default' => isset($request_data['phone']) ? $request_data['phone'] : '',
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <!--FAX-->
                        <?php
                        $fax_err = $this->Form->error($model_name . '.fax');
                        $fax_err_class = !empty($fax_err) ? 'has-error' : '';
                        ?>
                        <div class="form-group <?php echo $fax_err_class ?>">
                            <label class="col-sm-2 control-label"><?php echo __('Fax') ?> <?php echo $this->element('required') ?></label>

                            <div class="col-sm-10">
                                <?php
                                echo $this->Form->input($model_name . '.fax', array(
                                    'class' => 'form-control',
                                    'div' => false,
                                    'label' => false,
                                    'required' => true,
                                    'default' => isset($request_data['fax']) ? $request_data['fax'] : '',
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <!--EMAIL-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?php echo __('email_Setting') ?> <?php echo $this->element('required') ?></label>

                            <div class="col-sm-10">
                                <?php
                                echo $this->Form->input($model_name . '.email', array(
                                    'class' => 'form-control',
                                    'div' => false,
                                    'label' => false,
                                    'default' => isset($request_data['email']) ? $request_data['email'] : '',
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?php echo __('script_head') ?></label>

                            <div class="col-sm-10">
                                <?php
                                echo $this->Form->input($model_name . '.script_head', array(
                                    'class' => 'form-control',
                                    'div' => false,
                                    'label' => false,
                                    'type' => 'textarea',
                                    'default' => isset($request_data['script_head']) ? $request_data['script_head'] : '',
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <!--FACEBOOK-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?php echo __('facebook_Setting') ?></label>

                            <div class="col-sm-10">
                                <?php
                                echo $this->Form->input($model_name . '.link_fb', array(
                                    'class' => 'form-control',
                                    'div' => false,
                                    'label' => false,
                                    'default' => isset($request_data['link_fb']) ? $request_data['link_fb'] : '',
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <!--GOOGLE PLUS-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?php echo __('google_Setting') ?></label>

                            <div class="col-sm-10">
                                <?php
                                echo $this->Form->input($model_name . '.link_gg', array(
                                    'class' => 'form-control',
                                    'div' => false,
                                    'label' => false,
                                    'default' => isset($request_data['link_gg']) ? $request_data['link_gg'] : '',
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <!--TWITTER-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?php echo __('twitter_Setting') ?></label>

                            <div class="col-sm-10">
                                <?php
                                echo $this->Form->input($model_name . '.link_tw', array(
                                    'class' => 'form-control',
                                    'div' => false,
                                    'label' => false,
                                    'default' => isset($request_data['link_tw']) ? $request_data['link_tw'] : '',
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <!--youtube-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?php echo __('linkedin') ?></label>

                            <div class="col-sm-10">
                                <?php
                                echo $this->Form->input($model_name . '.link_in', array(
                                    'class' => 'form-control',
                                    'div' => false,
                                    'label' => false,
                                    'default' => isset($request_data['link_in']) ? $request_data['link_in'] : '',
                                ));
                                ?>
                            </div>
                        </div>

                        <!--Setting Module Tin tuc moi-->

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label
                                class="col-sm-2 control-label"><?php echo __('Bảo trì') ?></label>
                            <div class="col-sm-10">
                                <?php
                                echo $this->Form->input($model_name . '.off_site', array(
                                    'class' => 'iCheck',
                                    'div' => false,
                                    'label' => false,
                                    'type' => 'checkbox',
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a href="<?php echo Router::url(array('action' => 'index')) ?>" class="btn btn-white"><i class="fa fa-ban"></i> <span><?php echo __('cancel_btn') ?></span> </a>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <span><?php echo __('save_btn') ?></span> </button>
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