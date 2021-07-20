<html>
<head>

<link rel="stylesheet" type="text/css" href="css/userstyle.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@100;400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<style type="text/css">
    html,
    body,
    header,
    #intro {
      background: linear-gradient(rgba(0,0,0,0.6),rgba(0,0,0,0.6)),url("back.jpg")no-repeat center fixed;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;}
</style>
</head>

<body>

<style>
.registration-box
{
    width: 480px;
    height: 650px;
    background: rgba(0,0,0,0.7);
    color: #fff;
    top: 54%;
    left: 50%;
    position: absolute;
    transform: translate(-50%,-50%);
    box-sizing: border-box;
    padding: 30px 30px;  
}
.registration-box p{
    margin: 0;
    margin-top: -17px;
    font-size: 20px;
}
.registration-box input[type="text"],input[type="submit"]{
    width: 100%;
    margin-bottom: 20px;
}
.registration-box input[type="text"]
{
    border: none;
    border-bottom: 1px solid #fff;
    background:transparent;
    outline: none;
    height: 40px;
    color: #fff;
    font-size: 16px;
}
.registration-box input[type="submit"]{
    border: none;
    outline: none;
    height: 40px;
    background: #1c8adb;
    color: #fff;
    font-size: 18px;
    border-radius: 20px;
}
.registration-box input[type="submit"]:hover{
    cursor: pointer;
    background: #008031;
    color: #000;
}
</style>

<header>
  <nav class="navbar navbar-inverse ">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>                        
        </button>
        <a class="navbar-brand" href="#">TSF BANK</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="home.php">HOME</a></li>
          <li><a href="customer.php">VIEW CUSTOMERS</a></li>
          <li><a href="transaction.php">TRANSACTION HISTORY</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div id="intro" class="view">
    <div class="full-bg-img">
    </div>
  </div>
</header>

<div class="registration-box">
<form method="POST">

<?php
include 'connection1.php';
$ids=$_GET['id'];
$showquery="select * from `transaction` where id= ($ids) ";
$showdata=mysqli_query($conn,$showquery);
if (!$showdata) {
  printf("Error: %s\n", mysqli_error($conn));
  exit();
}
$arrdata=mysqli_fetch_assoc($showdata);
?> 
                          
  <h3 style="text-align: center;">Transfer Details</h3><br><br>
  <p>SENDER'S NAME :</p>
  <input type="text"  name="name1" value="<?php echo $arrdata['name']; ?>" required /><br><br>
  <p>SENDER'S EMAIL :</p>
  <input type="text" name="email1" value="<?php echo $arrdata['email']; ?>" required /><br><br>
  <p>AMOUNT :</p>
  <input type="text" name="amount1" value="" required placeholder="Enter amount"/><br><br>
  <p>RECEIVER'S NAME :</p>
  <input type="text"  name="name2" value="" required placeholder="Enter receiver's name"/><br><br>
  <p>RECEIVER'S EMAIL :</p>
  <input type="text" name="email2" value="" required placeholder="Enter receiver's email id"/><br><br>
  <input type="submit" name="submit" value="Proceed to Pay"/>
  
</form>
</div>
 
<?php
include 'connection1.php';

  if(isset($_POST['submit']))
  {
    $Sender_name=$_POST['name1'];
    $Sender_email=$_POST['email1'];
    $Sender=$_POST['amount1'];
    $Receiver_name=$_POST['name2'];
    $Receiver_email=$_POST['email2'];
     
    $ids=$_GET['id'];
    $senderquery="select * from `transaction` where id=$ids ";
    $senderdata=mysqli_query($conn,$senderquery);
    if (!$senderdata) {
     printf("Error: %s\n", mysqli_error($conn));
     exit();
    }
    $arrdata=mysqli_fetch_array($senderdata);

    $receiverquery="select * from `transaction` where email='$Receiver_email' ";
    $receiver_data=mysqli_query($conn,$receiverquery);
    if (!$receiver_data) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
    }
    $receiver_arr=mysqli_fetch_array($receiver_data);
    $id_receiver=$receiver_arr['id'];


    if($arrdata['balance'] >= $Sender)
    {
      $decrease_sender=$arrdata['balance'] - $Sender;
      $increase_receiver=$receiver_arr['balance'] + $Sender;
      $query="UPDATE `transaction` SET `id`=$ids,`balance`= $decrease_sender  where `id`=$ids ";
      $rec_query="UPDATE `transaction` SET `id`=$id_receiver,`balance`= $increase_receiver where  `id`=$id_receiver ";
      $res= mysqli_query($conn,$query);
      $rec_res= mysqli_query($conn,$rec_query);

      if($res && $rec_res)
      {
?>

  <script>
    swal("Done!", "Transaction Successful!", "success");
  </script> 
    
<?php
  $ins_query = "INSERT INTO history(`sname`, `rname`, `amount`) VALUES ('$Sender_name','$Receiver_name','$Sender')";
  $query1=mysqli_query($conn,$ins_query);
      }
      else
      {
?>

  <script>
    swal("Error!", "Error Occured!", "error");
  </script> 

<?php
      }
  }
  else
  {
?>

  <script>
    swal("Insufficient Balance", "Transaction Not  Successful!", "warning");
  </script> 

<?php  
  }
}
?>

</body>
</html>