<?php
echo $this->element('js/chosen');
$user = CakeSession::read('Auth.User');
$permissions = $user['permissions'];
?>
<?php echo $this->start('script'); ?>
<script>
    var ADD_NODE_TO_MENU = "<?php echo Router::url(array('controller' => 'menuNodes', 'action' => 'addNodeToMenu')) ?>";
    $(window).load(function () {
        MenuNestable.init();
        MenuNestable.handleAdd();
        MenuNestable.handleNestableMenu();
    });
</script>
<?php echo $this->end(); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel blank-panel">
            <div class="panel-heading">
                <div class="panel-options">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab-1">Manager Menus</a></li>
                    </ul>
                </div>
            </div>

            <div class="panel-body">
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="ibox-content m-b-sm border-bottom">
                            <?php
                            echo $this->Form->create('Menu', array(
                                'class' => 'form-inline',
                                'type' => 'get'
                            ))
                            ?>
                            <div class="form-group">
                                <span>Select a menu to edit:</span>
                                <?php
                                echo $this->Form->input('menu_code', array(
                                    'div' => false,
                                    'type' => 'select',
                                    'options' => $menu,
                                    'class' => 'form-control',
                                    'label' => false,
                                    'default' => $menuChoice
                                ));
                                echo $this->Form->input('lang_code', array(
                                    'div' => false,
                                    'type' => 'select',
                                    'options' => $langCodes,
                                    'class' => 'form-control',
                                    'style' => 'margin-left: 10px',
                                    'label' => false,
                                    'default' => $lang_code
                                ));
                                ?>
                            </div>
                            <button class="btn btn-white" type="submit">Select</button>
                            <?php echo $this->Form->end(); ?>
                        </div>

                        <div class="ibox float-e-margins">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="panel-group box-links-for-menu" id="accordion">
                                        <?php if (!empty($pages)): ?>
                                            <div class="panel panel-default panel-no-margin">
                                                <div class="panel-heading">
                                                    <h5 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Pages</a>
                                                    </h5>
                                                </div>
                                                <div id="collapseOne" data-type="Pages" class="panel-collapse collapse in">
                                                    <div class="panel-body">
                                                        <div class="the-box">
                                                            <input type="hidden" value="Pages" name="data[type]">
                                                            <?php foreach ($pages as $index => $page): ?>
                                                                <div class="checkbox i-checks">
                                                                    <label>
                                                                        <input name="data[value][<?php echo $index ?>]" value="<?php echo $page['Page']['id'] ?>" type="checkbox">
                                                                        <i></i> <?php echo $page['Page'][$lang_code]['name']; ?>
                                                                    </label>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                    <div class="panel-footer text-right">
                                                        <a href="#" class="btn btn-sm btn-white btn-add-to-menu">Add menu</a>
                                                        <span class="spinner"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <?php foreach ($categories as $key => $category): ?>
                                            <div class="panel panel-default panel-no-margin">
                                                <div class="panel-heading">
                                                    <h5 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#cate_<?php echo $key ?>"><?php echo ucwords($key) ?> Categories</a>
                                                    </h5>
                                                </div>
                                                <div id="cate_<?php echo $key ?>" data-type="<?php echo ucwords($key) ?>Categories" class="panel-collapse collapse out">
                                                    <div class="panel-body">
                                                        <div class="the-box">
                                                            <input type="hidden" value="<?php echo ucwords($key) ?>Categories" name="data[type]">
                                                            <?php foreach ($category as $index => $item): ?>
                                                                <div class="checkbox i-checks">
                                                                    <label>
                                                                        <input name="data[value][<?php echo $index ?>]" value="<?php echo $item['id'] ?>" type="checkbox">
                                                                        <i></i> <?php echo $item[$lang_code]['name']; ?>
                                                                    </label>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                    <div class="panel-footer text-right">
                                                        <a href="#" class="btn btn-sm btn-white btn-add-to-menu">Add menu</a>
                                                        <span class="spinner"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>

                                        <div class="panel panel-default panel-no-margin">
                                            <div class="panel-heading">
                                                <h5 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#external_link">Custom Links</a>
                                                </h5>
                                            </div>
                                            <div id="external_link" data-type="<?php echo EXTERNAL_LINK ?>" class="panel-collapse collapse out">
                                                <div class="panel-body">
                                                    <div class="the-box">
                                                        <input type="hidden" value="<?php echo EXTERNAL_LINK ?>" name="data[type]">
                                                        <div class="form-group">
                                                            <label for="node-title" class="">Link Text</label>
                                                            <input type="text" class="form-control" id="node-title" name="data[value][name]">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="node-title" class="">Url</label>
                                                            <input type="text" class="form-control" id="node-url" placeholder="http://" name="data[value][url]">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel-footer text-right">
                                                    <a href="#" class="btn btn-sm btn-white btn-add-to-menu">Add menu</a>
                                                    <span class="spinner"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="ibox float-e-margins">
                                        <?php
                                        echo $this->Form->create('Menu', array('class' => 'form-save-menu'));
                                        echo $this->Form->hidden('menu_code', array(
                                            'value' => $menuChoice,
                                        ));
                                        echo $this->Form->hidden('lang_code', array(
                                            'value' => $lang_code,
                                        ));
                                        echo $this->Form->hidden('deleted_nodes');
                                        echo $this->Form->textarea('menu_nodes', array('style' => 'display: none !important;', 'id' => 'nestable-output'));
                                        ?>
                                        <div class="ibox-title">
                                            <h3 class="m-t-none m-b">Menu Structure</h3>
                                        </div>
                                        <div class="ibox-content">
                                            <span>Drag each item into the order you prefer. Click the arrow on the right of the item to reveal additional configuration options.</span>

                                            <div class="dd nestable-menu" id="nestable" data-depth="0">
                                                <ol class="dd-list">
                                                    <?php echo $this->element('MenuNestable/_nestable-item', array('menuList' => $menuList)); ?>
                                                </ol>
                                            </div>

                                            <div class="hr-line-dashed"></div>
                                            <button class="btn btn-primary" type="submit">Save changes</button>
                                        </div>
                                        <?php echo $this->Form->end(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
