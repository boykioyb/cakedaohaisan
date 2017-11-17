<?php
echo $this->element('page-heading-with-add-action');
$user = CakeSession::read('Auth.User');
$permissions = $user['permissions'];
$langConfigs = Configure::read('S.Lang');
?>
<div class="ibox float-e-margins">
    <div class="ibox-content">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <?php if (!empty($list_data)): ?>
                        <th><?php echo __('no') ?></th>
                        <th>
                            <?php
                            echo $this->Paginator->sort('title', __('Tiêu đề'));
                            ?>
                        </th>
                        <th>
                            <?php
                            echo $this->Paginator->sort('phone', __('Số điện thoại'));
                            ?>
                        </th>
                        <th>
                            <?php
                            echo $this->Paginator->sort('email', __('Email'));
                            ?>
                        </th>
<!--                        <th>-->
<!--                            --><?php
//                            echo $this->Paginator->sort('website', __('Website'));
//                            ?>
<!--                        </th>-->
                        <th><?php echo __('operation') ?></th>
                    <?php else: ?>
                        <th><?php echo __('no') ?></th>
                        <th><?php echo __('Tiêu đề') ?></th>
                        <th><?php echo __('Số điện thoại') ?></th>
                        <th><?php echo __('Email') ?></th>
<!--                        <th>--><?php //echo __('Website') ?><!--</th>-->
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($list_data)): ?>
                    <?php
                    $stt = $this->Paginator->counter('{:start}');
                    ?>
                    <?php foreach ($list_data as $item): ?>
                        <tr>
                            <td>
                                <?php
                                $id = $item[$model_name]['id'];
                                echo $this->Form->create($model_name, array('url' => Router::url('edit/' . $id, true)
                                ));
                                echo $this->Form->hidden($model_name . '.id', array(
                                    'value' => $id,
                                ));
                                echo $stt;
                                ?>
                            </td>
                            <td><?php echo $item[$model_name][Configure::read('S.Lang_code_default')]['title'] ?></td>
                            <td><?php echo $item[$model_name]['phone'] ?></td>
                            <td><?php echo $item[$model_name]['email'] ?></td>
<!--                            <td>--><?php //echo $item[$model_name]['website'] ?><!--</td>-->
                            <td>
                                <a href="<?php echo Router::url(array('action' => 'edit', $id)) ?>"
                                   class="btn btn-primary" title="<?php echo __('edit_btn') ?>">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <?php
                                echo $this->Form->end();
                                ?>
                            </td>
                        </tr>
                        <?php $stt++; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align: center"><?php echo __('no_result') ?></td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php echo $this->element('pagination'); ?>
    </div>
</div>