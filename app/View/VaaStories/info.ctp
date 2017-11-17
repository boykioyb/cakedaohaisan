<?php
// sử dụng công cụ soạn thảo
echo $this->element('js/chosen');
// sử dụng upload file
echo $this->element('JqueryFileUpload/basic_plus_ui_assets');
echo $this->element('js/validate');
$user = CakeSession::read('Auth.User');
$permissions = $user['permissions'];
?>
<style>
    .mySlides {display:none}
    /* Slideshow container */
    .slideshow-container {
        max-width: 50%;
        position: relative;
        margin: auto;
    }
    /* Next & previous buttons */
    .prev, .next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        width: auto;
        padding: 16px;
        margin-top: -22px;
        color: white;
        font-weight: bold;
        font-size: 18px;
        transition: 0.6s ease;
        border-radius: 0 3px 3px 0;
    }

    /* Position the "next button" to the right */
    .next {
        right: 0;
        border-radius: 3px 0 0 3px;
    }

    /* On hover, add a black background color with a little bit see-through */
    .prev:hover, .next:hover {
        background-color: rgba(0,0,0,0.8);
    }

    /* On smaller screens, decrease text size */
    @media only screen and (max-width: 300px) {
        .prev, .next,.text {font-size: 11px}
    }
</style>

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
                    <label class="col-sm-2 control-label"><?php echo __('ID') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.id', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'readonly' => true
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('ref_id') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.ref_ids', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'readonly' => true,
                            'value' => isset($this->request->data[$model_name]['ref_id']) ? $this->request->data[$model_name]['ref_id'] : ''
                        ));
                        ?>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('ref_type') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.ref_type', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'readonly' => true
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('stories_title') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.vi.title', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'readonly' => true
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('post_content') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->textarea($model_name . '.content', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'required' => false,
                            'readonly' => true
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('like_count') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.like_count', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'type' => 'number',
                            'readonly' => true
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('comment_count') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.comment_count', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'type' => 'number',
                            'readonly' => true
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('share_count') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.share_count', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'type' => 'number',
                            'readonly' => true
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('stories_feeling') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.feeling', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'type' => 'text',
                            'readonly' => true,
                            'value' => isset($feeling) ? $feeling : ''
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('status') ?></label>

                    <div class="col-sm-10">
                        <?php
                        $id = ($stories[$model_name]['id'])
                        ?>
                        <div class="onoffswitch">
                            <input  type="checkbox" value="<?= $id ?>"
                                    class="onoffswitch-checkbox"
                                    id="changePass-<?= $id ?>"  
                                    <?php
                                    if ($stories[$model_name]['status'] == "1") {
                                        echo 'checked';
                                    }
                                    ?>>
                            <label class="onoffswitch-label"
                                   for="changePass-<?= $id ?>">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('with_members') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.with_members', array(
                            'class' => 'form-control chosen-select',
                            'multiple' => true,
                            'options' => isset($with_member) && !empty($with_member) ? $with_member : array(),
                            'div' => false,
                            'label' => false,
                            'readonly' => true,
                            'id' => 'with_members',
                            'value' => isset($value_member) && !empty($value_member) ? $value_member : ''
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">

                    <label class="col-sm-2 control-label"><?php echo __('stories_member') ?></label>

                    <div class="col-sm-10" style="background: #fff">
                        <?php
                        echo $this->Form->input($model_name . '.member', array(
                            'class' => 'form-control chosen-select',
                            'options' => $members,
                            'div' => false,
                            'label' => false,
                            'readonly' => true,
                            'empty' => '-------',
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">

                    <label class="col-sm-2 control-label"><?php echo __('owner') ?></label>

                    <div class="col-sm-10" style="background: #fff">
                        <?php
                        echo $this->Form->input($model_name . '.owner', array(
                            'class' => 'form-control chosen-select',
                            'options' => $members,
                            'div' => false,
                            'label' => false,
                            'readonly' => true,
                            'empty' => '-------',
                        ));
                        ?>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('loc_address') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.loc_address', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'readonly' => true,
                            'type' => 'text',
                            'placeholder' => 'Nhập địa điểm'
                        ));
                        ?>

                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('created') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.created', array(
                            'class' => 'form-control',
                            'type' => 'text',
                            'div' => false,
                            'label' => false,
                            'readonly' => 'readonly',
                            'value' => date("d-m-Y H:i:s", isset($this->request->data[$model_name]['created']) ? $this->request->data[$model_name]['created']->sec : '')
                        ));
                        ?>
                    </div>
                </div>

                <?php
                echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>
</div>
<script language="javascript">
    $("select").not(":selected").attr("disabled", "disabled");

    $(document).ready(function () {

        $('.onoffswitch-checkbox').change(function () {
            var status;
            var checkbox = $(this);
            var id = $(this).val();
            if (checkbox.is(":checked")) {
                status = 1;
            } else {
                status = 0;
            }
            swal({
                title: "Bạn muốn thay đổi trạng thái?",
                text: "Nhấn ok để thay đổi !!!",
                icon: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                closeOnCancel: true
            })
                    .then((isConfirm) => {
                        if (isConfirm) {
                            $.ajax({
                                url: '<?= Router::url(['controller' => 'VaaStories', 'action' => 'ajaxChangeStatus']) ?>',
                                type: 'post',
                                dateType: 'json',
                                data: {
                                    status: status,
                                    id: id
                                },
                                success: function (result) {
                                    var parsed = JSON.parse(result);
                                    if (parsed === 1) {
                                        swal({
                                            title: "Thay đổi thành công!",
                                            text: "Success",
                                            icon: "success",
                                            timer: 2000
                                        });
                                    } else {
                                        swal({
                                            title: "Thay đổi thất bại!",
                                            text: "error",
                                            icon: "error"
                                        });
                                        if (checkbox.is(":checked")) {
                                            checkbox.prop('checked', false);
                                        } else {
                                            checkbox.prop('checked', true);
                                        }
                                    }
                                },
                                error: function () {
                                    swal({
                                        title: "Lỗi",
                                        text: "error",
                                        icon: "error"
                                    });
                                }
                            });
                        } else {
                            if (checkbox.is(":checked")) {
                                checkbox.prop('checked', false);
                            } else {
                                checkbox.prop('checked', true);
                            }
                        }
                    });
        });
    });
</script>