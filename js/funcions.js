function lan_change(lan) {
    setCookie("lang", lan, 3600);
    document.session = 'lang' + "=" + lan;
    document.location.reload();
}


function pre_validation(required, classname) {
    var ret = true;
    for (var i in required) {
        if ($('#' + required[i]).val() == "") {
            $('#' + required[i]).addClass(classname);
            ret = false;
        }
        else {
            $('#' + required[i]).removeClass(classname);
        }
    }

    return ret;
}

function pre_validation2(class_required, classname) {
    var ret = true;

    $('.' + class_required).each(function () {
        if ($(this).val() == "" || $(this).val() == -1) {
            $(this).addClass(classname);
            ret = false;
        }
        else {
            $(this).removeClass(classname);
        }

        if($(this).attr('type')=='email') {
            if(!ValidateEmail($(this).val())) {
                $(this).addClass(classname);
                ret = false;
            }
        }
    });

    return ret;
}

function ValidateEmail(inputText) {
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (inputText.match(mailformat)) {
        return true;
    }
    else {
        return false;
    }
}

function isEmpty(v1, v2) {
    if ($.trim(v1) === "") {
        return v2;
    }
    return v1;
}

function TwoDigits(n) {
    return n > 9 ? "" + n : "0" + n;
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + "; " + expires + "; path=/";
};

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i].trim();
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
};

function addslashes(string) {
    return string.replace(/\\/g, '\\\\').
        replace(/\u0008/g, '\\b').
        replace(/\t/g, '\\t').
        replace(/\n/g, '\\n').
        replace(/\f/g, '\\f').
        replace(/\r/g, '\\r').
        replace(/'/g, '\\\'').
        replace(/"/g, '\\"');
}


if (typeof String.prototype.trim !== 'function') {
    String.prototype.trim = function () {
        return this.replace(/^\s+|\s+$/g, '');
    }
}


function pad(n, width, z) {
    z = z || '0';
    n = n + '';
    return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
}



/***************************************************************************************************************************/
// Funcions específiques
/***************************************************************************************************************************/
function decode_res_days(res_days_str) {

    var data = [];
    var aux1 = res_days_str.split(';');
    if (aux1.length > 0) {
        for (var i = 0; i < aux1.length; i++) {
            if (aux1[i] != "") {
                var aux2 = aux1[i].split('%');
                if (aux2.length == 4) {
                    var auxarray = [];
                    auxarray['act'] = parseInt(aux2[1]);
                    auxarray['tarifa'] = parseInt(aux2[2]);
                    auxarray['places'] = parseInt(aux2[3]);
                    data[aux2[0]] = auxarray;
                }
            }
        }
    }

    return data;
    //    $data = array();
    //    $aux1 = explode(';',$res_days_str);
    //    if(count($aux1)>0)
    //    {
    //        for($k=0;$k<count($aux1);$k++)
    //        {
    //            if($aux1[$k]!="")
    //            {
    //                $aux2 = explode('%',$aux1[$k]);
    //                if(count($aux2)==4)
    //                {                      
    //                    $data[$aux2[0]] = array('act'=>intval($aux2[1]),'tarifa'=>intval($aux2[2]),'places'=>intval($aux2[3]));
    //                }
    //            }
    //        }
    //    }
    //
    //    return $data;
}
/***************************************************************************************************************************/