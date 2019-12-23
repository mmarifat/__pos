// tooltip
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

var format = function (num) {
    var str = num.toString().replace("$", ""), parts = false, output = [], i = 1, formatted = null;
    if (str.indexOf(".") > 0) {
        parts = str.split(".");
        str = parts[0];
    }
    str = str.split("").reverse();
    for (var j = 0, len = str.length; j < len; j++) {
        if (str[j] != ",") {
            output.push(str[j]);
            if (i % 3 == 0 && j < (len - 1)) {
                output.push(",");
            }
            i++;
        }
    }
    formatted = output.reverse().join("");
    return (formatted + ((parts) ? "." + parts[1] : ""));
};

function msg(title, msg, url) {
    if (url !== "") {
        $.alert({
            title: title,
            content: msg,
            icon: 'fa fa-smile-o',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'green',
            onAction: function (btnName) {
                open(url, "_self");
            }
        });
    } else {
        $.alert({
            title: title,
            content: msg,
            icon: 'fa fa-smile-o',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'green'
        });
    }
}

function err(title, msg, url) {
    if (url !== "") {
        $.alert({
            title: title,
            content: msg,
            icon: 'fa fa-frown-o',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'red',
            onAction: function (btnName) {
                open(url, "_self");
            }
        });
    } else {
        $.alert({
            title: title,
            content: msg,
            icon: 'fa fa-frown-o',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'red'
        });
    }
}

var dialog = function () {
    return $.dialog({
        closeIcon: false,
        icon: 'fa fa-spinner fa-spin',
        title: 'Working!',
        content: 'Wait, We are processing your request!',
        theme: 'supervan'
    });
};


/*
Datatable footer summation callback
 */
jQuery.fn.dataTable.Api.register('sum()', function () {
    return this.flatten().reduce(function (a, b) {
        if (typeof a === 'string') {
            a = a.replace(/[^\d.-]/g, '') * 1;
        }
        if (typeof b === 'string') {
            b = b.replace(/[^\d.-]/g, '') * 1;
        }
        return a + b;
    }, 0);
});