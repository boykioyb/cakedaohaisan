<div class="panel panel-success">
    <div class="panel-heading" style="padding-top: 17px; padding-bottom: 20px" >
        <h4 class="panel-title">
            <a href="#collapse-module" data-toggle="collapse" class="streaming-panel-title">
                Settings
            </a>
        </h4>
    </div>

    <div class="panel-collapse collapse" id="collapse-module">
        <div class="panel-body">
            <div class="row panel-container">
                <div class="form-horizontal">

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('Tin tức mới') ?></label>

                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->input($model_name . '.cate_news', array(
                                'class' => 'form-control chosen-select',
                                'div' => false,
                                'label' => false,
                                'multiple' => false,
                                'options' => $categories,
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('Thông báo mới') ?></label>

                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->input($model_name . '.cate_notify', array(
                                'class' => 'form-control chosen-select',
                                'div' => false,
                                'label' => false,
                                'multiple' => false,
                                'options' => $categories,
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('Hoạt động thành viên') ?></label>

                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->input($model_name . '.cate_activity', array(
                                'class' => 'form-control chosen-select',
                                'div' => false,
                                'label' => false,
                                'multiple' => false,
                                'options' => $categories,
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('Tin thương hiệu doanh nhân') ?></label>

                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->input($model_name . '.cate_list', array(
                                'class' => 'form-control chosen-select',
                                'multiple' => true,
                                'div' => false,
                                'label' => false,
                                'options' => $categories,
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('Sự kiện tiêu biểu') ?></label>

                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->input($model_name . '.cate_event', array(
                                'class' => 'form-control chosen-select',
                                'div' => false,
                                'label' => false,
                                'multiple' => false,
                                'options' => $categories,
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <!-- End Form -->
                </div>
            </div>
        </div>
    </div>
</div>