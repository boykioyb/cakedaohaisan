<?php
echo $this->element('js/chosen');
// sử dụng công cụ soạn thảo
echo $this->element('js/tinymce');
// sử dụng upload file
echo $this->element('JqueryFileUpload/basic_plus_ui_assets');
echo $this->element('js/validate');
echo $this->element('js/languages');
echo $this->Html->css('plugins/bootstrap-tagsinput/bootstrap-tagsinput');
echo $this->Html->script('plugins/bootstrap-tagsinput/bootstrap-tagsinput');
echo $this->Html->script('location');
echo $this->Html->script('search');
echo $this->Html->script('plugins/slugify/jquery.slugify');

echo $this->element('js/datetimepicker');
$user = CakeSession::read('Auth.User');
$permissions = $user['permissions'];

$unique = isset($key) ? $key : uniqid();
$lang_configs = $listLangCodeDefault;
?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true"> Thông tin</a></li>
                    </ul>
                    <?php
                    echo $this->Form->create($model_name, array(
                        'class' => 'form-horizontal',
                        'id' => 'form_add'
                    ));
                    ?>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
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
                                        <button class="btn btn-success" id="add_lang" type="button"><i
                                                class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                                <!--                                <div class="hr-line-dashed"></div>-->
                                <!--                end ngon ngu-->

                                <div class="row" id="wrap-add-lang">
                                    <?php if (isset($this->request->data['Video']) && count($this->request->data['Video']) > 0) { ?>
                                        <?php
                                        foreach ($this->request->data['Video'] as $data_key => $data_value) {
                                            if (isset($lang_configs[$data_key]) && !empty($data_value['name'])) {
                                                echo $this->element('../Videos/add_lang', array('lang_code' => $data_key, 'country' => $lang_configs[$data_key], 'request_data' => $data_value));
                                            }
                                        }
                                        ?>
                                    <?php } ?>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?php echo 'Số lượt xem' ?></label>

                                    <div class="col-sm-10">
                                        <?php
                                        echo $this->Form->input($model_name . '.view_count', array(
                                            'class' => 'form-control',
                                            'div' => false,
                                            'label' => false,
                                            'type' => 'number',
                                        ));
                                        ?>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>


                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?php echo __('news_order') ?></label>

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
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?php echo 'Xuất hiện ở trang chủ' ?></label>

                                    <div class="col-sm-10">
                                        <?php
                                        echo $this->Form->input($model_name . '.is_hot', array(
                                            'class' => 'form-control',
                                            'div' => false,
                                            'label' => false,
                                            'default' => 0,
                                            'options' => $is_hot,
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
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?php echo 'Poster' ?></label>

                                    <div class="col-sm-10">
                                        <label><?php echo 'Kích thước ảnh phù hợp: 570x300px'; ?></label>
                                        <?php
                                        echo $this->element('JqueryFileUpload/basic_plus_ui', array(
                                            'name' => $model_name . '.files.poster',
                                            'options' => array(
                                                'id' => 'poster',
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
                                    <label class="col-sm-2 control-label"><?php echo 'Video' ?></label>
                                    <div class="col-sm-10">
                                        <?php
                                        echo $this->element('JqueryFileUpload/basic_plus_ui', array(
                                            'name' => $model_name . '.files.video',
                                            'options' => array(
                                                'id' => 'video',
                                            ),
                                            'upload_options' => array(
                                                'maxNumberOfFiles' => 1,
                                            ),
                                            'acceptFileTypes' => 'mp4',
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
                                        <button type="button" id="submit_form" class="btn btn-primary"><i
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
                name: $('input[name="data[Pages][' + langCodeClone + '][name]"]').val(),
                short_description: $('textarea[name="data[Pages][' + langCodeClone + '][short_description]"]').val(),
                description: $('textarea[name="data[Pages][' + langCodeClone + '][description]"]').val(),
                lang_code: toLangcodeClone,
                files: {
                    banner: null,
                    logo: null,
                    slide: null,
                    poster: null,
                    thumbnails: null
                }
            };
            if ($('select[name="data[Pages][' + langCodeClone + '][tags][]"]')) {
                dataClone.tags = $('select[name="data[Pages][' + langCodeClone + '][tags][]"]').val();
            }

            console.log(dataClone);
            $.post('<?php echo Router::url(array('action' => 'addLangPages', 'controller' => 'Pages')); ?>', dataClone, function (data) {
                if (data == 404) {
                    alert('Ngôn ngữ không tồn tại.');
                } else if (data == 100) {
                    alert('Thiếu tham số.');
                } else {
                    $('#wrap-add-lang').append(data);
                    loadChosen('chosens-pages-' + toLangcodeClone);
                    loadEditor('editor-pages-' + toLangcodeClone);
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
                        <button type="button" class="btn btn-success" onclick="actionCloneLang()">Clone Language
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>