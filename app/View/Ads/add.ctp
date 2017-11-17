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
<!--<script>-->
<!--    $('document').ready(function () {-->
<!--        $('#url_alias').slugify('#title');-->
<!--        $('.bootstrap-tagsinput').addClass('col-sm-12');-->
<!--    });-->
<!--</script>-->
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
                        class="col-sm-2 control-label"><?php echo 'Tên Ads' ?><?php echo $this->element('required') ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.name', array(
                            'id' => 'title',
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'required' => true,
                            'maxlength' => 300,
                        ));
                        ?>
                    </div>
                </div>
                <div class="form-group <?php echo $name_err_class ?>">
                    <label
                        class="col-sm-2 control-label"><?php echo 'Code' ?><?php echo $this->element('required') ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.code', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'required' => true,
                            'maxlength' => 300,
                        ));
                        ?>
                    </div>
                </div>
                <?php
                $name_err = $this->Form->error($model_name . '.url');
                $name_err_class = !empty($name_err) ? 'has-error' : '';
                ?>
                <div class="form-group <?php echo $name_err_class ?>">
                    <label
                        class="col-sm-2 control-label"><?php echo 'URL' ?><?php echo $this->element('required') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.url', array(
                            'id' => 'url_alias',
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'required' => true,
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group <?php echo $name_err_class ?>">
                    <label
                        class="col-sm-2 control-label"><?php echo 'Region' ?><?php echo $this->element('required') ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.region', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'required' => true,
                            'options'=> $regions,
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="pathItems">
                    <?php
                    if (isset($this->request->data[$model_name]['paths'])) {
                        foreach ($this->request->data[$model_name]['paths'] as $number => $slide) {
                            echo $this->element('add_path_ad', array(
                                'request_data' => $slide,
                                'number' => $number
                            ));
                        }
                    }
                    ?>
                </div>
                <div class="form-group" style="text-align: center">
                    <div>
                        <button class="btn btn-success" id="addPathAd" type="button"><i
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
                    <label class="col-sm-2 control-label"><?php echo __('Images') ?><p style="color: red">(340 X 340)</p></label>

                    <div class="col-sm-10">
                        <?php
                        $options = array(
                            'name' => $model_name . '.files.banner',
                            'options' => array(
                                'id' => 'banner',
                            ),
                            'upload_options' => array(
                                'maxNumberOfFiles' => 1,
                            ),
                        );
                        if(isset($request_data['images']['banner'])){
                            $options['request_data_file'] = $request_data['images']['banner'];
                        }
                        echo $this->element('JqueryFileUpload/basic_plus_ui', $options);
                        ?>
                    </div>
                </div>
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
    function addPathAd() {
        $('#addPathAd').click(function () {
            var number = $('.item_wrap_ajax_add_lang').length + 1;
            $.ajax({
                url: URL_ADD_PATH_AD,
                type: 'POST',
                dataType: 'HTML',
                data:{number:number},
                success: function (data) {
                    $('.pathItems').append(data);
                }
            })
        })
    };
</script>