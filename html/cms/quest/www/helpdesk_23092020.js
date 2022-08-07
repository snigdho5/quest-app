/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var helpdeskserver = 'https://access.cesc.co.in/gendesk_api/';

function getCategory() {
    var url = helpdeskserver + "category.php";
    //  var url = 'http://10.50.81.45/corpdesk_api/category.php';

    try {
        var myObjdata = '';
        // alert(url);
        $.get(url, {
            data_type: ''
        }, function (data) {
            //console.log(data);
            var myObj = JSON.parse(data);
            //var myObj = data['data'];
           // alert(myObj.data.length);
            var innerhtml = '<option value="">- Select -</option>';
            /*$.each(myObj.data, function (key, value) {
                alert(myObj.data[key].id);
                myObjdata = myObj[key];
                innerhtml = innerhtml + '<option value=' + myObjdata['id'] + '>' + myObjdata['category'] + '</option>';
            });*/
            for (var i = 0, len = myObj.data.length; i < len; i++) {
             //   console.log(data[i]);
             innerhtml = innerhtml + '<option value=' + myObj.data[i].id + '>' + myObj.data[i].category  + '</option>';
            }

            $('#category').html(innerhtml);
            // console.log(innerhtml);
            /* setTimeout(function () {
                 $.mobile.loading('hide');
             }, 300);*/
        });

    }
    catch (e) {
    }
}
function getCategoryEscalate() {
    var url = helpdeskserver + "category_escalate.php";
    //  var url = 'http://10.50.81.45/corpdesk_api/category.php';

    try {
        var myObjdata = '';
        // alert(url);
        $.get(url, {
            data_type: ''
        }, function (data) {
            //console.log(data);
            var myObj = JSON.parse(data);
            //var myObj = data['data'];
           // alert(myObj.data.length);
            var innerhtml = '<option value="">- Select -</option>';
            /*$.each(myObj.data, function (key, value) {
                alert(myObj.data[key].id);
                myObjdata = myObj[key];
                innerhtml = innerhtml + '<option value=' + myObjdata['id'] + '>' + myObjdata['category'] + '</option>';
            });*/
            for (var i = 0, len = myObj.data.length; i < len; i++) {
             //   console.log(data[i]);
             innerhtml = innerhtml + '<option value=' + myObj.data[i].id + '>' + myObj.data[i].category  + '</option>';
            }

            $('#category').html(innerhtml);
            // console.log(innerhtml);
            /* setTimeout(function () {
                 $.mobile.loading('hide');
             }, 300);*/
        });

    }
    catch (e) {
    }
}

function otherCategory() {
    var category = $("#category").val();
    //alert(category);
    if (category == '5' || category == '9') {
        $("#div_othcat").show();
    }
    else {
        $("#other_category").val("");
        $("#div_othcat").hide();
    }
}

function getLocation() {
    var url = helpdeskserver + "location.php";
    //var url = 'http://10.50.81.45/corpdesk_api/location.php';
    try {
        var myObjdata = '';
        // alert(url);
        $.get(url, {
            data_type: ''
        }, function (data) {
            //console.log(data);
          //  var myObj = data['data'];
           var myObj = JSON.parse(data);
            var innerhtml = '<option value="">- Select -</option>';
          /*  $.each(myObj, function (key, value) {
                myObjdata = myObj[key];
                innerhtml = innerhtml + '<option value=' + myObjdata['location_id'] + '>' + myObjdata['location'] + '</option>';
            });*/
            for (var i = 0, len = myObj.data.length; i < len; i++) {
                //   console.log(data[i]);
                innerhtml = innerhtml + '<option value=' + myObj.data[i].location_id + '>' + myObj.data[i].location  + '</option>';
               }
            $('#location').html(innerhtml);
            // console.log(innerhtml);
            /* setTimeout(function () {
                 $.mobile.loading('hide');
             }, 300);*/
        });

    }
    catch (e) {
    }
}


