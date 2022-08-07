/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var webserver='';
//    webserver="https://www.cesc.co.in/cescmob";
var webserver = "http://access.cesc.co.in/testcesc_mob";

var biserver="http://10.50.81.50/biuser/biws/";
var starttime = '';
document.addEventListener("backbutton", onBackKeyDown, false);

function onBackKeyDown()
{
   
    clearInterval(starttime);
    clearTimeout(starttime);
    starttime = 0;
    var pageURL = $(location).attr("href");
    // alert(pageURL);
    var myFilename = getPageName(pageURL);
    // call_back('','');
    ///Call_Pagechange(page,changemode,hashmode,callfrom)
    if(myFilename.trim()=='dashboard' )
    {
        navigator.notification.alert(
            'Use top left menu for logout  ',  // message
            function(){},         // callback
            'Information',            // title
            'OK'                  // buttonName
            );
    }
    else{
        call_back('','');

    //
    //        navigator.notification.alert(
    //            'Use footer back button ',  // message
    //            function(){},         // callback
    //            'Information',            // title
    //            'OK'                  // buttonName
    //            );
    }


}

try{
    document.addEventListener("offline", onOffline, false);
}catch(e){}
function onOffline() {
    $.mobile.loading( 'show', {
        text: 'Please wait. No network Found .....',
        textVisible: true,
        theme: 'z',
        html: ""
    });
    window.localStorage.setItem("offline",'Y');

}
try{

    document.addEventListener("online", onOnline, false);
}catch(e)
{}


function onOnline() {
    var offline=window.localStorage.getItem("offline");
    if(offline==null)offline='';
    if(offline=='Y')
    {
        window.localStorage.removeItem("offline");
        call_back('','');
        
    }

    checkConnection();
   
}

function checkConnection() {
     
    $.ajax({
        url: webserver,
        dataType: "jsonp",
        statusCode: {
            200: function (response) {
                $.mobile.loading( 'hide');
               
            },
            404: function (response) {
                $.mobile.loading( 'show', {
                    text: 'Please wait. No network Found .....',
                    textVisible: true,
                    theme: 'z',
                    html: ""
                });
            }
        }
    });



    var networkState = navigator.connection.type;

    var states = {};
    states[Connection.UNKNOWN]  = 'Unknown connection';
    states[Connection.ETHERNET] = 'Ethernet connection';
    states[Connection.WIFI]     = 'WiFi connection';
    states[Connection.CELL_2G]  = 'Cell 2G connection';
    states[Connection.CELL_3G]  = 'Cell 3G connection';
    states[Connection.CELL_4G]  = 'Cell 4G connection';
    states[Connection.CELL]     = 'Cell generic connection';
    states[Connection.NONE]     = 'No network connection';

// alert('Connection type: ' + states[networkState]);
}




function Get_uniqid()
{
    var uniqid=window.localStorage.getItem("uniqid");
    if(uniqid==null)uniqid='';
    if(uniqid=='undefined')uniqid='';
    return uniqid;
}
function Get_lastlogin()
{
    var last_login=window.localStorage.getItem("last_login");
    return last_login;
}


