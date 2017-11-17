<?php
// sử dụng công cụ soạn thảo
echo $this->element('js/chosen');
echo $this->element('js/tinymce');
// sử dụng upload file

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
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo 'Model ' ?></label>
                    <div class="col-sm-4">
                        <?php
                            echo $this->Form->input($model_name . '.model', array(
                                'id'        => 'model',
                                'class'     => 'form-control',
                                'div'       => false,
                                'label'     => false,
                                'maxlength' => 100
                            ));
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo 'Size ' ?></label>
                    <div class="col-sm-4">
                        <?php
                            echo $this->Form->input($model_name . '.size', array(
                                'class' => 'form-control',
                                'div'   => false,
                                'label' => false,
                                'type'  => 'number',
                                'min'   => 0,
                            ));
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo 'Field  ' ?></label>
                    <div class="col-sm-4">
                        <?php
                            echo $this->Form->input($model_name . '.field', array(
                                'id'        => 'field_name',
                                'class'     => 'form-control',
                                'div'       => false,
                                'label'     => false,
                                'maxlength' => 100
                            ));
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo 'Lang code  ' ?></label>
                    <div class="col-sm-4">
                        <?php
                            echo $this->Form->input($model_name . '.lang_code', array(
                                'id'        => 'lang_code',
                                'class'     => 'form-control',
                                'div'       => false,
                                'label'     => false,
                            ));
                        ?>
                    </div>
                </div>
				<div class="hr-line-dashed"></div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <a href="<?php echo Router::url(array('action' => 'index')); ?>"
                           class="btn btn-white"><i class="fa fa-ban"></i> <span><?php echo __('cancel_btn') ?></span>
                        </a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                            <span><?php echo('Run') ?></span></button>
                    </div>
                </div>
                <?php
                echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>
</div>