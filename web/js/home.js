var hours = ["7:55 - 8:50","8:50 - 9:45","9:45 - 10:40","11:00 - 11:55", "11:55 - 12:50", "12:50 - 13:45", "14:05 - 15:00", "15:00 - 15:55", "15:55 - 16:50", "16:50 - 17:45","18:05 - 19:00", "19:00 - 19:55", "19:55 - 20:50","21:10 - 22:05"];

$(function(){
    var date = new Date();
    var today = date.getDate();
    // Set click handlers for DOM elements
    $(".right-button").click({date: date}, next_year);
    $(".left-button").click({date: date}, prev_year);
    $(".month").click({date: date}, month_click);
    // Set current month as active
    $(".months-row").children().eq(date.getMonth()).addClass("active-month");
    init_calendar(date);

    //Navbar behavior
    $("#navbarSupportedContent li a").on("click",function(){
        $("#navbarSupportedContent li a").removeClass("active");
        $(this).addClass("active");
    });
        
    $(".reserve-button").click({date: date},reserve_click);

});

function reserve_click()
{

}



// Initialize the calendar by appending the HTML dates
function init_calendar(date) {
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
                show_hours();
            }

            // Set onClick handler for clicking a date
            curr_date.click();
            row.append(curr_date);
        }
    }
    // Append the last row and set the current year
    calendar_days.append(row);
    $(".year").text(year);

    $(".table-date").click({date: date}, date_click);
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
    $(".hours-container").empty();
    $(".hours-container").show(250);
    $(".active-date").removeClass("active-date");
    $(this).addClass("active-date");
    date.setDate(parseInt($(".active-date").html()));
    show_hours();
};

// Event handler for when a month is clicked
function month_click(event) {
    $(".hours-container").show(250);
    var date = event.data.date;
    $(".active-month").removeClass("active-month");
    $(this).addClass("active-month");
    var new_month = $(".month").index(this);
    date.setMonth(new_month);
    init_calendar(date);
}

// Event handler for when the year right-button is clicked
function next_year(event) {
    var date = event.data.date;
    var new_year = date.getFullYear()+1;
    $("year").html(new_year);
    date.setFullYear(new_year);
    init_calendar(date);
}

// Event handler for when the year left-button is clicked
function prev_year(event) {
    var date = event.data.date;
    var new_year = date.getFullYear()-1;
    $("year").html(new_year);
    date.setFullYear(new_year);
    init_calendar(date);
}

// Display all events of the selected date in card views, checking if there is a reservation
function show_hours() {
    var date = 
    var hoursContainer = $(".hours-container");
    var classroomName = "Classroom Example";
    hoursContainer.append($("<h4 id='classroomName' class='mt-4 text-white pb-3'>"+classroomName+"</h4>"));
    for(var i=0; i<14; i++) {
        var range = $("<div class='range' id='"+(i+1)+"'><p class='hours-text'>"+hours[i]+"</p><button class='button reserve-button'>Reserve</button><button class='button remove-button hidden'>Remove</button></div>");
        hoursContainer.append(range);
        $.ajax({url: "index.php",type: "GET", data: {ctl: "checkReservations",}, success: function(respuesta){
            
        }});
    }
    
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
