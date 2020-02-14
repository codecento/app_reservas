$(function(){
    $("#usersAdmin").on("click",getUsers);
    $("#classroomsAdmin").on("click",getClassrooms);
    $("body").on("click",".delete-classroom-card",deleteClassroom);
    $(".back-button").on("click",backButtonAction);
});

function backButtonAction()
{
    $("footer").css("position","fixed");
    $("#sections").css("display","block");
    $("#admin-content").css("display","none");
    $("#admin-content").html("");
    $(this).css("display","none");
}

/* Function that get normal users from database and show them on the users administration section */
function getUsers(){
    $("footer").css("position","relative");
    $("#sections").css("display","none");
    $("#admin-content").css("display","block");
    $("#administration-back").css("display","block");
    $.ajax({url: "index.php",type: "GET", data: {ctl: "getUsers"}, success: function(users){
        var usersArray = JSON.parse(users);
        if(usersArray.length>0){
            for(var i = 0; i < usersArray.length; i++){
                console.log("test");
                var user = $("<div class='user container mt-4 mb-4 p-2'><div class='row'><div class='col-sm align-self-center'><span style='font-weight: bold;'>User: </span><p class='user-name'>"+usersArray[i][0]+"</p></div><div class='col-sm align-self-center'><span style='font-weight: bold;'>E-mail: </span><p class='user-email'>"+usersArray[i][1]+"</p></div><div class='user-buttons col-sm align-self-center'><button class='delete-user btn btn-outline-danger'>Delete</button></div></div></div>");
                if(usersArray[i][3] == 0){
                    user.find(".user-buttons").append($("<button class='ml-1 change-level btn btn-outline-primary'>Habilitar</button>"));
                }
                $("#admin-content").append(user);
                user.find(".delete-user").on("click",deleteUser);
                
            }
        }else{
            $("#admin-content").html("<p>There is not any normal user on the database!</p>");
        }
        
    }});
}

/* Function that get every classroom in the database and show them on the classroom adminsitration section */
function getClassrooms(){
    $("footer").css("position","relative");
    $("#sections").css("display","none");
    $("#admin-content").css("display","block");
    $("#administration-back").css("display","block");
    $.ajax({url: "index.php",type: "GET", data: {ctl: "getClassrooms"}, success: function(classrooms){
        var classroomsArray = JSON.parse(classrooms);
        if(classroomsArray.length>0){
            for(var i = 0; i < classroomsArray.length; i++){
                var classroomCard = $("<div class='classroom-card mt-4 mb-4'><div class='card'><div class='card-header bg-success text-white'>"+classroomsArray[i][0]+"</div><div class='card-body'><p class='card-text'>"+classroomsArray[i][1]+"</p><a href='#' class='delete-classrom-card btn btn-danger'>Delete</a></div></div></div>");
                $("#admin-content").append(classroomCard);
            }
        }else{
            $("#admin-content").html("<p>There aren't classrooms on the database.</p>");
        }

        $("#admin-content").prepend("<div class='rounded' id='new-classroom'><h4>Add a new classroom</h4><input class='form-control' id='classroom-name' type='text' name='classroom-name' placeholder='Classroom'><br><input class='form-control' type='text' id='description' name='description' placeholder='Add a description'><br><div id='classroom-buttom-div'><button class='btn btn-dark' id='new-classroom-button'>Add classroom</button></div></div>");
        
    }});
}

function deleteClassroom(event)
{   
    var classroom = $(event.target).parent().find(".card-header").html();
    $.ajax({url: "index.php",type: "GET", data: {ctl: "deleteClassroom",classroom: classroom}, success: function(deleted){
        if(deleted == true){
            $(event.target).parent().parent().parent().remove();
        }
    }});
}

function deleteUser()
{
    var user = $(event.target).parent().find(".card-header").html();
    $.ajax({url: "index.php",type: "GET", data: {ctl: "deleteUser",classroom: classroom}, success: function(deleted){
        if(deleted == true){
            $(event.target).parent().parent().parent().remove();
        }
    }});
}

function changeUserLevel(event)
{
    
}