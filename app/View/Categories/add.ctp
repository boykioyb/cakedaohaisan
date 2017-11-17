<?php
// sử dụng công cụ soạn thảo
echo $this->element('js/chosen');
echo $this->element('js/tinymce');
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
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <?php
                echo $this->Form->create($model_name, array(
                    'class' => 'form-horizontal item_wrap_ajax_add_lang',
                    'url' => array(
                        '?' => $this->request->query,
                        'controller' => 'Categories',
                    ),
                ));
                ?>
                <!-- lang_code -->
                <?php
                echo $this->Form->hidden('id');
                ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('lang_code') ?></label>

                    <div class="col-sm-10">
                        <?php
                        if (isset($_GET['lang_code'])) {
                            $this->request->data[$model_name]['lang_code'] = $_GET['lang_code'];
                            $lang_code = $_GET['lang_code'];
                        } else if (!empty($this->Session->read('lang_code'))) {
                            $this->request->data[$model_name]['lang_code'] = $this->Session->read('lang_code');
                            $lang_code = $this->Session->read('lang_code');
                        } else {
                            $this->request->data[$model_name]['lang_code'] = Configure::read('S.Lang_code_default');
                            $lang_code = Configure::read('S.Lang_code_default');
                        }

                        echo $this->Form->input($model_name . '.lang_code', array(
                            'class' => 'form-control update-lang dr-langcode',
                            'div' => false,
                            'label' => false,
                            'default' => $lang_code,
                            'options' => $langCodes,
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <?php
                echo $this->Form->hidden($model_name . '.lang_', array(
                    'class' => 'form-control lang_',
                    'div' => false,
                    'label' => false,
                    'default' => 0,
                ));
                ?>

                <script>
                    $(document).ready(function () {
                        Global.generateSlugFromName();
                        $('.dr-langcode').change(function () {
                            var currentUrl = document.URL;
                            if (currentUrl.indexOf('?') > 0) {
                                if (currentUrl.indexOf('&lang_code') > 0) {
                                    currentUrl = currentUrl.substr(0, currentUrl.indexOf('&lang_code'));
                                }
                                window.location.href = currentUrl + '&lang_code=' + $(this).val();
                            } else {
                                if (currentUrl.indexOf('?lang_code') > 0) {
                                    currentUrl = currentUrl.substr(0, currentUrl.indexOf('?lang_code'));
                                }
                                window.location.href = currentUrl + '?lang_code=' + $(this).val();
                            }
                        });
                    });
                </script>

                <!-- end lang_code -->
                <?php
                if (isset($object_type_id) && !empty($object_type_id)) {
                    echo $this->Form->hidden($model_name . '.object_type', array(
                        'value' => $object_type_id,
                    ));
                }
                if (!empty($object_type_code)) {

                    echo $this->Form->hidden($model_name . '.object_type_code', array(
                        'value' => $object_type_code,
                    ));
                }
                ?>
                <?php
                $name_err = $this->Form->error($model_name . '.' . $lang_code . '.name');
                $name_err_class = !empty($name_err) ? 'has-error' : '';
                ?>
                <div class="form-group <?php echo $name_err_class ?>">
                    <label
                        class="col-sm-2 control-label"><?php echo __('category_name') ?><?php echo $this->element('required') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.' . $lang_code . '.name', array(
                            'class' => 'form-control name-slug',
                            'div' => false,
                            'label' => false,
                            'required' => true,
                        ));
                        ?>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>
                <?php
                $code_err = $this->Form->error($model_name . '.' . $lang_code .  '.url_alias');
                $code_err_class = !empty($name_err) ? 'has-error' : '';

                $option_code_categories = array(
                    'class' => 'form-control slug',
                    'div' => false,
                    'label' => false,
                    'required' => true
                );
                if (isset($object_type_id) && !empty($object_type_id)) {
                    $option_code_categories['disabled'] = true;
                } else {
                    ?>
                <?php } ?>
                <div class="form-group <?php echo $code_err_class ?>">
                    <label
                        class="col-sm-2 control-label"><?php echo 'Alias' ?><?php echo $this->element('required') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.' . $lang_code . '.url_alias', $option_code_categories);
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('category_description') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->textarea($model_name . '.' . $lang_code . '.short_description', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('category_meta_title') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.'.$lang_code . '.meta_title', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('category_meta_description') ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.'.$lang_code . '.meta_description', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'type' => 'textarea'
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('category_meta_tags') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.'.$lang_code . '.meta_tags', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('category_weight') ?></label>

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
                <?php
                $user = CakeSession::read('Auth.User');
                ?>
                <?php
                // ẩn edit status đối với user có type là CONTENT_EDITOR
                if ($user['type'] !== 'CONTENT_EDITOR'):
                    ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('category_status') ?></label>

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
                        <a href="<?php echo Router::url(array('action' => 'index', '?' => $this->request->query)) ?>"
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