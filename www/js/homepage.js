var page_mode = "reg";

function add_err_cols_to_form(div_w_form, form_cols_names){
    var len = $(div_w_form + " form table tr").length;
    var c;
    for (c = 1; c < len; c++){
        $(div_w_form + " form table tr:nth-of-type(" + c + ")").append("<td class='form_err' id='" + form_cols_names[c - 1] + "_err'></td>");
    }
}

add_err_cols_to_form("div#reg_form", ["name_reg", "email_reg", "role_reg", "pass_reg", "pass_conf_reg"]);
add_err_cols_to_form("div#log_form", ["name_log", "pass_log"]);

function toggle_2_login(){
    page_mode = "login";
    $("h2#h2_reg").css("display", "none");
    $("div#reg_form").css("display", "none");
    $("h2#h2_log").css("display", "initial");
    $("div#log_form").css("display", "initial");
}

function toggle_2_reg(){
    page_mode = "reg";
    $("h2#h2_reg").css("display", "initial");
    $("div#reg_form").css("display", "initial");
    $("h2#h2_log").css("display", "none");
    $("div#log_form").css("display", "none");
}

function form_2_json(form){
    var len = $(form).find("input").length; 
    var fields_arr = ($(form).find("input"));
    var fields_obj = new Object();
    var c;
    for (c = 0; c < len - 2; c++){
        var field = fields_arr[c];
        var name = $(form).find(field).attr("name");
        if ($(form).find(field).attr("type") == "radio" && !$(form).find(field).is(":checked")){ continue;}
        fields_obj[name] = $(form).find(field).val();
    }
    return JSON.stringify(fields_obj);
}


$("div#reg_form").find("input.button").click(reg_form);
$("div#log_form input.button").click(log_form);
$("div#reg_form form").find("input").keypress(function(e){
     var key = e.which;
     if(key == 13){
        $("div#reg_form").find("input.button").click();
        return false;  
      }
});
$("div#log_form form").find("input").keypress(function(e){
     var key = e.which;
     if(key == 13){
        $("div#log_form").find("input.button").click();
        return false;  
      }
});

function reg_form(){
    var payload = form_2_json($("div#reg_form form"));
    $.get("/?do=regForm&data=" + payload, function(resp){
        if (resp.name != "OK"){
            $("#name_reg_err").text(resp.name);
            $("#email_reg_err").text(resp.email);
            $("#role_reg_err").text(resp.role);
            $("#pass_reg_err").text(resp.password);
            $("#pass_conf_reg_err").text(resp.password_again);    
        }
        else { log_form();}
    });
}

function log_form(){
    var payload;
    if (page_mode == "reg"){ payload = form_2_json($("div#reg_form form"));}
    else { payload = form_2_json($("div#log_form form"));}
    $.get("/?do=logForm&data=" + payload, function(resp){
        if (resp.name == "OK"){
            window.location = "logged";
        }
        else {
            $("#name_log_err").text(resp.name);
            $("#pass_log_err").text(resp.password);
        }
    });
}

