<?php
echo $this->element('js/chosen');
echo $this->element('js/validate');
?>
<script>
    var serviceVina = <?php echo json_encode(Configure::read('sysconfig.Users.service_codes.VINAPHONE')); ?>;
    var serviceMobi = <?php echo json_encode(Configure::read('sysconfig.Users.service_codes.MOBIFONE')); ?>;
    $(function () {

        // khi user type là content provider hoặc distributor, thì thực hiện ẩn hiện content_provider hoặc distributor
        $('.type').on('change', function () {

            $('.cp-container').hide();
            $('.cp').prop('required', false);

            var type = $(this).val();
            if (type === 'CONTENT_EDITOR' || type === 'CONTENT_ADMIN') { // tương ứng với content provider

                $('.cp-container').show();
                $('.cp').prop('required', true);
            }
        });
        $('.type').trigger('change');

        $('form').validate();
        // thực hiện validate cho password và password confirm

        $('#telco').chosen().change(function () {
            var serviceCodes = {};
            var uniqueNames = [];
            var telco = $('#telco').val();
            if (telco != null) {
                if ($.inArray('MOBIFONE', telco) != -1) {
                    $.extend(serviceCodes, serviceMobi);
                }
                if ($.inArray('VINAPHONE', telco) != -1) {
                    $.extend(serviceCodes, serviceVina);
                }
            } else {
                serviceCodes = {};
                uniqueNames = [];
            }

            $.each(serviceCodes, function(i, el){
                if($.inArray(i, uniqueNames) === -1) uniqueNames.push(el);
            });
            $("#servicesList").html('<option value>----</option>');
            $.each(uniqueNames, function (idx, obj) {
                //$.each(data, function (idx, obj) {
                $("#servicesList").append('<option value="' + obj + '">' + obj + '</option>');
            });
            $("#servicesList").trigger("chosen:updated");
        })
    });
</script>
<?php echo $this->start('page-heading') ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-8">
        <h2><?php echo $page_title ?></h2>
    </div>
    <div class="col-sm-4">
        <div class="title-action">
            <a class="btn btn-primary" href="#reset-password" data-toggle="modal" data-target="#reset-password">
                <i class="fa fa-unlock"></i> <span><?php echo __('reset_password_action_title') ?></span>
            </a>
        </div>
    </div>
</div>
<?php echo $this->end() ?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <?php
                echo $this->Form->create($model_name, array(
                    'class' => 'form-horizontal',
                    'id' => 'user-form',
                ));
                ?>
                <?php
                if (!empty($this->request->data[$model_name]['id'])) {

                    echo $this->Form->hidden($model_name . '.id', array(
                        'value' => $this->request->data[$model_name]['id'],
                    ));
                }
                ?>
                <?php
                $user_name_err = $this->Form->error($model_name . '.username');
                $user_name_err_class = !empty($user_name_err) ? 'has-error' : '';
                ?>
                <div class="form-group <?php echo $user_name_err_class ?>">
                    <label
                        class="col-sm-2 control-label"><?php echo __('user_username') ?><?php echo $this->element('required') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.username', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'required' => true,
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label
                        class="col-sm-2 control-label"><?php echo __('user_email') ?><?php echo $this->element('required') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.email', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'required' => true,
                            'type' => 'email',
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label
                        class="col-sm-2 control-label"><?php echo __('user_type') ?><?php echo $this->element('required') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.type', array(
                            'class' => 'form-control type',
                            'div' => false,
                            'label' => false,
                            'options' => $type,
                            'required' => true,
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label
                        class="col-sm-2 control-label"><?php echo __('user_user_group') ?><?php echo $this->element('required') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.user_group', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'options' => $group,
                            'required' => true,
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('user_status') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.status', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'default' => 1,
                            'options' => $status,
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('user_description') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->textarea($model_name . '.description', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <a href="<?php echo Router::url(array('action' => 'index')) ?>" class="btn btn-white"><i
                                class="fa fa-ban"></i> <span><?php echo __('cancel_btn') ?></span> </a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                            <span><?php echo __('save_btn') ?></span></button>
                    </div>
                </div>
                <?php
                echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>
</div>
<div aria-hidden="true" role="dialog" tabindex="-1" id="reset-password" class="modal inmodal fade"
     style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <?php
            echo $this->Form->create($model_name, array(
                'url' => array(
                    'controller' => Inflector::pluralize($model_name),
                    'action' => 'resetPassword',
                ),
                'class' => 'form-horizontal',
                'id' => 'reset-password-form',
            ));
            ?>
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title"><?php echo __('reset_password_action_title') ?></h4>
            </div>
            <div class="modal-body">

                <?php
                if (!empty($this->request->data[$model_name]['id'])) {

                    echo $this->Form->hidden($model_name . '.id', array(
                        'value' => $this->request->data[$model_name]['id'],
                    ));
                }
                ?>
                <div class="form-group">
                    <label
                        class="col-sm-2 control-label"><?php echo __('user_password') ?><?php echo $this->element('required') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.password', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'required' => true,
                            'type' => 'password',
                            'id' => 'password',
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label
                        class="col-sm-2 control-label"><?php echo __('user_password_confirm') ?><?php echo $this->element('required') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.password_confirm', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'required' => true,
                            'type' => 'password',
                            'id' => 'password_confirm',
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-white" type="button"><?php echo __('cancel_btn') ?></button>
                <button class="btn btn-primary"><?php echo __('save_btn') ?></button>
            </div>
            <?php
            echo $this->Form->end();
            ?>
        </div>
    </div>
</div>

