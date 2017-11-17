<?php
echo $this->element('page-heading-with-add-action');
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
        <div class="col-md-4">
            <div class="form-group">
                <?php
                echo $this->Form->input('name', array(
                    'div' => false,
                    'class' => 'form-control',
                    'label' => __('object_type_name'),
                    'default' => $this->request->query('name'),
                ));
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <?php
                echo $this->Form->input('code', array(
                    'div' => false,
                    'class' => 'form-control',
                    'label' => __('object_type_code'),
                    'empty' => '-------',
                    'default' => $this->request->query('code'),
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
                    'label' => __('object_type_status'),
                    'options' => $status,
                    'empty' => '-------',
                    'default' => $this->request->query('status'),
                ));
                ?>
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
                            <th><?php echo __('no') ?></th>
                            <th>
                                <?php
                                echo $this->Paginator->sort('name', __('object_type_name'));
                                ?>
                            </th>
                            <th>
                                <?php
                                echo $this->Paginator->sort('code', __('object_type_code'));
                                ?>
                            </th>
                            <th>
                                <?php
                                echo $this->Paginator->sort('order', __('object_type_order'));
                                ?>
                            </th>
                            <th>
                                <?php
                                echo (__('object_type_status'));
                                ?>
                            </th>
                            <th><?php echo __('operation') ?></th>
                        <?php else: ?>
                            <th><?php echo __('no') ?></th>
                            <th><?php echo __('object_type_name') ?></th>
                            <th><?php echo __('object_type_code') ?></th>
                            <th><?php echo __('object_type_order') ?></th>
                            <th><?php echo __('object_type_status') ?></th>
                            <th><?php echo __('operation') ?></th>
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
                                    echo $stt;
                                    ?>
                                </td>
                                <td><?php echo $item[$model_name]['name'] ?></td>
                                <td><?php echo $item[$model_name]['code'] ?></td>
                                <td>
                                    <?= isset($item[$model_name]['order']) && $item[$model_name]['order'] ? $item[$model_name]['order'] : ''; ?>
                                </td>
                                <td>
                                    <?php
                                    echo $status[$item[$model_name]['status']];
                                    ?>
                                </td>
                                <td>
                                    <a href="<?php echo Router::url(array('action' => 'edit', $id)) ?>" class="btn btn-primary" title="<?php echo __('edit_btn') ?>">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="<?php echo Router::url(array('action' => 'reqDelete', $id)) ?>" class="btn btn-danger remove" title="<?php echo __('delete_btn') ?>">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php $stt++; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center"><?php echo __('no_result') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php echo $this->element('pagination'); ?>
    </div>
</div>

