<div class="container" id="big">
  <div class="row p-4">
    <div class="col-md-6 mb-5">
      <div class="card bg-light-orange" style="cursor:pointer; min-height:200px" id="my_groups">
        <div class="card-body-icon-container card-body">
          <h4 class="card-title">Moje grupy</h4>
          <i class="fa-solid fa-people-group"></i>
        </div>
      </div>
    </div>
    <!--<div class="col-md-6 mb-5">
      <div class="card bg-light-orange" style="min-height:200px" id="prayer" data-toggle="modal" data-target="#prayer_data">
        <div class="card-body">
          <div class="card-body-icon-container card-body">
            <h4 class="card-title">Dzisiaj modlisz się za</h4>
            <?php //echo $User->getPrayPersons(['name', 'surname']); ?>
          </div>
        </div>
      </div>
    </div>-->
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
    <?php if ($User->role == "ADMIN" || $User->role == "STRAP") { ?>
      <div class="col-md-6 mb-5">
        <div class="card bg-light-orange" style="cursor:pointer; min-height:200px" id="strap_panel">
          <div class="card-body-icon-container card-body">
            <h4 class="card-title">Panel Rzemyka</h4>
            <i class="fa-solid fa-user-tie"></i>
          </div>
        </div>
      </div>
    <?php } ?>
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
  var currentDate = new Date();
  var calendarDate = currentDate;

  function loadMeetings(date = null, direction = 'right') {
    if (date == null) {
      date = currentDate;
    }
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();
    date = (day < 10 ? '0' : '') + day + '-' + (month < 10 ? '0' : '') + month + '-' + year;
    let op_direcion = direction == 'right' ? 'left' : 'right';
    $.post('/ajax/ajax.php', {
        day: date,
        action: 'load_meetings'
      }, function(data) {
        console.log(data);
        if (data == '"No meetings to show"' || data == '[]') {
          $("#meetings_calendar").empty().append(`
          <div class="col-xl-12 mb-3">
            <div class="card bg-orange">
              <div class="card-body p-3">
                <div class="d-flex flex-row justify-content-between">
                  <h5 class="card-title m-0">Brak spotkań do wyświetlenia</h5>
                </div>
              </div>
            </div>
          </div>
        `);
        } else {
          let html = ``;
          data = JSON.parse(data);
          $.each(data, function(key, value) {
            let group_name = value.group_name;
            let id = value.id;
            let date = value.date;
            let group_id = value.group_id;
            let time = value.time;
            let meet = `
            <div class="col-xl-12 mb-3">
              <div class="card bg-orange group-meeting" style="cursor:pointer;" meeting_id="${id}" group_id="${group_id}">
                <div class="card-body p-3">
                  <div class="d-flex flex-row justify-content-between">
                    <h5 class="card-title m-0">${group_name}</h5>
                    <small>${time}</small>
                  </div>
                </div>
              </div>
            </div>
          `;
            html += meet;
          })
          $("#meetings_calendar").hide("slide", {
            direction: op_direcion
          }, 250, function() {
            $("#meetings_calendar").empty().append(html);
          }).show("slide", {
            direction: direction
          }, 250);
        }
    })
  }

  function showMeetingDetalis(id) {
    $.post('/ajax/ajax.php', {
      day: day,
      action: 'show_meeting_details'
    }, function(data) {

    })
  }

  function joinGroup(group_id) {
    $.post('/ajax/ajax.php', {
      group_id: group_id,
      action: 'join_group'
    }, function(data) {
      console.log(data);
    })
  }


  function calendarChangeDay(date, direction = 'right') {
    var daysOfWeek = ['Niedziela', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota'];
    let day = daysOfWeek[date.getDay()];
    let prevday = $("#day_name").html();
    let op_direcion = direction == 'right' ? 'left' : 'right';
    loadMeetings(date, direction);
    $("#day_name").hide("slide", {
      direction: op_direcion
    }, 250, function() {
      $("#day_name").html(day);
    }).show("slide", {
      direction: direction
    }, 250);
  }

  $('.fa-arrow-left').click(function() {
    calendarDate.setDate(calendarDate.getDate() - 1);
    calendarChangeDay(calendarDate, 'left');
  });

  $('.fa-arrow-right').click(function() {
    calendarDate.setDate(calendarDate.getDate() + 1);
    calendarChangeDay(calendarDate, 'right');
  });

  $(document).ready(function() {
    calendarChangeDay(currentDate);
  })

  $(document).on("click", "#admin_panel", function() {
    console.log("admin panel clicked");
    location.href = "./index.php?nav=admin_panel";
  });

  $(document).on("click", "#strap_panel", function() {
    console.log("strap panel clicked");
    location.href = "./index.php?nav=strap_panel";
  });

  $(document).on("click", "#my_groups", function() {
    location.href = "./index.php?nav=my_groups";
  });

  $(document).on("click", ".group-meeting", function() {
    let meeting_id = $(this).attr("meeting_id");
    let group_id = $(this).attr("group_id");
    location.href = "./index.php?nav=meeting_details&meeting_id=" + meeting_id + "&group_id=" + group_id;
  });
</script>