/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function loginbtn_validation_click()
{

    // $.mobile.changePage("dashboard.html", {transition: "flip", changeHash: false});
    // return;
    var   url=webserver+"/Mycescapplogic/MYcescregistration/loginvalidation.php";
    var mobile= $("#mobile_login").val();
    $("#msgdiv_login").hide();
    $.mobile.loading( 'show', {
        text: 'Please wait .....',
        textVisible: true,
        theme: 'z',
        html: ""
    });
    
    var isok="Y";
    var autologin=$('#autologin').val();//window.localStorage.getItem("autologin");
    //alert(autologin);
    var msgcap="";
    if(isok=='Y')
    {
        if(autologin!='Y')
        {
            var epin=$("#epin1").val().toString()+$("#epin2").val().toString()+$("#epin3").val().toString()+$("#epin4").val().toString();
            $("#epin_login").val(epin);
        }
        //  alert(getpDevicuuid());
        $.post(url, {
            mobile_no:  $("#mobile_login").val(),
            epin     :$("#epin_login").val(),
            uniqueid   : $("#uniqid").val(),
            uuid:       getpDevicuuid()
        }, function (data) {
            var myObj = JSON.parse(data);
            if(myObj.status=='Y')
            {
                window.localStorage.setItem("mpin",myObj.mpin);
                window.localStorage.setItem("mobile_no",myObj.mobile_no);
                window.localStorage.setItem("emp_name",myObj.emp_name);
                window.localStorage.setItem("emp_code",myObj.emp_code);
                window.localStorage.setItem("uniqid",myObj.uniqid);
                window.localStorage.setItem("last_login",myObj.last_login);
                window.localStorage.setItem("grade",myObj.grade);
                window.localStorage.setItem("department_code",myObj.department_code);
                $.mobile.changePage("dashboard.html", {
                    transition: "flip",
                    changeHash: false
                });
                $.mobile.loading('hide');
            }else{
                $.mobile.loading('hide');
                $('#autologin').val('N');
                window.localStorage.removeItem("mpin");
                $("#index_login_div").show();
                $("#mpin1").val('');
                $("#mpin2").val('');
                $("#mpin3").val('');
                $("#mpin4").val('');
                $("#msgdiv_login").show();
                $("#msgdiv_login").html(myObj.msgdtl);
                $("#msgdiv_login").addClass("alert alert-danger");
            }
        });

    }
    else{

        $("#index_login_div").show();
        $("#mpin1").val('');
        $("#mpin2").val('');
        $("#mpin3").val('');
        $("#mpin4").val('');
        $("#msgdiv_login").show();
        $("#msgdiv_login").html(myObj.msgdtl);
        $("#msgdiv_login").addClass("alert alert-danger");

    }

}


