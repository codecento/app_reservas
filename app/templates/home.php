<?php ob_start(); ?>
<script src="js/home.js"></script>
<?php 
  if(isset($notAdmin)){
    ?>
    <div class="modal d-block" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title text-white">Warning</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" id="delete-modal">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>You have to be an administrator to get into the Administration page.</p>
      </div>
    </div>
  </div>
</div>
<?php
  }
?>
<h2 class="page-title">Reserve a classroom  </h2>
<div class="back-button-container">
<button class="btn-dark rounded back-button hidden" id="administration-back">Go back</button>
</div>
<div id="classrooms">
  <div class="card" style="width: 18rem;">
    <div class="card-header bg-dark text-light text-white">
      Choose a classroom
    </div>
    <select class="form-control" id="classrooms-list">
      <option id="none-option">None</option>
    </select>
  </div>
  <div id="calendar" class="content hidden">
  <div class="calendar-container">
    <div class="calendar">
      <div class="year-header bg-dark text-light">
        <span class="left-button" id="prev"> &lang; </span>
        <span class="year" id="label"></span>
        <span class="right-button" id="next"> &rang; </span>
      </div>
      <table class="months-table">
        <tbody>
          <tr class="months-row">
            <td class="month">Jan</td>
            <td class="month">Feb</td>
            <td class="month">Mar</td>
            <td class="month">Apr</td>
            <td class="month">May</td>
            <td class="month">Jun</td>
            <td class="month">Jul</td>
            <td class="month">Aug</td>
            <td class="month">Sep</td>
            <td class="month">Oct</td>
            <td class="month">Nov</td>
            <td class="month">Dec</td>
          </tr>
        </tbody>
      </table>

      <table class="days-table">
        <td class="day">Sun</td>
        <td class="day">Mon</td>
        <td class="day">Tue</td>
        <td class="day">Wed</td>
        <td class="day">Thu</td>
        <td class="day">Fri</td>
        <td class="day">Sat</td>
      </table>
      <div class="frame">
        <table class="dates-table">
          <tbody class="tbody">
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="hours-container bg-dark text-light">
  </div>
</div>
<?php
$contenido = ob_get_clean();
include "layout.php"
?>    
</div>