function getPageName(url) {
    var index = url.lastIndexOf("/") + 1;
    var filenameWithExtension = url.substr(index);
    var filename = filenameWithExtension.split(".")[0]; // <-- added this line
    return filename;                                    // <-- added this line
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
function getpDevicuuid()
{
    var uuid ='';
    try {
        uuid = device.uuid;
    }
    catch(err) {
        uuid ='99999999';

    }
    //  alert(uuid);
    return uuid;
}

function getEmp_code()
{
    var emp_code=window.localStorage.getItem("emp_code");
    if(emp_code==null)emp_code='';
    if(emp_code=='undefined')emp_code='';
    //if(emp_code=='')window.location='index.html';
    return emp_code;
}
function getMobile_no()
{
    var mobile_no=window.localStorage.getItem("mobile_no");
    if(mobile_no==null)mobile_no='';
    if(mobile_no=='undefined')mobile_no='';
    //if(emp_code=='')window.location='index.html';
    return mobile_no;
 
}



function app_load(page_level)
{
    var emp_code='';
    var emp_name='';
    try{
        var  uniqid=Get_uniqid();
        // alert(uniqid);
        if(uniqid==null)uniqid='';

        if(uniqid!='')
        {
            var   url=webserver+"/Mycescapplogic/MYcescregistration/loginvalidation_session.php";
            //  alert(url);
            $.post(url, {
                uniqid:  uniqid
            }, function (data) {
                //   alert(JSON.stringify(data));
                var myObj = JSON.parse(data);
            
                if(myObj.status=='Y')
                {
                    emp_code=window.localStorage.getItem("emp_code");
                    emp_name=window.localStorage.getItem("emp_name");
                }else{
                    window.localStorage.removeItem("mobile_no");
                    window.localStorage.removeItem("uniqid");
                    window.localStorage.removeItem("last_login");
                    window.localStorage.removeItem("emp_code");
                    //                    alert('else22 =>'+data +' => '+uniqid);
                    if(page_level==0)
                        window.location.href="index.html";
                    else if(page_level==2)
                        window.location.href="../../index.html";
                    else
                        window.location.href="../index.html";
                }

            });
        }else{
             
            window.localStorage.removeItem("uniqid");
            window.localStorage.removeItem("last_login");
            window.localStorage.removeItem("emp_code");
            if(page_level==0)
                window.location.href="index.html";
            else if(page_level==2)
                window.location.href="../../index.html";
            else
                window.location.href="../index.html";


        }
    }catch(err){
      
        window.localStorage.removeItem("mobile_no");
        window.localStorage.removeItem("uniqid");
        window.localStorage.removeItem("last_login");
        window.localStorage.removeItem("emp_code");
        if(page_level==0)
            window.location.href="index.html";
        else if(page_level==2)
            window.location.href="../../index.html";
        else
            window.location.href="../index.html";
    }


}


function getWeatherData()
{
    //var url = helpdeskserver + "/problemDetails/" + emp_code;
    var url = "https://access.cesc.co.in/testcesc_mob/Mycescapplogic/json/Weather_API.php";

    try {
        var myObjdata = '';
        var dataObj;
        var innerhtml = ''
        //alert(url);
        var src="<img  src='../www/images/ajax-loader.gif' width=20px />";
  
//        $('#weatherDiv').html(src);

        $("#weatherDiv").fadeOut('slow', function() {
                //    $('#weatherDiv').html(innerhtml);

                });

        $.get(url, {
            }, function (data) {
                //console.log(data);
                var myObj = JSON.parse(data);
                //console.log(myObj);
                //alert(myObj[0].run_date);
                var run_date = myObj[0].run_date;
                var temperature = myObj[0].temperature;
                var rain = myObj[0].rain;

                var innerhtml = '';
                innerhtml = innerhtml + '<p>'+run_date+'</p>';
                innerhtml = innerhtml + '<p>';
                innerhtml = innerhtml + '<i class="fa fa-thermometer-half" aria-hidden="true"></i>';
                innerhtml = innerhtml +'&nbsp;'+temperature+' <sup>o</sup> C';
                if(rain > 0)
                    innerhtml = innerhtml + ' &nbsp;<img src="assets/images/cloud.png">&nbsp;'+rain+' mm';
                innerhtml = innerhtml + '</p>';

               

                $("#weatherDiv").fadeIn('slow', function() {
                    $('#weatherDiv').html(innerhtml);

                });

            });

    }
    catch (e) {
    }
}




function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
}