function email_mobile_validation() {


    var   url=webserver+"/Mycescapplogic/MYcescregistration/json_mobile_email_validation.php";
    var mobile= $("#mobile").val();
    $("#autootpstop").prop( "disabled", false );
    $("#autootpstop").prop( "checked", false );
    //Check Mobile number

    if (mobile == '' || isNaN(mobile) || mobile.length != 10) {
        $("#mobile").removeClass("cust_id_textbox_valid");
        $("#mobile").addClass("cust_id_textbox_red");
        $("#mobile").addClass("cust_id_textbox_invalid");
        $("#mobile").focus();
        return false;
    } else {
        $("#mobile").removeClass("cust_id_textbox_red");
        $("#mobile").removeClass("cust_id_textbox_invalid");
        $("#mobile").addClass("cust_id_textbox_valid");
    }



    //    $.mobile.loading( 'show', {
    //        text: 'wait....',
    //        textVisible: true,
    //        theme: 'z',
    //        html: ""
    //    });
    $('#wait_loader_newrgn').show();
    //alert($('#wait_loader_rgn').html());


    var email_id='';
    email_id= $("#email_id").val().toLowerCase()+$("#comp_id").val();
    $.ajax({
        url: url,
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        type: "POST",
        dataType: "json",
        data: {
            mobile_no:  $("#mobile").val(),
            email_id:  email_id
        },
        success: function (data) {
            //  console.log(data);
            $.mobile.loading( 'hide');
            if(data.status=='Y')
            {
                // $.mobile.changePage("menu.html", {transition: "flip", changeHash: false});
                $("#emp_name").val(data.FULL_NAME);
                $("#emp_code").val(data.EMP_CODE);
                new_registration();

            }else{

                $("#msgdiv_registration").html(data.msgdtl);
                $("#msgdiv_registration").addClass("alert alert-danger");
                $("#msgdiv_registration").show();
                $('#wait_loader_newrgn').hide();

            }

        },
        error: function () {
            console.log("error");
            //  alert(error);
            //   $.mobile.loading( 'hide');
            $('#wait_loader_newrgn').hide();
        }
    });

}
var timer = null;
var  orgtotalSeconds=60;
var  totalSeconds=orgtotalSeconds;
function new_registration() {
    var otp=JenOTP();

    var   url=webserver+"/Mycescapplogic/MYcescregistration/Mycescappregistration.php";
    //    var mobile= $("#mobile").val();
    //  $("#autootpstop").prop( "disabled", false );
    // $("#autootpstop").prop( "checked", false );
    //    $.mobile.loading( 'show', {
    //        text: 'Please wait .....',
    //        textVisible: true,
    //        theme: 'z',
    //        html: ""
    //    });
    $('#wait_loader_newrgn').show();


    var email_id='';
    email_id= $("#email_id").val().toLowerCase()+$("#comp_id").val();
   
    $.ajax({
        url: url,
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        type: "POST",
        dataType: "json",
        data: {
            mobile_no:  $("#mobile").val(),
            email_id:   email_id,
            sms_msg :   otp,
            exp_time:   orgtotalSeconds,
            rgn_type:   'N',
            uuid:       getpDevicuuid(),
            platform :  getplatform(),
            emp_code : $("#emp_code").val(),
            emp_name : $("#emp_name").val()

        },
        success: function (data) {
            //  console.log(data);
            //  $.mobile.loading( 'hide');
            $('#wait_loader_newrgn').hide();
            if(data.status=='Y')
            {
                $("#logindiv").hide();
                $("#otp_verification_registration").fadeIn('slow', function() {

                    $("#op_type").val('V');

                });
                //                $("#logindiv").fadeOut('slow', function() {
                //
                //                    });


                $("#uniqid").val(data.uniqid);
                $("#otp").val(data.otp);
                $("#checkbtn").html('Verify');

                $("#updttime").show();
                //                $.mobile.loading( 'show', {
                //                    text: 'Please wait .....',
                //                    textVisible: true,
                //                    theme: 'z',
                //                    html: ""
                //                });
                $('#wait_loader_newrgn').show();
                try{
                    startWatch();
                    // $("#otpdiv").hide();
                    $("#checkbtn").hide();
                    window.localStorage.setItem("autootp",'Y');

                    $("#rgn_cancel").hide();
                }catch(err){
                    //  $.mobile.loading( 'hide');
                    $("#rgn_cancel").show();
                    window.localStorage.setItem("autootp",'N');
                }
                clearInterval(timer);
                timer = null;
                totalSeconds=orgtotalSeconds;
                timer = setInterval(setTime, 1000);

            }else{
                
                $("#msgdiv_registration").html(data.msgdtl);
                $("#msgdiv_registration").addClass("alert alert-danger");
                $("#msgdiv_registration").show();
                $('#wait_loader_newrgn').hide();
                
            }

        },
        error: function () {
            console.log("error");
            //  $.mobile.loading( 'hide');
            $('#wait_loader_newrgn').hide();
        }
    });

}
function otp_check()
{
    var  autootp='X';
    try{
        autootp=window.localStorage.getItem("autootp");
    }catch(err){}
    if(autootp==null)autootp="X";

    var otpverify= $('#otpverify').val();
    if(autootp=='Y'){
        var res = otpverify.split("");
        if(res[0]!=null)$('#otp1').val(res[0]);
        if(res[1]!=null)$('#otp2').val(res[1]);
        if(res[2]!=null)$('#otp3').val(res[2]);
        if(res[3]!=null)$('#otp4').val(res[3]);
        if(res[4]!=null)$('#otp5').val(res[4]);
        if(res[5]!=null)$('#otp6').val(res[5]);
    }

    var otpinput=$("#otp1").val().toString()+$("#otp2").val().toString()+$("#otp3").val().toString()+$("#otp4").val().toString()+$("#otp5").val().toString()+$("#otp6").val().toString()
    $("#otpverify").val(otpinput);
    //  $("#otp").val('111111');
    var isok="Y";

    var   url=webserver+"/Mycescapplogic/MYcescregistration/otp_check.php";
    $.ajax({
        url: url,
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        type: "POST",
        dataType: "json",
        data: {
            otp: $("#otpverify").val(),
            mobile: $("#mobile").val()

        },
        success: function (data) {
            // alert(data);
            //   console.log(data);
            if(data.status!='Y')
            {
                try{
                    navigator.notification.alert(
                        'OTP mismatch',  // message
                        function(){},         // callback
                        globalstoreObject.alert_caption,            // title
                        'OK'                  // buttonName
                        );
                }catch(err){
                    alert('OTP mismatch');



                }
                $("#msgdiv_registration").show();
                $("#msgdiv_registration").html(data.msgdtl);
                $("#msgdiv_registration").addClass("alert alert-danger");
            //$.mobile.loading('hide');
            // $('#wait_loader_newrgn').hide();
            }else{
                $("#otp_verification_registration").hide();
                $("#chooseepindiv").fadeIn('slow', function() {
                    $("#op_type").val('U');
                    $("#checkbtn").html('Submit');
                    $.mobile.loading('hide');
                    $('#wait_loader_newrgn').hide();
                });
                clearInterval(timer);
                timer = null;
            }

        },
        error: function () {
            console.log("error");

        }
    });


}
function setePIN_complete() {



    var   url=webserver+"/Mycescapplogic/MYcescregistration/Mycescappregistration.php";
    var mobile= $("#mobile").val();
    $("#op_type").val('PIN');
    //    $.mobile.loading( 'show', {
    //        text: 'Please wait .....',
    //        textVisible: true,
    //        theme: 'z',
    //        html: ""
    //    });
    $('#wait_loader_newrgn').show();


    var epin=$("#mpin1").val().toString()+$("#mpin2").val().toString()+$("#mpin3").val().toString()+$("#mpin4").val().toString();
    $("#epin").val(epin);
    var email_id='';
    email_id= $("#email_id").val().toLowerCase()+$("#comp_id").val();
    $.post(url, {
        mobile_no:  $("#mobile").val(),
        email_id:   email_id,
        rgn_type:   'U',
        uuid:       getpDevicuuid(),
        platform :  getplatform(),
        mpin     :$("#epin").val(),
        uniqid   : $("#uniqid").val(),
        emp_code : $("#emp_code").val(),
        emp_name : $("#emp_name").val(),
        otp: $("#otpverify").val()
    }, function (data) {
        //  alert(data);
        // alert(JSON.stringify(data));
        var myObj = JSON.parse(data);
        //    alert(myObj.msg);
        if(myObj.status=='Y')
        {
            $("#msgdiv_registration").html(myObj.msgdtl);
            $("#msgdiv_registration").removeClass("alert alert-danger");

            $("#msgdiv_registration").addClass("alert alert-success");
            $("#rgn_cancel").show();
            $("#rgn_cancel").html(' <a href="index.html" data-role="none" data-transition="flip">Login Now</a> ');
            $("#chooseepindiv").hide();
            $("#msgdiv_registration").fadeIn('slow', function() {
                $("#checkbtn").hide();
            });
            //            $("#chooseepindiv").fadeOut('slow', function() {
            //
            //                });
            //  $.mobile.loading('hide');
            $('#wait_loader_newrgn').hide();
        }else{
            $("#msgdiv_registration").removeClass("alert alert-success");
            $("#msgdiv_registration").html(myObj.msgdtl);
            $("#msgdiv_registration").addClass("alert alert-danger");
            $("#msgdiv_registration").show();
        }
    });



}
function setTime() {
    totalSeconds--;
    var  autootp='X';
    try{
        autootp=window.localStorage.getItem("autootp");
    }catch(err){}
    if(autootp!='Y')
    {
        $("#otpdiv").show();
    }else{
        $("#otpdiv").hide();
    }
    
    if (totalSeconds==0)
    {   // alert('test');
        if (timer) {
            clearInterval(timer);
            timer = null;
            totalSeconds=orgtotalSeconds;
            $('#wait_loader_newrgn').hide();
           
            $("#updttime").fadeOut('slow', function() {

                });
            $("#otp_verification_registration").fadeOut('slow', function() {
                $("#op_type").val('C');
                $("#checkbtn").html('Check');

            });
            $("#logindiv").fadeIn('slow', function() {
                $("#checkbtn").show();
                $('#wait_loader_newrgn').hide();
            });
           
            $("#chooseepindiv").hide();
            $("#otpdiv").show();
            $('#otp1').val('');
            $('#otp2').val('');
            $('#otp3').val('');
            $('#otp4').val('');
            $('#otp5').val('');
            $('#otp6').val('');

            $('#mpin1').val('');
            $('#mpin2').val('');
            $('#mpin3').val('');
            $('#mpin4').val('');

           

        }
    }
    $('#updatingIn').text(totalSeconds);
}

