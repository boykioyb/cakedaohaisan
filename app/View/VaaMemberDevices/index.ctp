<?php
echo $this->element('js/chosen');
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
                echo $this->Form->input('platform', array(
                    'div' => false,
                    'class' => 'form-control',
                    'label' => __('platform'),
                    'default' => $this->request->query('platform'),
                ));
                ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <?php
                echo $this->Form->input('uuid', array(
                    'div' => false,
                    'class' => 'form-control',
                    'label' => __('uuid'),
                    'type' => 'number',
                    'default' => $this->request->query('uuid'),
                ));
                ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <?php
                echo $this->Form->input('push_reg_id', array(
                    'div' => false,
                    'class' => 'form-control',
                    'label' => __('push_reg_id'),
                    'type' => 'text',
                    'default' => $this->request->query('push_reg_id'),
                ));
                ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <?php
                echo $this->Form->input('push_reg_type', array(
                    'div' => false,
                    'class' => 'form-control',
                    'label' => __('push_reg_type'),
                    'type' => 'text',
                    'default' => $this->request->query('push_reg_type'),
                ));
                ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <?php
                echo $this->Form->input('client_ip', array(
                    'div' => false,
                    'class' => 'form-control',
                    'label' => __('client_ip'),
                    'type' => 'text',
                    'default' => $this->request->query('client_ip'),
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
                            <th style="width: 15%"><?php echo $this->Paginator->sort('ID', __('Member')); ?></th>
                            <th style="width: 18%"><?php echo $this->Paginator->sort('order', __('platform')); ?></th>
                            <th style="width: 10%"><?php echo(__('uuid')); ?></th>
                            <th style="width: 10%"><?php echo __('push_reg_id') ?></th>
                            <th style="width: 8%"><?php echo __('push_reg_type') ?></th>
                            <th style="width: 8%"><?php echo __('user_agent') ?></th>
                            <th style="width: 8%"><?php echo __('client_ip') ?></th>
                            <th style="width: 10%"><?php echo __('status') ?></th>
                            <th style="width: 10%"><?php echo __('created_date') ?></th>
                        <?php else: ?>
                            <th style="width: 3%"><?= __('STT') ?></th>
                            <th style="width: 15%"><?php echo $this->Paginator->sort('ID', __('ID')); ?></th>
                            <th style="width: 18%"><?php echo $this->Paginator->sort('order', __('platform')); ?></th>
                            <th style="width: 10%"><?php echo(__('uuid')); ?></th>
                            <th style="width: 10%"><?php echo __('push_reg_id') ?></th>
                            <th style="width: 8%"><?php echo __('push_reg_type') ?></th>
                            <th style="width: 8%"><?php echo __('user_agent') ?></th>
                            <th style="width: 8%"><?php echo __('client_ip') ?></th>
                            <th style="width: 10%"><?php echo __('status') ?></th>
                            <th style="width: 10%"><?php echo __('created_date') ?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($list_data)): ?>
                        <?php
                        $stt = $this->Paginator->counter('{:start}');
                        ?>
                        <?php for ($i = 0; $i < count($list_data); $i++): ?>
                            <tr class="form-edit">
                                <td>
                                    <?php
                                    echo $stt;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $id = $list_data[$i][$model_name]['id'];
                                    echo $this->Form->hidden('id', array(
                                        'value' => $id,
                                    ));
                                    ?>
                                    <strong>
                                        <?php
                                        $data = isset($list_data[$i][$model_name]['member']) ? $members['name'] : '';
                                        ?>
                                        <?php echo $this->Html->link($data, array('controller' => 'VaaMemberDevices', 'action' => 'infoMembers', $id)); ?>
                                    </strong><br>
                                    <small>ID:<?= isset($id) ? $id : '' ?></small>
                                    <br/>

                                </td>

                                <td>
                                    <strong>
                                        <?= isset($list_data[$i][$model_name]['platform']) ? $list_data[$i][$model_name]['platform'] : '' ?>
                                    </strong>
                                </td>

                                <td><?= isset($list_data[$i][$model_name]['uuid']) ? $list_data[$i][$model_name]['uuid'] : ''; ?></td>
                                <td><?= isset($list_data[$i][$model_name]['push_reg_id']) ? $list_data[$i][$model_name]['push_reg_id'] : ''; ?></td>
                                <td><?= isset($list_data[$i][$model_name]['push_reg_type']) ? $list_data[$i][$model_name]['push_reg_type'] : ''; ?></td>
                                <td><?= isset($list_data[$i][$model_name]['user_agent']) ? substr($list_data[$i][$model_name]['user_agent'], 0, 20) . '...' : ''; ?></td>
                                <td><?= isset($list_data[$i][$model_name]['client_ip']) ? $list_data[$i][$model_name]['client_ip'] : ''; ?></td>
                                <td>
                                    <div class="onoffswitch">
                                        <input  type="checkbox" value="<?= $id ?>"
                                                class="onoffswitch-checkbox"
                                                id="changePass-<?= $id ?>"   <?php
                                                if (isset($list_data[$i][$model_name]['status']) && $list_data[$i][$model_name]['status'] == "1") {
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
                                    <?php $dates = isset($list_data[$i][$model_name]['created']) && !empty($list_data[$i][$model_name]['created']) ? $list_data[$i][$model_name]['created']->sec : ''; ?>
                                    <?= date('d-m-Y H:i:s', $dates); ?>
                                </td>
                            </tr>
                            <?php $stt++; ?>
                        <?php endfor; ?>
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
</script>