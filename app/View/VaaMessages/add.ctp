<?php
// sử dụng công cụ soạn thảo
echo $this->element('js/chosen');
// sử dụng upload file
echo $this->element('JqueryFileUpload/basic_plus_ui_assets');
echo $this->element('js/validate');
$user = CakeSession::read('Auth.User');
$permissions = $user['permissions'];
?>
<style>
    /* Always set the map height explicitly to define the size of the div
    * element that contains the map. */
    .chosen-container-single .chosen-drop{
        background: #fff;
    }
    #map {
        height: 100%;
        padding: 125px;
    }
    /* Optional: Makes the sample page fill the window. */
    .wrapper-map {
        height: 100%;
        width: 100%;
        margin: 0;
        padding: 0;
    }
    #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
    }

    #infowindow-content .title {
        font-weight: bold;
    }

    #infowindow-content {
        display: none;
    }

    #map #infowindow-content {
        display: inline;
    }

    .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
    }

    #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
    }

    .pac-controls {
        display: inline-block;
        padding: 5px 11px;
    }

    .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
    }

    #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
    }

    #pac-input:focus {
        border-color: #4d90fe;
    }

    #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
    }
    #target {
        width: 345px;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <?php
                echo $this->Form->create($model_name, array(
                    'class' => 'form-horizontal',
                ));
                ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('post_content') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->textarea($model_name . '.content', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'required' => false
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('like_count') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.like_count', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'type' => 'number'
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('comment_count') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.comment_count', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'type' => 'number'
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('share_count') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.share_count', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'type' => 'number'
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('status') ?></label>

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
                    <label class="col-sm-2 control-label"><?php echo __('post_discussion') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.discussion', array(
                            'class' => 'form-control chosen-select',
                            'options' => $discussion,
                            'empty' => '-------',
                            'div' => false,
                            'label' => false,
                            'id' => 'discussion'
                        ));
                        ?>
                        <i id="icon-loading" style="display: none;color: #1ab394; position: absolute; right: 4%;float: right;top: 1px;" class="fa fa-cog fa-spin fa-2x fa-fw"></i>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('with_members') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.with_members', array(
                            'class' => 'form-control chosen-select',
                            'multiple' => true,
                            'options' => isset($with_member) && !empty($with_member) ? $with_member : array(),
                            'div' => false,
                            'label' => false,
                            'id' => 'with_members',
                            'value' => isset($value_member) && !empty($value_member) ? $value_member : ''
                        ));
                        ?>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">

                    <label class="col-sm-2 control-label"><?php echo __('owner') ?></label>

                    <div class="col-sm-10" style="background: #fff">
                        <?php
                        echo $this->Form->input($model_name . '.owner', array(
                            'class' => 'form-control chosen-select',
                            'options' => $members,
                            'div' => false,
                            'label' => false,
                            'empty' => '-------',
                        ));
                        ?>
                    </div>
                </div>

                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('loc_address') ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->Form->input($model_name . '.loc_address', array(
                            'class' => 'form-control',
                            'div' => false,
                            'label' => false,
                            'type' => 'text',
                            'id' => 'pac-input',
                            'placeholder' => 'Nhập địa điểm'
                        ));
                        ?>
                        <div class='wrapper-map'>
                            <?php
                            $lat = isset($this->request->data[$model_name]['loc']['coordinates'][0]) ? $this->request->data[$model_name]['loc']['coordinates'][0] : '';
                            $lng = isset($this->request->data[$model_name]['loc']['coordinates'][1]) ? $this->request->data[$model_name]['loc']['coordinates'][1] : '';
                            echo $this->Form->input($model_name . '.lat', array(
                                'class' => 'form-control',
                                'div' => false,
                                'label' => false,
                                'type' => 'hidden',
                                'id' => 'lat',
                                'value' => isset($lat) && !empty($lat) ? $lat : ''
                            ));
                            echo $this->Form->input($model_name . '.lng', array(
                                'class' => 'form-control',
                                'div' => false,
                                'label' => false,
                                'type' => 'hidden',
                                'id' => 'lng',
                                'value' => isset($lng) && !empty($lng) ? $lng : ''
                            ));
                            ?>
<!--                            <input id="lat" type="hidden" value="" >
                            <input id="lng" type="hidden" value="" >-->
                            <div id="map"></div>

                        </div>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo 'Đính kèm' ?></label>

                    <div class="col-sm-10">
                        <?php
                        echo $this->element('JqueryFileUpload/basic_plus_ui', array(
                            'name' => $model_name . '.files.attach',
                            'options' => array(
                                'id' => 'attach',
                                'multiple' => true,
                            ),
                            'upload_options' => array(
                                'maxNumberOfFiles' => 10,
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <a href="<?php echo Router::url(array('action' => 'index', '?' => array('object_type_code' => $this->request->query('object_type_code')))) ?>"
                           class="btn btn-white"><i class="fa fa-ban"></i> <span><?php echo __('cancel_btn') ?></span>
                        </a>
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
<script>
    $(function () {
        $('#discussion').change(function () {
            $.ajax({
                url: '<?= Router::url(['controller' => 'VaaPosts', 'action' => 'ajaxGetWithMemberFromDiscussion']) ?>',
                type: 'post',
                dateType: 'json',
                data: {
                    id: $('#discussion').val()
                },
                beforeSend() {
                    $('#icon-loading').show();
                    $('#with_members').html('<option></option>');
                    $("#with_members").trigger("chosen:updated");
                },
                success(result) {
                    $('#icon-loading').hide();
                    var parsed = JSON.parse(result);
                    console.log(parsed);

                    $.map(parsed, function (item) {
                        console.log(item);
                        $('#with_members').append('<option value = "' + item.id + '">' + item.name + '</option>');
                        $("#with_members").trigger("chosen:updated");
                    });
                }
            });
        });
    });
    function initAutocomplete() {
        var geocoder = new google.maps.Geocoder();

        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 21.0296, lng: 105.7914},
            zoom: 13,
            mapTypeId: 'roadmap'
        });
        // Create the search box and link it to the UI element.
        input = document.getElementById('pac-input');
        searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function () {
            searchBox.setBounds(map.getBounds());
        });
        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function () {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            // Clear out the old markers.
            markers.forEach(function (marker) {
                marker.setMap(null);
            });
            markers = [];
            // For each place, get the icon, name and location.
            var bounds = new google.maps.LatLngBounds();
            places.forEach(function (place) {
                if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                var icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                };

                // Create a marker for each place.
                markers.push(new google.maps.Marker({
                    map: map,
                    icon: icon,
                    title: place.name,
                    position: place.geometry.location
                }));

                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });

            map.fitBounds(bounds);

            var address = document.getElementById('pac-input').value;
            geocoder.geocode({'address': address}, function (results, status) {
                if (status === 'OK') {
                    map.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location
                    });
                    marker.setMap(null);
                    document.getElementById('lat').value = results[0].geometry.location.lat();
                    document.getElementById('lng').value = results[0].geometry.location.lng();
                } else {
                    alert("ád");
                }
            });
        });

    }


</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB322mTGN13e6zZ2TysR6JZ4XuToz8Z6P8&libraries=places&callback=initAutocomplete"
async defer></script>