function checkmobileno(id)
{

    var val=id.value;

    var i=0;
    var length=val.length;
    var chr='';
    var firstchar='';
    for(i=0;i<length;i++)
    {

        firstchar=val.substring(0,1);
        if(firstchar=='6'||firstchar=='7'||firstchar=='8'||firstchar=='9')
        {
            isok='Y';

        }else{
            id.value=id.value.substring(0,id.value.length-1);
        }
        chr=val.substring(i, i+1);
        if(chr==0||chr==1||chr==2||chr==3||chr==4||chr==5||chr==6||chr==7||chr==8||chr==9){

        }else{
            id.value=id.value.substring(0,id.value.length-1);
            return false;
        }
    }


    var isok='Y';

    if( (id.value.length== 10)&&(isok=='Y') )
    {
        return 'ok';
        id.focus();

    }
    return true;
}

document.addEventListener("deviceready", messagesetting, false);
function messagesetting()
{
    var options = {
        delimiter : "",
        length : '',
        origin : "'"
    };
    try{
        OTPAutoVerification.startOTPListener(options,function(){}, function(){});
    }catch(err){}
}
var success = function (otp) {
    //  alert("GOT OTP", otp);
    OTPAutoVerification.stopOTPListener();
}

var failure = function () {
    OTPAutoVerification.stopOTPListener();
//  alert("Problem in listening OTP");
}
function startWatch() {  // start listening incoming sms
    if(SMS) SMS.startWatch(function(){
        ///  alert('watching', 'watching started');
        }, function(){
        // alert('failed to start watching');
        });
}