function newTicket() {

    var user_id = $("#user_id").val();
    var subject = $("#subject").val();
    //var desc            = $("#desc").val();
    // var priority = $("#priority").val();
    var category = $("#category").val();
    var other_category = $("#other_category").val();
    var location = $("#location").val();
    var mobile = $("#mobile").val();
    var intercom = $("#intercom").val();


    /* if (desc.search(/\S/) == -1) {
         alert('Please give description');
         $("#desc").focus();
         return false;
     }
 
     if (priority == '') {
         alert('Please select priority');
         $("#priority").focus();
         return false;
     }*/

    if (category == '') {
        alert('Please select category');
        $("#category").focus();
        return false;
    }
    if (category == '5') {
        if (other_category == '') {
            alert('Please give other category');
            $("#other_category").focus();
            return false;
        }
    }

    if (location == '') {
        alert('Please select your location');
        $("#location").focus();
        return false;
    }

    if (mobile == '' && intercom == '') {
        alert('Please give either your mobile no. or intercom');
        $("#mobile").focus();
        return false;
    }

    if (mobile != '') {
        if (mobile.length != 10) {
            alert('Please give valid mobile no.');
            $("#mobile").focus();
            return false;
        }
        for (i = 0; i < mobile.length; i++)
        {   
        // Check that current character is number.
        var c = mobile.charAt(i);
        if (((c < "0") || (c > "9")))
        {
        alert("Only numeric values are allowed for mobile no.");
        $("#mobile").focus();    
        return false;   
        } 
        
    }
    }
    if (intercom != '') {
        if (intercom.length != 5) {
            alert('Please give valid intercom.');
            $("#intercom").focus();
            return false;
        }
        for (i = 0; i < intercom.length; i++)
        {   
        // Check that current character is number.
        var c = intercom.charAt(i);
        if (((c < "0") || (c > "9")))
        {
        alert("Only numeric values are allowed intercom");
        $("#intercom").focus();    
        return false;   
        } 
        
    }
    }

    if (subject == '') {
        alert('Please give subject');
        $("#subject").focus();
        return false;
    }
    

    if (subject.length > 130) {
        alert('Please give subject with in 130 characters');
        $("#subject").focus();
        return false;
    }


    if (subject != '' && category != '' && location != '' && mobile != '') {
        try {
            var url =helpdeskserver+"complaint_general.php";
            //var url = "http://10.50.81.45/corpdesk_api/complaint_general.php";
            //  alert(url);
            $.post(url, {
                subject: encodeURI(subject),
                //priority: priority,
                category: category,
                other_category: encodeURI(other_category),
                user_id: user_id,
                mode: 'APP',
                location: location,
                mobile: mobile,
                intercom: intercom
            },
                function (data) {
                    //  alert(data);
                    console.log(data);
                    //alert("Success");
                    var myObj = JSON.parse(data);
                    // alert(myObj.docket_no);
                    // alert(myObj.status);
                    //$("#loader_slider").hide();
                    //alert(myObj.staff_id);
                    if (myObj.status == 'Success') {
                        $("#detaildiv").hide();
                        $("#thanks_msg").show();
                        var innerHtml = '';
                        innerHtml = innerHtml + '<div class="col-xs-12 text-center bg-info" id="thanks_msg">';
                        innerHtml = innerHtml + '<p>Your complaint has been registered successfully</p>';
                        innerHtml = innerHtml + '<p>Docket Number is: ' + myObj.docket_no + '</p><br/>';
                        innerHtml = innerHtml + '<p>Your docket has been assigned to ' + myObj.staff_name + '.</p>';
                        innerHtml = innerHtml + '<p><img src=img/' + myObj.image_code + "></img></p>";
                        innerHtml = innerHtml + '<p>Contact No. : ' + myObj.staff_mobile + '</p>';
						innerHtml = innerHtml + '<center><a href="new_ticket.html" class="btn btn-primary pull-right">Back</a></center>';
                        innerHtml = innerHtml + '</div>';
                        $("#thanks_msg").html(innerHtml);
                    } else {
                        $("#alert").show();
                        var innerHtml = '';
                        innerHtml = innerHtml + '<div class="col-xs-12 text-center bg-danger" id="thanks_msg">';
                        innerHtml = innerHtml + '<p>Failure, please try again...</p>';
                        innerHtml = innerHtml + '</div>';
                        $("#alert").html(innerHtml);
                    }
                });
        }
        catch (e) {
            alert(e);
        }

        //  return true;
    }

}
/*function login_chk() {
    //  alert("Login Test");
    var email = $("#email").val();
    //var desc            = $("#desc").val();
    var password = $("#password").val();

    if (email == '') {
        alert('Please give Email ID');
        $("#email").focus();
        return false;
    }

    if (password == '') {
        alert('Please give your email password');
        $("#password").focus();
        return false;
    }
    
	$("#please_wait").show();
    try {
        //var url =webserver+"/Mycescapplogic/helpdesk/complaint_general.php";
        var url = "http://cescintranet/helpdesk/PHPMailer_v2.0.4/examples/test_gmail_auth.php";
        //  alert(url);
        $.post(url, {
            email: email,
            password: password
        },
            function (data) {
                // alert(data);
                console.log(data);
                //alert("Success");
                var myObj = JSON.parse(data);
                // alert(myObj.status);

                if (myObj.status == 'Success') {
                    window.localStorage.setItem("glb_val", myObj.email);
                    window.location = "new_ticket.html";

                } else {
                    $("#alert").show();
                    var innerHtml = '';
                    innerHtml = innerHtml + '<div class="col-xs-12 text-center bg-danger" id="thanks_msg">';
                    innerHtml = innerHtml + '<p>Failure, please try again...</p>';
                    innerHtml = innerHtml + '</div>';
                    $("#alert").html(innerHtml);
					$("#please_wait").hide();
                }
            });
    }
    catch (e) {
        alert(e);
    }
    
    //  return true;
	
    //*************To be removed later***************** 
    $("#please_wait").show();
    window.localStorage.setItem("glb_val", email);
    window.location = "new_ticket.html";
    //****************************** 
}*/

function login_chk() {
     // alert("Login Test");
    var email = $("#email").val();
    //var desc            = $("#desc").val();
    var password = $("#password").val();

    var domain = email.split('@');

    if (email == '') {
        alert('Please give Email ID');
        $("#email").focus();
        return false;
    }


    if (email != '') {
        if (domain[1] != 'rp-sg.in' && domain[1] != 'rpsg.in')
        {
            alert('Please give your corporate email ID');
            $("#email").focus();
            return false;
        }

    }


    if (password == '') {
        alert('Please give your email password');
        $("#password").focus();
        return false;
    }

    $("#please_wait").show();
    try {
        //var url =webserver+"/Mycescapplogic/helpdesk/complaint_general.php";
        // var url = "http://cescintranet/helpdesk/PHPMailer_v2.0.4/examples/test_gmail_auth.php";
        //var url = "https://10.40.4.38/corpdesk/www/PHPMailer_v2.0.4/examples/curl_test.php";
        var url = "http://access.cesc.co.in/gendesk/www/PHPMailer_v2.0.4/examples/curl_test.php";
        //alert(url);
        $.get(url, {
            email: email,
            password: password
        },
                function (data) {
                    //alert(data);
                    //console.log(data);
                    // alert("Success");
                    var myObj = JSON.parse(data);
                    // alert(myObj.status);

                    if (myObj.status == 'Success') {
                        window.localStorage.setItem("glb_val", myObj.email);
                        window.location = "new_ticket.html";

                    } else {
                        $("#alert").show();
                        var innerHtml = '';
                        innerHtml = innerHtml + '<div class="col-xs-12 text-center bg-danger" id="thanks_msg">';
                        innerHtml = innerHtml + '<p>Failure, please try again...</p>';
                        innerHtml = innerHtml + '</div>';
                        $("#alert").html(innerHtml);
                        $("#please_wait").hide();
                    }
                });
    } catch (e) {
        alert(e);
    }

    //  return true;

    //*************To be removed later***************** */
     /*$("#please_wait").show();
     window.localStorage.setItem("glb_val", email);
     window.location = "new_ticket.html";*/
    //****************************** 
}


