<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reserva de aulas</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</head>

<body>
<nav id="navbar" class="navbar navbar-expand-lg navbar-light bg-success">
  <a class="navbar-brand" href="#"><img src="img/logo.png" id="logo"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link text-light" href="index.php?ctl=home">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-light" href="index.php?ctl=reservations">My reservations</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-light" href="index.php?ctl=administration">Administration</a>
      </li>
    </ul>
    
        <form class="form-inline my-2 my-lg-0" method="POST" action="index.php?ctl=logout">
          <?php 
          echo "<img id='user-image' src='user_images/".$_SESSION["user"]."'>";
           ?>
        <label class="nav-link text-white">Welcome, <?php echo $_SESSION["user"]?></label>
        <button class="btn btn-dark my-2 my-sm-0" type="submit">Logout</button>
    </form>
     
  </div>
</nav>

<main>
<?php echo $contenido ?>
</main>



<footer class="bg-success container-fluid">
    <div class="row" id="footer">
        <div class="col-sm-4">
          <a class="nav-link text-white" href="#">&copy; Copyright - Vicente Palacios Barrera</a>
        </div>
        <div class="col-sm-4">
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Privacy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Terms & Conditions</a>
                </li>
            </ul>
        </div>
        <div class="col-sm-4">

        </div>
    </div>
</footer>
</body>

</html>