<?php ob_start(); ?>
<script src="js/administration.js"></script>
<h2 class="page-title">Administration hub</h2>
<div id="sections" class="container">
    <div class="row">
        <div id="usersAdmin" class="section col-sm-4">
            <h3>Users</h3>
        </div>
        <div class="col-sm-4">

        </div>
        <div id="classroomsAdmin" class="section col-sm-4">
            <h3>Classrooms</h3>
        </div>
    </div>
</div>
<div id="admin-content">

</div>
<?php $contenido = ob_get_clean(); ?>
<?php include "layout.php"; ?>