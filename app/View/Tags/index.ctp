
<?php
echo $this->element('js/chosen');
//echo $this->element('page-heading-with-add-action');
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
        <div class="col-md-4">
            <div class="form-group">
                <?php
                echo $this->Form->input('name', array(
                    'div' => false,
                    'class' => 'form-control',
                    'label' => __('Tên tag'),
                    'default' => $this->request->query('name'),
                ));
                ?>
                <?php
                echo $this->Form->hidden('object_type_code', array(
                    'value' => $this->request->query('object_type_code'),
                ));
//                ?>
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
                        <th style="width:40%"><?php echo __('Tên tag') ?></th>
                        <th><?php echo __('category_modified'); ?></th>
                        <th style="width:4%"><?php echo __('operation') ?></th>
                    <?php else: ?>
                        <th><?php echo __('no') ?></th>
                        <th><?php echo __('Tên tag') ?></th>
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
                            <td><?php if (isset($item[$model_name]['name'])) echo $item[$model_name]['name'] ?></td>
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