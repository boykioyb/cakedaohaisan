<?php
echo $this->element('js/chosen');
echo $this->Html->css('stylerange.css');
echo $this->Html->script('search');
$user = CakeSession::read('Auth.User');
$permissions = $user['permissions'];
?>
<div class="ibox-content m-b-sm border-bottom">
    <?php
    echo $this->Form->create('Search', array(
        'url' => array(
            'action' => $this->action,
            'controller' => Inflector::pluralize($model_name),
        ),
        'type' => 'get',
    ))
    ?>
    <div class="row">

        <div class="col-md-3">
            <div class="form-group">
                <?php
                echo $this->Form->input('id', array(
                    'div' => false,
                    'class' => 'form-control',
                    'label' => __('ID'),
                    'default' => $this->request->query('id'),
                ));
                ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <?php
                echo $this->Form->input('name', array(
                    'div' => false,
                    'class' => 'form-control',
                    'label' => __('name'),
                    'default' => $this->request->query('name'),
                ));
                ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <?php
                echo $this->Form->input('username', array(
                    'div' => false,
                    'class' => 'form-control',
                    'label' => __('username'),
                    'type' => 'text',
                    'default' => $this->request->query('username'),
                ));
                ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <?php
                echo $this->Form->input('email', array(
                    'div' => false,
                    'class' => 'form-control',
                    'label' => __('Email'),
                    'type' => 'text',
                    'default' => $this->request->query('email'),
                ));
                ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <?php
                echo $this->Form->input('mobile', array(
                    'div' => false,
                    'class' => 'form-control',
                    'label' => __('number_mobile'),
                    'type' => 'number',
                    'default' => $this->request->query('mobile'),
                ));
                ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <?php
                echo $this->Form->input('birthday', array(
                    'div' => false,
                    'class' => 'form-control datepicker showDate',
                    'label' => __('birthday'),
                    'type' => 'text',
                    'default' => $this->request->query('birthday'),
                ));
                ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <?php
                echo $this->Form->input('gender', array(
                    'div' => false,
                    'class' => 'form-control',
                    'label' => __('gender'),
                    'options' => $gender,
                    'empty' => '-------',
                    'default' => $this->request->query('gender'),
                ));
                ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <?php
                echo $this->Form->input('status', array(
                    'div' => false,
                    'class' => 'form-control',
                    'label' => __('blog_status'),
                    'options' => $status,
                    'empty' => '-------',
                    'default' => $this->request->query('status'),
                ));
                ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label><?= __('created'); ?>(bắt đầu)</label>
                <div class='input-group date' id='datetimepicker1'>
                    <input type="text" class="form-control" name="start"
                           value="<?=
                           isset($this->request->query['start']) ? $this->request->query['start'] : ''
                           ?>"
                           id="dateStart"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label><?= __('created'); ?>(kết thúc)</label>
                <div class='input-group date' id='datetimepicker2'>
                    <input type="text" class="form-control" name="end"
                           value="<?=
                           isset($this->request->query['end']) ? $this->request->query['end'] : ''
                           ?>"
                           id="dateEnd"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div>
                <label style="visibility: hidden"><?php echo __('search_btn') ?></label>
            </div>
            <?php echo $this->element('buttonSearchClear'); ?>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
