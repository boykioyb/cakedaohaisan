<div class="panel panel-info item_wrap_ajax_add_lang" id="item_wrap_ajax_add_lang_<?php echo $lang_code ?>" data-panel_index="<?php echo $lang_code ?>" data-unique="<?php echo $lang_code ?>">
    <div class="panel-heading">
        <h4 class="panel-title">
            <div class="row">
                <div class="col-sm-10">
                    <a href="#collapse-<?php echo $lang_code ?>"  data-toggle="collapse" style="width: 90%" class="streaming-panel-title">
                        <?php echo $country; ?>
                    </a>
                </div>
                <div class="col-sm-2">
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
                    <?php
                    $name_err = $this->Form->error($model_name . '.' . $lang_code . '.name');
                    $name_err_class = !empty($name_err) ? 'has-error' : '';
                    ?>
                    <div class="form-group <?php echo $name_err_class ?>">
                        <label class="col-sm-2 control-label"><?php echo __('news_name') ?> <?php echo $this->element('required') ?></label>

                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->input($model_name . '.' . $lang_code . '.name', array(
                                'class' => 'form-control name-slug',
                                'div' => false,
                                'label' => false,
                                'required' => true,
                                'default' => isset($request_data['name']) ? $request_data['name'] : '',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('Slug') ?></label>

                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->input($model_name . '.' . $lang_code . '.url_alias', array(
                                'class' => 'form-control slug',
                                'div' => false,
                                'label' => false,
                                'required' => true,
                                'default' => isset($request_data['url_alias']) ? $request_data['url_alias'] : '',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label
                            class="col-sm-2 control-label"><?php echo __('blog_tags') ?></label>

                        <div class="col-sm-10">
                            <select name="<?php echo 'data[' . $model_name . '][' . $lang_code . '][tags][]'; ?>" class="chosens-tag" data-tags="true" tabindex="-1" aria-hidden="true" multiple="true">
                                <?php
                                if (isset($request_data['tags'])) {
                                    foreach ($request_data['tags'] AS $icon) {
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
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('news_short_description') ?></label>

                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->textarea($model_name . '.' . $lang_code . '.short_description', array(
                                'class' => 'col-xs-12 form-control' . $lang_code,
                                'style' => 'height:100px',
                                'div' => false,
                                'label' => false,
                                'default' => isset($request_data['short_description']) ? $request_data['short_description'] : '',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo __('Content') ?></label>

                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->textarea($model_name . '.' . $lang_code . '.description', array(
                                'class' => 'form-control editor',
                                'style' => 'height:100px',
                                'div' => false,
                                'label' => false,
                                'default' => isset($request_data['description']) ? $request_data['description'] : '',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo 'Tên cho SEO' ?></label>
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
                    </div> <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo 'Mô tả cho SEO' ?></label>
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
                        <label class="col-sm-2 control-label"><?php echo 'Tag cho SEO' ?></label>
                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->input($model_name . '.' . $lang_code . '.meta_tags', array(
                                'class' => 'form-control',
                                'div' => false,
                                'label' => false,
                                'default' => isset($request_data['meta_tags']) ? $request_data['meta_tags'] : '',
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