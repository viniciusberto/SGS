$(function () {
    $("#sortable1, #sortable2").sortable({
        connectWith: ".connectedSortable"
    }).disableSelection();
});

// Loads the correct sidebar on window load,
// collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function () {
    $(window).bind("load resize", function () {
        var topOffset = 50;
        var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    // var element = $('ul.nav a').filter(function() {
    //     return this.href == url;
    // }).addClass('active').parent().parent().addClass('in').parent();
    var element = $('ul.nav a').filter(function () {
        return this.href == url;
    }).addClass('active').parent();

    while (true) {
        if (element.is('li')) {
            element = element.parent().addClass('in').parent();
        } else {
            break;
        }
    }
});

$(function () {
    $('#side-menu').metisMenu();
});












function atualizarTempo() {
    $('.tempo').each(function (index, item) {
        var id = parseInt($(item).attr('data-id'));
        var dataLimite = $(item).attr('data-limite');
        var dia = parseInt(dataLimite.substr(0, 2));
        var mes = parseInt(dataLimite.substr(3, 2));
        var ano = parseInt(dataLimite.substr(6, 4));
        var hr = parseInt(dataLimite.substr(11, 2));
        var min = parseInt(dataLimite.substr(14, 2));
        var seg = parseInt(dataLimite.substr(17, 2));
        dataLimite = new Date(ano, mes - 1, dia, hr, min, seg).valueOf();
        var dataAtual = new Date().valueOf();
        var tempoRestante = dataLimite - dataAtual;
        if (tempoRestante > 0) {
            tempoRestante = new Date(tempoRestante);
            hr = tempoRestante.getUTCHours();
            min = tempoRestante.getUTCMinutes();
            seg = tempoRestante.getUTCSeconds();
            var warning;
            var danger;
            var succes;

            if(hr === 0 && min === 0 && seg === 0){
                succes = false;
                warning = false;
                danger = true;
            }else{
                if (hr == 0 && min < 15 && min > 0) {
                    succes = false;
                    warning = true;
                    danger = false;
                } else {
                    succes = true;
                    warning = false;
                    danger = false;
                }
            }

            $('#chamado-' + id).toggleClass('list-group-item-success', succes);
            $('#chamado-' + id).toggleClass('list-group-item-warning', warning);
            $('#chamado-' + id).toggleClass('list-group-item-danger', danger);
            $('#chamado-' + id).find('.botao-trocar').toggleClass('btn-success', succes);
            $('#chamado-' + id).find('.botao-trocar').toggleClass('btn-warning', warning);
            $('#chamado-' + id).find('.botao-trocar').toggleClass('btn-danger', danger);
            $('#modal-' + id).find('.botao-trocar').toggleClass('btn-success', succes);
            $('#modal-' + id).find('.botao-trocar').toggleClass('btn-warning', warning);
            $('#modal-' + id).find('.botao-trocar').toggleClass('btn-danger', danger);
            if (hr < 10) {
                hr = '0' + hr;
            }
            if (min < 10) {
                min = '0' + min;
            }
            if (seg < 10) {
                seg = '0' + seg;
            }
            $(item).find('#texto').html(hr + ':' + min + ':' + seg);
        } else {
            $(item).find('#texto').html('00:00:00');
        }
    });
    setTimeout('atualizarTempo()', 1000);
}
$(function () {
    atualizarTempo();
});