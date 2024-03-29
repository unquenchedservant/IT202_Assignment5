<?php
  session_start();
  include("include/config.php");
  include("include/header.php");
  include("include/chatcontrol.php");
?>

<html>
	<head>
		<meta charset="utf-8">
		<title>Chat Login</title>
		<link rel="stylesheet" href="styles/styles.css">
	</head>

	<body>
		<div id = "main">
			<form action="" method="post">
				<table>
					<tr>
						<th colspan="3">Chill Chat Platform</th>
					</tr>
					<tr>
						<td colspan="3" class="labels">Username:   &nbsp;   <input type="text" name="username" id="username" maxlength="14" value="<?php echo $_SESSION['username'];?>" onkeyup="checklogin();"></td>
					</tr>
					<tr>
						<td colspan="3" class="labels">Password: &nbsp;     <input type="password" name="pass" id="pass" maxlength="20" value="<?php echo $_SESSION['pass'];?>" onkeyup="checklogin();"></td>
					</tr>
          <tr id="chatbox">
              <td>Chat: <input type="text" name="chat" id="chat" onkeyup="uploadChat();"/></td>
          </tr>
          <tr>
						<td>
							<input type="submit" name = "logout" value="logout"/>
						</td>
          </tr>
				</table>
        <p>

        </p>
        <table>
					<tr>
						<th colspan="2">Listen</th>
					</tr>
					<tr>
						<td class="labels">Username:   <input type="text" name="luser" id="luser" maxlength="14"></td>
              <td><input type="button" name="listen" value = "listen" onclick="checkuser();"/></td>
					</tr>
          <tr>
            <td colspan="2"id="listenbox">

            </td>
          </tr>
				</table>
			</form>
			<Center>
				<div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error_msg; ?></div>
			</Center>
		</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript">
      function checklogin(){
        var username = document.getElementById( "username" ).value;
        var pass = document.getElementById( "pass" ).value;
        $.ajax({
          type: "POST",
          url: "checklogin.php",
          data: {user:username, password:pass},
          success: function(msg){
              if(msg == "YES"){
                $("#chatbox").html('<td>Chat: <input type="text" name="chat" id="chat" onkeyup="uploadChat();"/></td>');
              }else if (msg == "NO") {
                $("#chatbox").html('<td>please enter a valid login</td>');
              }
           }
        });
      }
      function checkuser(){
        var username = document.getElementById( "luser" ).value;
        var usere = document.getElementById("username").value;
        if(username == usere){
          $("#listenbox").html('Username must be different than your own');
        }else{
          $.ajax({
            type: "POST",
            url: "checkulogin.php",
            data: {user:username},
            success: function(msg){
                if(msg == "YES"){
                  setInterval(getChat, 10);
                }else if (msg == "NO") {
                  $("#listenbox").html('That user doesnt exist');
                }
             }
          })
        }
      }
      function uploadChat(){
        var username = document.getElementById("username").value;
        var chat = document.getElementById("chat").value;
        $.ajax({
          type: "POST",
          url: "uploadChat.php",
          data: {user:username, message:chat},
          success: function(){

           }
        })
      }
      function getChat(){
        var username = document.getElementById("luser").value;
        $.ajax({
          type:"POST",
          url: "getChat.php",
          data: {user:username},
          success: function(msg){
            if(msg==""){
              $("#listenbox").html('This user has nothing typed');
            }else if (msg=="192389138fj39f3od9393jf939fj3j93f") {
              $("#listenbox").html('This user is logged off');
            }else{
              $("#listenbox").html(msg);
            }
          }
        })
      }
    </script>
    <noscript>
      <h3>this site requires javascript</h3>
    </noscript>
	</body>
</html>