/*function getDocketDetails(docket) {
    var url = helpdeskserver + "docketDetails/" + docket;

    try {
        var myObjdata = '';
        // alert(url);
        $.get(url, {
            data_type: ''
        }, function (data) {
            //console.log(data);
            // alert(data)
            var myObj = data['data'];
            var innerHtml = '';
            $.each(myObj, function (key, value) {
                myObjdata = myObj[key];
                // alert(myObjdata['staff_id']);
                // alert(myObjdata['solution']);
                innerHtml = '<div class="panel panel-default"><div class="panel-body"><div class="content" ><h2 class="header">' + myObjdata['subject'] + '<span class="pull-right"><a href="#" class="btn btn-info deleteit" form="delete-ticket-1" onclick="window.history.back();">Back</a></form></span></h2>';
                innerHtml = innerHtml + '<div class="panel well well-sm"><div class="panel-body"><div class="col-md-12" ><div class="col-md-6"><p> <strong>Docket No.</strong>: ';
                innerHtml = innerHtml + myObjdata['docket_no'] + '</p>';
                innerHtml = innerHtml + '<p><strong>Status</strong>: ' + '<span style="color: #15a000">' + myObjdata['status_desc'] + '</span></p></div>';
                innerHtml = innerHtml + '<div class="col-md-6"><p> <strong>Responsible</strong>: ' + myObjdata['staff_id'] + '</p>';
                innerHtml = innerHtml + '<p><strong>Category</strong>: <span style="color: #0014f4">' + myObjdata['category_desc'] + '</span></p>';
                innerHtml = innerHtml + '<p> <strong>Created</strong>: ' + myObjdata['comp_datetime'] + '</p></div></div></div></div></div><form method="POST" action="http://ticketit.kordy.info/tickets/1" accept-charset="UTF-8" id="delete-ticket-1"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="2F5Y00q3whqlw8elHxj8iU2aPB3HCXCwc2elVUfg"></form></div></div>';
                if (myObjdata['solution'] != null) {
                    innerHtml = innerHtml + '<h2>Comments</h2><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title">'
                    innerHtml = innerHtml + myObjdata['staff_id'];
                    innerHtml = innerHtml + '<span class="pull-right">' + myObjdata['solution_time'] + '</span></h3></div><div class="panel-body"><div class="content">';
                    innerHtml = innerHtml + '<p>' + myObjdata['solution'] + '</p>';
                    innerHtml = innerHtml + ' </div></div></div><div id="feedback_msg"><div class="panel panel-default"></div><div class="panel-body"><form method="POST" action="http://ticketit.kordy.info/tickets-comment" accept-charset="UTF-8" class="form-horizontal"><input name="_token" type="hidden" value="2F5Y00q3whqlw8elHxj8iU2aPB3HCXCwc2elVUfg">';
                    innerHtml = innerHtml + ' <input name="ticket_id" type="hidden" value="1"><fieldset><legend>Your Feedback</legend>';
                    innerHtml = innerHtml + '<div class="form-group"><div class="col-lg-12">';
                    innerHtml = innerHtml + '<textarea class="form-control" rows="3" name="feedback" id="feedback" cols="50"></textarea></div></div><div class="text-right col-md-12"><input class="btn btn-primary" type="button" onClick="insertFeedback(' + myObjdata['docket_no'] + ')" value="Submit"></div></fieldset></form></div></div>';
                    //innerHtml = innerHtml + '<div id="feedback_msg"></div>';
                }

            });
            $('#docket_details').html(innerHtml);
            $("#docket_details").show();
            // console.log(innerhtml);
            
        });

    }
    catch (e) {
    }
}*/

