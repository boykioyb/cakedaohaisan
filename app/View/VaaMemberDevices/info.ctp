<style>
    #name_member{
        background-color: #1bb394;
        color: white;
        padding: 8px 20px;
        position: absolute;
        right: 1.8%;
        top: 0;
    }

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
                        'controller' => 'VaaMemberDevices',
                    ),
                ));
                ?>
                <?php
                echo $this->Form->hidden('id');
                ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('Member_id') ?></label>
                    <div class="col-sm-10">
                        <input id="text_id" type="text" class="form-control" readonly name="Member_id" value="<?= isset($info_member['VaaMemberDevice']['id']) ? $info_member['VaaMemberDevice']['id'] : '' ?>"/>
                        <span id="name_member" class="text-white" ><?= $members_name; ?></span>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('Member') ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.member', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'readonly' => 'readonly',
                            'default' => isset($request_data['member']) ? $request_data['member'] : '',
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('token') ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.token', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'readonly' => 'readonly',
                            'rows' => '5'
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('platform') ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.platform', array(
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
                    <label class="col-sm-2 control-label"><?php echo __('uuid') ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.uuid', array(
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
                    <label class="col-sm-2 control-label"><?php echo __('push_reg_id') ?></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" readonly name="push_reg_id" value="<?= isset($info_member['VaaMemberDevice']['push_reg_id']) ? $info_member['VaaMemberDevice']['push_reg_id'] : '' ?>"/>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('push_reg_type') ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.push_reg_type', array(
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
                    <label class="col-sm-2 control-label"><?php echo __('user_agent') ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.user_agent', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'readonly' => 'readonly',
                            'row' => '3'
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('client_ip') ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.client_ip', array(
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
                    <label class="col-sm-2 control-label"><?php echo __('status') ?></label>

                    <div class="col-sm-10">
                        <?php $id = ($info_member[$model_name]['id']) ?>
                        <div class="onoffswitch">
                            <input  type="checkbox" value="<?= $id ?>"
                                    class="onoffswitch-checkbox"
                                    id="changePass-<?= $id ?>"  
                                    <?php
                                    if ($info_member[$model_name]['status'] == "1") {
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
                            'value' => date("d-m-Y H:i:s", isset($info_member[$model_name]['created']) ? $info_member[$model_name]['created']->sec : '')
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
        x = 3;
        if ($("#discussions .card").size() <= 2) {
            $('#loadMoreDiss').hide();
        }
        if ($("#blacklist .card").size() <= 2) {
            $('#loadMoreBack').hide();
        }
        if ($("#accordion .card").size() <= 2) {
            $('#loadMore').hide();
        }
        $('div#headingTwo:lt(' + x + ')').show();
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
                                url: '<?= Router::url(['controller' => 'VaaMemberDevices', 'action' => 'ajaxChangeStatus']) ?>',
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


    function loadMore(id, idLess, idMore) {
        size_li = $(id + " .card").size();
        x = (x + 5 <= size_li) ? x + 5 : size_li;
        $(id + ' .card:lt(' + x + ')').show();
        if (x <= 3) {
            $(idLess).hide();
        }
        if (Math.max(x) === size_li) {
            $(idMore).hide();
        }
    }
    function showLess(id, idLess, idMore) {
        size_li = $(id + " .card").size();
        x = (x - 5 < 0) ? 3 : x - 5;
        $(id + ' .card').not(':lt(' + x + ')').hide();
        if (x <= 3) {
            $(idLess).hide();
        }
        if (Math.max(x) === size_li || size_li === 0) {
            $(idMore).hide();
        }
    }

</script>