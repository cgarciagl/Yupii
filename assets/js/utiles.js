var ResultData = {};

function get_value(purl, pparameters) {
    var valor = 'N/A_';
    $.ajax({
        url: base_url + 'index.php/' + purl,
        type: 'POST',
        data: pparameters,
        async: false,
        cache: false,
        dataType: 'text',
        timeout: 30000,
        error: function (a, b) {
            valor = b;
        },
        success: function (msg) {
            valor = msg;
        }
    });
    return valor;
}

function get_object(purl, pparameters) {
    var t = get_value(purl, pparameters);
    return (new Function('return ' + t))();
}

function redirect_to(purl) {
    setTimeout(function () {
        window.location.href = base_url + 'index.php/' + purl;
    }, 0);
}

function open_in_new(purl) {
    window.open(base_url + 'index.php/' + purl, "_new");
}

function redirect_by_post(purl, pparameters, in_new_tab) {
    var url = '';
    pparameters = (typeof pparameters == 'undefined') ? {} : pparameters;
    in_new_tab = (typeof in_new_tab == 'undefined') ? true : in_new_tab;
    if (purl.substr(0, 7) == 'http://') {
        url = purl;
    }
    else {
        url = base_url + 'index.php/' + purl;
    }
    var form = document.createElement("form");
    $(form).attr("id", "reg-form").attr("name", "reg-form").attr("action", url).attr("method", "post").attr("enctype", "multipart/form-data");
    if (in_new_tab) {
        $(form).attr("target", "_blank");
    }
    $.each(pparameters, function (key) {
        $(form).append('<input type="text" name="' + key + '" value="' + this + '" />');
    });
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
    return false;
}

function trim(inputString) {
    return $.trim(inputString);
}

function get_hour_number() {
    return (new Date().getTime());
}

var timestamp = get_hour_number();

function move_element(elem, to) {
    elem.appendTo(to);
}

$.fn.serializeObject = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

$.fn.shake = function (options) {
    var settings = {
        'shakes': 2,
        'distance': 10,
        'duration': 400
    };
    if (options) {
        $.extend(settings, options);
    }
    var pos;
    return this.each(function () {
        var $this = $(this);
        pos = $this.css('position');
        if (!pos || pos === 'static') {
            $this.css('position', 'relative');
        }
        for (var x = 1; x <= settings.shakes; x++) {
            $this.animate({left: settings.distance * -1}, (settings.duration / settings.shakes) / 4)
                .animate({left: settings.distance}, (settings.duration / settings.shakes) / 2)
                .animate({left: 0}, (settings.duration / settings.shakes) / 4);
        }
    });
};
