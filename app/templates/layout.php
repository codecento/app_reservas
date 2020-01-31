<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reserva de aulas</title>
</head>

<body>
    <div class="container">
        <div class="menu-wrap">
            <nav class="menu">
                <div class="profile"><img src="img/user1.png" alt="Matthew Greenberg" /><span>Matthew Greenberg</span></div>
                <div class="link-list">
                    <a href="#"><span>Latest stories</span></a>
                    <a href="#"><span>Your friends</span></a>
                    <a href="#"><span>Personal Settings</span></a>
                    <a href="#"><span>Security &amp; Privacy</span></a>
                </div>
                <div class="icon-list">
                    <a href="#"><i class="fa fa-fw fa-home"></i></a>
                    <a href="#"><i class="fa fa-fw fa-question-circle"></i></a>
                    <a href="#"><i class="fa fa-fw fa-power-off"></i></a>
                </div>
            </nav>
        </div>

        <?php echo isset($contenido) ? $contenido : "" ?>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>