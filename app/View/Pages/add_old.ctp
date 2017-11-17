<?php
echo $this->element('js/chosen');
// sử dụng công cụ soạn thảo
echo $this->element('js/tinymce');
// sử dụng upload file
echo $this->element('JqueryFileUpload/basic_plus_ui_assets');
$user = CakeSession::read('Auth.User');
$permissions = $user['permissions'];
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <?php
                echo $this->Form->create($model_name, array(
                    'class' => 'form-horizontal',
                ));
                ?>
                <?= $this->element('lang_field') ?>


                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('category') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.categories', array(
                            'class' => 'form-control chosen-select',
                            'div' => false,
                            'label' => false,
                            'options' => $categories,
                            'empty' => '-------',
                            'multiple' => true,
                            'required' => true
                        ));
                        ?>
                    </div>
                </div>

                <?php
                $name_err = $this->Form->error($model_name . '.name');
                $name_err_class = !empty($name_err) ? 'has-error' : '';
                ?>
                <div class="form-group <?php echo $name_err_class ?>">
                    <label
                        class="col-sm-2 control-label"><?php echo __('title_name') ?><?php echo $this->element('required') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.name', array(
                            'class'    => 'form-control',
                            'div'      => false,
                            'label'    => false,
                            'required' => true,
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>


                <?php
                $name_err = $this->Form->error($model_name . '.source');
                $name_err_class = !empty($name_err) ? 'has-error' : '';
                ?>
                <div class="form-group <?php echo $name_err_class ?>">
                    <label class="col-sm-2 control-label"><?php echo __('new_source') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.source', array(
                            'class' => 'form-control',
                            'div'   => false,
                            'label' => false,
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <?php
                $name_err = $this->Form->error($model_name . '.link_video');
                $name_err_class = !empty($name_err) ? 'has-error' : '';
                ?>
                <div class="form-group <?php echo $name_err_class ?>">
                    <label class="col-sm-2 control-label"><?php echo __('link_video') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.link_video', array(
                            'class' => 'form-control',
                            'div'   => false,
                            'label' => false,
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <?php
                $code_err = $this->Form->error($model_name . '.short_description');
                $code_err_class = !empty($code_err) ? 'has-error' : '';
                ?>
                <div class="form-group <?php echo $code_err_class ?>">
                    <label class="col-sm-2 control-label"><?php echo __('short_description') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.short_description', array(
                            'type'  => 'textarea',
                            'class' => 'form-control',
                            'div'   => false,
                            'label' => false,
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <?php
                $code_err = $this->Form->error($model_name . '.description');
                $code_err_class = !empty($code_err) ? 'has-error' : '';
                ?>
                <div class="form-group <?php echo $code_err_class ?>">
                    <label class="col-sm-2 control-label"><?php echo __('new_description') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.description', array(
                            'type'  => 'textarea',
                            'class' => 'form-control editor',
                            'div'   => false,
                            'label' => false,
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
                            'name'           => $model_name . '.files.logo',
                            'options'        => array(
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

                <?php
                $name_err = $this->Form->error($model_name . '.order');
                $name_err_class = !empty($name_err) ? 'has-error' : '';
                ?>
                <div class="form-group <?php echo $name_err_class ?>">
                    <label class="col-sm-2 control-label"><?php echo __('new_order') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.order', array(
                            'type'  => 'number',
                            'class' => 'form-control',
                            'div'   => false,
                            'label' => false,
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>


                <?php
                // ẩn edit status đối với user có type là CONTENT_EDITOR
                if (in_array('News_edit_status_field', $permissions)):
                    ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('new_status') ?></label>

                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->input($model_name . '.status', array(
                                'class'   => 'form-control',
                                'div'     => false,
                                'label'   => false,
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
                        <a href="<?php echo Router::url(array('action' => 'index')) ?>" class="btn btn-white"><i
                                class="fa fa-ban"></i> <span><?php echo __('cancel_btn') ?></span> </a>
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