function getDocketDetails(docket) {
    var url = helpdeskserver + "docket_details.php";
 //var url = 'http://10.50.81.45/corpdesk_api/docket_details.php';

    try {
        var myObjdata = '';
        // alert(url);
        $.post(url, {
            docket: docket,
        }, function (data) {
            //console.log(data);
            // alert(data)
            //var myObj = data['data'];
            var myObj = JSON.parse(data);
            var innerHtml = '';
          //  for (var i = 0, len = myObj.data.length; i < len; i++) {
              //  alert(myObj.data[0].docket_no);
           // $.each(myObj, function (key, value) {
             //   myObjdata = myObj[key];
                // alert(myObjdata['staff_id']);
                // alert(myObjdata['solution']);
                //alert(myObjdata['status_desc']);
                innerHtml = '<div class="panel panel-default"><div class="panel-body"><div class="content" ><h2 class="header">' + myObj.data[0].subject + '<span class="pull-right"><a href="#" class="btn btn-info deleteit" form="delete-ticket-1" onclick="window.history.back();">Back</a></form></span></h2>';
                innerHtml = innerHtml + '<div class="panel well well-sm"><div class="panel-body"><div class="col-md-12" ><div class="col-md-6"><p> <strong>Docket No.</strong>: ';
                innerHtml = innerHtml + myObj.data[0].docket_no+ '</p>';
                innerHtml = innerHtml + '<p><strong>Status</strong>: ' + '<span style="color: #15a000">' + myObj.data[0].status_desc + '</span></p></div>';
                innerHtml = innerHtml + '<div class="col-md-6"><p> <strong>Responsible</strong>: ' + myObj.data[0].staff_id + '</p>';
                innerHtml = innerHtml + '<p><strong>Category</strong>: <span style="color: #0014f4">' + myObj.data[0].category_desc + '</span></p>';
                innerHtml = innerHtml + '<p> <strong>Created</strong>: ' + myObj.data[0].comp_datetime + '</p></div></div></div></div></div><form method="POST" action="http://ticketit.kordy.info/tickets/1" accept-charset="UTF-8" id="delete-ticket-1"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="2F5Y00q3whqlw8elHxj8iU2aPB3HCXCwc2elVUfg"></form></div></div>';
                /*if (myObj.data[0].solution != null) {
                    innerHtml = innerHtml + '<h2>Comments</h2><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title">'
                    innerHtml = innerHtml + myObj.data[0].staff_id;
                    innerHtml = innerHtml + '<span class="pull-right">' + myObj.data[0].solution_time + '</span></h3></div><div class="panel-body"><div class="content">';
                    innerHtml = innerHtml + '<p>' + myObj.data[0].solution + '</p>';
                    innerHtml = innerHtml + ' </div></div></div><div id="feedback_msg"><div class="panel panel-default"></div><div class="panel-body"><form method="POST" action="http://ticketit.kordy.info/tickets-comment" accept-charset="UTF-8" class="form-horizontal"><input name="_token" type="hidden" value="2F5Y00q3whqlw8elHxj8iU2aPB3HCXCwc2elVUfg">';
                    if(myObj.data[0].status_desc == 'Open')
                    {
                        innerHtml = innerHtml + '<input name="ticket_id" type="hidden" value="1"><fieldset><legend>Your Feedback</legend>';
                        innerHtml = innerHtml + '<div class="form-group"><div class="col-lg-12">';
                        innerHtml = innerHtml + '<textarea class="form-control" rows="3" name="feedback" id="feedback" cols="50"></textarea></div></div><div class="text-right col-md-12"><input class="btn btn-primary" type="button" onClick="insertFeedback(' + myObj.data[0].docket_no + ')" value="Submit"></div></fieldset></form></div></div>';
                    }
                    if((myObj.data[0].status_desc == 'Addressed') && myObj.data[0].feedback == null)
                    {
                        innerHtml = innerHtml + ' <input name="ticket_id" type="hidden" value="1"><fieldset><legend>Your Feedback</legend>';
                        innerHtml = innerHtml + '<div class="form-group"><div class="col-lg-12">';
                      //  innerHtml = innerHtml + '<textarea class="form-control" rows="3" name="feedback" id="feedback" cols="50">'+myObjdata['feedback']+'</textarea></div></div></fieldset></form></div></div>';
                      //  innerHtml = innerHtml + '<textarea class="form-control" rows="3" name="feedback" id="feedback" cols="50"></textarea></div></div><div class="text-right col-md-12"><input class="btn btn-primary" type="button" onClick="insertFeedback(' + myObj.data[0].docket_no + ')" value="Submit"></div></fieldset></form></div></div>';
                        innerHtml = innerHtml + '<input type="radio" id="r1" name="feedback" value="2"> Solved &nbsp;&nbsp;<input type="radio" id="r2" name="feedback" value="4"> Not Solved</div></div><div class="text-right col-md-12"><input class="btn btn-primary" type="button" onClick="insertFeedback(' + myObj.data[0].docket_no + ')" value="Submit"></div></fieldset></form></div></div>';
                    }
                    if(myObj.data[0].feedback != null)
                    {
                        innerHtml = innerHtml + ' <input name="ticket_id" type="hidden" value="1"><fieldset><legend>Your Feedback</legend>';
                        innerHtml = innerHtml + '<div class="form-group"><div class="col-lg-12">';
                        innerHtml = innerHtml + '<textarea class="form-control" rows="3" name="feedback" id="feedback" cols="50">'+myObj.data[0].feedback+'</textarea></div></div></fieldset></form></div></div>';
                    }
                    //innerHtml = innerHtml + '<div id="feedback_msg"></div>';
               // }

          //  });
            }*/
            $('#docket_details').html(innerHtml);
            $("#docket_details").show();
            // console.log(innerhtml);
            /* setTimeout(function () {
                 $.mobile.loading('hide');
             }, 300);*/
        });

    }
    catch (e) {
    }

     var url = helpdeskserver + "solution_details.php";
 //var url = 'http://10.50.81.45/corpdesk_api/docket_details.php';

    try {
        var myObjdata = '';
        // alert(url);
        $.post(url, {
            docket: docket,
        }, function (data) {
            //console.log(data);
            // alert(data)
            //var myObj = data['data'];
            var myObj = JSON.parse(data);
            var innerHtml = '';
            for (var i = 0, len = myObj.data.length; i < len; i++) {
              //  alert(myObj.data[0].docket_no);
           // $.each(myObj, function (key, value) {
             //   myObjdata = myObj[key];
                // alert(myObjdata['staff_id']);
                // alert(myObjdata['solution']);
                //alert(myObjdata['status_desc']);
                /*innerHtml = '<div class="panel panel-default"><div class="panel-body"><div class="content" ><h2 class="header">' + myObj.data[0].subject + '<span class="pull-right"><a href="#" class="btn btn-info deleteit" form="delete-ticket-1" onclick="window.history.back();">Back</a></form></span></h2>';
                innerHtml = innerHtml + '<div class="panel well well-sm"><div class="panel-body"><div class="col-md-12" ><div class="col-md-6"><p> <strong>Docket No.</strong>: ';
                innerHtml = innerHtml + myObj.data[0].docket_no+ '</p>';
                innerHtml = innerHtml + '<p><strong>Status</strong>: ' + '<span style="color: #15a000">' + myObj.data[0].status_desc + '</span></p></div>';
                innerHtml = innerHtml + '<div class="col-md-6"><p> <strong>Responsible</strong>: ' + myObj.data[0].staff_id + '</p>';
                innerHtml = innerHtml + '<p><strong>Category</strong>: <span style="color: #0014f4">' + myObj.data[0].category_desc + '</span></p>';
                innerHtml = innerHtml + '<p> <strong>Created</strong>: ' + myObj.data[0].comp_datetime + '</p></div></div></div></div></div><form method="POST" action="http://ticketit.kordy.info/tickets/1" accept-charset="UTF-8" id="delete-ticket-1"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="2F5Y00q3whqlw8elHxj8iU2aPB3HCXCwc2elVUfg"></form></div></div>';*/
                if (myObj.data[i].solution != null) {
                    innerHtml = innerHtml + '<h2>Comments</h2><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title">'
                    innerHtml = innerHtml + myObj.data[i].staff_id;
                    innerHtml = innerHtml + '<span class="pull-right">' + myObj.data[i].solution_time + '</span></h3></div><div class="panel-body"><div class="content">';
                    innerHtml = innerHtml + '<p>' + myObj.data[i].solution + '</p>';
                    innerHtml = innerHtml + ' </div></div></div><div id="feedback_msg"><div class="panel panel-default"></div><div class="panel-body"><form method="POST" action="http://ticketit.kordy.info/tickets-comment" accept-charset="UTF-8" class="form-horizontal"><input name="_token" type="hidden" value="2F5Y00q3whqlw8elHxj8iU2aPB3HCXCwc2elVUfg">';
                    if(myObj.data[i].status == '1')
                    {
                        innerHtml = innerHtml + '<input name="ticket_id" type="hidden" value="1"><fieldset><legend>Your Feedback</legend>';
                        innerHtml = innerHtml + '<div class="form-group"><div class="col-lg-12">';
                        innerHtml = innerHtml + '<textarea class="form-control" rows="3" name="feedback" id="feedback" cols="50"></textarea></div></div><div class="text-right col-md-12"><input class="btn btn-primary" type="button" onClick="insertFeedback(' + docket + ')" value="Submit"></div></fieldset></form></div></div>';
                    }
                    if(myObj.data[0].feedback != null)
                    {
                        innerHtml = innerHtml + ' <input name="ticket_id" type="hidden" value="1"><fieldset><legend>Your Feedback</legend>';
                        innerHtml = innerHtml + '<div class="form-group"><div class="col-lg-12">';
                        innerHtml = innerHtml + '<textarea class="form-control" rows="3" name="feedback" id="feedback" cols="50">'+myObj.data[0].feedback+'</textarea></div></div></fieldset></form></div></div>';
                    }
                    //innerHtml = innerHtml + '<div id="feedback_msg"></div>';
                }

          //  });
            }

                    if(((myObj.data[0].status == '3') || (myObj.data[0].status == '5')) && myObj.data[0].feedback == null)
                    {
                        innerHtml = innerHtml + ' <input name="ticket_id" type="hidden" value="1"><fieldset><legend>Your Feedback</legend>';
                        innerHtml = innerHtml + '<div class="form-group"><div class="col-lg-12">';
                      //  innerHtml = innerHtml + '<textarea class="form-control" rows="3" name="feedback" id="feedback" cols="50">'+myObjdata['feedback']+'</textarea></div></div></fieldset></form></div></div>';
                      //  innerHtml = innerHtml + '<textarea class="form-control" rows="3" name="feedback" id="feedback" cols="50"></textarea></div></div><div class="text-right col-md-12"><input class="btn btn-primary" type="button" onClick="insertFeedback(' + myObj.data[0].docket_no + ')" value="Submit"></div></fieldset></form></div></div>';
                        innerHtml = innerHtml + '<input type="radio" id="r1" name="feedback" value="2"> Solved &nbsp;&nbsp;<input type="radio" id="r2" name="feedback" value="4"> Not Solved</div></div><div class="text-right col-md-12"><input class="btn btn-primary" type="button" onClick="insertFeedback(' + docket + ')" value="Submit"></div></fieldset></form></div></div>';
                    }
            $('#solution_details').html(innerHtml);
            $("#solution_details").show();
            // console.log(innerhtml);
            /* setTimeout(function () {
                 $.mobile.loading('hide');
             }, 300);*/
        });

    }
    catch (e) {
    }
}

