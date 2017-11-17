<?php
// sử dụng công cụ soạn thảo
echo $this->element('js/chosen');
// sử dụng upload file
echo $this->element('JqueryFileUpload/basic_plus_ui_assets');
echo $this->element('js/datetimepicker');
echo $this->Html->css('plugins/bootstrap-tagsinput/bootstrap-tagsinput');
echo $this->Html->script('plugins/bootstrap-tagsinput/bootstrap-tagsinput');
echo $this->Html->script('location');
echo $this->Html->script('search');
echo $this->Html->script('plugins/slugify/jquery.slugify');
$user = CakeSession::read('Auth.User');
$permissions = $user['permissions'];
?>
<script>
    $('document').ready(function () {
        $('#url_alias').slugify('#title');
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
                ));
                ?>
                <?php
                $name_err = $this->Form->error($model_name . '.name');
                $name_err_class = !empty($name_err) ? 'has-error' : '';
                ?>
                <div class="form-group <?php echo $name_err_class ?>">
                    <label
                        class="col-sm-2 control-label"><?php echo 'Tên Block' ?><?php echo $this->element('required') ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.name', array(
                            'id' => 'title',
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'maxlength' => 300,
                        ));
                        ?>
                    </div>
                </div>
                <div class="form-group <?php echo $name_err_class ?>">
                    <label
                        class="col-sm-2 control-label"><?php echo 'Loại' ?><?php echo $this->element('required') ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.code', array(
                            'class' => 'form-control chosen-select',
                            'options' => $code,
                            'div' => false,
                            'label' => false,
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="RegionItems">
                    <?php
                    if (isset($this->request->data[$model_name]['paths'])) {
                        foreach ($this->request->data[$model_name]['paths'] as $number => $slide) {
                            echo $this->element('add_regions', array(
                                'request_data' => $slide,
                                'number' => $number
                            ));
                        }
                    }
                    ?>
                </div>
                <div class="form-group" style="text-align: center">
                    <div>
                        <button class="btn btn-success" id="addRegion" type="button"><i
                                class="fa fa-plus"></i> Add path</button>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('blog_description') ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.description', array(
                            'type' => 'textarea',
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'maxlength' => 500,
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
<script>
    function addRegion() {
        $('#addRegion').click(function () {
            var number = $('.item_wrap_ajax_add_lang').length + 1;
            $.ajax({
                url: URL_ADD_REGION,
                type: 'POST',
                dataType: 'HTML',
                data:{number:number},
                success: function (data) {
                    $('.RegionItems').append(data);
                }
            })
        })
    };
</script>