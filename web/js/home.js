var hours = ["7:55 - 8:50","8:50 - 9:45","9:45 - 10:40","11:00 - 11:55", "11:55 - 12:50", "12:50 - 13:45", "14:05 - 15:00", "15:00 - 15:55", "15:55 - 16:50", "16:50 - 17:45","18:05 - 19:00", "19:00 - 19:55", "19:55 - 20:50","21:10 - 22:05"];

$(function(){
    /* Call to 'create_classrooms' method */
    create_classrooms();

    $("#delete-modal").on("click",function(){
        $(this).parentsUntil("main").remove();
    });
});

/* Function that creates the calendar */
function create_classroom_calendar(){
    $("#calendar").removeClass("hidden");
    var classroom = $(this).attr("id");
    var date = new Date();
    var today = date.getDate();
    // Set click handlers for DOM elements
    $(".right-button").click({date: date,classroom: classroom}, next_year);
    $(".left-button").click({date: date,classroom: classroom}, prev_year);
    $(".month").click({date: date,classroom: classroom}, month_click);
    // Set current month as active
    $(".months-row").children().eq(date.getMonth()).addClass("active-month");
    init_calendar(date,classroom);
        
}

/* Function that makes a reservation by the user using ajax */
function reserve_click(event)
{
    var myDateString = formatDate(event.data.date);
    var range = $(this).parent().attr("id");
    $.ajax({url: "index.php",type: "GET", data: {ctl: "addReservation",date: myDateString,classroom: event.data.classroom,range: range}, success: function(added){
        if(added){
            $(event.target).parent().remove();
        }
    }});
}

/* Function that stores the classrooms sent from the server */
function create_classrooms(){
    $.ajax({url: "index.php",type: "GET", data: {ctl: "getClassrooms"}, success: function(classroomsAjax){
        var classrooms = JSON.parse(classroomsAjax);
        for (let index = 0; index < classrooms.length; index++) {
            var listItem = $("<li class='list-group-item' id='"+classrooms[index][0]+"'><p>"+classrooms[index][0]+"</p><p class='hidden'>"+classrooms[index][1]+"</li>");
            listItem.click(create_classroom_calendar);
            $("#classrooms ul").append(listItem); 
        }
    }});
}

// Initialize the calendar by appending the HTML dates
function init_calendar(date,classroom) {
    $(".tbody").empty();
    $(".hours-container").empty();
    var calendar_days = $(".tbody");
    var month = date.getMonth();
    var year = date.getFullYear();
    var day_count = days_in_month(month, year);
    var row = $("<tr class='table-row'></tr>");
    var today = date.getDate();
    // Set date to 1 to find the first day of the month
    date.setDate(1);
    var first_day = date.getDay();
    // 35+firstDay is the number of date elements to be added to the dates table
    // 35 is from (7 days in a week) * (up to 5 rows of dates in a month)
    for(var i=0; i<35+first_day; i++) {
        // Since some of the elements will be blank, 
        // need to calculate actual date from index
        var day = i-first_day+1;
        // If it is a sunday, make a new row
        if(i%7===0) {
            calendar_days.append(row);
            row = $("<tr class='table-row'></tr>");
        }
        // if current index isn't a day in this month, make it blank
        if(i < first_day || day > day_count) {
            var curr_date = $("<td class='table-date nil'>"+"</td>");
            row.append(curr_date);
        }   
        else {
            var curr_date = $("<td class='table-date'>"+day+"</td>");
            if(today===day && $(".active-date").length===0) {
                curr_date.addClass("active-date");
                date.setDate(today);
                show_hours(date,classroom);
                
            }

            // Set onClick handler for clicking a date
            row.append(curr_date);
        }
    }
    // Append the last row and set the current year
    calendar_days.append(row);
    $(".year").text(year);

    $(".table-date").click({date: date,classroom: classroom}, date_click);
}

// Get the number of days in a given month/year
function days_in_month(month, year) {
    var monthStart = new Date(year, month, 1);
    var monthEnd = new Date(year, month + 1, 1);
    return (monthEnd - monthStart) / (1000 * 60 * 60 * 24);    
}

// Event handler for when a date is clicked
function date_click(event) {
    var date = event.data.date;
    var classroom = event.data.classroom;
    console.log("Clase:"+classroom);
    $(".hours-container").empty();
    $(".hours-container").show(250);
    $(".active-date").removeClass("active-date");
    $(this).addClass("active-date");
    date.setDate(parseInt($(".active-date").html()));
    show_hours(date,classroom);
};

// Event handler for when a month is clicked
function month_click(event) {
    $(".hours-container").show(250);
    var date = event.data.date;
    var classroom = event.data.classroom;
    $(".active-month").removeClass("active-month");
    $(this).addClass("active-month");
    var new_month = $(".month").index(this);
    date.setMonth(new_month);
    init_calendar(date,classroom);
}

// Event handler for when the year right-button is clicked
function next_year(event) {
    var date = event.data.date;
    var classroom = event.data.classroom;
    var new_year = date.getFullYear()+1;
    $("year").html(new_year);
    date.setFullYear(new_year);
    init_calendar(date,classroom);
}

// Event handler for when the year left-button is clicked
function prev_year(event) {
    var date = event.data.date;
    var classroom = event.data.classroom;
    var new_year = date.getFullYear()-1;
    $("year").html(new_year);
    date.setFullYear(new_year);
    init_calendar(date,classroom);
}

// Display all events of the selected date in card views, checking if there is a reservation
function show_hours(date,classroom) {
    var hoursContainer = $(".hours-container");
    var classroomName = classroom;

    var myDateString = formatDate(date);

    console.log(myDateString);

    hoursContainer.append($("<h4 id='classroomName' class='mt-4 text-white pb-3'>"+classroomName+"</h4>"));
    for(var i=0; i<14; i++) {
        var rangeId = i+1;
        var range = $("<div class='range text-dark' id='"+rangeId+"'><p class='hours-text'>"+hours[i]+"</p><button class='button reserve-button'>Reserve</button><button class='button remove-button hidden'>Remove</button></div>");
        hoursContainer.append(range);
    }

    /* Add click event handler to the reserve button */
    $(".reserve-button").click({date: date,classroom: classroom},reserve_click);

    $.ajax({url: "index.php",type: "GET", data: {ctl: "getDateReservations",date: myDateString,classroom: classroomName}, success: function(reservations){
        var reservationsArray = reservations;
        console.log(reservationsArray);
        for(var i = 0; i < JSON.parse(reservationsArray).length; i++){
            $(".range").each(function(){
                console.log(JSON.parse(reservationsArray)[i])
                if($(this).attr("id") == JSON.parse(reservationsArray)[i].range_reservation){
                    $(this).remove();
                }
            });
        }
    }});
    
}

function formatDate(date)
{
    date = date.toJSON().split("T")[0];
    date = date.split("-");

    if(date[1].length == 1){
        date[1] = "0"+date[1];
    }

    if(date[2].length == 1){
        date[2] = "0"+date[2];
    }

    return date.join("-");
}

const months = [ 
    "January", 
    "February", 
    "March", 
    "April", 
    "May", 
    "June", 
    "July", 
    "August", 
    "September", 
    "October", 
    "November", 
    "December" 
];
