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
                    <!--NAME COMPANY-->
                    <?php
                    $title_err = $this->Form->error($model_name . '.' . $lang_code . '.title');
                    $title_err_class = !empty($title_err) ? 'has-error' : '';
                    ?>
                    <div class="form-group <?php echo $title_err_class ?>">
                        <label class="col-sm-2 control-label"><?php echo __('title') ?> <?php echo $this->element('required') ?></label>

                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->input($model_name . '.' . $lang_code . '.title', array(
                                'class' => 'form-control',
                                'div' => false,
                                'label' => false,
                                'required' => true,
                                'default' => isset($request_data['title']) ? $request_data['title'] : '',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <?php
                    $title_err = $this->Form->error($model_name . '.' . $lang_code . '.address');
                    $title_err_class = !empty($title_err) ? 'has-error' : '';
                    ?>
                    <div class="form-group <?php echo $title_err_class ?>">
                        <label class="col-sm-2 control-label"><?php echo __('Địa chỉ') ?> <?php echo $this->element('required') ?></label>

                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->input($model_name . '.' . $lang_code . '.address', array(
                                'class' => 'form-control',
                                'div' => false,
                                'label' => false,
                                'required' => true,
                                'default' => isset($request_data['address']) ? $request_data['address'] : '',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <?php
                    $description_err = $this->Form->error($model_name . '.' . $lang_code . '.description');
                    $description_err_class = !empty($description_err) ? 'has-error' : '';
                    ?>
                    <div class="form-group <?php echo $description_err_class ?>">
                        <label class="col-sm-2 control-label"><?php echo __('description') ?> <?php echo $this->element('required') ?></label>

                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->input($model_name . '.' . $lang_code . '.description', array(
                                'class' => 'form-control',
                                'div' => false,
                                'label' => false,
                                'required' => true,
                                'type' => 'textarea',
                                'default' => isset($request_data['description']) ? $request_data['description'] : '',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <!-- tag_hot-->

                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('hot_tags') ?></label>
                        <div class="col-sm-10">
                            <select name="<?php echo 'data[' . $model_name . '][' . $lang_code . '][hot_tags][]'; ?>" class="chosens-tag" data-tags="true" tabindex="-1" aria-hidden="true" multiple="true">
                                <?php
                                if (isset($request_data['hot_tags'])) {
                                    foreach ($request_data['hot_tags'] AS $icon) {
                                        ?>
                                        <option value="<?php echo $icon; ?>" selected><?php echo $icon; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <!--copyright-->
                    <?php
                    $copyright_err = $this->Form->error($model_name . '.' . $lang_code . '.copyright');
                    $copyright_err_class = !empty($copyright_err) ? 'has-error' : '';
                    ?>
                    <div class="form-group <?php echo $copyright_err_class ?>">
                        <label class="col-sm-2 control-label"><?php echo __('Copyright') ?> <?php echo $this->element('required') ?></label>

                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->input($model_name . '.' . $lang_code . '.copyright', array(
                                'class' => 'form-control editor',
                                'div' => false,
                                'label' => false,
                                'type' => 'textarea',
                                'required' => true,
                                'default' => isset($request_data['copyright']) ? $request_data['copyright'] : '',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('meta_title') ?></label>

                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->input($model_name . '.' . $lang_code . '.meta_title', array(
                                'class' => 'form-control',
                                'div' => false,
                                'label' => false,
                                'default' => isset($request_data['meta_title']) ? $request_data['meta_title'] : '',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('meta_description') ?></label>

                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->input($model_name . '.' . $lang_code . '.meta_description', array(
                                'class' => 'form-control',
                                'div' => false,
                                'label' => false,
                                'default' => isset($request_data['meta_description']) ? $request_data['meta_description'] : '',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('meta_keyword') ?></label>

                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->input($model_name . '.' . $lang_code . '.meta_keyword', array(
                                'class' => 'form-control',
                                'div' => false,
                                'label' => false,
                                'default' => isset($request_data['meta_keyword']) ? $request_data['meta_keyword'] : '',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <!-- End Form -->
                </div>
            </div>
        </div>
    </div>
</div>