function checkOnlydigit(control_id)
{
    var i=0;
    control_id='#'+control_id;
    var val=$(control_id).val();
    var length=val.length;
    var chr='';
    for(i=0;i<length;i++)
    {
        chr=val.substring(i, i+1);
        // alert(chr);
        if(chr==0||chr==1||chr==2||chr==3||chr==4||chr==5||chr==6||chr==7||chr==8||chr==9){

        }else{
            $(control_id).val($(control_id).val().substring(0,$(control_id).val().length-1));
            return false;
        }
    }
    return true;
}


function moveOnMax(field) {
    var length = field.value.length;
    var val=field.value;
    var i=0;
    var chr;
    for(i=0;i<length;i++)
    {
        chr=val.substring(i, i+1);
        // alert(chr);
        if(chr==0||chr==1||chr==2||chr==3||chr==4||chr==5||chr==6||chr==7||chr==8||chr==9){

        }
        else{

            field.value='';
            return false;
        }
    }
    if (length == 0) {
        $(field).prev().focus();
        return false;
    }
    else if (length > 0) {
        $(field).next().focus();
        return false;
    }
}

function datevalidation(fsdt,tsdt)

{
    var frmdtarr=fsdt.split('/');
    var todtarr=tsdt.split('/');
    var mmfsdt = frmdtarr[0];
    var ddfsdt = frmdtarr[1];
    var yyyyfsdt = frmdtarr[2];
    var dt1   = frmdtarr[0];
    var mon1  = frmdtarr[1];
    var yr1   = frmdtarr[2];
    var dt2   = todtarr[0];
    var mon2  = todtarr[1];
    var yr2   = todtarr[2];
    var date1 = new Date(mon1+"/"+dt1+"/"+yr1);
    var date2 = new Date(mon2+"/"+ dt2+"/"+yr2 );
  
    if (date2 < date1|| fsdt == '' || tsdt == '' )
    {
        return false;

    }else
        return true;


}