function stopWatch()  {   // stop listening incoming sms
    if(SMS) SMS.stopWatch(function(){
        update('watching', 'watching stopped');
    }, function(){
        updateStatus('failed to stop watching');
    });

}


function checkbtn_click()
{
    $("#checkbtn").show();
    $("#msgdiv_registration").hide();
    $("#msgdiv_registration").html('');
    
    var op_type= $("#op_type").val();
    // alert(op_type);
    if(op_type=='C')//for check
    {
        email_mobile_validation();
    }
    else if(op_type=='V')//for verify
    {
        otp_check();//check OTP
    }
    else  if(op_type=='U')//Pin Set
    {
        setePIN_complete();
    }

}

function setePIN_complete() {



    var   url=webserver+"/Mycescapplogic/MYcescregistration/Mycescappregistration.php";
    var mobile= $("#mobile").val();
    $("#op_type").val('PIN');
    //    $.mobile.loading( 'show', {
    //        text: 'Please wait .....',
    //        textVisible: true,
    //        theme: 'z',
    //        html: ""
    //    });

    $('#wait_loader_newrgn').show();

    var epin=$("#mpin1").val().toString()+$("#mpin2").val().toString()+$("#mpin3").val().toString()+$("#mpin4").val().toString();
    $("#epin").val(epin);
    var email_id='';
    email_id= $("#email_id").val().toLowerCase()+$("#comp_id").val();
    $.post(url, {
        mobile_no:  $("#mobile").val(),
        email_id:   email_id,
        rgn_type:   'U',
        uuid:       getpDevicuuid(),
        platform :  getplatform(),
        mpin     :$("#epin").val(),
        uniqid   : $("#uniqid").val(),
        emp_code : $("#emp_code").val(),
        emp_name : $("#emp_name").val(),
        otp:  $('#otpverify').val()
    }, function (data) {
        // alert(data);
        // alert(JSON.stringify(data));
        var myObj = JSON.parse(data);
        //    alert(myObj.msg);
        if(myObj.status=='Y')
        {
            $("#msgdiv_registration").html(myObj.msgdtl);
            $("#msgdiv_registration").addClass("alert alert-success");
            $("#rgn_cancel").show();
            //  $("#rgn_cancel").html(' <a href="index.html" data-role="none" data-transition="flip">Login Now</a> ');
            $("#rgn_cancel").html(' <a href="#" onclick="OpenIndexPage()" >Login Now</a> ');

            $("#chooseepindiv").hide();
            $("#msgdiv_registration").fadeIn('slow', function() {
                $("#checkbtn").hide();
            });
            //            $("#chooseepindiv").fadeOut('slow', function() {
            //
            //                });
            //  $.mobile.loading('hide');
            $('#wait_loader_newrgn').hide();
        }else{
            $("#msgdiv_registration").html(myObj.msgdtl);
            $("#msgdiv_registration").addClass("alert alert-danger");
        }
    });



}
function OpenIndexPage()
{
    window.location='index.html';
}



