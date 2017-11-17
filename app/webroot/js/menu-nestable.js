// Init
var MenuNestable = function () {
    /*Functions*/
    function set_data_items(target)
    {
        target.each(function(index, el) {
            var current = $(this);
            current.data('id', current.attr('data-id'));
            current.data('name', current.attr('data-name'));
            current.data('relatedid', current.attr('data-relatedid'));
            current.data('type', current.attr('data-type'));
            current.data('customurl', current.attr('data-customurl'));
        });
    }

    var updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (typeof output != 'undefined') {
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        }
    };
    /*Functions*/

    return {
        //main function to initiate the module
        init: function ()
        {
            var depth = parseInt($('#nestable').attr('data-depth'));
            if(depth < 1) depth = 5;
            // activate Nestable for list 1
            $('#nestable').nestable({
                    group: 1,
                    maxDepth: depth,
                })
                .on('change', updateOutput);

            // output initial serialised data
            updateOutput($('#nestable').data('output', $('#nestable-output')));
        },
        showNodeDetail: function (el) {
            //Show node details
            var parent = el.parent().parent();
            el.toggleClass('active');
            parent.toggleClass('active');
        },

        handleAdd: function () {
            $('.box-links-for-menu .btn-add-to-menu').on('click', function(event) {
                event.preventDefault();
                var current = $(this);
                var parent = current.parents('.panel-collapse');
                var map = {};
                parent.find(".the-box input").each(function() {
                    if ($(this).attr('type') == 'checkbox') {
                        if ($(this).parent().hasClass('checked')) {
                            map[$(this).attr("name")] = $(this).val();
                        }
                    } else {
                        map[$(this).attr("name")] = $(this).val();
                    }
                });

                $.ajax({
                    url: ADD_NODE_TO_MENU,
                    dataType: 'HTML',
                    type: 'POST',
                    data: map,
                    beforeSend: function () {
                        $('.spinner').toggleClass('is-active');
                    },
                    success: function (response) {
                        $('.nestable-menu > ol.dd-list').append(response);
                        MenuNestable.init();
                        MenuNestable.handleNestableMenu();
                        $('.spinner').toggleClass('is-active');
                    }
                });

                // Change json
                set_data_items($('#nestable > ol.dd-list li.dd-item'));
                parent.find('.list-item > li.active').removeClass('active');
            });
        },
        
        handleNestableMenu: function()
        {
            // Edit attr
            $('.nestable-menu .item-details input[type="text"]').on('change blur keyup', function(event) {
                event.preventDefault();
                var current = $(this);
                var parent = current.closest('li.dd-item');
                parent.attr('data-' + current.attr('name'), current.val());
                parent.data(current.attr('name'), current.val());
                parent.find('> .text[data-update="' + current.attr('name') + '"]').text(current.val());
                if(current.val().trim() == '')
                {
                    parent.find('> .text[data-update="' + current.attr('name') + '"]').text(current.attr('data-old'));
                }
                set_data_items($('#nestable > ol.dd-list li.dd-item'));
                MenuNestable.init();
            });

            // Remove nodes
            $('.form-save-menu input[name="deleted_nodes"]').val('');
            $('.nestable-menu .item-details .btn-remove').on('click', function(event) {
                event.preventDefault();
                var current = $(this);
                var dd_item = current.parents('.item-details').parent();

                $elm = $('.form-save-menu input[name="data[Menu][deleted_nodes]"]');
                //add id of deleted nodes to delete in controller
                $elm.val($elm.val() + ' ' + dd_item.attr('data-id'));
                var children = dd_item.find('> .dd-list').html();
                if(children != '' && children != null)
                {
                    dd_item.before(children);
                }
                dd_item.remove();
                set_data_items($('#nestable > ol.dd-list li.dd-item'));
                MenuNestable.init();
            });

            // Cancel edit
            $('.nestable-menu .item-details .btn-cancel').on('click', function(event) {
                event.preventDefault();
                var current_pa = $(this);
                var parent = current_pa.parents('.item-details').parent();
                parent.find('input[type="text"]').each(function(index, el) {
                    var current = $(this);
                    current.val(current.attr('data-old'));
                });
                parent.find('input[type="text"]').trigger('change');
                parent.removeClass('active');
                MenuNestable.init();
            });
        }
    };
}();