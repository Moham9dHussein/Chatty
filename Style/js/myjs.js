var items = document.querySelectorAll(".contacts li"),
        tab = [], index, head ;

        // add values to the array
for(var i = 0; i < items.length; i++){
           tab.push(items[i].innerHTML);
         }


        // get selected element index
for(var i = 0; i < items.length; i++)
        {
            items[i].onclick = function(){
              console.log(tab);
              while(document.getElementById("kk")){
                document.getElementById("kk").remove();
              }
               index = tab.indexOf(this.innerHTML);
               head = document.getElementById("user_head" + index).innerHTML;
               textarea();
               userhead();
               getmessages(head);
               document.getElementById('chathead').innerHTML = head;
               document.getElementById(index).className = "active";
               for (var i = 0; i < items.length; i++) {
                 if (i != index) {
                  document.getElementById(i).className = "notactive";
                 }
               }
        
            };
        }



function clickhead() {

  var items = document.querySelectorAll(".contacts li"),
        tab = [], index,head;

        // add values to the array
for(var i = 0; i < items.length; i++){
           tab.push(items[i].innerHTML);
         }


        // get selected element index
for(var i = 0; i < items.length; i++)
        {
          console.log(items.length);
            items[i].onclick = function(){
              //console.log(tab);
              while(document.getElementById("kk")){
                document.getElementById("kk").remove();
              }
               index = tab.indexOf(this.innerHTML);
               console.log(index);
               head = document.getElementById("user_head" + index).innerHTML;
               console.log(head);
               textarea();
               userhead();
               getmessages(head);
               document.getElementById('chathead').innerHTML = head;
               document.getElementById(index).className = "active";
               for (var i = 0; i < items.length; i++) {
                 if (i != index) {
                  document.getElementById(i).className = "notactive";
                 }
               }
        
            };
        }
}



//clickhead();




function textarea()
{
  if (!document.getElementById("input-group-append")) {
  var div = document.createElement("div");
  div.setAttribute('class', 'input-group-append');
  div.setAttribute('id', 'input-group-append');
  div.innerHTML = '<div class="input-group-append"><span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span></div><textarea name="" class="form-control type_msg" placeholder="Type your message..." id="texarea"></textarea><div class="input-group-append"><span class="input-group-text send_btn" id="sbtn"><i class="fas fa-location-arrow"></i></span></div>';
  document.getElementById("myfooter").appendChild(div);
  document.getElementById("sbtn").addEventListener("click", send);
document.getElementById('texarea').addEventListener('keyup', function (e) {
    if (e.key === 'Enter') {
      send();
      document.getElementById("texarea").value = "";
    }

});

}
}

function userhead() {
  if (!document.getElementById("headyhead")) {
  var div = document.createElement("div");
  div.setAttribute('class', 'd-flex bd-highlight');
  div.setAttribute('id', 'headyhead');
  div.innerHTML = '<div class="img_cont"><img src="images/_D.jpg" class="rounded-circle user_img"><span class="online_icon"></span></div><div class="user_info"><span id="chathead"></span></div>';
  document.getElementById("heady").appendChild(div);

}
  
}

function send() {
  if (!document.getElementById("texarea").value == "") {
	head = document.getElementById("chathead").innerHTML;
	postmessages(head);
  var msg = document.getElementById("texarea").value;
  var div = document.createElement("div");
  div.setAttribute('class', 'd-flex justify-content-end mb-4 kk');
  div.setAttribute('id', "kk");
  div.innerHTML = '<div class="msg_cotainer_send">'+msg+'<span class="msg_time_send">8:55 AM, Today</span></div><div class="img_cont_msg"><img src="HOME/profil.png" class="rounded-circle user_img_msg"></div>';
  document.getElementById("texarea").value = "";
document.getElementById("chatBox").appendChild(div);
var ll = document.querySelectorAll(".kk:last-child")[0].offsetTop;
console.log(ll);
document.getElementById('chatBox').scrollTop = ll;
  //this.window.scrollBy(0,100);
}

}


function postmessages(head)
{
var messagesent = document.getElementById("texarea").value;
  var xhttp;
  //var getmessage = [];
  var xhttp = new XMLHttpRequest();
  
  xhttp.onreadystatechange=function()
  {
  if (this.readyState==4 && this.status==200)
    {
    	if (xhttp.responseText == '1') {
    		console.log("sent succ");
    	}else
    	{
    		console.log("error while sending");
    	}

        }
  };
xhttp.open("POST","../../processing/send.php?q=" + this.head,true);  //Sending request to newfile.php
xhttp.setRequestHeader("Content-Type", "application/json"); 
var data = {rname: this.head, message: messagesent};
xhttp.send(JSON.stringify(data));
}


