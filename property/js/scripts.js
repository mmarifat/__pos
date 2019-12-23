String.prototype.replaceAll = function (search, replacement) {
    var target = this;
    return target.split(search).join(replacement);
};

(function (e, u) {
    $(".dateTimePicker").datetimepicker({
        format: 'DD MMM, YYYY hh:mm a'
    });
    $(".selectedTimeDate").datetimepicker({
        format: 'DD MMM, YYYY hh:mm a'
    });

    if ($("form").attr("novalidate") != undefined || null) {
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation({
            preventSubmit: true
        });
    }
    $('[data-toggle="tooltip"]').tooltip();
    var popOverSettings = {
        container: 'body',
        html: true,
        selector: '[data-toggle="popover"]'
    };
    $('body').popover(popOverSettings);


    $("select").each(function (elmN) {
        if ($(elmN).attr("value") !== undefined) {
            document.getElementById($(elmN).attr("id")).value = $(elmN).attr("value").toString();
        }
    });

    $(".slelectTwo").select2();

})(window);
$('.loader').hide();
$('body').on("click", "[modal-toggler='true']", function (e) {
    $('.loader').show();
    var $_modalID = $(this).data("target");
    $($_modalID).load($(this).data('remote') ? $(this).data('remote') : $(this).attr('href'), function (e) {
        setTimeout(function (e) {
            $($_modalID).modal("show");
            $('.loader').hide();
        }, 1500);
    });
});
window.onclick = function (e) {
    if ($(e.target).hasClass("pop-close")) {
        $(e.target).closest("div.popover").popover("hide");
    }
};
