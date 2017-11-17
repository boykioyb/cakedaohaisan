<?php
// sử dụng upload file
echo $this->Html->script('search');
?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="tabs-container">
                    <?php
                    echo $this->Form->create($model_name, array(
                        'class' => 'form-horizontal',
                    ));
                    ?>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?php echo 'Tên' ?><?php echo $this->element('required') ?></label>

                                    <div class="col-sm-10">
                                        <?php
                                        echo $this->Form->input($model_name . '.name', array(
                                            'class' => 'form-control',
                                            'div' => false,
                                            'required' => true,
                                            'label' => false,
                                        ));
                                        ?>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?php echo 'Email' ?></label>

                                    <div class="col-sm-10">
                                        <?php
                                        echo $this->Form->input($model_name . '.email', array(
                                            'class' => 'form-control',
                                            'div' => false,
                                            'label' => false,
                                        ));
                                        ?>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?php echo 'Mobile' ?></label>

                                    <div class="col-sm-10">
                                        <?php
                                        echo $this->Form->input($model_name . '.mobile', array(
                                            'class' => 'form-control',
                                            'div' => false,
                                            'label' => false,
                                        ));
                                        ?>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?php echo __('Content') ?></label>

                                    <div class="col-sm-10">
                                        <?php
                                        echo $this->Form->input($model_name . '.content', array(
                                            'type' => 'textarea',
                                            'class' => 'form-control editor',
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
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="panel-body">
                            <div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a href="<?php echo Router::url(array('action' => 'index')) ?>"
                                           class="btn btn-white"><i class="fa fa-ban"></i>
                                            <span><?php echo __('cancel_btn') ?></span> </a>
                                        <button class="btn btn-primary"><i
                                                class="fa fa-save"></i> <span><?php echo __('save_btn') ?></span>
                                        </button>
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