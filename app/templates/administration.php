<?php ob_start(); ?>
<script src="js/administration.js"></script>
<h2 class="page-title mb-5">Administration hub</h2>
<div class="back-button-container">
<button class="btn-dark rounded back-button hidden" id="administration-back">Go back</button>
</div>
<div id="sections" class="container">
    <div class="row">
        <div id="usersAdmin" class="rounded btn section col-sm-4 text-center bg-dark text-light" style="height: 100px">
            <h3 class="mt-3">Users</h3>
        </div>
        <div class="col-sm-4" style="height: 50px">

        </div>
        <div id="classroomsAdmin" class="rounded section btn col-sm-4 text-center bg-dark text-light" style="height: 100px">
            <h3 class="mt-3">Classrooms</h3>
        </div>
    </div>
</div>

<div id="admin-content">

</div>
<?php $contenido = ob_get_clean(); ?>
<?php include "layout.php"; ?>