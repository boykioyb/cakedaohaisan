<div class="ibox float-e-margins">
    <div class="ibox-content">
        <div class="table-responsive">
            <table class="table table-striped">

                <thead>
                <tr>
                    <?php if (!empty($list_data)): ?>
                        <th style="width:4%"><?php echo __('no') ?></th>
                        <th style="width:12%">
                            <?php
                            echo $this->Paginator->sort('name', __('Tên'));
                            ?>
                        </th>
                        <th style="width:6%">
                            <?php
                            echo $this->Paginator->sort('phone', __('Số điện thoại'));
                            ?>
                        </th>
                        <th style="width:6%">
                            <?php
                            echo $this->Paginator->sort('email', __('Email'));
                            ?>
                        </th>
                        <th style="width:40%"><?php echo __('Nội dung') ?></th>
                        <th><?php echo __('category_modified'); ?></th>
                        <th style="width:4%"><?php echo __('operation') ?></th>
                    <?php else: ?>
                        <th><?php echo __('no') ?></th>
                        <th><?php echo __('Tên') ?></th>
                        <th><?php echo __('Số điện thoại') ?></th>
                        <th><?php  echo __('Email') ?></th>
                        <th><?php echo __('Nội dung') ?></th>
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
                                echo $this->Form->create($model_name, array('url' => Router::url('delete/' . $id, true)
                                ));
                                echo $this->Form->hidden($model_name . '.id', array(
                                    'value' => $id,
                                ));
                                echo $stt;
                                ?>
                            </td>
                            <td><?php echo $item[$model_name]['name'] ?></td>
                            <td><?php echo $item[$model_name]['phone'] ?></td>
                            <td><?php echo $item[$model_name]['email'] ?></td>
                            <td><?php echo $item[$model_name]['content'] ?></td>
                            <td><?= date('d-m-Y', $item[$model_name]['modified']->sec); ?></td>
                            <td>
                                <a href="<?php echo Router::url(array('action' => 'reqDelete', $id)) ?>"
                                   class="btn btn-danger remove" title="<?php echo __('delete_btn') ?>">
                                    <i class="fa fa-trash"></i>
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