function getPendingDocketDetails(docket) {
    var url = helpdeskserver + "docket_details.php";
 //var url = 'http://10.50.81.45/corpdesk_api/docket_details.php';

    try {
        var myObjdata = '';
        // alert(url);
        $.post(url, {
            docket: docket,
        }, function (data) {
            //console.log(data);
            // alert(data)
            //var myObj = data['data'];
            var myObj = JSON.parse(data);
            var innerHtml = '';
          //  for (var i = 0, len = myObj.data.length; i < len; i++) {
              //  alert(myObj.data[0].docket_no);
           // $.each(myObj, function (key, value) {
             //   myObjdata = myObj[key];
                // alert(myObjdata['staff_id']);
                // alert(myObjdata['solution']);
                //alert(myObjdata['status_desc']);
                innerHtml = '<div class="panel panel-default"><div class="panel-body"><div class="content" ><h2 class="header">' + myObj.data[0].subject + '<span class="pull-right"><a href="#" class="btn btn-info deleteit" form="delete-ticket-1" onclick="window.history.back();">Back</a></form></span></h2>';
                innerHtml = innerHtml + '<div class="panel well well-sm"><div class="panel-body"><div class="col-md-12" ><div class="col-md-6"><p> <strong>Docket No.</strong>: ';
                innerHtml = innerHtml + myObj.data[0].docket_no+ '</p>';
                innerHtml = innerHtml + '<p><strong>Status</strong>: ' + '<span style="color: #15a000">' + myObj.data[0].status_desc + '</span></p></div>';
                innerHtml = innerHtml + '<div class="col-md-6"><p> <strong>Responsible</strong>: ' + myObj.data[0].staff_id + '</p>';
                innerHtml = innerHtml + '<p><strong>Category</strong>: <span style="color: #0014f4">' + myObj.data[0].category_desc + '</span></p>';
                innerHtml = innerHtml + '<p> <strong>Created</strong>: ' + myObj.data[0].comp_datetime + '</p></div></div></div></div></div><form method="POST" action="http://ticketit.kordy.info/tickets/1" accept-charset="UTF-8" id="delete-ticket-1"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="2F5Y00q3whqlw8elHxj8iU2aPB3HCXCwc2elVUfg"></form></div></div>';
                /*if (myObj.data[0].solution != null) {
                    innerHtml = innerHtml + '<h2>Comments</h2><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title">'
                    innerHtml = innerHtml + myObj.data[0].staff_id;
                    innerHtml = innerHtml + '<span class="pull-right">' + myObj.data[0].solution_time + '</span></h3></div><div class="panel-body"><div class="content">';
                    innerHtml = innerHtml + '<p>' + myObj.data[0].solution + '</p>';
                    innerHtml = innerHtml + ' </div></div></div><div id="feedback_msg"><div class="panel panel-default"></div><div class="panel-body"><form method="POST" action="http://ticketit.kordy.info/tickets-comment" accept-charset="UTF-8" class="form-horizontal"><input name="_token" type="hidden" value="2F5Y00q3whqlw8elHxj8iU2aPB3HCXCwc2elVUfg">';
                    if(myObj.data[0].status_desc == 'Open')
                    {
                        innerHtml = innerHtml + '<input name="ticket_id" type="hidden" value="1"><fieldset><legend>Your Feedback</legend>';
                        innerHtml = innerHtml + '<div class="form-group"><div class="col-lg-12">';
                        innerHtml = innerHtml + '<textarea class="form-control" rows="3" name="feedback" id="feedback" cols="50"></textarea></div></div><div class="text-right col-md-12"><input class="btn btn-primary" type="button" onClick="insertFeedback(' + myObj.data[0].docket_no + ')" value="Submit"></div></fieldset></form></div></div>';
                    }
                    if((myObj.data[0].status_desc == 'Addressed') && myObj.data[0].feedback == null)
                    {
                        innerHtml = innerHtml + ' <input name="ticket_id" type="hidden" value="1"><fieldset><legend>Your Feedback</legend>';
                        innerHtml = innerHtml + '<div class="form-group"><div class="col-lg-12">';
                      //  innerHtml = innerHtml + '<textarea class="form-control" rows="3" name="feedback" id="feedback" cols="50">'+myObjdata['feedback']+'</textarea></div></div></fieldset></form></div></div>';
                      //  innerHtml = innerHtml + '<textarea class="form-control" rows="3" name="feedback" id="feedback" cols="50"></textarea></div></div><div class="text-right col-md-12"><input class="btn btn-primary" type="button" onClick="insertFeedback(' + myObj.data[0].docket_no + ')" value="Submit"></div></fieldset></form></div></div>';
                        innerHtml = innerHtml + '<input type="radio" id="r1" name="feedback" value="2"> Solved &nbsp;&nbsp;<input type="radio" id="r2" name="feedback" value="4"> Not Solved</div></div><div class="text-right col-md-12"><input class="btn btn-primary" type="button" onClick="insertFeedback(' + myObj.data[0].docket_no + ')" value="Submit"></div></fieldset></form></div></div>';
                    }
                    if(myObj.data[0].feedback != null)
                    {
                        innerHtml = innerHtml + ' <input name="ticket_id" type="hidden" value="1"><fieldset><legend>Your Feedback</legend>';
                        innerHtml = innerHtml + '<div class="form-group"><div class="col-lg-12">';
                        innerHtml = innerHtml + '<textarea class="form-control" rows="3" name="feedback" id="feedback" cols="50">'+myObj.data[0].feedback+'</textarea></div></div></fieldset></form></div></div>';
                    }
                    //innerHtml = innerHtml + '<div id="feedback_msg"></div>';
               // }

          //  });
            }*/
            $('#docket_details').html(innerHtml);
            $("#docket_details").show();
            // console.log(innerhtml);
            /* setTimeout(function () {
                 $.mobile.loading('hide');
             }, 300);*/
        });

    }
    catch (e) {
    }

     var url = helpdeskserver + "solution_details.php";
 //var url = 'http://10.50.81.45/corpdesk_api/docket_details.php';

    try {
        var myObjdata = '';
        // alert(url);
        $.post(url, {
            docket: docket,
        }, function (data) {
            //console.log(data);
            // alert(data)
            //var myObj = data['data'];
            var myObj = JSON.parse(data);
            var innerHtml = '';
            for (var i = 0, len = myObj.data.length; i < len; i++) {
              //  alert(myObj.data[0].docket_no);
           // $.each(myObj, function (key, value) {
             //   myObjdata = myObj[key];
                // alert(myObjdata['staff_id']);
                // alert(myObjdata['solution']);
                //alert(myObjdata['status_desc']);
                /*innerHtml = '<div class="panel panel-default"><div class="panel-body"><div class="content" ><h2 class="header">' + myObj.data[0].subject + '<span class="pull-right"><a href="#" class="btn btn-info deleteit" form="delete-ticket-1" onclick="window.history.back();">Back</a></form></span></h2>';
                innerHtml = innerHtml + '<div class="panel well well-sm"><div class="panel-body"><div class="col-md-12" ><div class="col-md-6"><p> <strong>Docket No.</strong>: ';
                innerHtml = innerHtml + myObj.data[0].docket_no+ '</p>';
                innerHtml = innerHtml + '<p><strong>Status</strong>: ' + '<span style="color: #15a000">' + myObj.data[0].status_desc + '</span></p></div>';
                innerHtml = innerHtml + '<div class="col-md-6"><p> <strong>Responsible</strong>: ' + myObj.data[0].staff_id + '</p>';
                innerHtml = innerHtml + '<p><strong>Category</strong>: <span style="color: #0014f4">' + myObj.data[0].category_desc + '</span></p>';
                innerHtml = innerHtml + '<p> <strong>Created</strong>: ' + myObj.data[0].comp_datetime + '</p></div></div></div></div></div><form method="POST" action="http://ticketit.kordy.info/tickets/1" accept-charset="UTF-8" id="delete-ticket-1"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="2F5Y00q3whqlw8elHxj8iU2aPB3HCXCwc2elVUfg"></form></div></div>';*/
                if (myObj.data[i].solution != null) {
                    innerHtml = innerHtml + '<h2>Comments</h2><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title">'
                    innerHtml = innerHtml + myObj.data[i].staff_id;
                    innerHtml = innerHtml + '<span class="pull-right">' + myObj.data[i].solution_time + '</span></h3></div><div class="panel-body"><div class="content">';
                    innerHtml = innerHtml + '<p>' + myObj.data[i].solution + '</p>';
                    innerHtml = innerHtml + ' </div></div></div><div id="feedback_msg"><div class="panel panel-default"></div><div class="panel-body"><form method="POST" action="http://ticketit.kordy.info/tickets-comment" accept-charset="UTF-8" class="form-horizontal"><input name="_token" type="hidden" value="2F5Y00q3whqlw8elHxj8iU2aPB3HCXCwc2elVUfg">';
                   /* if(myObj.data[i].status == '1')
                    {
                        innerHtml = innerHtml + '<input name="ticket_id" type="hidden" value="1"><fieldset><legend>Your Feedback</legend>';
                        innerHtml = innerHtml + '<div class="form-group"><div class="col-lg-12">';
                        innerHtml = innerHtml + '<textarea class="form-control" rows="3" name="feedback" id="feedback" cols="50"></textarea></div></div><div class="text-right col-md-12"><input class="btn btn-primary" type="button" onClick="insertFeedback(' + docket + ')" value="Submit"></div></fieldset></form></div></div>';
                    }
                    if(myObj.data[0].feedback != null)
                    {
                        innerHtml = innerHtml + ' <input name="ticket_id" type="hidden" value="1"><fieldset><legend>Your Feedback</legend>';
                        innerHtml = innerHtml + '<div class="form-group"><div class="col-lg-12">';
                        innerHtml = innerHtml + '<textarea class="form-control" rows="3" name="feedback" id="feedback" cols="50">'+myObj.data[0].feedback+'</textarea></div></div></fieldset></form></div></div>';
                    }
                    //innerHtml = innerHtml + '<div id="feedback_msg"></div>';*/
                }

          //  });
            }

                    /*if(((myObj.data[0].status == '3') || (myObj.data[0].status == '5')) && myObj.data[0].feedback == null)
                    {
                        innerHtml = innerHtml + ' <input name="ticket_id" type="hidden" value="1"><fieldset><legend>Your Feedback</legend>';
                        innerHtml = innerHtml + '<div class="form-group"><div class="col-lg-12">';
                      //  innerHtml = innerHtml + '<textarea class="form-control" rows="3" name="feedback" id="feedback" cols="50">'+myObjdata['feedback']+'</textarea></div></div></fieldset></form></div></div>';
                      //  innerHtml = innerHtml + '<textarea class="form-control" rows="3" name="feedback" id="feedback" cols="50"></textarea></div></div><div class="text-right col-md-12"><input class="btn btn-primary" type="button" onClick="insertFeedback(' + myObj.data[0].docket_no + ')" value="Submit"></div></fieldset></form></div></div>';
                        innerHtml = innerHtml + '<input type="radio" id="r1" name="feedback" value="2"> Solved &nbsp;&nbsp;<input type="radio" id="r2" name="feedback" value="4"> Not Solved</div></div><div class="text-right col-md-12"><input class="btn btn-primary" type="button" onClick="insertFeedback(' + docket + ')" value="Submit"></div></fieldset></form></div></div>';
                    }*/
            $('#solution_details').html(innerHtml);
            $("#solution_details").show();
            // console.log(innerhtml);
            /* setTimeout(function () {
                 $.mobile.loading('hide');
             }, 300);*/
        });

    }
    catch (e) {
    }
}

