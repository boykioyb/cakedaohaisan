<?php
echo $this->element('js/chosen');
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
            'controller' => 'Pages',
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
                    'options' => $langCodes, //Configure::read('S.Lang'),
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
//                    'disabled' => !empty($this->request->query('lang_code')) ? false : true,
                    'label' => 'Tên trang',
                    'default' => $this->request->query('name'),
                ));
                ?>
            </div>
        </div>

        <!--        <div class="col-md-4">-->
        <!--            <div class="form-group">-->
        <!--                --><?php
        //                echo $this->Form->input('categories', array(
        //                    'div' => false,
        //                    'class' => 'form-control',
        //                    'label' => __('category'),
        //                    'options' => $categories,
        //                    'empty' => '-------',
        //                    'default' => $this->request->query('categories'),
        //                ));
        //                ?>
        <!--            </div>-->
        <!--        </div>-->

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
                        <th style="width:5%"><?php echo __('no') ?></th>
                        <th style="width:20%"><?php echo 'Tên Page' ?></th>
                        <th style="width:20%"><?php echo 'Thứ tự' ?></th>
                        <th style="width:15%"><?php echo 'Trạng thái' ?></th>
                        <th style="width:20%"><?php echo __('operation') ?></th>
                    <?php else: ?>
                        <th><?php echo __('no') ?></th>
                        <th><?php echo 'Tên Page' ?></th>
                        <th><?php echo 'Chủ nhiệm đề tài' ?></th>
                        <th><?php echo 'Thứ tự' ?></th>
                        <th><?php echo __('operation') ?></th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($list_data)): ?>
                    <?php //debug($item[$model_name]['categories']);die; ?>
                    <?php
                    $stt = $this->Paginator->counter('{:start}');
                    ?>
                    <?php foreach ($list_data as $item): ?>
                        <tr class="form-edit">
                            <td>
                                <?php
//                                debug($model_name);die;
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
                                <?php echo isset($item[$model_name]['weight']) ? $item[$model_name]['weight'] : '' ?>
                            </td>

                            <td>
                                <?php
                                echo $this->Form->input($model_name . '.status', array(
                                    'div' => false,
                                    'class' => 'form-control',
                                    'label' => false,
                                    'options' => $status,
                                    'default' => $item[$model_name]['status'],
                                ));

                                ?>
                            </td>
                            <!--                                <td>-->
                            <!--                                    --><?php //echo isset($status[$item[$model_name]['status']]) ? $status[$item[$model_name]['status']] : '' ?>
                            <!---->
                            <!--                                </td>-->

                            <td>
                                <?php
                                $permissions = $user['permissions'];
                                ?>
                                <?php
                                echo $this->element('Button/submit_form_edit', array(
                                    'id'             => $id,
                                    'permissions'    => $permissions,
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

