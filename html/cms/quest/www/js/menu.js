//alert(window.localStorage.getItem("glb_val"));
if(window.localStorage.getItem("glb_val") == null)
{
    window.location = "index.html";
}
var url = helpdeskserver + 'user_type.php'
//var url = helpdeskserver + "userType/" + window.localStorage.getItem("glb_val");
//alert(window.localStorage.getItem("glb_val3"));
//alert($("#menu_type").val());
try {
    var myObjdata = '';
  //  alert(url);
  $.post(url, {
    userid: window.localStorage.getItem("glb_val")
}, function (data) {
        //console.log(data);
       /* var myObj = data['data'];
        //var innerhtml = '<option value="">- Select -</option>';
        $.each(myObj, function (key, value) {
            myObjdata = myObj[key];
            //alert(userid);
            alert('ddd');
             alert(myObjdata['userType']);
            window.localStorage.setItem("glb_val2", myObjdata['userType']);
            var myObj = JSON.parse(data);
            alert(myObj.emp_type);
           // window.localStorage.setItem("glb_val2", myObj.emp_type);

        });*/
        var myObj = JSON.parse(data);
        //alert(myObj.emp_type);
        window.localStorage.setItem("glb_val2", myObj.emp_type);
    });

}
catch (e) {
}


if (window.localStorage.getItem("glb_user_type") == '1') {
    if ($("#menu_type").val() == '1')
        document.write('<div class="panel panel-default"><div class="panel-body"><ul class="nav nav-pills"><li role="presentation" style="background-color:#D0AD68;"><a href="new_ticket.html"><font color="#FFFFFF">New Ticket</font></a></li><li role="presentation" class=""><a href="complaint_status.html">Ticket Status</a></li><li role="presentation" class=""><a href="#" onClick="logout();">Logout </a></li></ul></div></div>');
    if ($("#menu_type").val() == '2')
        document.write('<div class="panel panel-default"><div class="panel-body"><ul class="nav nav-pills"><li role="presentation" class=""><a href="new_ticket.html">New Ticket</a></li><li role="presentation" style="background-color:#D0AD68;"><a href="complaint_status.html"><font color="#FFFFFF">Ticket Status</font></a></li><li role="presentation" class=""><a href="#" onClick="logout();">Logout </a></li></ul></div></div>');
    if ($("#menu_type").val() == '3')
        document.write('<div class="panel panel-default"><div class="panel-body"><ul class="nav nav-pills"><li role="presentation" class=""><a href="new_ticket.html">New Ticket</a></li><li role="presentation" class=""><a href="complaint_status.html">Ticket Status</a></li><li role="presentation" class=""><a href="#" onClick="logout();">Logout </a></li></ul></div></div>');
    /*if ($("#menu_type").val() == '4')
        document.write('<div class="panel panel-default"><div class="panel-body"><ul class="nav nav-pills"><li role="presentation" class=""><a href="new_ticket.html">New Ticket</a></li><li role="presentation" class=""><a href="complaint_status.html">Ticket Status</a></li><li role="presentation" style="background-color:#D0AD68;"><a href="list_category.html"><font color="#FFFFFF">Index</font></a></li><li role="presentation" class=""><a href="#" onClick="logout();">Logout </a></li></ul></div></div>');*/
}
//if (window.localStorage.getItem("glb_val2") == '0') {
else{
        document.write('<div class="panel panel-default"><div class="panel-body"><ul class="nav nav-pills"><li role="presentation" class="active"><a href="show_ticket.html">Show Ticket</a></li><li role="presentation" class=""><a href="#" onClick="logout();">Logout </a></li></ul></div></div>');
   
}

