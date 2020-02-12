$(function(){
    $("#usersAdmin").on("click",getUsers);
    $("#classroomsAdmin").on("click",getClassrooms);
    $("body").on("click",".delete-classroom-card",deleteClassroom);
});

function getUsers(){
    
}

/* Function that get every classroom in the database and show them on the classroom adminsitration section */
function getClassrooms(){
    $("#sections").css("display","none");
    $("#adminContent").css("display","block");
    $.ajax({url: "index.php",type: "GET", data: {ctl: "getClassrooms"}, success: function(classrooms){
        var classroomsArray = JSON.parse(classrooms);
        if(classroomsArray.length>0){
            for(var i = 0; i < classroomsArray.length; i++){
                var classroomCard = $("<div class='classroom-card mt-4 mb-4'><div class='card'><div class='card-header'>"+classroomsArray[i][0]+"</div><div class='card-body'><p class='card-text'>"+classroomsArray[i][1]+"</p><a href='#' class='delete-classrom-card btn btn-danger'>Delete</a></div></div></div>");
                $("#adminContent").append(classroomCard);
            }
        }else{
            $("#adminContent").html("<p>You don't have any reservations!");
        }
        
    }});
}

function deleteClassroom(event)
{   
    $.ajax({url: "index.php",type: "GET", data: {ctl: "deleteClassroom",classroom: classroom}, success: function(deleted){
        
    }});
}