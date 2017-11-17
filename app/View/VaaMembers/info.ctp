<?php
echo $this->Html->css('stylerange.css');
?>
<style>
    .card:nth-child(n+3),#showLess,#showLessDiss,#showLessBlack{
        display:none;
    }
    .less{
        cursor: pointer;
    }
    .input-group-addon{
        position: absolute;
        right: 2%;
        top: 0;
        width: 5%;
        padding: 9px 0px;
        height: 100%;
        background: #1bb394;
        cursor: pointer;
    }
    .white{
        color: white;
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
                        'controller' => 'VaaMembers',
                    ),
                ));
                ?>
                <?php
                echo $this->Form->hidden('id');
                ?>

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
                    <label class="col-sm-2 control-label"><?php echo __('username') ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.username', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'readonly' => 'readonly',
                            'default' => isset($request_data['username']) ? $request_data['username'] : '',
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('number_mobile') ?></label>
                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.number_mobile', array(
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
                        if (isset($member[$model_name]['file_uris']['avatar'][0]) && file_exists('../' . $member[$model_name]['file_uris']['avatar'][0])):
                            echo $this->Html->image('../' . $member[$model_name]['file_uris']['avatar'][0], ['style' => 'display: block;max-width: 15%;max-height: 16%;', 'id' => 'myImg', 'onclick' => 'myFunction(this.src,this.alt)']);
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
                        <?php $id = ($member[$model_name]['id']) ?>
                        <div class="onoffswitch">
                            <input  type="checkbox" value="<?= $id ?>"
                                    class="onoffswitch-checkbox"
                                    id="changePass-<?= $id ?>"  
                                    <?php
                                    if ($member[$model_name]['status'] == "1") {
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
                    <label class="col-sm-2 control-label"><?php echo __('gender') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.gender', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'readonly' => 'readonly',
                            'value' => $member[$model_name]['gender'] == "0" ? 'Nữ' : ($member[$model_name]['gender'] == "1" ? 'Nam' : 'Khác')
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('name_company') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.company_name', array(
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
                    <label class="col-sm-2 control-label"><?php echo __('address_partner') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.address', array(
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
                    <label class="col-sm-2 control-label"><?php echo __('friends') ?></label>

                    <div class="col-sm-10">
                        <div class="form-group">
                            <div id="accordion" role="tablist">
                                <?php if (!empty($friend)) : ?>
                                    <?php
                                    $key = 1000;
                                    foreach ($friend as $val):
                                        $key++;
                                        ?>
                                        <div class="card">
                                            <div class="card-header" role="tab" id="headingTwo">
                                                <h5 class="mb-0">
                                                    <a class="collapsed" data-toggle="collapse" href="#<?= $key ?>" aria-expanded="false" aria-controls="collapseTwo">
                                                        <?php echo(isset($val['name']) ? $val['name'] : ''); ?>
                                                    </a>
                                                </h5>
                                            </div>
                                            <div id="<?= $key ?>" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"><?php echo __('id') ?></label>

                                                    <div class="col-sm-10">
                                                        <?php
                                                        echo $this->Form->input($model_name . '.id', array(
                                                            'type' => 'text',
                                                            'class' => 'form-control vaa-id',
                                                            'div' => false,
                                                            'readonly' => 'readonly',
                                                            'label' => false,
                                                            'value' => isset($val['id']) ? $val['id'] : ''
                                                        ));
                                                        ?>
                                                        <a class="white" href="<?php echo Router::url(array('controller' => 'VaaMembers', 'action' => 'infoMembers', $val['id'])); ?>">
                                                            <span class="input-group-addon">
                                                                <span  class="fa fa-eye" ></span>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"><?php echo __('username') ?></label>

                                                    <div class="col-sm-10">
                                                        <?php
                                                        echo $this->Form->input($model_name . '.username', array(
                                                            'type' => 'text',
                                                            'class' => 'form-control',
                                                            'div' => false,
                                                            'readonly' => 'readonly',
                                                            'label' => false,
                                                            'value' => isset($val['username']) ? $val['username'] : ''
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
                                                            'type' => 'text',
                                                            'class' => 'form-control',
                                                            'div' => false,
                                                            'readonly' => 'readonly',
                                                            'label' => false,
                                                            'value' => isset($val['name']) ? $val['name'] : ''
                                                        ));
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"><?php echo __('gender') ?></label>

                                                    <div class="col-sm-10">
                                                        <?php
                                                        echo $this->Form->input($model_name . '.gender', array(
                                                            'class' => 'form-control',
                                                            'div' => false,
                                                            'label' => false,
                                                            'readonly' => 'readonly',
                                                            'value' => $val['gender'] == "0" ? 'Nữ' : ($val['gender'] == "1" ? 'Nam' : 'Khác')
                                                        ));
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <div id="loadMore" class="less" onclick="loadMore('#accordion', '#showLess', '#loadMore')">Xem thêm</div>
                                <div id="showLess" class="less" onclick="showLess('#accordion', '#showLess', '#loadMore')">Thu gọn</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('blacklists') ?></label>

                    <div class="col-sm-10">
                        <div class="form-group">
                            <div id="blacklist" role="tablist">
                                <?php if (!empty($blacklists)) : ?>
                                    <?php
                                    $k = 212;
                                    foreach ($blacklists as $value):
                                        $k++;
                                        ?>
                                        <div class="card">
                                            <div class="card-header" role="tab" id="headingTwo">
                                                <h5 class="mb-0">
                                                    <a class="collapsed" data-toggle="collapse" href="#<?= $k ?>c" aria-expanded="false" aria-controls="collapseTwo">
                                                        <?php echo(isset($value['name']) ? $value['name'] : ''); ?>
                                                    </a>
                                                </h5>
                                            </div>
                                            <div id="<?= $k ?>c" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"><?php echo __('id') ?></label>

                                                    <div class="col-sm-10">
                                                        <?php
                                                        echo $this->Form->input($model_name . '.id', array(
                                                            'type' => 'text',
                                                            'class' => 'form-control',
                                                            'div' => false,
                                                            'readonly' => 'readonly',
                                                            'label' => false,
                                                            'value' => isset($value['id']) ? $value['id'] : ''
                                                        ));
                                                        ?>
                                                        <a class="white"  href="<?php echo Router::url(array('controller' => 'VaaMembers', 'action' => 'infoMembers', $value['id'])); ?>">
                                                            <span class="input-group-addon">
                                                                <span  class="fa fa-eye" ></span>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"><?php echo __('username') ?></label>

                                                    <div class="col-sm-10">
                                                        <?php
                                                        echo $this->Form->input($model_name . '.username', array(
                                                            'type' => 'text',
                                                            'class' => 'form-control',
                                                            'div' => false,
                                                            'readonly' => 'readonly',
                                                            'label' => false,
                                                            'value' => isset($value['username']) ? $value['username'] : ''
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
                                                            'type' => 'text',
                                                            'class' => 'form-control',
                                                            'div' => false,
                                                            'readonly' => 'readonly',
                                                            'label' => false,
                                                            'value' => isset($value['name']) ? $value['name'] : ''
                                                        ));
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"><?php echo __('gender') ?></label>

                                                    <div class="col-sm-10">
                                                        <?php
                                                        echo $this->Form->input($model_name . '.gender', array(
                                                            'class' => 'form-control',
                                                            'div' => false,
                                                            'label' => false,
                                                            'readonly' => 'readonly',
                                                            'value' => $value['gender'] == "0" ? 'Nữ' : ($value['gender'] == "1" ? 'Nam' : 'Khác')
                                                        ));
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <div id="loadMoreBack" class="less"  onclick="loadMore('#blacklist', '#showLessBlack', '#loadMoreBack')">Xem thêm</div>
                                <div id="showLessBlack" class="less" onclick="showLess('#blacklist', '#showLessBlack', '#loadMoreBack')">Thu gọn</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('discussions') ?></label>

                    <div class="col-sm-10">
                        <div class="form-group">
                            <div id="discussions" role="tablist">
                                <?php if (!empty($discussions)) : ?>
                                    <?php
                                    $dis_i = 01;
                                    foreach ($discussions as $vals):

                                        $dis_i++;
                                        ?>
                                        <div class="card">
                                            <div class="card-header" role="tab" id="headingTwo">
                                                <h5 class="mb-0">
                                                    <a class="collapsed" data-toggle="collapse" href="#<?= $dis_i ?>d" aria-expanded="false" aria-controls="collapseTwo">
                                                        <?php echo(isset($vals['name']) ? $vals['name'] : ''); ?>
                                                    </a>
                                                </h5>
                                            </div>
                                            <div id="<?= $dis_i ?>d" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"><?php echo __('id') ?></label>

                                                    <div class="col-sm-10">
                                                        <?php
                                                        echo $this->Form->input($model_name . '.id', array(
                                                            'type' => 'text',
                                                            'class' => 'form-control',
                                                            'div' => false,
                                                            'readonly' => 'readonly',
                                                            'label' => false,
                                                            'value' => isset($vals['id']) ? $vals['id'] : ''
                                                        ));
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="hr-line-dashed"></div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"><?php echo __('discussions_name') ?></label>

                                                    <div class="col-sm-10">
                                                        <?php
                                                        echo $this->Form->input($model_name . '.name', array(
                                                            'type' => 'text',
                                                            'class' => 'form-control',
                                                            'div' => false,
                                                            'readonly' => 'readonly',
                                                            'label' => false,
                                                            'value' => isset($vals['name']) ? $vals['name'] : ''
                                                        ));
                                                        ?>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <div id="loadMoreDiss" class="less" onclick="loadMore('#discussions', '#showLessDiss', '#loadMoreDiss')">Xem thêm</div>
                                <div id="showLessDiss" class="less" onclick="showLess('#discussions', '#showLessDiss', '#loadMoreDiss')">Thu gọn</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('last_login_at') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.last_login_at', array(
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
                    <label class="col-sm-2 control-label"><?php echo __('created') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.created', array(
                            'class' => 'form-control',
                            'type' => 'text',
                            'div' => false,
                            'label' => false,
                            'readonly' => 'readonly',
                            'value' => date("d-m-Y H:i:s", isset($member[$model_name]['created']) ? $member[$model_name]['created']->sec : '')
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
                                url: '<?= Router::url(['controller' => 'VaaMembers', 'action' => 'ajaxChangeStatus']) ?>',
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