function todays_date()
{
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    if(dd<10){
        dd='0'+dd;
    }
    if(mm<10){
        mm='0'+mm;
    }
    today = dd+'/'+mm+'/'+yyyy;
    return today;
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
function deleteCookie(cname) {
    setCookie(cname,"",-1);
    var d = new Date(); //Create an date object
    d.setTime(d.getTime() - (1000*60*60*24)); //Set the time to the past. 1000 milliseonds = 1 second
    var expires = "expires=" + d.toGMTString(); //Compose the expirartion date
    window.document.cookie = cname+"="+"; "+expires;//Set the cookie with name and the expiration date

}

function IDGenerator() {

    this.length = 8;
    this.timestamp = +new Date;

    var _getRandomInt = function( min, max ) {
        return Math.floor( Math.random() * ( max - min + 1 ) ) + min;
    }

    this.generate = function() {
        var ts = this.timestamp.toString();
        var parts = ts.split( "" ).reverse();
        var id = "";

        for( var i = 0; i < this.length; ++i ) {
            var index = _getRandomInt( 0, parts.length - 1 );
            id += parts[index];
        }

        return id;
    }


}


//###  OTP generation  ###
function JenOTP()
{
    var key = base32tohex($('#secret').val());
    var epoch = Math.round(new Date().getTime() / 1000.0);
    var time = leftpad(dec2hex(Math.floor(epoch / 30)), 16, '0');

    // updated for jsSHA v2.0.0 - http://caligatio.github.io/jsSHA/
    var shaObj = new jsSHA("SHA-1", "HEX");
    shaObj.setHMACKey(key, "HEX");
    shaObj.update(time);
    var hmac = shaObj.getHMAC("HEX");
    if (hmac == 'KEY MUST BE IN BYTE INCREMENTS') {
        $('#hmac').append($('<span/>').addClass('label important').append(hmac));
    } else {
        var offset = hex2dec(hmac.substring(hmac.length - 1));
        var part1 = hmac.substr(0, offset * 2);
        var part2 = hmac.substr(offset * 2, 8);
        var part3 = hmac.substr(offset * 2 + 8, hmac.length - offset);
    }

    var otp = (hex2dec(hmac.substr(offset * 2, 8)) & hex2dec('7fffffff')) + '';
    otp = (otp).substr(otp.length - 6, 6);
    return otp;
}
function dec2hex(s) {
    return (s < 15.5 ? '0' : '') + Math.round(s).toString(16);
}
function hex2dec(s) {
    return parseInt(s, 16);
}


function base32tohex(base32) {
    var base32chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ234567";
    var bits = "";
    var hex = "";

    for (var i = 0; i < base32.length; i++) {
        var val = base32chars.indexOf(base32.charAt(i).toUpperCase());
        bits += leftpad(val.toString(2), 5, '0');
    }

    for (var i = 0; i+4 <= bits.length; i+=4) {
        var chunk = bits.substr(i, 4);
        hex = hex + parseInt(chunk, 2).toString(16) ;
    }
    return hex;

}

function leftpad(str, len, pad) {
    if (len + 1 >= str.length) {
        str = Array(len + 1 - str.length).join(pad) + str;
    }
    return str;
}
var page_movment = {
    level_cnt : 0,
    page : new Array()
}


function call_back(changemode,hashmode)
{
    var page='';
    if(changemode=='')
    {
        changemode="flip";
    }
    if(page_movment.level_cnt>=1)
    {
        
        clearInterval(starttime);
      
        clearTimeout(starttime);
        starttime = 0;
        page=page_movment.page[page_movment.level_cnt];
        // alert(page);
        page_movment.level_cnt=page_movment.level_cnt-1;
        if(hashmode=='')
            hashmode=true;
        $.mobile.changePage(page, {
            transition: changemode,
            changeHash: hashmode
        });
    }
}


function Call_Pagechange(page,changemode,hashmode,callfrom)
{
    page_movment.level_cnt=page_movment.level_cnt+1;
    page_movment.page[page_movment.level_cnt]=callfrom;

    //page_movment.page.push(callfrom);
   
    clearInterval(starttime);
     
    clearTimeout(starttime);
    starttime =0;
    if(changemode=='')
    {
        changemode="flip";
    }
    if(hashmode=='')
        hashmode=true;
    $.mobile.changePage(page, {
        transition: changemode,
        changeHash: hashmode
    });
}

function Mycesclogout(level)
{
    // alert(level);
    window.localStorage.removeItem("mpin");
    if(level==1)
        window.location='../index.html';
    else
        window.location='index.html';

}

/*HINT: createHeaderMenuFooter();
    Parameters: Page layer, Header div id, Menu div id, Footer div id
*/
function createHeaderMenuFooter(page_layer, header_id, menu_id, footer_id){
    var headerHtml = '';
    var menuHtml   = '';
    var footerHtml = '';
    
    var headerDiv_id = '';
    var menuDiv_id   = '';
    var footerDiv_id = '';
    
    headerDiv_id = "#"+header_id;
    menuDiv_id   = "#"+menu_id;
    footerDiv_id = "#"+footer_id;
    
    if(page_layer == 1){
        //## Header Html
        headerHtml = headerHtml+'<a href="#nav-panel" data-icon="bars" data-iconpos="notext" data-role="none" class="my_menu_line ui-btn-left"><i class="fa fa-bars"></i></a>';
        headerHtml = headerHtml+'<h2 class="ui-title" role="heading" aria-level="1">';
        headerHtml = headerHtml+'<img src="../assets/images/Logo.png">';
        headerHtml = headerHtml+'</h2>';
        //-----------------
        
        //## Menu Html
        menuHtml = menuHtml+'<li class="menuProfile">';
        menuHtml = menuHtml+'<div class="col-xs-12 padding0 imgProfile">';
        menuHtml = menuHtml+'<img src="../assets/images/emp_icon.png" id="img_take">';
        menuHtml = menuHtml+'</div>';
        menuHtml = menuHtml+'<div class="col-xs-12 padding0">';
        menuHtml = menuHtml+'<label class="lblHello pt5" id="helloNameInMenu"></label>';
        menuHtml = menuHtml+'<label class="lblLastLogin pt5" style="display:none" >Last Login - 11:27 AM, 13 Jun 18</label>';
        menuHtml = menuHtml+'</div>';
        menuHtml = menuHtml+'</li>';
        menuHtml = menuHtml+'<li><a href="../dashboard.html" data-transition="flip" data-role="none"><img src="../assets/images/menu_home.png"> Home</a></li>';
        menuHtml = menuHtml+'<li><a href="#" onclick="Call_Pagechange(\'../operational/submenu_operational.html\',\'\',\'\',\'../dashboard.html\');"><img src="../assets/images/menu_operational.png"> Operational Parameters</a></li>';
        menuHtml = menuHtml+'<li><a href="#" onclick="Call_Pagechange(\'../hrms/submenu_hrms.html\',\'\',\'\',\'../dashboard.html\');"><img src="../assets/images/menu_employee.png"> Employee Self - Service</a></li>';
        menuHtml = menuHtml+'<li><a href="#" onclick="Call_Pagechange(\'../travel/submenu_travel.html\',\'\',\'\',\'../dashboard.html\');"><img src="../assets/images/menu_travel.png"> Travel Management</a></li>';
        menuHtml = menuHtml+'<li><a href="#" onclick="Call_Pagechange(\'../guest_house/gh_home.html\',\'\',\'\',\'../dashboard.html\');"><img src="../assets/images/menu_guest_house.png"> Guest House Booking</a></li>';
        menuHtml = menuHtml+'<li><a href="#" onclick="Call_Pagechange(\'../medical/submenu_medical.html\',\'\',\'\',\'../dashboard.html\');"><img src="../assets/images/menu_medical.png"> Medical Information</a></li>';
        menuHtml = menuHtml+'<li><a href="#" onclick="Call_Pagechange(\'../helpdesk/submenu_helpdesk.html\',\'\',\'\',\'../dashboard.html\');"><img src="../assets/images/menu_ithelp.png"> IT Help Desk</a></li>';
        //  menuHtml = menuHtml+'<li><a href="#" style="color:red;"><img src="../assets/images/menu_logout.png" > Logout</a></li>';
        menuHtml = menuHtml+"<li><a href=\"#\" onclick=\"Mycesclogout('1');\"  style=\"color:red;\"><img src=\"../assets/images/menu_logout.png\" > Logout</a></li>";

        //-----------------
        
        //## Footer Html
        //footerHtml = footerHtml+'<a href="#" onclick="call_back(\'\',\'\')" data-icon="bars" data-iconpos="notext" data-role="none" data-transition="flip">';
        //footerHtml = footerHtml+'<i class="fa fa-angle-left fa-2x back" aria-hidden="true"></i>';
        //footerHtml = footerHtml+'</a>';
        footerHtml = footerHtml+'<h4 class="ui-title" role="heading" aria-level="1">Copyright &#169; 2018 Corporate Information Systems</h4>';
    //-----------------
        
    } else {
        //## Header Html
        headerHtml = headerHtml+'<a href="#nav-panel" data-icon="bars" data-iconpos="notext" data-role="none" class="my_menu_line ui-btn-left"><i class="fa fa-bars"></i></a>';
        headerHtml = headerHtml+'<h2 class="ui-title" role="heading" aria-level="1">';
        headerHtml = headerHtml+'<img src="assets/images/Logo.png">';
        headerHtml = headerHtml+'</h2>';
        //-----------------
        
        //## Menu Html
        menuHtml = menuHtml+'<li class="menuProfile">';
        menuHtml = menuHtml+'<div class="col-xs-12 padding0 imgProfile">';
        menuHtml = menuHtml+'<img src="assets/images/emp_icon.png" id="img_take">';
        menuHtml = menuHtml+'</div>';
        menuHtml = menuHtml+'<div class="col-xs-12 padding0">';
        menuHtml = menuHtml+'<label class="lblHello pt5" id="helloNameInMenu"></label>';
        menuHtml = menuHtml+'<label class="lblLastLogin pt5"  style="display:none" >Last Login - 11:27 AM, 13 Jun 18</label>';
        menuHtml = menuHtml+'</div>';
        menuHtml = menuHtml+'</li>';
        menuHtml = menuHtml+'<li><a href="dashboard.html" data-transition="flip" data-role="none"><img src="assets/images/menu_home.png"> Home</a></li>';
        menuHtml = menuHtml+'<li><a href="#" onclick="Call_Pagechange(\'operational/submenu_operational.html\',\'\',\'\',\'../dashboard.html\');"><img src="assets/images/menu_operational.png"> Operational Parameters</a></li>';
        menuHtml = menuHtml+'<li><a href="#" onclick="Call_Pagechange(\'hrms/submenu_hrms.html\',\'\',\'\',\'../dashboard.html\');"><img src="assets/images/menu_employee.png"> Employee Self - Service</a></li>';
        menuHtml = menuHtml+'<li><a href="#" onclick="Call_Pagechange(\'travel/submenu_travel.html\',\'\',\'\',\'../dashboard.html\');"><img src="assets/images/menu_travel.png"> Travel Management</a></li>';
        menuHtml = menuHtml+'<li><a href="#" onclick="Call_Pagechange(\'guest_house/gh_home.html\',\'\',\'\',\'../dashboard.html\');"><img src="assets/images/menu_guest_house.png"> Guest House Booking</a></li>';
        menuHtml = menuHtml+'<li><a href="#" onclick="Call_Pagechange(\'medical/submenu_medical.html\',\'\',\'\',\'../dashboard.html\');"><img src="assets/images/menu_medical.png"> Medical Information</a></li>';
        menuHtml = menuHtml+'<li><a href="#" onclick="Call_Pagechange(\'helpdesk/submenu_helpdesk.html\',\'\',\'\',\'../dashboard.html\');"><img src="assets/images/menu_ithelp.png"> IT Help Desk</a></li>';
        //  menuHtml = menuHtml+'<li><a href="#"  style="color:red;"><img src="assets/images/menu_logout.png"> Logout</a></li>';
        menuHtml = menuHtml+"<li><a href=\"#\" onclick=\"Mycesclogout('0');\"  style=\"color:red;\"><img src=\"assets/images/menu_logout.png\" > Logout</a></li>";

        //-----------------
        
        //## Footer Html
        //footerHtml = footerHtml+'<h4 class="ui-title" role="heading" aria-level="1">Corporate Information Systems - <img src="assets/images/icon_phone.png" width="15"> 9903082391</h4>';
        footerHtml = footerHtml+'<h4 class="ui-title" role="heading" aria-level="1">Copyright &#169; 2018 Corporate Information Systems</h4>';
    //-----------------
    }
    
    // Place header html inside the header div id
    $(headerDiv_id).html(headerHtml); 
    //-------------------------------------------
    
    // Place menu html inside the menu div id
    $(menuDiv_id).html(menuHtml);       
    $(menuDiv_id).listview({
        filter: true
    }).listview('refresh');
   
    var emp_code = window.localStorage.getItem("emp_code");
    //  alert(emp_code);
    var imageSrc = webserver+"/Mycescapplogic/json/mysqlimageview.php?emp_code="+emp_code;
    $("#img_take").attr('src', imageSrc);
    var emp_name = window.localStorage.getItem("emp_name");
    $("#login_name").html(' Welcome '+emp_name.toLowerCase());
    $("#helloNameInMenu").html(' Hello '+emp_name.toLowerCase());
    //---------------------
    
    // Place footer html inside the footer div id
    $(footerDiv_id).html(footerHtml);   
//------------------------------
    
}
