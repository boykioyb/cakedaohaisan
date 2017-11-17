<?php
echo $this->Html->script('plugins/slugify/jquery.slugify');
?>
<script>
    $('document').ready(function () {
        var index = <?php echo $number ?>;
        $('.path' + index).slugify('.name' + index);
        $('.bootstrap-tagsinput').addClass('col-sm-12');
    });
    function removeImage(index) {
        $('#item_wrap_ajax_add_lang_' + index).remove();
    }
</script>
<div class="panel panel-info item_wrap_ajax_add_lang" id="item_wrap_ajax_add_lang_<?php echo $number ?>"
     data-panel_index="<?php echo $number ?>" data-unique="<?php echo $number ?>">
    <div class="panel-heading">
        <h4 class="panel-title">
            <div class="row">
                <div class="col-sm-10">
                    <a href="#collapse-<?php echo $number ?>" data-toggle="collapse" style="width: 90%"
                       class="streaming-panel-title">
                    </a>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-danger" onclick="removeImage('<?php echo $number; ?>')" type="button"><i
                            class="fa fa-trash"></i></button>
                </div>
            </div>
        </h4>
    </div>
    <div class="panel-collapse collapse in" id="collapse-<?php echo $number ?>">
        <div class="panel-body">
            <div class="row panel-container">
                <div class="form-horizontal">
                    <?php
                    $name_err = $this->Form->error($model_name . '.paths' . '.' . $number);
                    $name_err_class = !empty($name_err) ? 'has-error' : '';
                        ?>
                    <div class="form-group <?php echo $name_err_class ?>">
                        <label
                            class="col-sm-2 control-label"><?php echo 'Path' ?><?php echo $this->element('required') ?></label>
                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->input($model_name . '.paths' . '.' . $number, array(
                                'class' => 'form-control',
                                'id' => 'path',
                                'div' => false,
                                'label' => false,
                                'required' => true,
                            ));
                            ?>
                        </div>
                    </div>
                    <!-- End Form -->
                </div>
            </div>
        </div>
    </div>
</div>