/////////////////////reset epin

function rst_checkbtn_click()
{
    var rst_op_type=   $("#rst_op_type").val();
   
    if(rst_op_type=='C')
    {
        var mobile_no= $('#rst_mobile').val();
        var email_id='';
        email_id= $("#rst_email_id").val().toLowerCase() +$("#rst_comp_id").val();
        // console.log(email_id);
        var otp=JenOTP();
        var   url=webserver+"/Mycescapplogic/MYcescregistration/json_rst_mobile_validation.php";
        $.ajax({
            url: url,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            type: "POST", /* or type:"GET" or type:"PUT" */
            dataType: "json",
            data: {
                mobile_no: mobile_no,
                email_id: email_id,
                otp:      otp,
                exp_time:   orgtotalSeconds
            },
            success: function (data) {

                if(data.status=='Y')
                {
                    $("#rst_logindiv").hide();
                    $("#rst_otp_verification_registration").fadeIn('slow', function() {

                        $("#rst_op_type").val('V');

                    });
                    //                $("#logindiv").fadeOut('slow', function() {
                    //
                    //                    });


                    $("#rst_uniqid").val(data.uniqid);
                    $("#rst_otp").val(data.otp);
                    $("#checkbtn_reset").html('Verify');

                    $("#rst_updttime").show();
                    //                    $.mobile.loading( 'show', {
                    //                        text: 'Please wait .....',
                    //                        textVisible: true,
                    //                        theme: 'z',
                    //                        html: ""
                    //                    });
                    $("#wait_loader").show();
                    try{
                        startWatch();
                        // $("#otpdiv").hide();
                        // $("#rst_updttime").hide();
                        window.localStorage.setItem("rst_autootp",'Y');

                        $("#rgn_cancel").hide();
                    }catch(err){
                        //  $.mobile.loading( 'hide');
                        $("#rgn_cancel").show();
                        window.localStorage.setItem("rst_autootp",'N');
                    }
                    clearInterval(timer);
                    timer = null;
                    totalSeconds=orgtotalSeconds;
                    timer = setInterval(rst_setTime, 1000);

                }
                else{
                    //  console.log(data.msgdtl);
                    $("#rst_msgdiv_registration").html(data.msgdtl);
                    $("#rst_msgdiv_registration").addClass("alert alert-danger");
                    $("#rst_msgdiv_registration").show();
                }

            },
            error: function () {
                console.log("error");
            }
        });
        return;
    }else  if(rst_op_type=='V')
    {
        rst_otp_check();
    }else  if(rst_op_type=='U')
    {
        resetPIN_complete();
    }
}


function rst_setTime() {
    totalSeconds--;
    var  autootp='X';
    try{
        autootp=window.localStorage.getItem("rst_autootp");
    }catch(err){}
    if(autootp!='Y')
    {
        $("#rst_otpdiv").show();
        $("#rst_otp_verification_registration").show();
    }else{
        $("#rst_otpdiv").hide();
    }
    if (totalSeconds==0)
    {
        if (timer) {
            clearInterval(timer);
            timer = null;
            //  totalSeconds=12;


            //            if($('#btn_newapp_otp')!==null)  $('#btn_newapp_otp').text('Resend OTP');
            //            else if($('#btn_otp')!==null)  $('#btn_otp').text('Resend OTP');
            //            else if($('#btn_otpforgot')!==null)  $('#btn_otpforgot').text('Resend OTP');
            totalSeconds=orgtotalSeconds;
            // $.mobile.loading( 'hide');


            $("#wait_loader").hide();
            $("#rst_updttime").fadeOut('slow', function() {
                $("#rst_chooseepindiv").hide();
            });
            $("#rst_otp_verification_registration").fadeOut('slow', function() {
                $("#rst_op_type").val('C');
                $("#checkbtn_reset").html('Check');

            });
            $("#rst_logindiv").fadeIn('slow', function() {
                $("#checkbtn_reset").show();

            });

            $("#rst_otpdiv").show();
            $('#rst_otp1').val('');
            $('#rst_otp2').val('');
            $('#rst_otp3').val('');
            $('#rst_otp4').val('');
            $('#rst_otp5').val('');
            $('#rst_otp6').val('');

        }
    }
    $('#rst_updatingIn').text(totalSeconds);
}