function insertFeedback(docket) {
    //alert(docket);
   /* var feedback = $("#feedback").val();

    if (feedback.search(/\S/) == -1) {
        alert('Please give your feedback');
        $("#feedback").focus();
        return false;
    }*/
    //var feedback = $("#feedback").val();
    if (document.getElementById('r1').checked) {
        feedback = document.getElementById('r1').value;
    }
    if (document.getElementById('r2').checked) {
        feedback = document.getElementById('r2').value;
    }

    if (feedback != '') {
        try {
            var url =helpdeskserver+"insert_feedback.php";
            //var url = 'http://10.50.81.45/corpdesk_api/insert_feedback.php';

            //alert(url);
            $.post(url, {
                docket: docket,
                feedback: encodeURI(feedback)
            },
                function (data) {
                   // alert(data);
                   // console.log(data);
                    //alert("Success");
                    var myObj = JSON.parse(data);
                    // alert(myObj.docket_no);
                    // alert(myObj.status);
                    //$("#loader_slider").hide();
                    //alert(myObj.staff_id);
                    if (myObj.status == 'Success') {
                        $("#feedback_msg").show();
                        var innerHtml = '';
                        innerHtml = innerHtml + '<div class="col-xs-12 text-center bg-info" id="feedback_msg">';
                        innerHtml = innerHtml + '<p>Thank you for your feedback</p>';
                        innerHtml = innerHtml + '</div>';
                        $("#feedback_msg").html(innerHtml);
                    } else {
                        $("#alert").show();
                        var innerHtml = '';
                        innerHtml = innerHtml + '<div class="col-xs-12 text-center bg-danger" id="feedback_msg">';
                        innerHtml = innerHtml + '<p>Failure, please try again...</p>';
                        innerHtml = innerHtml + '</div>';
                        $("#alert").html(innerHtml);
                    }
                });
        }
        catch (e) {
            alert(e);
        }

        //  return true;
    }



}

