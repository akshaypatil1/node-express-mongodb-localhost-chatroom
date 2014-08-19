<?php
	session_start();
	if(!isset($_SESSION['name']))
	{
		header("Location: http://192.168.0.9/chat/index.php");
	}
	$name = $_SESSION['name'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Chat</title>
        <style>
        	body,
			textarea,
			input{
				font:13px "Trebuchet MS", Arial, Helvetica, sans-serif;
			}
			.chat{
				max-width:300px;
				/*background-image:url(water.jpg);*/
			}
			.btn{
				padding-top:10px;
				max-width:300px;
			}
			.chat-messages, .chat textarea, .chat-name{
				border:1px solid #bbb;
			}
			/*.chat-messages{
				background-image:url(img/2.jpg);
			}*/
			.chat-messages{
				width:100%;
				height:300px;
				overflow-y:scroll;
				max-width: 100%;
    			overflow-x: hidden;
				padding:10px;
				text-align:justify;
			}
			#mytable
			{
				width:100%;
				max-width:100%;
			}
			.chatName{
				vertical-align:text-top;
				width:300px;
				max-width:300px;
				padding-right:15px;
				height:10px;
				font-weight:bold;
				font-size:14px;
				color:#00F;
				/*text-decoration:underline;*/
			}
			.chatMsg{
				width:70%;
				padding-left::15px;
			}
			.chat-name{
				width:100%;
				padding:10px;
				border-bottom:0;
				margin:0;
			}
			.chat textarea{
				width:100%;
				padding:10px;
				border-top:0;
				margin:0;
				max-width:100%;
			}
			.chat-status{
				color:#bbb;
			}
			.chat-name, .chat textarea{
				outline:none;
			}
			.chat-message{
				margin-bottom:20px;
			}
        </style>    
    </head>
    
    <body>
    	
        <div class="chat">
            <input type="text" class="chat-name" placeholder="Enter Your Name" <?php if($name!=''){?> value="<?php echo $name?>" disabled="disabled" <?php }?>/>
            <div id="chat-messages" class="chat-messages">
            	<table id="myTable">
                </table>
            </div>
            <textarea placeholder="Type Your Message"></textarea>
            <div class="chat-status">Status: <span>Ideal</span></div>
        </div>
        <div class="btn">
        	<input type="button" name="logout" value="Logout" onclick="logoutFunction()"/>
            <script>
				function logoutFunction()
				{
					window.location.href = 'http://192.168.0.9/chat/index.php';
				}
			</script>
        </div>	
        <script src="http://192.168.0.9/chat/node_modules/socket.io/node_modules/socket.io-client/socket.io.js"></script>
        
        <script>
        	(function(){
				var getNode = function(s){
					return document.querySelector(s);
				},
						
				status = getNode('.chat-status span'),
				messages = getNode('.chat-messages');
				textarea = getNode('.chat textarea'),
				chatName = getNode('.chat-name'),
				statusDefault = status.textContent,
				setStatus = function(s){
					status.textContent = s;
					if(s !== statusDefault)
					{
						var delay  = setTimeout(function(){
							setStatus(statusDefault);
							clearInterval(delay);
							},3000);
					}
				};
						
				try{
					//var socket = io.connect('http://127.0.0.1:8080');
					var socket = io.connect('http://192.168.0.9:8080');
				}
				catch(e){
					
				}
				if(socket !== undefined)
				{
					//listen for output
					socket.on('output', function(data){
						//console.log(data);
						if(data.length){
							for(var x =0; x<data.length; x=x+1)
							{
								var table = document.getElementById("myTable");
								var row = table.insertRow(-1);
								var cell1 = row.insertCell(0);
								cell1.className = "chatName";
								var cell2 = row.insertCell(1);
								cell2.className = "chatMsg";
								cell1.innerHTML = data[x].name;
								cell2.innerHTML = data[x].message;
									
								/*var message = document.createElement('div');
								message.setAttribute('class', 'chat-message');
								
								message.textContent = data[x].name+ '=> '+data[x].message;									
								
								//Append
								messages.appendChild(message);
								messages.insertBefore(message, messages.lastChild);*/
							}
							new Audio('sounds/skype_chat.mp3').play();
								//var beep = PlaySound('beep');
						}
					});
					
					//listen for status
					
					socket.on('status', function(data){
						setStatus((typeof data === 'object')? data.message : data);
						var check_insert = data.clear;
							
						if(check_insert == '1')
						{
							textarea.value='';
								//window.setInterval(function()
								//{
							var elem = document.getElementById('chat-messages');
							elem.scrollTop = elem.scrollHeight;
								//}, 1000);
						}
					});
					//console.log('ok!');
					//listen for keydown
					textarea.addEventListener('keydown', function(event){
						if(event.which===46 || event.which===8)
							setStatus('Erasing');
						else
							setStatus('Typing');
						var self = this,
							name = chatName.value,
							msg = self.value;
						console.log(event);
						if(event.which===13 && event.shiftKey===false){
							textarea.value='';
								//window.setInterval(function()
								//{
							var elem = document.getElementById('chat-messages');
							elem.scrollTop = elem.scrollHeight;
							socket.emit('input',{
								name: name,
								message: msg
							});								//console.log('sent');
							event.preventDefault();
						}
						
					});
				}
			})();
        </script>
    </body>
</html>
