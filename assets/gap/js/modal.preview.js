(function ($) {
    const sModal = `<div id="js-md-result" style="overflow-y: scroll;" class="modal fade" tabindex="-1" role="dialog"><div class="modal-dialog modal-lg" style="width:1200px" role="document"><div class="modal-content"><div class="modal-body"><p>One fine body&hellip;</p></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button></div></div></div></div>`;

    var methods = {
        init: function (options) {
            console.log(options);
            if (document.getElementById("js-md-result") == undefined)
                document.body.insertAdjacentHTML('afterend', sModal);

            this.click(function (e) {
                e.preventDefault();
                const id = $(e.currentTarget).attr('data-item-id')
                $.ajax({
                    url: `${options.url}\\${id}`,
                    method: 'GET',
                    dateType: 'json',
                    success: function (response) {
                        $("#js-md-result .modal-body").html(response.data);
                    },

                }).always(function () {
                    $("#js-md-result").modal('show');
                });



            });
        },
        show: function () {}, // IS
        hide: function () {}, // GOOD
        update: function (content) {} // !!!
    };

    $.fn.modalPreview = function (methodOrOptions) {
        if (methods[methodOrOptions]) {
            return methods[methodOrOptions].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof methodOrOptions === 'object' || !methodOrOptions) {
            // Default to "init"
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + methodOrOptions + ' does not exist on jQuery.tooltip');
        }
    };
})(jQuery);