function getDocketDetailsReply(docket) {
     var url = helpdeskserver + "docket_details.php";
     // getCategory();
      getCategoryEscalate();
    //var url = 'http://10.50.81.45/corpdesk_api/docket_details.php';
    try {
        var myObjdata = '';
        // alert(url);
        $.post(url, {
            docket: docket,
        }, function (data) {
            //console.log(data);
           // var myObj = data['data'];
           var myObj = JSON.parse(data);
            var innerHtml = '';
            var escalateHtml = '';
           // $.each(myObj, function (key, value) {
               // myObjdata = myObj[key];
                // alert(myObjdata['staff_id']);
                // alert(myObjdata['solution']);
                innerHtml = '<div class="panel panel-default"><div class="panel-body"><div class="content" ><h2 class="header">' + myObj.data[0].subject + '<span class="pull-right"><a href="#" class="btn btn-info deleteit" form="delete-ticket-1" onclick="window.history.back();">Back</a></form></span></h2>';
                innerHtml = innerHtml + '<div class="panel well well-sm"><div class="panel-body"><div class="col-md-12" ><div class="col-md-6"><p> <strong>Docket No.</strong>: ';
                innerHtml = innerHtml + myObj.data[0].docket_no + '</p>';
                innerHtml = innerHtml + '<p><strong>Location</strong>: ' + '<span style="color: #FF7733">' + myObj.data[0].location + '</span></p>';
                innerHtml = innerHtml + '<p><strong>Mobile</strong>: ' + '<span style="color: #9B348B">' + myObj.data[0].mobile + '</span></p>';
                innerHtml = innerHtml + '<p><strong>Intercom</strong>: ' + '<span style="color: #22CC8B">' + myObj.data[0].intercom + '</span></p>';
                innerHtml = innerHtml + '</div>';
                innerHtml = innerHtml + '<div class="col-md-6"><p> <strong>Complainant</strong>: ' + myObj.data[0].user + '</p>';
                innerHtml = innerHtml + '<p><strong>Category</strong>: <span style="color: #0014f4">' + myObj.data[0].category_desc + '</span></p>';
                innerHtml = innerHtml + '<p> <strong>Created</strong>: ' + myObj.data[0].comp_datetime + '</p><p><strong>Status</strong>: ' + '<span style="color: #15a000">' + myObj.data[0].status_desc + '</span></p></div></div></div></div></div><form method="POST" action="http://ticketit.kordy.info/tickets/1" accept-charset="UTF-8" id="delete-ticket-1"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="2F5Y00q3whqlw8elHxj8iU2aPB3HCXCwc2elVUfg"></form></div></div>';
               
               // escalateHtml=innerHtml;
                //innerHtml = innerHtml + '<h2>Comments</h2><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title">'
                //innerHtml = innerHtml + myObjdata['staff_id'];
                //innerHtml = innerHtml + '<span class="pull-right">' + myObjdata['solution_time'] + '</span></h3></div><div class="panel-body"><div class="content">';
                //innerHtml = innerHtml + '<p>' + myObjdata['solution'] + '</p>';
                if( myObj.data[0].status_desc != 'Closed'){
                innerHtml = innerHtml + ' <div id="reply_msg"><div class="panel panel-default"></div><div class="panel-body"><form method="POST" action="http://ticketit.kordy.info/tickets-comment" accept-charset="UTF-8" class="form-horizontal"><input name="_token" type="hidden" value="2F5Y00q3whqlw8elHxj8iU2aPB3HCXCwc2elVUfg">';
                innerHtml = innerHtml + ' <input name="ticket_id" type="hidden" value="1"><fieldset><legend>Reply</legend>';
                innerHtml = innerHtml + '<div class="form-group"><div class="col-lg-12">';
                innerHtml = innerHtml + '<textarea class="form-control" rows="3" name="reply" id="reply" cols="50"></textarea></div><br><legend>Escalate</legend><select class="form-control" data-role="none" name="category" id="category"></select></div><div class="text-right col-md-12"><input class="btn btn-primary" type="button" onClick="insertReply(' + myObj.data[0].docket_no + ',\''+myObj.data[0].subject+'\',\''+myObj.data[0].location+'\',\''+myObj.data[0].mobile+'\',\''+myObj.data[0].intercom+'\',\''+myObj.data[0].category_desc+'\',\''+myObj.data[0].user+'\')" value="Submit"></div></fieldset></form></div></div>';}
                //innerHtml = innerHtml + '<div id="feedback_msg"></div>';

           // });
            $('#docket_details').html(innerHtml);
            $("#docket_details").show();
            // console.log(innerhtml);
            /* setTimeout(function () {
                 $.mobile.loading('hide');
             }, 300);*/
        });

    }
    catch (e) {
    }
}

