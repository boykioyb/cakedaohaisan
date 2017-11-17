<?php
// sử dụng công cụ soạn thảo
echo $this->element('js/chosen');
// sử dụng upload file
echo $this->element('JqueryFileUpload/basic_plus_ui_assets');
echo $this->element('js/validate');
$user = CakeSession::read('Auth.User');
$permissions = $user['permissions'];
?>
<script>
    $(function () {
        $('.permissions').chosen();
        $('.home_url').chosen();
    });
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <?php
                echo $this->Form->create($model_name, array(
                    'class' => 'form-horizontal',
                ));
                ?>
                <?php
                echo $this->Form->hidden('id');
                $name_err = $this->Form->error($model_name . '.name');
                $name_err_class = !empty($name_err) ? 'has-error' : '';
                ?>
                <div class="form-group <?php $name_err_class ?>">
                    <label class="col-sm-2 control-label"><?php echo __('discussions_name') ?> <?php echo $this->element('required') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.name', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'required' => true,
                            'default' => isset($request_data['name']) ? $request_data['name'] : ''
                        ));
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('discussions_description') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->textarea($model_name . '.description', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('join_members') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.join_members', array(
                            'class' => 'form-control chosen-select',
                            'multiple' => true,
                            'options' => $members,
                            'div' => false,
                            'label' => false,
                            'value' => isset($value_member) && !empty($value_member) ? $value_member : ''
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('owner') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.owner', array(
                            'class' => 'form-control chosen-select',
                            'options' => $members,
                            'div' => false,
                            'label' => false
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('status') ?></label>

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
                    <label class="col-sm-2 control-label"><?php echo 'Avatar' ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->element('JqueryFileUpload/basic_plus_ui', array(
                            'name' => $model_name . '.files.avatar',
                            'options' => array(
                                'id' => 'avatar',
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
                    <label class="col-sm-2 control-label"><?php echo 'Cover' ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->element('JqueryFileUpload/basic_plus_ui', array(
                            'name' => $model_name . '.files.cover',
                            'options' => array(
                                'id' => 'cover',
                            ),
                            'upload_options' => array(
                                'maxNumberOfFiles' => 1,
                            ),
                        ));
                        ?>
                    </div>
                </div>
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