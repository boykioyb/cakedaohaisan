<?php
echo $this->element('js/chosen');
echo $this->element('js/datetimepicker');
echo $this->element('page-heading-with-add-action');
echo $this->Html->script('search');
$user = CakeSession::read('Auth.User');
$permissions = $user['permissions'];
?>
<div class="ibox-content m-b-sm border-bottom">
    <?php
    echo $this->Form->create('Search', array(
        'url' => array(
            'action' => $this->action,
            'controller' => 'Notebooks',
        ),
        'type' => 'get',
    ))
    ?>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <?php
                echo $this->Form->input('lang_code', array(
                    'div' => false,
                    'class' => 'form-control search_lang_code',
                    'label' => __('lang_code'),
                    'options' => $langCodes,
                    'default' => $this->request->query('lang_code'),
                ));
                ?>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <?php
                echo $this->Form->input('name', array(
                    'div' => false,
                    'class' => 'form-control search_name',
                    'label' => __('title_name'),
                    'default' => $this->request->query('name'),
                ));
                ?>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <?php
                echo $this->Form->input('categories', array(
                    'div' => false,
                    'class' => 'form-control chosen-select',
                    'label' => __('category'),
                    'options' => $categories,
                    'empty' => '-------',
                    'default' => $this->request->query('categories'),
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
                    'label' => __('new_status'),
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
                            <th style="width:4%"><?php echo __('no') ?></th>
                            <th style="width:18%"><?php echo $this->Paginator->sort('name', __('new_location')); ?></th>
                            <th style="width:8%"><?php echo $this->Paginator->sort('weight', __('new_order')); ?></th>
                            <th style="width:19%"><?php echo(__('new_status')); ?></th>
                            <th style="width:20%"><?php echo __('category') ?></th>
                            <th style="width:13%">
                                <?php echo $this->Paginator->sort('modified', __('new_modified')); ?>
                                <br/>
                                <?php echo $this->Paginator->sort('user', __('create_user')); ?>
                            </th>
                            <th style="width:10%"><?php echo __('operation') ?></th>
                        <?php else: ?>
                            <th><?php echo __('no') ?></th>
                            <th><?php echo __('new_location') ?></th>
                            <th><?php echo __('new_order') ?></th>
                            <th><?php echo __('new_status') ?></th>
                            <th><?php echo __('category') ?></th>
                            <th>
                                <?php echo __('new_modified'); ?>
                                <br/>
                                <?php echo __('create_user') ?>
                            </th>
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
                                    echo $this->Form->hidden($model_name . '.id', array(
                                        'value' => $id,
                                    ));
                                    echo $stt;
                                    ?>
                                </td>
                                <td>
                                    <strong>
                                        <?php echo isset($item[$model_name][$lang_code]['name']) ? $item[$model_name][$lang_code]['name'] : '' ?>
                                    </strong>
                                    <br/>
                                    <?php
                                    if (isset($item[$model_name]['list_other_name'])) {
                                        echo $this->element('other-name', array(
                                            'listOtherNames' => $item[$model_name]['list_other_name'],
                                        ));
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $this->Form->input($model_name . '.weight', array(
                                        'div' => false,
                                        'class' => 'form-control',
                                        'label' => false,
                                        'default' => isset($item[$model_name]['weight']) ? $item[$model_name]['weight'] : '',
                                    ));
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $this->Form->input($model_name . '.status', array(
                                        'div' => false,
                                        'class' => 'form-control chosen-select',
                                        'label' => false,
                                        'options' => $status,
                                        'default' => $item[$model_name]['status'],
                                    ));
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $this->Form->input($model_name . '.categories', array(
                                        'div' => false,
                                        'class' => 'form-control chosen-select',
                                        'label' => false,
                                        'multiple' => true,
                                        'options' => $categories,
                                        'default' => isset($item[$model_name]['categories']) ? $item[$model_name]['categories'] : '',
                                    ));
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo date('d-m-Y H:i:s',$item[$model_name]['modified']->sec);
                                    ?>
                                    <div class="hr-line-dashed"></div>
                                    <?php
                                    echo __('creator') . ': ' . (!empty($item['User']) ? $item['User']['username'] : __('unknown'));
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $permissions = $user['permissions'];
                                    ?>
                                    <?php
                                    echo $this->element('Button/submit_form_edit', array(
                                        'id' => $id,
                                        'permissions' => $permissions,
                                    ));
                                    ?>
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
                            <td colspan="8" style="text-align: center"><?php echo __('no_result') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php echo $this->element('pagination'); ?>
    </div>
</div>