function insertReply(docket_no,subject,location,mobile,intercom,category_desc,user) {
//function insertReply(docket,subject) {
   // alert(docket);
   // alert($("#category").val());
     var innerHtml = '';

    var category = $("#category").val();
    if(category == '')
        category = 0;

    var reply = $("#reply").val();

    if (reply.search(/\S/) == -1) {
        alert('Please give your reply');
        $("#reply").focus();
        return false;
    }

  //   alert(subject);

    if (reply != '') {
        try {
              var url =helpdeskserver+"insert_reply.php";
           // var url = 'http://10.50.81.45/corpdesk_api/insert_reply.php';

            //alert(url);
            $.post(url, {
                docket: docket_no,
                category: category,
                reply: encodeURI(reply),
                subject: encodeURI(subject),
                location: location,
                mobile: mobile,
                intercom: intercom,
                category_desc: category_desc,
                user: user
                //mailtxt: encodeURI(escalateHtml)
            },
                function (data) {
                //    alert(data);
                    console.log(data);
                    //alert("Success");
                    var myObj = JSON.parse(data);
                    // alert(myObj.docket_no);
                    // alert(myObj.status);
                    //$("#loader_slider").hide();
                    //alert(myObj.staff_id);
                    if (myObj.status == 'Success') {
                        $("#reply_msg").show();
                        var innerHtml = '';
                        innerHtml = innerHtml + '<div class="col-xs-12 text-center bg-info" id="feedback_msg">';
                        innerHtml = innerHtml + '<p>Your reply has been recorded successfully </p>';
                        innerHtml = innerHtml + '</div>';
                        $("#reply_msg").html(innerHtml);
                    } else {
                        $("#alert").show();
                        var innerHtml = '';
                        innerHtml = innerHtml + '<div class="col-xs-12 text-center bg-danger" id="feedback_msg">';
                        innerHtml = innerHtml + '<p>Failure, please try again...</p>';
                        innerHtml = innerHtml + '</div>';
                        $("#alert").html(innerHtml);
                    }
                });
        }
        catch (e) {
            alert(e);
        }

        //  return true;
    }



}

function logout()
{
    window.localStorage.setItem("glb_val",null);
    window.location = "index.html";
}

function mobileCheck()
{
    var mobile = $("#mobile").val();
      if (mobile != '') {
        if (mobile.length != 10) {
            alert('Please give valid mobile no.');
            $("#mobile").focus();
            return false;
        }
        for (i = 0; i < mobile.length; i++)
        {   
        // Check that current character is number.
        var c = mobile.charAt(i);
        if (((c < "0") || (c > "9")))
        {
        alert("Only numeric values are allowed for mobile no.");
        $("#mobile").focus();    
        return false;   
        } 
        
    }
    }

}

function intercomCheck()
{
    var intercom = $("#intercom").val();
      if (intercom != '') {
        if (intercom.length != 5) {
            alert('Please give valid intercom.');
            $("#intercom").focus();
            return false;
        }
        for (i = 0; i < intercom.length; i++)
        {   
        // Check that current character is number.
        var c = intercom.charAt(i);
        if (((c < "0") || (c > "9")))
        {
        alert("Only numeric values are allowed intercom");
        $("#intercom").focus();    
        return false;   
        } 
        
    }
    }

}
