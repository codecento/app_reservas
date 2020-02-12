var hours = ["7:55 - 8:50","8:50 - 9:45","9:45 - 10:40","11:00 - 11:55", "11:55 - 12:50", "12:50 - 13:45", "14:05 - 15:00", "15:00 - 15:55", "15:55 - 16:50", "16:50 - 17:45","18:05 - 19:00", "19:00 - 19:55", "19:55 - 20:50","21:10 - 22:05"];

$(function(){

    /* Get user reservations with Ajax */
    $.ajax({url: "index.php",type: "GET", data: {ctl: "getUserReservations"}, success: function(reservations){
        var reservationsArray = JSON.parse(reservations);

        if(reservationsArray.length>0){
            for(var i = 0; i < reservationsArray.length; i++){
                var fecha = reservationsArray[i].date_reservation;
                var range = parseInt(reservationsArray[i][3]) - 1;
                range = hours[range];
                var reservation = $("<div class='reservation container mt-4 mb-4 p-2'><div class='row'><div class='col-sm align-self-center'><span style='font-weight: bold;'>Classroom: </span><p class='reserve-classroom-name'>"+reservationsArray[i][1]+"</p></div><div class='col-sm align-self-center'><span style='font-weight: bold;'>Date: </span><p class='reserve-date'>"+reverseDate(reservationsArray[i][2])+"</p><span style='font-weight: bold;'>Hour: </span><p class='reserve-hour'>"+range+"</p></div><div class='col-sm align-self-center'><button class='delete-reserve btn btn-outline-danger'>Delete</button></div></div></div>");
                $("#reservations").append(reservation);
                reservation.find(".delete-reserve").on("click",deleteReserve);
            }
        }else{
            $("#reservations").html("<p>You don't have any reservations!");
        }
        
    }});
});

/* Function that deletes a reserve from the database using Ajax */
function deleteReserve(event)
{
    /* Get the reservation info */
    var classroom = $(event.target).parent().parent().find(".reserve-classroom-name").text();
    var date = reverseDate($(event.target).parent().parent().find(".reserve-date").text());
    var hour = hours.indexOf($(event.target).parent().parent().find(".reserve-hour").text())+1;

    /* Use ajax to delete reservations from database and, if done, remove the html element */
    $.ajax({url: "index.php",type: "GET", data: {ctl: "deleteReservation", classroom: classroom, date: date, range: hour}, success: function(deleted){
        if(deleted == true){
            $(event.target).parent().parent().parent().remove();
        }
    }});
}

function reverseDate(date)
{
    var date = date.split("-");
    return date[2]+"-"+date[1]+"-"+date[0];
}