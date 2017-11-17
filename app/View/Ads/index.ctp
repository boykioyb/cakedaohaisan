<?php
echo $this->element('js/chosen');
echo $this->element('page-heading-with-add-action-object-id');
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
                    'label' => 'Tiêu đề',
                    'default' => $this->request->query('name'),
                ));
                ?>
                <?php
                echo $this->Form->hidden('object_type_code', array(
                    'value' => $this->request->query('object_type_code'),
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
                    'label' => 'Code',
                    'default' => $this->request->query('code'),
                ));
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <?php
                echo $this->Form->input('region', array(
                    'div' => false,
                    'class' => 'form-control',
                    'label' => 'Region',
                    'default' => $this->request->query('region'),
                ));
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <?php
                echo $this->Form->input('weight', array(
                    'div' => false,
                    'class' => 'form-control',
                    'label' => __('blog_weight'),
                    'type' => 'number',
                    'default' => $this->request->query('weight'),
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
                    'label' => __('blog_status'),
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
                        <th style="width: 5%"><?php echo __('no') ?></th>
                        <th style="width: 30%"><?php echo $this->Paginator->sort('name','Tiêu đề'); ?></th>
                        <th style="width: 10%"><?php echo 'Code' ?></th>
                        <th style="width: 10%"><?php echo 'Region' ?></th>
                        <th style="width: 10%"><?php echo $this->Paginator->sort('order', __('blog_weight')); ?></th>
                        <th style="width: 15%"><?php echo $this->Paginator->sort('modified', __('blog_modified')); ?></th>
                        <th style="width: 10%"><?php echo(__('blog_status')); ?></th>
                        <th style="width: 10%"><?php echo __('operation') ?></th>
                    <?php else: ?>
                        <th><?php echo __('no') ?></th>
                        <th><?php echo 'Tiêu đề' ?></th>
                        <th><?php echo 'Code' ?></th>
                        <th><?php echo 'Region' ?></th>
                        <th><?php echo __('blog_weight') ?></th>
                        <th><?php echo __('blog_modified') ?></th>
                        <th><?php echo __('blog_status') ?></th>
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
                        <tr class="form-edit">
                            <td>
                                <?php
                                $id = $item[$model_name]['id'];
                                echo $this->Form->hidden('id', array(
                                    'value' => $id,
                                ));
                                echo $stt;
                                ?>
                            </td>
                            <td><?= $item[$model_name]['name']; ?></td>
                            <td><?= $item[$model_name]['code']; ?></td>
                            <td><?= $item[$model_name]['region']; ?></td>
                            <td><?= $item[$model_name]['weight']; ?></td>
                            <td><?= date('d-m-Y H:i:s', $item[$model_name]['modified']->sec); ?></td>
                            <td>
                                <?php
                                    echo $status[$item[$model_name]['status']];
                                ?>
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

