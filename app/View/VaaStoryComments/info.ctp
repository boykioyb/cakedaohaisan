<?php
echo $this->Html->css('stylerange.css');
?>
<style>

    input:hover{
        color: black;
    }

</style>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <?php
                echo $this->Form->create($model_name, array(
                    'class' => 'form-horizontal',
                    'url' => array(
                        '?' => $this->request->query,
                        'controller' => 'VaaFiles',
                    ),
                ));
                ?>
                <?php
                echo $this->Form->hidden('id');
                ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('ID') ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.id', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'readonly' => 'readonly',
                            'value' => isset($story[$model_name]['id']) ? $story[$model_name]['id'] : ''
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('parent_id') ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.parent_ids', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'readonly' => 'readonly',
                            'value' => isset($story[$model_name]['parent_id']) ? $story[$model_name]['parent_id'] : 0
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('stories_like') ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.story', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'readonly' => 'readonly',
                            'value' => isset($story_id['content']) ? $story_id['content'] : ''
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
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'readonly' => 'readonly',
                            'value' => isset($owner['name']) ? $owner['name'] : ''
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('status') ?></label>

                    <div class="col-sm-10">
                        <?php
                        $id = ($story[$model_name]['id'])
                        ?>
                        <div class="onoffswitch">
                            <input  type="checkbox" value="<?= $id ?>"
                                    class="onoffswitch-checkbox"
                                    id="changePass-<?= $id ?>"  
                                    <?php
                                    if ($story[$model_name]['status'] == "1") {
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
                    <label class="col-sm-2 control-label"><?php echo __('created') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.created', array(
                            'class' => 'form-control',
                            'type' => 'text',
                            'div' => false,
                            'label' => false,
                            'readonly' => 'readonly',
                            'value' => date("d-m-Y H:i:s", isset($story[$model_name]['created']) ? $story[$model_name]['created']->sec : '')
                        ));
                        ?>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<script>

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
                                url: '<?= Router::url(['controller' => 'VaaStoryComments', 'action' => 'ajaxChangeStatus']) ?>',
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