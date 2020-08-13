function getData(arr) {
    postData(arr.data, arr.url);
}

function renderGetData(data) {
    data = data.data;
    $('.tabel-info #from').html(data.from);
    $('.tabel-info #to').html(data.to);
    $('.tabel-info #total').html(data.total);
    $('.tabel-info #last_page').html(data.last_page);
    // $('.tabel-info select[name=page]').html(buildPagesOpt(data.current_page, data.last_page));
    $('.tabel-info input[name=page]').attr('max', data.last_page);
    $('.tabel-info input[name=page]').val(data.current_page);
    var renderThis = buildTbody(data.data, componenTable);
    $(rendorTableBodyOn).html(renderThis);
}

function buildTbody(data, config) {
    var result = '';
    if (data.length == 0) {
        result += '<tr><td colspan=' + config.length + ' class="text-center">Not data found!</td></tr>';
    } else {
        $.each(data, function(index, val) {
            result += '<tr id=' + val.id + '>';
            $.each(config, function(idx, valT) {
                $.each(val, function(idsc, valsc) {
                    if (valT.data == idsc) {
                        result += '<td>';
                        if (valT.hight_light == true) { result += '<span class="badge ' + valT.hight_light_class + '">'; }
                        result += valsc;
                        if (valT.hight_light == true) { result += '</span>'; }
                        result += '</td>';
                    }
                });
            });
            result += '</tr>';
        });
    }
    return result;
}

function buildPagesOpt(current_page, last_page) {
    var opt = '';
    for (i = 1; i <= last_page; i++) {
        opt += "<option value='" + i + "' ";
        if (current_page == i) {
            opt += "selected";
        }
        opt += " >" + i + "</option>"
    }
    return opt;
}

function actionButtonExe(data) {
    var id = true;
    if (data.select == true) {
        id = getSelectedRowId({ "target": data.target, "multiple": data.multiple });
        if (id === false) { return false; }
    }
    data["id"] = id;
    if (data.confirm == true) {
        pnotifyConfirm({
            "title": "Warning",
            "type": "info",
            "text": "Are You Sure Do " + data.action + " On Selected Data?",
            "data": data,
            "url": data.url
        });
    } else {
        postData(data, data.url);
    }
}

function getSelectedRowId(data) {
    var idData = "";
    $(data.target).each(function() {
        idData += $(this).attr('id') + '^';
    });
    var idDL = idData.length - 1;
    idData = idData.substr(0, idDL);
    if (idData === null || idData === '' || idData === undefined) {
        pnotify({ "title": "info", "type": "error", "text": "No Data Selected!" });
        return false;
    } else if (data.multiple == false && idData.indexOf('^') > -1) {
        pnotify({ "title": "info", "type": "error", "text": "You only can selected one data!" });
        return false;
    }
    return idData;
}

function show_tab(target) {
    $(target).tab('show');
}

function fill_form(data) {
    $(data.target).find('button').removeAttr('disabled');
    $(data.target).find('.input').val(null).removeAttr('required').removeAttr('readonly');
    $.each(data.required, function(key, target) {
        $('[name=' + target + ']').attr('required', 'true');
    });
    $.each(data.readonly, function(key, target) {
        $('[name=' + target + ']').attr('readonly', 'true');
    });
    $.each(data.data, function(key, val) {
        var inputTarget = data.target + ' [name=' + key + ']';
        if ($(inputTarget).hasClass('file')) {
            $('img.' + key).attr('src', val).show();
        } else if ($(inputTarget).is('textarea')) {
            $(inputTarget).data('text', val);
        } else {
            $(inputTarget).val(val);
        }
    });
}

function close_form(target) {
    $(target).find('button').attr('disabled', 'true');
    $(target).find('.input').val(null).removeAttr('required').removeAttr('readonly');
    $(target).find('.input').attr('readonly', 'true');
    $(target).find('img').attr('src', null).hide();
}

function validatorError(data) {
    $.each(data.data, function(arrK, arrV) {
        pnotify({ "title": "info", "type": "error", "text": arrV });
    });
}

function rebuildTable() {
    var input = {};
    $.each($('.rebuildTable'), function(e) {
        input[$(this).attr('name')] = $(this).val();
        if ($(this).attr('name') == 'page' && parseInt($(this).val()) > parseInt($(this).attr('max'))) {
            pnotify({ "title": "info", "type": "error", "text": 'Sorry page not found!' });
            throw "exit";
        }
    });
    getData({ 'data': input, 'url': urlgetdatauser });
}

$(document).on('click', 'table.selected-table tbody tr', function() {
    $(this).toggleClass('selected');
});

$(document).on('change', '.rebuildTable', function() {
    rebuildTable();
});

$(document).on('click', '#dTableAction a.action-item', function() {
    var data = {
        "action": $(this).data('action'),
        "select": $(this).data('select'),
        "confirm": $(this).data('confirm'),
        "multiple": $(this).data('multiple'),
        "url": $(this).attr('href'),
        "target": rendorTableBodyOn + " tr.selected"
    };
    actionButtonExe(data);
    return false;
});

$(document).on('submit', 'form.postData', function() {
    var input = {};
    input['form_id'] = $(this).attr('id');
    $.each($('.input'), function() {
        input[$(this).attr('name')] = $(this).val();
        if ($(this).attr('type') == 'file' && $(this).hasClass('file')) {
            var thisFile = $(this).prop('files')[0];
            if (thisFile != null) {
                let attrNameInput = $(this).attr('name');
                var reader = new FileReader();
                reader.readAsArrayBuffer(thisFile);
                reader.onloadend = function(oFREvent) {
                    var byteArray = new Uint8Array(oFREvent.target.result);
                    var len = byteArray.byteLength;
                    var binary = '';
                    for (var i = 0; i < len; i++) {
                        binary += String.fromCharCode(byteArray[i]);
                    }
                    byteArray = window.btoa(binary);
                    input[attrNameInput + '_encode'] = byteArray;
                    input[attrNameInput + '_path'] = thisFile.name;
                };
            }
        } else if ($(this).hasClass('select')) {
            input[$(this).attr('name')] = $(this).find('option:selected').val();
        }
    });
    pnotifyConfirm({
        "title": "Warning",
        "type": "info",
        "text": "Are You Sure Do Store This Data?",
        "formData": false,
        "data": input,
        "url": $(this).attr('action')
    });
    return false;
});