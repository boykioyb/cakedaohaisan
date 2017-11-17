<div class="panel panel-warning item_wrap_ajax_add_lang" id="item_wrap_ajax_add_lang_<?php echo $lang_code ?>" data-panel_index="<?php echo $lang_code ?>" data-unique="<?php echo $lang_code ?>">
    <div class="panel-heading">
        <h4 class="panel-title">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 title-language">
                    <a href="#collapse-<?php echo $lang_code ?>"  data-toggle="collapse" style="width: 90%" class="streaming-panel-title">
                        <?php echo $country; ?>
                    </a>
                </div>
                <div class="col-sm-2 btn-language">
                    <button class="btn btn-success" onclick="showModalClone('<?php echo $lang_code; ?>')" type="button"><i class="fa fa-copy"></i></button>
                    <button class="btn btn-danger" onclick="removeLang('<?php echo $lang_code; ?>')" type="button"><i class="fa fa-trash"></i></button>
                </div>
            </div>
        </h4>
    </div>

    <div class="panel-collapse collapse" id="collapse-<?php echo $lang_code ?>">
        <div class="panel-body">
            <div class="row panel-container">
                <div class="form-horizontal">
                    <!-- Start Form -->
                    <?php
                    $name_err = $this->Form->error($model_name . '.' . $lang_code. '.name');
                    $name_err_class = !empty($name_err) ? 'has-error' : '';
                    ?>
                    <div class="form-group <?php $name_err_class?>">
                        <label class="col-sm-2 control-label"><?php echo __('name_members') ?> <?php echo $this->element('required') ?></label>

                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->input($model_name . '.' .$lang_code . '.name',array(
                                'class' => 'form-control',
                                'div' => false,
                                'label' => false,
                                'required' => true,
                                'default' => isset($request_data['name']) ? $request_data['name'] : '',
                            ));
                            ?>
                        </div>
                    </div>
<!--                    <div class="hr-line-dashed"></div>-->
<!--                    <div class="form-group">-->
<!--                        <label class="col-sm-2 control-label">--><?php //echo __('first_letter') ?><!-- --><?php //echo $this->element('required') ?><!--</label>-->
<!---->
<!--                        <div class="col-sm-10">-->
<!--                            --><?php
//                            echo $this->Form->input($model_name . '.' .$lang_code . '.first_letter', array(
//                                'class' => 'form-control',
//                                'div' => false,
//                                'label' => false,
//                                'default' => isset($request_data['first_letter']) ? $request_data['first_letter'] : '',
//                            ));
//                            ?>
<!--                        </div>-->
<!--                    </div>-->
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('address') ?></label>

                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->input($model_name . '.' .$lang_code . '.address', array(
                                'class' => 'form-control',
                                'div' => false,
                                'label' => false,
                                'default' => isset($request_data['address']) ? $request_data['address'] : '',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('contact_name') ?></label>

                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->input($model_name . '.' .$lang_code . '.contact_name', array(
                                'class' => 'form-control',
                                'div' => false,
                                'label' => false,
                                'default' => isset($request_data['contact_name']) ? $request_data['contact_name'] : '',
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