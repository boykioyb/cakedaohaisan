<?php
echo $this->element('JqueryFileUpload/basic_plus_ui_assets');
$user = CakeSession::read('Auth.User');
$permissions = $user['permissions'];
?>
<script>
    $(function () {
        $('input[type=checkbox]').hide();

        $( ".process-csv-form" ).submit(function() {
            var file = $( "input[name='data[files][files]']" ).val();

            if( file === undefined ){
                alert("Hãy nhập file dữ liệu.");
                return false;
            }
        });
    })
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <?php
                echo $this->Form->create('Members', array(
                    'class' => 'form-horizontal process-csv-form',
                ));
                ?>

                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo __('File mẫu') ?></label>

                    <div class="col-sm-9">
                        <a href="<?php echo Router::url('/', true).Configure::read('sysconfig.Members.default_file') ?>" style="padding-top:7px;float:left">Download</a>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo __('File xử lý') ?></label>

                    <div class="col-sm-9">
                        <?php
                        echo $this->element('JqueryFileUpload/basic_plus_ui', array(
                            'name'           => 'files.files',
                            'options'        => array(
                                'id' => 'csv',
                            ),
                            'upload_options' => array(
                                'maxNumberOfFiles' => 1,
                                'acceptFileTypes' => 'xls|xlsx',
                            ),
                        ));
                        ?>
                    </div>
                </div>
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