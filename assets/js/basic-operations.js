const contID = $('#VisualContent').data('name');

$(document).ready(function(){
    var w = window.outerWidth;
    var h = window.outerHeight;
    //console.log(w, h);
    $('#BtnMenuBurguer').click(function() {
        $('#BtnMenu'+contID).toggleClass('active');
        $('.container-table').toggleClass('table-width');
        $('.container-table-bootstrap').toggleClass('table-width');
    })
})


//------------------------------- OPERACIONES -----------------------------------

    function filterTable(value,body,clase) {
        var filter, panel, d, td, i, j, k, visible;
        var tr = "";
        filter = value;
        panel = document.getElementById(body);
        d = panel.getElementsByTagName("tr");
        let Fila = document.getElementsByClassName(clase);
        //
        for (i = 0; i < d.length; i++) {
            visible = false;
            td = d[i].getElementsByTagName("td");
            for (j = 0; j < td.length; j++) {
                if (td[j] && td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                    visible = true;
                }
            }
            if (visible === true) {
                d[i].style.display = "";
                $(d[i]).addClass(clase);
            }
            else {
                d[i].style.display = "none";
                $(d[i]).removeClass(clase);
            }
        }
        result = Fila.length;
    }

    function searchFilterTable(filter,val) {
        $('#'+filter).val(val);
        $('#'+filter).keyup();
    }

    function eraserFilterTable(filter) {
        $('#'+filter).val("");
        $('#'+filter).keyup();
    }

    function filterSelectedTable(obj,body,clase) {
        const val = $(obj).val().toUpperCase();
        filterTable(val,body,clase);
    }

    function update_counter(obj,counter){
        $(counter).html(obj.value.length);
    }

    function copy_clipboard(container) {
        const text = document.getElementById(container).value;
        navigator.clipboard.writeText(text).then(() => {
            //console.log('Texto copiado al portapapeles: ' + text)
            toastr.info("Texto Copiado");
        }).catch(err => {
            console.error('Error al copiar al portapapeles:', err)
        })
    }

    function showContent(obj,title){
        let clase = document.getElementsByClassName('divContenido'+contID);
        let select = document.getElementsByClassName('boton');
        const div = $(obj).data('div');
        const clss = 'divContenido'+contID;
        $('#TitleSectionMenu').html(title);
        //console.log(div, clss);
        for (let i=0;i<clase.length;i++) {
            const id = $(clase[i]).attr('id');
            //console.log(id);
            if (id == div) {
                $(clase[i]).removeClass('ocultarObjeto');
            }
            else {
                $(clase[i]).addClass('ocultarObjeto');
            }
        }

        for(var i=0;i<select.length;i++){
            select[i].classList.remove('active-seg');
            if(select[i].getAttribute('data-div') == div) {
                select[i].classList.add('active-seg');
            }
        }
    }

    function iconFunction(event,type) {
        const icon = $(event).children('i');
        if (type == 1) {
            icon.attr('class', icon.hasClass('fa fa-eye') ? 'fa fa-eye-slash' : icon.attr('data-class'));
            icon.attr('title', icon.hasClass('fa fa-eye') ? 'Ver' : 'Ocultar');
        }
        else if (type == 2) {
            icon.attr('class', icon.hasClass('fa fa-info-circle') ? 'fas fa-info' : icon.attr('data-class'));
            icon.attr('title', icon.hasClass('fa fa-info-circle') ? 'Ver Info' : 'Ocultar Info');
        }
        else if (type == 3) {
            icon.attr('class', icon.hasClass('fas fa-plus') ? 'fas fa-minus' : icon.attr('data-class'));
            icon.attr('title', icon.hasClass('fas fa-plus') ? 'Ver' : 'Ocultar');
        }
        else if (type == 4) {
            icon.attr('class', icon.hasClass('fas fa-arrow-circle-left') ? 'fas fa-arrow-circle-right' : icon.attr('data-class'));
            icon.attr('title', icon.hasClass('fas fa-arrow-circle-left') ? 'Mostrar Menú' : 'Ocultar Menú');
        }
    }

    function orderArray(array) {
        let compare;
        compare = function(a,b) {
            return (b.comision - a.comision);
        };
        array.sort(compare);
        return array;
    }

    function getPhoneValue(data) {
        if (data.length < 10 || data == "000000000") {
            data = "";
        }
        return data;
    }

    function getNumberInteger(data) {
        data = (Number.isInteger(data) != true) ? data.toFixed(2) : data;
        return data
    }

    function getNumberValue(data) {
        if (data == "[object Object]" || data == undefined || data == null || data == "" || data == 0) {
            data = 0;
        }
        return data;
    }

    function getTextValue(data) {
        if (data == "[object Object]" || data == undefined || data == null || data == "") {
            data = "";
        }
        return data;
    }

    function getDateFormat(data,format) {
        let nameM = new Array ("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
        let numbermonth = new Array ("01","02","03","04","05","06","07","08","09","10","11","12");
        let nameD = new Array("Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb");
        let numberday = new Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
        let monthname = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        let dayname = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");

        var dateF = "";

        if (data == undefined || data == null || data == "") {
            dateF = "";
        }
        else {
            if (!data.includes(':')) { data = data + " 00:00:00";}
            date = new Date(data);
            switch (format) {
                case 1:
                    dateF = numberday[date.getDate()] + "/" + nameM[date.getMonth()] + "/" + date.getFullYear();
                break;
                case 2:
                    dateF = numberday[date.getDate()] + "/" + numbermonth[date.getMonth()] + "/" + date.getFullYear();
                break;
                case 3:
                    //fecha.replace(/[-]/g, "/"); //Reemplaza todas "-" por "/"
                    dateF = date.getFullYear() + "/" + numbermonth[date.getMonth()] + "/" + date.getDate();
                break;
                case 4:
                    dateF = date.getFullYear() + "-" + numbermonth[date.getMonth()] + "-" + numberday[date.getDate()];
                break;
                case 5:
                    dateF = dayname[date.getDay()] + " " + numberday[date.getDate()] + " de " + monthname[date.getMonth()] + " del " + date.getFullYear();
                break;
                case 6:
                    dateF = dayname[date.getDay()];
                break;
                case 7:
                    dateF = monthname[date.getMonth()];
                break;
                case 8:
                    dateF = date.getFullYear();
                break;
                case 9:
                    if (!data.includes('00:00:00')) { dateF = date.toLocaleTimeString('en-US'); }
                break;
                case 10:
                    dateF = dayname[date.getDate()] + " " + numberday[date.getDate()] + " de " + monthname[date.getMonth()] + " del " + date.getFullYear();
                break;
            }
        }
        return dateF;
    }