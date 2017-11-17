<?php
foreach ($menuList as $menu):
    $nameMenu = '';
    if (!empty($menu[$lang_code]['name'])) {
        $nameMenu = $menu[$lang_code]['name'];
    } else {
        unset($langCodes[$lang_code]);
        foreach ($langCodes as $code => $nameCode) {
            if (!empty($menu[$code]['name'])) {
                $nameMenu = $menu[$code]['name'];
            }
        }
    }
    ?>
    <li class="dd-item"
        data-id="<?php echo $menu['id'] ?>"
        data-type="<?php echo $menu['type'] ?>"
        data-relatedid="<?php echo $menu['related_id'] ?>"
        data-customurl="<?php echo $menu['link'] ?>"
        data-name="<?php echo $nameMenu ?>">
        <div class="dd-handle text" data-update="name">
            <?php echo $nameMenu ?>
        </div>
        <div class="dd-type"><?php echo $menu['type'] ?></div>
        <div class="detail-icon">
            <a class="show-item-details" onclick="MenuNestable.showNodeDetail($(this)); return false;">
                <i class="fa fa-sort-desc"></i>
            </a>
        </div>
        <div class="item-details">
            <?php if ($menu['type'] == EXTERNAL_LINK): ?>
                <div class="form-group">
                    <span data-update="customurl">URL</span>
                    <input type="text" class="form-control" value="<?php echo $menu['link'] ?>" name="customurl" data-old="<?php echo $menu['link'] ?>">
                </div>
            <?php endif; ?>
            <div class="form-group">
                <span data-update="name">Navigation Label</span>
                <input type="text" class="form-control" value="<?php echo $nameMenu ?>" name="name" data-old="<?php echo $nameMenu ?>">
            </div>
            <div class="text-right">
                <?php
                if (!empty($menu['id'])) {
                    echo $this->Html->link('Edit', array('controller' => 'menuNodes', 'action' => 'edit', $menu['id']), array('target' => '_blank', 'class' => 'btn-edit'));
                }
                ?>
                <a class="btn-remove" href="#">Remove</a>
                <a class="btn-cancel" href="#" onclick="MenuNestable.showNodeDetail($(this)); return false;">Cancel</a>
            </div>
        </div>
        <?php
        if (!empty($menu['children'])) {
            echo '<ol class="dd-list">';
            echo $this->element('MenuNestable/_nestable-item', array('menuList' => $menu['children']));
            echo '</ol>';
        }
        ?>
    </li>
<?php endforeach; ?>
