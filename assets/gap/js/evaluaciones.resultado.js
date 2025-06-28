$(document).ready(function () {
    const path = $("#base_url").attr("data-base-url");
    $('.js-show-message').modalPreview({
        url: `${path}evaluaciones/eve_competencia/`
    });
});