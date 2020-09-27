<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Notes</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="styling.css" rel="stylesheet">
      <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
      <style>
        #container{
            margin-top:120px;   
        }

        #notePad, #allNotes, #done, .delete{
            display: none;   
        }

        .buttons{
            margin-bottom: 20px;   
        }

        textarea{
            width: 100%;
            max-width: 100%;
            font-size: 16px;
            line-height: 1.5em;
            border-left-width: 20px;
            border-color: #CA3DD9;
            color: #CA3DD9;
            background-color: #FBEFFF;
            padding: 10px;
              
        }
        
        .noteheader{
            border: 1px solid grey;
            border-radius: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            padding: 0 10px;
            background: linear-gradient(#FFFFFF,#ECEAE7);
        }
          
        .text{
            font-size: 20px;
            word-wrap: break-word;
            /*<!--overflow: hidden;*/
            white-space: initial;
            text-overflow: ellipsis;
        }
          
        .timetext{
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        .notes{
            margin-bottom: 100px;
        }

      </style>
  </head>
  <body>
    <!--Navigation Bar-->  
      <nav role="navigation" class="navbar navbar-custom navbar-fixed-top">
      
          <div class="container-fluid">
            
              <div class="navbar-header">
              
                  <a class="navbar-brand">Online Notes</a>
                  <button type="button" class="navbar-toggle" data-target="#navbarCollapse" data-toggle="collapse">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                  
                  </button>
              </div>
              <div class="navbar-collapse collapse" id="navbarCollapse">
                  <ul class="nav navbar-nav">
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="#">Help</a></li>
                    <li><a href="#">Contact us</a></li>
                    <li class="active"><a href="all2.php">All Notes</a></li>
                      <li ><a href="mainpageloggedin.php">My Notes</a></li>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                      <li><a href="#">Logged in as <b><?php echo $_SESSION['username']?></b></a></li>
                    <li><a href="index.php?logout=1">Log out</a></li>
                  </ul>
              
              </div>
          </div>
      
      </nav>
    <br>
<!--Container-->

  <div class="container">
    <h4  style="text-align: center;">
                    ALL NOTES: 
                  </h4>
    <?php
//session_start();

include('connection.php');

//get the user_id
$user_id = $_SESSION['user_id'];
//run a query to delete empty notes
$sql = "DELETE FROM notes WHERE note=''";
$result = mysqli_query($link, $sql);
if(!$result){
    echo '<div class="alert alert-warning">An error occured!</div>'; exit;
}
//run a query to look for notes corresponding to user_id
$sql = "SELECT * FROM notes ";

//shows notes or alert message
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $note_id = $row['id'];
            $note = $row['note'];
            $time = $row['time'];
            $time = date("F d, Y h:i:s A", $time);
            
            echo "
        <div class='note'>
            <div class='col-xs-5 col-sm-3 delete'>
                <button class='btn-lg btn-danger' style='width:100%'>delete</button>
            
            </div>
            <div class='noteheader' id='$note_id'>
                <div class='text'>$note</div>
                <div class='timetext'>$time</div> 
                   
            </div>
        </div>";
        }
    }else{
        echo '<div class="alert alert-warning">You have not created any notes yet!</div>'; exit;
    }
    
}else{
    echo '<div class="alert alert-warning">An error occured!</div>'; exit;
//    echo "ERROR: Unable to excecute: $sql." . mysqli_error($link);
}

echo "\n";
echo "\n";


?>
    </div>
      

    
      

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="mynotes.js"></script>  
  </body>
</html>