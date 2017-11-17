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
                            'value' => isset($file[$model_name]['id']) ? $file[$model_name]['id'] : ''
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('name') ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.name', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'readonly' => 'readonly',
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('mime') ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.mime', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'readonly' => 'readonly',
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('avatar') ?></label>
                    <div class="col-sm-10">
                        <?php
                        if (isset($file[$model_name]['uri']) && file_exists('../' . $file[$model_name]['uri'])):
                            echo $this->Html->image('../' . $file[$model_name]['uri'], ['style' => 'display: block;max-width: 15%;max-height: 16%;', 'id' => 'myImg', 'onclick' => 'myFunction(this.src,this.alt)']);
                        else:
                            echo $this->Html->image('icon-user-default.png', ['style' => 'display: block;']);
                        endif;
                        ?>
                        <div id="myModal" class="modal">
                            <span class="close">&times;</span>
                            <img class="modal-content" id="img01">
                            <div id="caption"></div>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('status') ?></label>

                    <div class="col-sm-10">
                        <?php $id = ($file[$model_name]['id']) ?>
                        <div class="onoffswitch">
                            <input  type="checkbox" value="<?= $id ?>"
                                    class="onoffswitch-checkbox"
                                    id="changePass-<?= $id ?>"  
                                    <?php
                                    if ($file[$model_name]['status'] == "1") {
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
                    <label class="col-sm-2 control-label"><?php echo __('size') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.size', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'readonly' => 'readonly',
                            'value' => isset($file[$model_name]['size']) ? $file[$model_name]['size'] . " KB" : ''
                        ));
                        ?>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('module') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.module', array(
                            'type' => 'text',
                            'class' => 'form-control',
                            'div' => false,
                            'readonly' => 'readonly',
                            'label' => false,
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
                            'value' => date("d-m-Y H:i:s", isset($file[$model_name]['created']) ? $file[$model_name]['created']->sec : '')
                        ));
                        ?>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<script>
    var modal = document.getElementById('myModal');

    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    function myFunction(src, alt) {
        modal.style.display = "block";
        modalImg.src = src;
        captionText.innerHTML = alt;
    }

    var span = document.getElementsByClassName("close")[0];

    span.onclick = function () {
        modal.style.display = "none";
    };
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
                                url: '<?= Router::url(['controller' => 'VaaFiles', 'action' => 'ajaxChangeStatus']) ?>',
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