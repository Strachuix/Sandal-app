<style>
</style>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>DA Sandał</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="../system/js/jquery.ba-throttle-debounce.min.js"></script>
  <link href="./../bootstrap/css/bootstrap.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/b8bbfc7fe6.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link href="./css/color_theme.css" rel="stylesheet">
  <script src="./../bootstrap/js/bootstrap.min.js"></script>
</head>

<body>
  <style type="text/css">
    #navbarNav {
      transition: 0.3s ease;
    }
  </style>
  <nav class="navbar navbar-expand-lg navbar-light bg-orange border-bottom mb-4">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon custom-toggler"></span>
    </button>
    <a class="navbar-brand" href="./index.php?nav=index">DA Sandał</a>
    <img src="./graphics/sandal_logo_xsm.png" alt="Logo Sandał" class="img-fluid" style="max-height: 45px;">

    <div class="collapse navbar-collapse bg-orange" id="navbarNav" style="width: 25%;">
      <ul class="navbar-nav ml-auto bg-orange">
        <li class="nav-item">
          <a class="nav-link goto_account_settings bg-orange text-dark" href="#"><?php echo $User->name . " " . $User->surname ?></a>
        </li>
        <li class="nav-item bg-orange">
          <a class="nav-link goto_main_page bg-orange text-dark" href="#">Strona główna</a>
        </li>
        <li class="nav-item bg-orange">
          <a class="nav-link logout bg-orange text-dark" href="#">Wyloguj</a>
        </li>
      </ul>
    </div>
  </nav>
  <script type="text/javascript">
    var dark_mode = false;
    $(document).ready(function() {
      let dark_mode = localStorage.getItem('dark_mode');
      $("#themeSwitch").attr("checked", dark_mode == "true");
      if (dark_mode == "true") {
        $("body").addClass("dark-mode");
      }

    });
    // $(document).on("click", ".navbar-toggler", function(){
    //     if($(".navbar-collapse").css('display') == 'none'){
    //         $(".navbar-collapse").css('display', 'block');
    //     }else{
    //         $(".navbar-collapse").css('display', 'none');
    //     }
    // });
    $(document).on("click", ".goto_main_page", function() {
      window.location.href = "/index.php?nav=index";
    });
  </script>
  <script>
    $(document).on('click', ".logout", function() {
      $.post("./sign/ajax_sign.php?action=logout", function() {
        window.location.href = "/index.php";
      });
    });
    $(".goto_account_settings").on('click', function() {
      window.location.href = "/index.php?nav=account_settings";
    });

    var navbarToggler = document.querySelector(".navbar-toggler");
    var navbarNav = document.querySelector("#navbarNav");

    // Dodaj nasłuchiwanie na kliknięcie przycisku hamburgera
    navbarToggler.addEventListener("click", function() {
      // Jeśli nawigacja jest ukryta, pokaż ją
      if (navbarNav.classList.contains("collapse")) {
        navbarNav.classList.remove("collapse");
      } else { // W przeciwnym razie schowaj nawigację
        navbarNav.classList.add("collapse");
      }
    });
  </script>