function getmessages(head)
{
  console.log(head);
  var xhttp;
  var getmessage = [];
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange=function()
  {
  if (this.readyState==4 && this.status==200)
    {
      console.log(xhttp.responseText);
    	getmessage.push(xhttp.responseText);
      const obj = JSON.parse(getmessage);
      console.log(obj);
      distrubuter(obj);
      console.log("i', wating")
      if (document.getElementById("kk")) {
        console.log("i', wating2")
      var rr = document.querySelectorAll(".kk:last-child")[0].offsetTop;
      document.getElementById('chatBox').scrollTop = rr;
      }
      /*
    	const obj = JSON.parse(getmessage[0]);
    	distrubuter(obj);
      
    	console.log(obj);
      */
        }
  };
xhttp.open("GET","../../processing/chat.php?q=" + head,true);  
xhttp.send();
}



function distrubuter(message)
{
  console.log("distrubuter");
	for (var key in message) {console.log("distrubuter");
		console.log(key);
    console.log(message[key][0]);
    if (key.charAt(0) == "s") {
    	//console.log(key.charAt(0));
      //call_me.apply(this, args)
        sentmessage(message[key]);
        //console.log(message.key);
    }else if (key.charAt(0) == "r") {
    	recivedmessage(message[key]);
    }

}
console.log("distrubuterend");
}

function sentmessage(sende){
	var div = document.createElement("div");
	div.setAttribute('class', 'd-flex justify-content-end mb-4 kk');
	div.setAttribute('id', "kk");
	div.innerHTML = '<div class="msg_cotainer_send" >'+sende[0]+'<span class="msg_time_send">'+sende[1]+'</span></div><div class="img_cont_msg"><img src="HOME/profil.png" class="rounded-circle user_img_msg"></div>';
	document.getElementById("texarea").value = "";
	document.getElementById("chatBox").appendChild(div);
}




function recivedmessage(recive){

	var div = document.createElement("div");
	div.setAttribute('class', 'd-flex justify-content-start mb-4 kk');
	div.setAttribute('id', "kk");
	div.innerHTML = '<div class="img_cont_msg"><img src="HOME/profil.png" class="rounded-circle user_img_msg"></div><div class="msg_cotainer">'+recive[0]+'<span class="msg_time">'+recive[1]+'</span></div>';
	document.getElementById("texarea").value = "";
document.getElementById("chatBox").appendChild(div);
}




function showHint(str) {
  var gethint = [];
  if (str.length == 0) {
    //document.getElementById("sugg").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        gethint.push(xmlhttp.responseText);
        const h = JSON.parse(gethint);
        console.log(h);
        var options = '';
        for (var key in h) {
      
        
          options += '<option value="' + h[key] + '">';
        
      
      }document.getElementById('sugg').innerHTML = options;
/*
        var div = document.createElement("option");
        div.setAttribute('value', this.responseText);
        div.innerHTML = '<img src="images/1.png">'
        document.getElementById("sugg").appendChild(div);*/
        //document.getElementById("sugg").innerHTML = "<option value="+this.responseText+"> ";
      }
    };
    xmlhttp.open("GET", "../../processing/gethint.php?q=" + str, true);
    xmlhttp.send();
  }
}


function onInput() {
    var val = document.getElementById("searchBar").value;
    var opts = document.getElementById('sugg').childNodes;
    for (var i = 0; i < opts.length; i++) {
      if (opts[i].value === val) {
        // An item was selected from the list!
        // yourCallbackHere()
        newchat(val);
        clickhead();
        //alert(opts[i].value);
        break;
      }
    }
  }

function newchat(head) {
  var newlenght = document.getElementById("myui").getElementsByTagName("li").length;
  var lis = document.createElement("li");
  lis.setAttribute('id', newlenght);
  lis.innerHTML = '<div class="d-flex bd-highlight"><div class="img_cont"><img src="images/1.png" class="rounded-circle user_img"><span class="online_icon"></span></div><div class="user_info"><span id="user_head'+newlenght+'">'+head+'</span><p>online</p></div></div>';
  document.getElementById("myui").appendChild(lis);

}


  