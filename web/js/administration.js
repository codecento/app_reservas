$(function(){
    //Add click events on loading the page
    $("#usersAdmin").on("click",getUsers);
    $("#classroomsAdmin").on("click",getClassrooms);
    $(".back-button").on("click",backButtonAction);
});

function backButtonAction()
{
    //Adds behaviour to the back button on administration sections
    $("footer").css("position","fixed");
    $("#sections").css("display","block");
    $("#admin-content").css("display","none");
    $("#admin-content").html("");
    $(this).css("display","none");
}

/* Function that get normal users from database and show them on the users administration section */
function getUsers(){
    //Changes footer behaviour to keep them at the bottom of the page without overlapping the content
    $("footer").css("position","relative");
    //Hides the sections to show the admin content
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
                    user.find(".user-buttons").append($("<button class='ml-1 change-level btn btn-outline-primary'>Enable</button>"));
                }
                $("#admin-content").append(user);
                user.find(".delete-user").on("click",deleteUser);
                user.find(".change-level").on("click",changeUserLevel);
            }
        }else{
            $("#admin-content").html("<p>There is not any normal user on the database!</p>");
        }
        
    }});
}

/* Function that get every classroom in the database and show them on the classroom adminsitration section */
function getClassrooms(){
    //Changes footer behaviour to keep them at the bottom of the page without overlapping the content
    $("footer").css("position","relative");
    //Hides the sections to show the admin content
    $("#sections").css("display","none");
    $("#admin-content").css("display","block");
    $("#administration-back").css("display","block");
    $.ajax({url: "index.php",type: "GET", data: {ctl: "getClassrooms"}, success: function(classrooms){
        var classroomsArray = JSON.parse(classrooms);
        if(classroomsArray.length>0){
            //Goes through the array of classrooms from database to create divs
            for(var i = 0; i < classroomsArray.length; i++){
                var classroomCard = $("<div class='classroom-card mt-4 mb-4'><div class='card'><div class='card-header bg-success text-white'>"+classroomsArray[i][0]+"</div><div class='card-body'><p class='card-text'>"+classroomsArray[i][1]+"</p><a href='#' class='delete-classroom-card btn btn-danger'>Delete</a></div></div></div>");
                $("#admin-content").append(classroomCard);
            }
        }

        //Add the 'addClassroom' div to administration page
        $("#admin-content").prepend("<div class='rounded mt-3' id='new-classroom'><h4>Add a new classroom</h4><input class='form-control' id='classroom-name' type='text' name='classroom-name' placeholder='Classroom'><br><input class='form-control' type='text' id='description' name='description' placeholder='Add a description'><br><div id='classroom-buttom-div'><button class='btn btn-dark' id='new-classroom-button'>Add classroom</button></div></div>");
        //Adds a click event that deletes the selected classroom
        $(".delete-classroom-card").on("click",deleteClassroom);
        //Adds a click event that adds the defined classroom
        $("#new-classroom-button").on("click",addClassroom);
    }});
}

function addClassroom(event)
{
    var classroomName = $(event.target).parentsUntil("#admin-content").find("#classroom-name").val();
    var classroomDescription = $(event.target).parentsUntil("#admin-content").find("#description").val();
    $.ajax({url: "index.php",type: "GET", data: {ctl: "addClassroom",classroomName: classroomName,classroomDescription: classroomDescription}, success: function(added){
        if(added == 1){
            //Adds a div showin a classroom
            $("#admin-content").append($("<div class='classroom-card mt-4 mb-4'><div class='card'><div class='card-header bg-success text-white'>"+classroomName+"</div><div class='card-body'><p class='card-text'>"+classroomDescription+"</p><a href='#' class='delete-classroom-card btn btn-danger'>Delete</a></div></div></div>"));
            //Removes the data on the add classroom inputs
            $(event.target).parentsUntil("#admin-content").find("#classroom-name").val('');
            $(event.target).parentsUntil("#admin-content").find("#description").val('');
        }
    }});
}

function deleteClassroom(event)
{   
    event.preventDefault();
    var classroom = $(event.target).parentsUntil(".classroom-card").find(".card-header").html();
    $.ajax({url: "index.php",type: "GET", data: {ctl: "deleteClassroom",classroom: classroom}, success: function(deleted){
        if(deleted == 1){
            //Removes the classroom div if has been removed from the database
            $(event.target).parent().parent().parent().remove();
        }
    }});
}

function deleteUser(event)
{
    $.ajax({url: "index.php",type: "GET", data: {ctl: "deleteUser",user: user}, success: function(deleted){
        if(deleted == 1){ 
            //Removes user div if has been removed from the database
            $(event.target).parentsUntil("#admin-content").remove();
        }
    }});
}

function changeUserLevel(event)
{
    var user = $(event.target).parentsUntil(".user").find(".user-name").html();
    $.ajax({url: "index.php",type: "GET", data: {ctl: "changeUserLevel",user: user}, success: function(changed){
        if(changed == 1){
            //Removes the 'Enable' button if the user has been succesfully enabled
            $(event.target).remove();
        }
    }});
}