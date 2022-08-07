/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var helpdeskserver = 'http://webtest/corpdesk/public/';

function getCategory() {
  //  var url = helpdeskserver + "category";
      var url = 'http://10.50.81.45/corpdesk_api/category.php';

    try {
        var myObjdata = '';
        // alert(url);
        $.get(url, {
            data_type: ''
        }, function (data) {
            //console.log(data);
            var myObj = JSON.parse(data);
            //var myObj = data['data'];
            alert(myObj.data.length);
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
    if (category == '5') {
        $("#div_othcat").show();
    }
    else {
        $("#other_category").val("");
        $("#div_othcat").hide();
    }
}

function getLocation() {
    var url = helpdeskserver + "location";

    try {
        var myObjdata = '';
        // alert(url);
        $.get(url, {
            data_type: ''
        }, function (data) {
            //console.log(data);
            var myObj = data['data'];
            var innerhtml = '<option value="">- Select -</option>';
            $.each(myObj, function (key, value) {
                myObjdata = myObj[key];
                innerhtml = innerhtml + '<option value=' + myObjdata['location_id'] + '>' + myObjdata['location'] + '</option>';
            });
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

    if (mobile == '') {
        alert('Please give your mobile no.');
        $("#mobile").focus();
        return false;
    }

    if (subject == '') {
        alert('Please give subject');
        $("#subject").focus();
        return false;
    }
    if (mobile != '') {
        if (mobile.length != 10) {
            alert('Please give valid mobile no.');
            $("#mobile").focus();
            return false;
        }
    }

    if (subject.length > 130) {
        alert('Please give subject with in 130 characters');
        $("#subject").focus();
        return false;
    }


    if (subject != '' && category != '' && location != '' && mobile != '') {
        try {
            //var url =webserver+"/Mycescapplogic/helpdesk/complaint_general.php";
            var url = "http://10.50.81.45/corpdesk_api/complaint_general.php";
            //  alert(url);
            $.post(url, {
                subject: encodeURI(subject),
                //priority: priority,
                category: category,
                other_category: encodeURI(other_category),
                user_id: user_id,
                mode: 'APP',
                location: location,
                mobile: mobile
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
function login_chk() {
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
    
	/*$("#please_wait").show();
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
    */
    //  return true;
	
    //*************To be removed later***************** */
    $("#please_wait").show();
    window.localStorage.setItem("glb_val", email);
    window.location = "new_ticket.html";
    //****************************** */
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
                //alert(myObjdata['status_desc']);
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
                    if(myObjdata['status_desc'] == 'Open')
                    {
                        innerHtml = innerHtml + ' <input name="ticket_id" type="hidden" value="1"><fieldset><legend>Your Feedback</legend>';
                        innerHtml = innerHtml + '<div class="form-group"><div class="col-lg-12">';
                        innerHtml = innerHtml + '<textarea class="form-control" rows="3" name="feedback" id="feedback" cols="50"></textarea></div></div><div class="text-right col-md-12"><input class="btn btn-primary" type="button" onClick="insertFeedback(' + myObjdata['docket_no'] + ')" value="Submit"></div></fieldset></form></div></div>';
                    }
                    if(myObjdata['status_desc'] == 'Closed' && myObjdata['feedback'] == null)
                    {
                        innerHtml = innerHtml + ' <input name="ticket_id" type="hidden" value="1"><fieldset><legend>Your Feedback</legend>';
                        innerHtml = innerHtml + '<div class="form-group"><div class="col-lg-12">';
                      //  innerHtml = innerHtml + '<textarea class="form-control" rows="3" name="feedback" id="feedback" cols="50">'+myObjdata['feedback']+'</textarea></div></div></fieldset></form></div></div>';
                        innerHtml = innerHtml + '<textarea class="form-control" rows="3" name="feedback" id="feedback" cols="50"></textarea></div></div><div class="text-right col-md-12"><input class="btn btn-primary" type="button" onClick="insertFeedback(' + myObjdata['docket_no'] + ')" value="Submit"></div></fieldset></form></div></div>';
                    }
                    if(myObjdata['feedback'] != null)
                    {
                        innerHtml = innerHtml + ' <input name="ticket_id" type="hidden" value="1"><fieldset><legend>Your Feedback</legend>';
                        innerHtml = innerHtml + '<div class="form-group"><div class="col-lg-12">';
                        innerHtml = innerHtml + '<textarea class="form-control" rows="3" name="feedback" id="feedback" cols="50">'+myObjdata['feedback']+'</textarea></div></div></fieldset></form></div></div>';
                    }
                    //innerHtml = innerHtml + '<div id="feedback_msg"></div>';
                }

            });
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

function insertFeedback(docket) {
    //alert(docket);
    var feedback = $("#feedback").val();

    if (feedback.search(/\S/) == -1) {
        alert('Please give your feedback');
        $("#feedback").focus();
        return false;
    }

    if (feedback != '') {
        try {
            //var url =webserver+"/Mycescapplogic/helpdesk/complaint_general.php";
            var url = 'http://10.50.81.45/corpdesk_api/insert_feedback.php';

            //alert(url);
            $.post(url, {
                docket: docket,
                feedback: encodeURI(feedback)
            },
                function (data) {
                    //alert(data);
                    console.log(data);
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

                //innerHtml = innerHtml + '<h2>Comments</h2><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title">'
                //innerHtml = innerHtml + myObjdata['staff_id'];
                //innerHtml = innerHtml + '<span class="pull-right">' + myObjdata['solution_time'] + '</span></h3></div><div class="panel-body"><div class="content">';
                //innerHtml = innerHtml + '<p>' + myObjdata['solution'] + '</p>';
                innerHtml = innerHtml + ' <div id="reply_msg"><div class="panel panel-default"></div><div class="panel-body"><form method="POST" action="http://ticketit.kordy.info/tickets-comment" accept-charset="UTF-8" class="form-horizontal"><input name="_token" type="hidden" value="2F5Y00q3whqlw8elHxj8iU2aPB3HCXCwc2elVUfg">';
                innerHtml = innerHtml + ' <input name="ticket_id" type="hidden" value="1"><fieldset><legend>Reply</legend>';
                innerHtml = innerHtml + '<div class="form-group"><div class="col-lg-12">';
                innerHtml = innerHtml + '<textarea class="form-control" rows="3" name="reply" id="reply" cols="50"></textarea></div></div><div class="text-right col-md-12"><input class="btn btn-primary" type="button" onClick="insertReply(' + myObjdata['docket_no'] + ')" value="Submit"></div></fieldset></form></div></div>';
                //innerHtml = innerHtml + '<div id="feedback_msg"></div>';

            });
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

function insertReply(docket) {
    //alert(docket);
    var reply = $("#reply").val();

    if (reply.search(/\S/) == -1) {
        alert('Please give your reply');
        $("#reply").focus();
        return false;
    }

    if (reply != '') {
        try {
            //var url =webserver+"/Mycescapplogic/helpdesk/complaint_general.php";
            var url = 'http://10.50.81.45/corpdesk_api/insert_reply.php';

            //alert(url);
            $.post(url, {
                docket: docket,
                reply: encodeURI(reply)
            },
                function (data) {
                    //alert(data);
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