<html>
  <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

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
  .table-responsive{
    padding: 100px 200px 100px 200px;
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
          <li class="active"><a href="#">VIEW CUSTOMERS</a></li>
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

  <div id="link"class="table-responsive">
  <table class="table table-bordered">
    <tr>
      <th style="color:white">CUSTOMER ID</th>
      <th style="color:white">NAME</th>
      <th style="color:white">EMAIL</th>
      <th style="color:white">BALANCE</th>
      <th style="color:white">TRANSFER MONEY</th>
    </tr>

    <?php
      include 'connection1.php';
      $selectquery = " select * from transaction";
      $query = mysqli_query($conn,$selectquery);
      $numofrows = mysqli_num_rows($query);
      while($res = mysqli_fetch_array($query))
      {
      ?>

    <tr>
      <td style="color:white"><?php echo $res['id'];?></td>
      <td style="color:white"><?php echo $res['name'];?></td>
      <td style="color:white"><?php echo $res['email'];?></td>
      <td style="color:white"><?php echo $res['balance'];?></td>
      <td><a href="transfermoney.php?id= <?php  echo $res['id']; ?>">Transfer</a> </td>
    </tr>

    <?php
      }
    ?>
  </table>
  </div>
</body>
</html>

