<?php
if (!empty($this->Session->read('lang_code'))) {
    $langCodeDefault = $this->Session->read('lang_code');
} else {
    $langCodeDefault = Configure::read('S.Lang_code_default');
}
echo $this->element('Categories/page-heading-with-add-action');
?>
<div class="ibox float-e-margins">
    <div class="ibox-content">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr> 
                        <th><?php echo __('no') ?></th> 
                        <th><?php echo __('category_name'); ?></th> 
                        <th><?php echo __('Slug'); ?></th>
                        <th><?php echo __('category_weight'); ?></th>
                        <th><?php echo __('category_status'); ?></th>
                        <th><?php echo __('category_modified'); ?></th>
                        <th><?php echo __('operation') ?></th> 
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($list_data)): ?>
                        <?php
                        $stt = 1;
                        ?>
                        <?php foreach ($list_data as $item): ?>
                            <?php
                            $id = $item[$model_name]['id'];
                            ?>
                            <tr>
                                <td><?php echo $stt ?></td>
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
                                    <?php echo isset($item[$model_name][$lang_code]['url_alias']) ? $item[$model_name][$lang_code]['url_alias'] : '' ?>
                                </td>
                                <td><?= $item[$model_name]['weight']; ?></td>
                                <td><?= $status[$item[$model_name]['status']]; ?></td>
                                <td><?= date('d-m-Y ', $item[$model_name]['modified']->sec); ?></td>
                                <td>
                                    <a href="<?php echo Router::url(array('action' => 'edit', $id, '?' => [ 'object_type_code' => $item[$model_name]['object_type_code']])) ?>" class="btn btn-primary" title="<?php echo __('edit_btn') ?>">
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
                            <td colspan="8" style="text-align: center"><?php echo __('no_result') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div> 
    </div>
</div>

