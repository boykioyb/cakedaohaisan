<script>
    function changeLanguageSelect(thisValue, unique, count) {
        if (thisValue.length > 0) {
            $('#' + unique + ' input#file_strack' + count).attr('name', 'data[Streaming][file_strack][' + thisValue + ']');
            $('#' + unique + ' #select_' + count).attr('name', 'data[Streaming][tracks][]');
        } else {
            $('#' + unique + ' input#file_strack' + count).attr('name', '');
            $('#' + unique + ' #select_' + count).attr('name', '');
        }
    }

    function createSelectLanguage(unique, count) {
        var elementSelectLanguage = '<select id="select_' + count + '" onchange="changeLanguageSelect(this.value, \'' + unique + '\', ' + count + ')" >';
        elementSelectLanguage += '<option value="">- Chọn ngôn ngữ -</option>';
        <?php if(isset($languages) && count($languages) > 0){ ?>
        <?php foreach($languages as $code=>$name){ ?>
        elementSelectLanguage += '<option value="<?php echo $code ?>"> <?php echo $name; ?> </option>';
        <?php } ?>
        <?php } ?>
        elementSelectLanguage += '</select>';
        return elementSelectLanguage;
    }

    $(function () {
        $('form').validate();

        $('#submit_form').click(function () {
            $('#form_add').submit();
        });

        $('.datepicker').datetimepicker({
            'format': 'DD-MM-YYYY',
            'showTodayButton': true
        });

        $('#add_lang').click(function () {
            var lang_code = $('#update_lang').val();
            if (lang_code.length > 0 && (checkLangCode(lang_code) == false)) {
                $.get('<?php echo Router::url(array('action' => 'addLang')) . '?lang_code=';  ?>' + lang_code, function (data) {
                    if (data == 404) {
                        alert('Ngôn ngữ không tồn tại.');
                    } else if (data == 100) {
                        alert('Thiếu tham số.');
                    } else {
                        $('#wrap-add-lang').append(data);
                        Global.tags();
                        Global.generateSlugFromName();
                        Global.initEditor();
                        $('form').validate();
                    }
                });
                $('#clone-language-code').val('');
            } else {
                if (checkLangCode(lang_code)) {
                    alert('Ngôn ngữ đã có!');
                } else {
                    alert('Bạn phải chọn ngôn ngữ!');
                }
            }
        });

    });

    function checkLangCode(lang_code) {
        var is_check = false;
        $('.item_wrap_ajax_add_lang').each(function () {
            if ($(this).attr('id') == ('item_wrap_ajax_add_lang_' + lang_code)) {
                is_check = true;
            }
        });

        return is_check;
    }

    function removeLang(lang_code) {
        $('#item_wrap_ajax_add_lang_' + lang_code).remove();
    }


    var langCodeClone;
    function showModalClone(langCode) {
        langCodeClone = langCode;
        $('#modalCloneLang').modal();
        $('.clone-language-code option').each(function(){
            if($(this).attr('value') == langCodeClone || checkLangCode($(this).attr('value')) == true){
                $(this).attr('disabled', 'true');
            }
        });
    }
    function actionCloneLang(){
        var toLangcodeClone = $('#clone-language-code').val();
        if(toLangcodeClone.length > 0 && (checkLangCode(toLangcodeClone) == false)) {
            var dataClone = {
                lang_code: toLangcodeClone,
            };

            var input = $('input, textarea, select', $('#item_wrap_ajax_add_lang_'+langCodeClone));
            input.each(function (index, value) {
                if (typeof $(value).val() !== 'undefined') {
                    dataClone[$(value).attr('name')] = $(value).val();
                }
            });

            $.post('<?php echo Router::url(array('action' => 'addLang'));  ?>', dataClone, function (data) {
                if (data == 404) {
                    alert('Ngôn ngữ không tồn tại.');
                } else if (data == 100) {
                    alert('Thiếu tham số.');
                } else {
                    $('#wrap-add-lang').append(data);
                    Global.tags();
                    Global.generateSlugFromName();
                    Global.initEditor();
                    $('form').validate();
                }
            });
            $('#modalCloneLang').modal('hide');
        }else{
            if(checkLangCode(toLangcodeClone)){
                alert('Ngôn ngữ đã có!');
            }else{
                alert('Bạn phải chọn ngôn ngữ!');
            }
        }
        $('#clone-language-code').val('');
    }
</script>
<!-- Modal -->
<div class="modal fade" id="modalCloneLang" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Clone Language</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-8">
                        <?php
                        if (isset($this->request->data) && isset($_GET['lang_code'])) {
                            $this->request->data[$model_name]['lang_code'] = $_GET['lang_code'];
                        }
                        echo $this->Form->input($model_name . '.lang_code', array(
                            'class' => 'form-control clone-language-code',
                            'id' => 'clone-language-code',
                            'div' => false,
                            'label' => false,
                            'options' => Configure::read('S.Lang'),
                            'empty' => "-- chọn ngôn ngữ --"
                        ));
                        ?>
                    </div>
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-success" onclick="actionCloneLang()" >Clone Language</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>