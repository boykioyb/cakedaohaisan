<?php
echo $this->element('js/chosen');
echo $this->Html->css('stylerange.css');
echo $this->Html->script('search');

$user = CakeSession::read('Auth.User');
$permissions = $user['permissions'];
?>
<style>
    .popover {max-width:400px;}
    input:hover{
        color: black;
    }
    .chosen-container-single .chosen-drop{
        background: #fff;
    }
</style>
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
                echo $this->Form->input($model_name . '.discussion', array(
                    'class' => 'form-control chosen-select',
                    'options' => $discussion_id,
                    'empty' => '-------',
                    'div' => false,
                    'label' => __('post_discussion'),
                    'id' => 'discussion',
                    'default' => $this->request->query('discussion'),
                ));
                ?>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <?php
                echo $this->Form->input($model_name . '.owner', array(
                    'class' => 'form-control chosen-select',
                    'options' => $owner_id,
                    'empty' => '-------',
                    'div' => false,
                    'label' => __('owner'),
                    'id' => 'owner',
                    'default' => $this->request->query('owner'),
                ));
                ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <?php
                echo $this->Form->input('post_name', array(
                    'div' => false,
                    'class' => 'form-control',
                    'label' => __('post_name'),
                    'type' => 'text',
                    'default' => $this->request->query('post_name'),
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
                            <th style="width: 15%"><?= __('ID') ?></th>
                            <th style="width: 10%"><?php echo $this->Paginator->sort('name', __('post_discussion')); ?></th>
                            <th style="width: 15%"  class="text-center"><?php echo __('post_name'); ?></th>
                            <th style="width: 10%"><?php echo(__('owner')); ?></th>
                            <th style="width: 8%"><?php echo __('status') ?></th>
                            <th style="width: 10%"><?php echo __('created_date') ?></th>
                        <?php else: ?>
                            <th style="width: 3%"><?= __('STT') ?></th>
                            <th style="width: 15%"><?= __('ID') ?></th>
                            <th style="width: 15%"><?php echo $this->Paginator->sort('name', __('post_discussion')); ?></th>
                            <th style="width: 15%"  class="text-center"><?php echo __('post_name'); ?></th>
                            <th style="width: 10%"><?php echo(__('owner')); ?></th>
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
                                    echo $this->Html->link(isset($id) ? $id : '', array('controller' => 'VaaPostLikes', 'action' => 'infoPost', $id));
                                    ?>
                                </td>

                                <td>
                                    <?= isset($discussion[$i]['name']) ? $discussion[$i]['name'] : '' ?>
                                </td>
                                <td>
                                    <?php echo $this->Html->link(isset($post[$i]['content']) ? $post[$i]['content'] : '', array('controller' => 'VaaPosts', 'action' => 'infoPost', isset($post[$i]['id']) ? $post[$i]['id'] : '')); ?>
                                </td>
                                <td>
                                    <a href="#"  data-placement="bottom" rel="popover" data-popover-content="#<?= !empty($owner[$i]['id']) ? $owner[$i]['id'] : '' ?>"><?= !empty($owner[$i]['name']) ? $owner[$i]['name'] : '' ?></a>
                                    <div id="<?= !empty($owner[$i]['id']) ? $owner[$i]['id'] : '' ?>" class="hide">
                                        <div class="form-group " style="width:209px">
                                            <?php
                                            echo $this->Form->input($model_name . '.id', array(
                                                'type' => 'text',
                                                'class' => 'form-control vaa-id',
                                                'div' => false,
                                                'title' => 'ID người tạo',
                                                'readonly' => 'readonly',
                                                'label' => false,
                                                'value' => isset($owner[$i]['id']) ? $owner[$i]['id'] : ''
                                            ));
                                            ?>

                                        </div>
                                        <div class="form-group" style="width:209px">

                                            <?php
                                            echo $this->Form->input($model_name . '.name', array(
                                                'type' => 'text',
                                                'class' => 'form-control vaa-id',
                                                'div' => false,
                                                'title' => __('name'),
                                                'readonly' => 'readonly',
                                                'label' => false,
                                                'value' => isset($owner[$i]['name']) ? $owner[$i]['name'] : ''
                                            ));
                                            ?>
                                        </div>
                                        <div class="form-group" style="width:209px">

                                            <?php
                                            echo $this->Form->input($model_name . '.username', array(
                                                'type' => 'text',
                                                'class' => 'form-control vaa-id',
                                                'div' => false,
                                                'title' => __('username'),
                                                'readonly' => 'readonly',
                                                'label' => false,
                                                'value' => isset($owner[$i]['username']) ? $owner[$i]['username'] : ''
                                            ));
                                            ?>
                                        </div>
                                        <a class="btn btn-primary float-sm-right" style="float: right;margin-bottom: 10px;" href="<?php echo Router::url(array('controller' => 'VaaMembers', 'action' => 'infoMembers', $owner[$i]['id'])); ?>">
                                            <i  class="fa fa-eye" ></i>
                                            Xem thông tin
                                        </a>
                                    </div>
                                </td>
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
        $('[data-toggle="tooltip"]').tooltip();
        $('[rel="popover"]').popover({
            container: 'body',
            html: true,
            content: function () {
                var clone = $($(this).data('popover-content')).clone(true).removeClass('hide');
                return clone;
            }
        }).click(function (e) {
            e.preventDefault();
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
                                url: '<?= Router::url(['controller' => 'VaaPostLikes', 'action' => 'ajaxChangeStatus']) ?>',
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