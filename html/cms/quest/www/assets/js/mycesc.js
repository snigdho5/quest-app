var globalstoreObject = {
    alert_caption : 'Mycesc App',
    emp_code : '',
    emp_name : '',
    type : ''
}
window.onscroll = function() {
    scrollFunction()
};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        if(document.getElementById("myBtn")!=null)
            document.getElementById("myBtn").style.display = "block";
    }
    else {
        if(document.getElementById("myBtn")!=null)
            document.getElementById("myBtn").style.display = "none";
    }
}
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}


function getplatform()
{
    var platform='';
    try {
        platform=device.platform;
    }
    catch(err) {
    }
    return platform;
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




function Loadmedical_menu(val)
{
    // alert(val);
    var innerhtml='<a href="doctors_on_duty_searchby_date.html" class="list-group-item" data-transition="slide"><i class="fa fa-arrow-right"></i> Date Range </a>';
    innerhtml=innerhtml+'<a href="doctors_on_duty_searchby_name.html" class="list-group-item" data-transition="slide"><i class="fa fa-arrow-right"></i> Doctor\'s Name </a>';
    innerhtml=innerhtml+'<a href="doctors_on_duty_searchby_zone.html" class="list-group-item" data-transition="slide"><i class="fa fa-arrow-right"></i> Doctor\'s Zone </a>';
    //alert(innerhtml);
    $("#right_menu"+val).html(innerhtml);

}
//$(document).ready(function() {


//function checkbtn_click()
//{
//    $("#checkbtn").show();
//
//    var op_type= $("#op_type").val();
//    // alert(op_type);
//    if(op_type=='C')//for check
//    {
//        email_mobile_validation();
//    }
//    else if(op_type=='V')//for verify
//    {
//        otp_check();//check OTP
//    }
//    else  if(op_type=='U')//Pin Set
//    {
//        setePIN_complete();
//    }
//
//}

//function loginbtn_validation_click()
//{
//
//    // $.mobile.changePage("dashboard.html", {transition: "flip", changeHash: false});
//    // return;
//    var   url=webserver+"/Mycescapplogic/MYcescregistration/loginvalidation.php";
//    var mobile= $("#mobile_login").val();
//
//    $.mobile.loading( 'show', {
//        text: 'Please wait .....',
//        textVisible: true,
//        theme: 'z',
//        html: ""
//    });
//    var isok="Y";
//    var autologin=$('#autologin').val();//window.localStorage.getItem("autologin");
//    //    alert('autologin=>'+autologin);
//    var msgcap="";
//    if(isok=='Y')
//    {
//        if(autologin!='Y')
//        {
//            var epin=$("#epin1").val().toString()+$("#epin2").val().toString()+$("#epin3").val().toString()+$("#epin4").val().toString();
//            $("#epin_login").val(epin);
//        }
//
//        $.post(url, {
//            mobile_no:  $("#mobile_login").val(),
//            epin     :$("#epin_login").val(),
//            uniqid   : $("#uniqid").val()
//        }, function (data) {
//
//            //  alert(JSON.stringify(data));
//            var myObj = JSON.parse(data);
//            //  alert(myObj.msg);
//            if(myObj.status=='Y')
//            {
//                //  alert(myObj.emp_code);
//                window.localStorage.setItem("mpin",myObj.mpin);
//                window.localStorage.setItem("mobile_no",myObj.mobile_no);
//                window.localStorage.setItem("emp_name",myObj.emp_name);
//                window.localStorage.setItem("emp_code",myObj.emp_code);
//                window.localStorage.setItem("uniqid",myObj.uniqid);
//                window.localStorage.setItem("last_login",myObj.last_login);
//                $.mobile.changePage("dashboard.html", {
//                    transition: "flip",
//                    changeHash: false
//                });
//
//
//                $.mobile.loading('hide');
//            }else{
//                $.mobile.loading('hide');
//                $("#msgdiv_login").show();
//                $("#msgdiv_login").html(myObj.msgdtl);
//                $("#msgdiv_login").addClass("alert alert-danger");
//            }
//        });
//
//    }else{
//        $("#msgdiv_login").show();
//        $("#msgdiv_login").html(myObj.msgdtl);
//        $("#msgdiv_login").addClass("alert alert-danger");
//
//    }
//
//}

function Get_lastlogin()
{
    var last_login=window.localStorage.getItem("last_login");
    return last_login;
}


//////////////check for account present

function phoneCall(id)
{
    var number='';
    number=  $("#"+id).val();

    try{
        window.plugins.CallNumber.callNumber(successCallback, errorCallback, number, false);
    }catch(err){

    }
}

function phoneCall2(number)
{

    try{
        window.plugins.CallNumber.callNumber(successCallback, errorCallback, number, false);
    }catch(err){

    }
}

function successCallback(result) {
    // alert(result);
    consol.log(result);

}
function errorCallback(error) {
    //  alert(error);
    consol.log(error);

}

function CancelClick()
{
    window.location='index.html';
}

