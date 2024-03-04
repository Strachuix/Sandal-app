<style>
  #day_name{
    overflow: hidden;
  }
</style>
<div class="container" id="big">
  <div class="row p-4 col-12">
    <div class="col-md-6 mb-5">
      <div class="card bg-light-orange" style="cursor:pointer; min-height:200px" id="my_groups">
        <div class="card-body-icon-container card-body">
          <h4 class="card-title">Moje grupy</h4>
          <i class="fa-solid fa-people-group"></i>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-5">
      <div class="card bg-light-orange" style="min-height:200px" id="prayer" data-toggle="modal" data-target="#prayer_data">
        <div class="card-body">
          <div class="card-body-icon-container card-body">
            <h4 class="card-title">Dzisiaj modlisz się za</h4>
            <?php echo $User->getPrayPersons(['name', 'surname']); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-5">
      <div class="card bg-light-orange" style="min-height:200px" id="calendar">
        <div class="card-body">
            <h4 class="card-title">Kalendarz</h4>
            <div class="container mt-4">
              <div class="d-flex flex-row justify-content-around align-items-center">
                <i class="fa-solid fa-arrow-left text-lg"></i>
                <div class="text-center">
                  <h5 id="day_name"></h5>
                </div>
                <i class="fa-solid fa-arrow-right text-lg"></i>
              </div>
              <div class="row mt-4" id="meetings_calendar">
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php if ($User->role == "ADMIN") { ?>
      <div class="col-md-6 mb-5">
        <div class="card bg-light-orange" style="cursor:pointer; min-height:200px" id="admin_panel">
          <div class="card-body-icon-container card-body">
            <h4 class="card-title">Panel Administratora</h4>
            <i class="fa-solid fa-screwdriver-wrench"></i>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>

<script>
  var calendarDate = new Date();
  var currentDate = new Date();

  function loadMeetings(date = null) {
    if (date == null) {
      var day = currentDate.getDate();
      var month = currentDate.getMonth() + 1;
      var year = currentDate.getFullYear();
      var date = (day < 10 ? '0' : '') + day + '-' + (month < 10 ? '0' : '') + month + '-' + year;
    } else {

    }
    $.post('/ajax/ajax.php', {
      day: date,
      action: 'load_meetings'
    }, function(data) {
      $("#meetings_calendar").empty().append(data);
    })
  }

  function showMeetingDetalis(id) {
    $.post('/ajax/ajax.php', {
      day: day,
      action: 'show_meeting_details'
    }, function(data) {

    })
  }

  
  function calendarChangeDay(date){
    var daysOfWeek = ['Niedziela', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota'];
    let day = daysOfWeek[date.getDay()];
    let prevday =  $("#day_name").html();
    if ($.inArray(prevday,daysOfWeek) < $.inArray(day,daysOfWeek)) {
      $("#day_name").hide("slide", { direction: "left" }, 500, function(){
        $("#day_name").html(day);
      }).show("slide", { direction: "right" }, 500);
    }else{
      $("#day_name").hide("slide", { direction: "right" }, 500, function(){
        $("#day_name").html(day);
      }).show("slide", { direction: "left" }, 500);
    }
  }
  
  $('.fa-arrow-left').click(function() {
    calendarDate.setDate(calendarDate.getDate() - 1);
    calendarChangeDay(calendarDate);
  });

  $('.fa-arrow-right').click(function() {
    calendarDate.setDate(calendarDate.getDate() + 1);
    calendarChangeDay(calendarDate);
  });

  $(document).ready(function() {
    loadMeetings();
    calendarChangeDay(currentDate);
  })

  $(document).on("click", "#admin_panel", function() {
    console.log("admin panel clicked");
    location.href = "./index.php?nav=admin_panel";
  });

  $(document).on("click", "#my_groups", function() {
    console.log("admin panel clicked");
    location.href = "./index.php?nav=my_groups";
  });
</script>