function rst_otp_check()
{
   
    var  autootp='X';
    try{
        autootp=window.localStorage.getItem("rst_autootp");
    }catch(err){}
    if(autootp==null)autootp="X";
    var otpverify= $('#rst_otpverify').val();
    if(autootp=='Y'){
        var res = otpverify.split("");
        if(res[0]!=null)$('#rst_otp1').val(res[0]);
        if(res[1]!=null)$('#rst_otp2').val(res[1]);
        if(res[2]!=null)$('#rst_otp3').val(res[2]);
        if(res[3]!=null)$('#rst_otp4').val(res[3]);
        if(res[4]!=null)$('#rst_otp5').val(res[4]);
        if(res[5]!=null)$('#rst_otp6').val(res[5]);
    }

    var otpinput=$("#rst_otp1").val().toString()+$("#rst_otp2").val().toString()+$("#rst_otp3").val().toString()+$("#rst_otp4").val().toString()+$("#rst_otp5").val().toString()+$("#rst_otp6").val().toString()
    $("#rst_otpverify").val(otpinput);
    //  $("#otp").val('111111');
    var isok="Y";
    if($("#rst_otpverify").val()==$("#rst_otp").val())
    {

        clearInterval(timer);
        timer = null;
        $("#rst_otp_verification_registration").hide();
        $("#rst_chooseepindiv").fadeIn('slow', function() {
            $("#rst_op_type").val('U');
            $("#checkbtn_reset").html('Submit');
            //   $.mobile.loading('hide');
            $("#wait_loader").hide();
        });

    }else{
        try{
            navigator.notification.alert(
                'OTP mismatch',  // message
                function(){},         // callback
                globalstoreObject.alert_caption,            // title
                'OK'                  // buttonName
                );
        }catch(err){
            alert('OTP mismatch');
        }
        //  $.mobile.loading('hide');
        $("#wait_loader").hide();
    }

}

function resetPIN_complete() {
    var   url=webserver+"/Mycescapplogic/MYcescregistration/ResetEpin.php";
    var mobile= $("#rst_mobile").val();
    $("#rst_op_type").val('PIN');
    //    $.mobile.loading( 'show', {
    //        text: 'Please wait .....',
    //        textVisible: true,
    //        theme: 'z',
    //        html: ""
    //    });
    $("#wait_loader").show();
    var epin=$("#rst_mpin1").val().toString()+$("#rst_mpin2").val().toString()+$("#rst_mpin3").val().toString()+$("#rst_mpin4").val().toString();
    $("#rst_epin").val(epin);
    var email_id='';
    email_id= $("#rst_email_id").val()+$("#rst_comp_id").val();
    $.post(url, {
        mobile_no:  $("#rst_mobile").val(),
        email_id:   email_id,
        rgn_type:   'U',
        uuid:       getpDevicuuid(),
        platform :  getplatform(),
        mpin     :$("#rst_epin").val(),
        uniqid   : $("#rst_uniqid").val(),
        otp :$("#rst_otpverify").val()

    }, function (data) {
        var myObj = JSON.parse(data);
        if(myObj.status=='Y')
        {
            $("#rst_msgdiv_registration").html(myObj.msgdtl);
            $("#rst_msgdiv_registration").addClass("alert alert-success");
            $("#rst_rgn_cancel").show();
            //    $("#rst_rgn_cancel").html(' <a href="index.html" data-role="none" data-transition="flip">Login Now</a> ');
            $("#rst_rgn_cancel").html(' <a href="#" onclick="OpenIndexPage()" >Login Now</a> ');

            $("#rst_chooseepindiv").hide();
            $("#rst_msgdiv_registration").fadeIn('slow', function() {
                $("#checkbtn_reset").hide();
            });
            clearInterval(timer);
            timer = null;
            // $.mobile.loading('hide');
            $("#wait_loader").hide();
        }else{
            $("#rst_msgdiv_registration").html(myObj.msgdtl);
            $("#rst_msgdiv_registration").addClass("alert alert-danger");
        }
    });



}

///////////////////