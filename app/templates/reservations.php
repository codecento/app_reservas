<?php ob_start(); ?>
<script src="js/reservations.js"></script>
<h2 class="page-title">Manage your reservations</h2>
<div id="reservations">
    
</div>
<?php $contenido = ob_get_clean(); ?>
<?php include "layout.php"; ?>