<div class="ibox float-e-margins">
    <div class="ibox-content">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <?php if (!empty($list_data)): ?>
                            <th style="width: 3%"><?= __('STT') ?></th>
                            <th style="width: 15%"><?php echo $this->Paginator->sort('name', __('name')); ?></th>
                            <th style="width: 18%"><?php echo $this->Paginator->sort('order', __('username')); ?></th>
                            <th style="width: 10%"><?php echo(__('number_mobile')); ?></th>
                            <th style="width: 10%"><?php echo __('avatar') ?></th>
                            <th style="width: 8%"><?php echo __('birthday') ?></th>
                            <th style="width: 8%"><?php echo __('gender') ?></th>
                            <th style="width: 8%"><?php echo __('status') ?></th>
                            <th style="width: 10%"><?php echo __('created_date') ?></th>
                        <?php else: ?>
                            <th style="width: 3%"><?= __('STT') ?></th>
                            <th style="width: 15%"><?php echo $this->Paginator->sort('name', __('name')); ?></th>
                            <th style="width: 18%"><?php echo $this->Paginator->sort('order', __('username')); ?></th>
                            <th style="width: 10%"><?php echo(__('number_mobile')); ?></th>
                            <th style="width: 10%"><?php echo __('avatar') ?></th>
                            <th style="width: 8%"><?php echo __('birthday') ?></th>
                            <th style="width: 8%"><?php echo __('gender') ?></th>
                            <th style="width: 8%"><?php echo __('status') ?></th>
                            <th style="width: 10%"><?php echo __('created_date') ?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($list_data)): ?>
                        <?php
                        $stt = $this->Paginator->counter('{:start}');
                        ?>
                        <?php foreach ($list_data as $item): ?>
                            <tr class="form-edit">
                                <td>
                                    <?php
                                    echo $stt;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $id = $item[$model_name]['id'];
                                    echo $this->Form->hidden('id', array(
                                        'value' => $id,
                                    ));
                                    ?>
                                    <strong>
                                        <?php echo isset($item[$model_name]['name']) ? $item[$model_name]['name'] : ''; ?>
                                    </strong><br>
                                    <small>ID:<?= isset($id) ? $id : '' ?></small>
                                    <br/>

                                </td>

                                <td>
                                    <strong>
                                        <?php echo $this->Html->link(isset($item[$model_name]['username']) ? $item[$model_name]['username'] : '', array('controller' => 'VaaMembers', 'action' => 'infoMembers', $id)); ?>
                                        <br>
                                        <small>Email: <?= isset($item[$model_name]['email']) ? $item[$model_name]['email'] : ''; ?></small></td>

                                <td><?= isset($item[$model_name]['mobile']) ? $item[$model_name]['mobile'] : ''; ?></td>

                                <td>
                                    <?php
                                    if (isset($item[$model_name]['file_uris']['avatar'][0]) && file_exists('../' . $item[$model_name]['file_uris']['avatar'][0])):
                                        echo $this->Html->image('../' . $item[$model_name]['file_uris']['avatar'][0], ['style' => 'display: block;margin: auto;max-width: 100%;max-height: 16%;', 'id' => 'myImg', 'onclick' => 'myFunction(this.src,this.alt)']);
                                    else:
                                        echo $this->Html->image('icon-user-default.png', ['style' => 'display: block;margin: auto;']);
                                    endif;
                                    ?>
                                    <div id="myModal" class="modal">
                                        <span class="close">&times;</span>
                                        <img class="modal-content" id="img01">
                                        <div id="caption"></div>
                                    </div>
                                </td>

                                <td><?= isset($item[$model_name]['birthday']) && $item[$model_name]['birthday'] !== null ? date('d-m-Y', strtotime($item[$model_name]['birthday'])) : ''; ?></td>

                                <td>
                                    <?php
                                    if (isset($item[$model_name]['gender'])) {
                                        if ($item[$model_name]['gender'] == 0) {
                                            echo 'Nữ';
                                        } elseif ($item[$model_name]['gender'] == 1) {
                                            echo('Nam');
                                        } else {
                                            echo("Khác");
                                        }
                                    } else {
                                        echo "";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <div class="onoffswitch">
                                        <input  type="checkbox" value="<?= $id ?>"
                                                class="onoffswitch-checkbox"
                                                id="changePass-<?= $id ?>"   <?php
                                                if (isset($item[$model_name]['status']) && $item[$model_name]['status'] == "1") {
                                                    echo 'checked';
                                                }
                                                ?>>
                                        <label class="onoffswitch-label"
                                               for="changePass-<?= $id ?>">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <?php $dates = isset($item[$model_name]['created']) && !empty($item[$model_name]['created']) ? $item[$model_name]['created']->sec : ''; ?>
                                    <?= date('d-m-Y H:i:s', $dates); ?>
                                </td>

                            </tr>
                            <?php $stt++; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center"><?php echo __('no_result') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php echo $this->element('pagination'); ?>
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
        $('#datetimepicker1').datetimepicker({
            format: 'DD-MM-YYYY HH:mm:ss'
        });
        $('#datetimepicker2').datetimepicker({
            format: 'DD-MM-YYYY HH:mm:ss'
        });

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
</script>