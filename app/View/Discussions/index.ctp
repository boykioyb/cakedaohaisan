<?php
echo $this->element('js/chosen');
echo $this->element('page-heading-with-add-action');
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
        <div class="col-md-4">
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
        <div class="col-md-4">
            <div class="form-group">
                <?php
                echo $this->Form->input('name', array(
                    'div' => false,
                    'class' => 'form-control',
                    'label' => __('discussions_name'),
                    'default' => $this->request->query('name'),
                ));
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <?php
                echo $this->Form->input('status', array(
                    'div' => false,
                    'class' => 'form-control',
                    'label' => __('status'),
                    'options' => $status,
                    'empty' => '-------',
                    'default' => $this->request->query('status'),
                ));
                ?>
            </div>
        </div>
        <div class="col-md-4">
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
        <div class="col-md-4">
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
                            <th style="width: 5%"><?php echo __('no') ?></th>
                            <th style="width: 20%"><?php echo __('discussions_name'); ?></th>
                            <th style="width: 23%"><?php echo __('discussions_description'); ?></th>
                            <th style="width: 10%"><?php echo __('avatar') ?></th>
                            <th style="width: 12%"><?php echo __('owner'); ?></th>
                            <th style="width: 10%"><?php echo __('status'); ?></th>
                            <th style="width: 10%"><?php echo __('created'); ?></th>
                            <th style="width: 15%"><?php echo __('operation') ?></th>
                        <?php else: ?>
                            <th style="width: 5%"><?php echo __('no') ?></th>
                            <th style="width: 20%"><?php echo __('discussions_name'); ?></th>
                            <th style="width: 23%"><?php echo __('discussions_description'); ?></th>
                            <th style="width: 10%"><?php echo __('avatar') ?></th>
                            <th style="width: 12%"><?php echo __('owner'); ?></th>
                            <th style="width: 10%"><?php echo __('status'); ?></th>
                            <th style="width: 10%"><?php echo __('created'); ?></th>
                            <th style="width: 15%"><?php echo __('operation') ?></th>
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
                                    $id = $list_data[$i][$model_name]['id'];
                                    echo $this->Form->hidden('id', array(
                                        'value' => $id,
                                    ));
                                    echo $stt;
                                    ?>
                                </td>

                                <td>
                                    <strong>
                                        <?php echo isset($list_data[$i][$model_name]['name']) ? $list_data[$i][$model_name]['name'] : '' ?>
                                    </strong><br>
                                    <small>ID: <?= isset($id) ? $id : '' ?> </small>

                                </td>

                                <td ><?= isset($list_data[$i][$model_name]['description']) ? $list_data[$i][$model_name]['description'] : ''; ?></td>
                                <td>
                                    <?php $image_file = isset($list_data[$i][$model_name]['files']['avatar'][0]->{'$id'}) ? $list_data[$i][$model_name]['files']['avatar'][0]->{'$id'} : ''; ?>
                                    <?php $image_url = isset($list_data[$i][$model_name]['file_uris']['avatar'][$image_file]) ? $list_data[$i][$model_name]['file_uris']['avatar'][$image_file] : 'icon-user-default.png'; ?>
                                    <?php
                                    if (file_exists('../' . $image_url)):
                                        echo $this->Html->image('../' . $image_url, ['style' => 'display: block;margin: auto;max-width: 100%;max-height: 16%;', 'id' => 'myImg', 'onclick' => 'myFunction(this.src,this.alt)']);
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
                                <td><div class="onoffswitch">
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
                                    </div></td>
                                <td>
                                    <?php $dates = isset($list_data[$i][$model_name]['created']) ? $list_data[$i][$model_name]['created']->sec : '' ?>
                                    <?= date('d-m-Y H:i:s', $list_data[$i][$model_name]['created']->sec); ?>
                                </td>
                                <td>
                                    <?php
                                    echo $this->element('Button/edit', array(
                                        'id' => $id,
                                        'permissions' => $permissions,
                                    ));
                                    ?>
                                    <?php
                                    echo $this->element('Button/delete', array(
                                        'id' => $id,
                                        'permissions' => $permissions,
                                    ));
                                    ?>
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
                                url: '<?= Router::url(['controller' => 'Discussions', 'action' => 'ajaxChangeStatus']) ?>',
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