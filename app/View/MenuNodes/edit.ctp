<?php
echo $this->element('js/chosen');
// sử dụng công cụ soạn thảo
echo $this->element('js/tinymce');
// sử dụng upload file
echo $this->element('JqueryFileUpload/basic_plus_ui_assets');
echo $this->element('js/validate');
echo $this->element('js/languages');

echo $this->element('js/datetimepicker');
echo $this->Html->script('plugins/slugify/jquery.slugify');

$user = CakeSession::read('Auth.User');
$permissions = $user['permissions'];

$unique = isset($key) ? $key : uniqid();
$lang_configs = $listLangCodeDefault;
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

                                <?php
                                if (!empty($this->request->data[$model_name]['id'])) {

                                        echo $this->Form->hidden($model_name . '.id', array(
                                            'value' => $this->request->data[$model_name]['id'],
                                        ));
                                }
                                ?>

                                <div class="form-group">
                                        <label class="col-sm-2 control-label"><?php echo __('Loại menu') ?></label>

                                        <div class="col-sm-10">
                                                <?php
                                                echo $this->Form->input($model_name . '.menu_code', array(
                                                    'class' => 'form-control',
                                                    'div' => false,
                                                    'label' => false,
                                                    'default' => 0,
                                                    'options' => $type,
                                                ));
                                                ?>
                                        </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                        <label class="col-sm-2 control-label"><?php echo __('Menu cha') ?></label>

                                        <div class="col-sm-10">
                                                <?php
                                                echo $this->Form->input($model_name . '.parent_id', array(
                                                    'class' => 'form-control',
                                                    'div' => false,
                                                    'label' => false,
                                                    'empty' => '---Select parent---',
                                                    'options' => $parents,
                                                ));
                                                ?>
                                        </div>
                                </div>
                                <div class="hr-line-dashed"></div>

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
                                                    'options' => $langCodes,
                                                ));
                                                ?>
                                        </div>
                                        <div class="col-sm-2">
                                                <button class="btn btn-success" id="add_lang" type="button"><i class="fa fa-plus"></i></button>
                                        </div>
                                </div>
                                <!--                                <div class="hr-line-dashed"></div>-->
                                <!--                end ngon ngu-->

                                <div id="wrap-add-lang">
                                        <?php if (isset($this->request->data['MenuNode']) && count($this->request->data['MenuNode']) > 0) { ?>
                                                <?php
                                                foreach ($this->request->data['MenuNode'] as $data_key => $data_value) {
                                                        if (isset($lang_configs[$data_key]) && !empty($data_value['name'])) {
                                                                echo $this->element('../MenuNodes/add_lang', array('lang_code' => $data_key, 'country' => $lang_configs[$data_key], 'request_data' => $data_value));
                                                                ?>
                                                                <script type="text/javascript">
                                                                        $(document).ready(function () {
                                                                                loadChosen('chosens-news-<?php echo $data_key; ?>');
                                                                                loadEditor('editor-news-<?php echo $data_key; ?>');
                                                                        });
                                                                </script>
                                                                <?php
                                                        }
                                                }
                                                ?>
                                        <?php } ?>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <?php
                                $name_err = $this->Form->error($model_name . '.description');
                                $name_err_class = !empty($name_err) ? 'has-error' : '';
                                ?>

                                <div class="form-group <?php echo $name_err_class ?>">
                                        <label class="col-sm-2 control-label"><?php echo 'Link' ?> <?php echo $this->element('required') ?></label>

                                        <div class="col-sm-10">
                                                <?php
                                                echo $this->Form->input($model_name . '.link', array(
                                                    'class' => 'form-control',
                                                    'div' => false,
                                                    'label' => false,
                                                    'required' => true,
                                                ));
                                                ?>
                                        </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <?php
                                $name_err = $this->Form->error($model_name . '.target');
                                $name_err_class = !empty($name_err) ? 'has-error' : '';
                                ?>
                                <div class="form-group <?php echo $name_err_class ?>">
                                        <label class="col-sm-2 control-label"><?php echo __('menu_target') ?></label>

                                        <div class="col-sm-10">
                                                <?php
                                                echo $this->Form->input($model_name . '.target', array(
                                                    'class' => 'form-control',
                                                    'div' => false,
                                                    'label' => false,
                                                    'placeholder' => '_blank',
                                                ));
                                                ?>
                                        </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <?php
                                $name_err = $this->Form->error($model_name . '.attr');
                                $name_err_class = !empty($name_err) ? 'has-error' : '';
                                ?>
                                <div class="form-group <?php echo $name_err_class ?>">
                                        <label class="col-sm-2 control-label"><?php echo __('Attr') ?></label>

                                        <div class="col-sm-10">
                                                <?php
                                                echo $this->Form->input($model_name . '.attr', array(
                                                    'class' => 'form-control',
                                                    'div' => false,
                                                    'label' => false,
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
                                        <label class="col-sm-2 control-label"><?php echo __('content_provider_order') ?></label>

                                        <div class="col-sm-10">
                                                <?php
                                                echo $this->Form->input($model_name . '.order', array(
                                                    'class' => 'form-control',
                                                    'div' => false,
                                                    'label' => false,
                                                ));
                                                ?>
                                        </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                        <label class="col-sm-2 control-label"><?php echo __('Icon') ?></label>
                                        <div class="col-sm-10">
                                                <?php
                                                $options = array(
                                                    'name' => $model_name . '.images.icon',
                                                    'options' => array(
                                                        'id' => 'icon',
                                                    ),
                                                    'upload_options' => array(
                                                        'maxNumberOfFiles' => 1,
                                                    ),
                                                );
                                                if (isset($request_data['images']['icon'])) {
                                                        $options['request_data_file'] = $request_data['images']['icon'];
                                                }
                                                echo $this->element('JqueryFileUpload/basic_plus_ui', $options);
                                                ?>
                                        </div>
                                </div>

                                <div class="form-group">
                                        <label class="col-sm-2 control-label"><?php echo __('content_provider_status') ?></label>

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
                                                <a href="<?php echo Router::url(array('action' => 'index')) ?>" class="btn btn-white"><i class="fa fa-ban"></i> <span><?php echo __('cancel_btn') ?></span> </a>
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <span><?php echo __('save_btn') ?></span> </button>
                                        </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <?php
                                echo $this->Form->end();
                                ?>
                        </div>
                </div>
        </div>
</div>

<script type="text/javascript">
        var langCodeClone;
        function showModalClone(langCode) {
                langCodeClone = langCode;
                $('#modalCloneLang').modal();
                $('.clone-language-code option').each(function () {
                        if ($(this).attr('value') == langCodeClone || checkLangCode($(this).attr('value')) == true) {
                                $(this).attr('disabled', 'true');
                        }
                });
        }
        function actionCloneLang() {
                var toLangcodeClone = $('#clone-language-code').val();
                if (toLangcodeClone.length > 0 && (checkLangCode(toLangcodeClone) == false)) {
                        var dataClone = {
                                name: $('input[name="data[MenuNode][' + langCodeClone + '][name]"]').val(),
                                short_description: $('textarea[name="data[MenuNode][' + langCodeClone + '][short_description]"]').val(),
                                description: $('textarea[name="data[MenuNode][' + langCodeClone + '][description]"]').val(),
                                lang_code: toLangcodeClone,
                                files: {
                                        banner: null,
                                        logo: null,
                                        slide: null,
                                        poster: null,
                                        thumbnails: null
                                }
                        };
                        if ($('select[name="data[MenuNode][' + langCodeClone + '][tags][]"]')) {
                                dataClone.tags = $('select[name="data[MenuNode][' + langCodeClone + '][tags][]"]').val();
                        }

                        console.log(dataClone);
                        $.post('<?php echo Router::url(array('action' => 'addLangMenu', 'controller' => 'MenuNodes')); ?>', dataClone, function (data) {
                                if (data == 404) {
                                        alert('Ngôn ngữ không tồn tại.');
                                } else if (data == 100) {
                                        alert('Thiếu tham số.');
                                } else {
                                        $('#wrap-add-lang').append(data);
                                        loadChosen('chosens-news-' + toLangcodeClone);
                                        loadEditor('editor-news-' + toLangcodeClone);
                                        $('form').validate();
                                }
                        });
                        $('#modalCloneLang').modal('hide');
                } else {
                        if (checkLangCode(toLangcodeClone)) {
                                alert('Ngôn ngữ đã có!');
                        } else {
                                alert('Bạn phải chọn ngôn ngữ!');
                        }
                }
                $('#clone-language-code').val('');
        }
</script>
<!-- Modal -->
<div class="modal fade" id="modalCloneLang" role="dialog">
        <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                        <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Clone Language</h4>
                        </div>
                        <div class="modal-body">
                                <div class="row">
                                        <div class="col-sm-8">
                                                <?php
                                                if (isset($this->request->data) && isset($_GET['lang_code'])) {
                                                        $this->request->data[$model_name]['lang_code'] = $_GET['lang_code'];
                                                }
                                                echo $this->Form->input($model_name . '.lang_code', array(
                                                    'class' => 'form-control clone-language-code',
                                                    'id' => 'clone-language-code',
                                                    'div' => false,
                                                    'label' => false,
                                                    'options' => $listLangCodeDefault,
                                                    'empty' => "-- chọn ngôn ngữ --"
                                                ));
                                                ?>
                                        </div>
                                        <div class="col-sm-4">
                                                <button type="button" class="btn btn-success" onclick="actionCloneLang()" >Clone Language</button>
                                        </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                </div>

        </div>
</div>