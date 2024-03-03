<?php
    if($User->role != "ADMIN"){
        echo "You are not allowed to enter this site";
    }else{
?>

<div class="container">
    <div class="row justify-content-center bg-white-orange">
        <div class="col-md-5 rounded shadow p-4 m-4 bg-light-orange" id="sign_up">
            <h4 class="bg-light-orange">Dodaj użytkownika</h4>
            <form id="sign-up-form" class="bg-light-orange">
                <div class="mb-3 bg-light-orange">
                    <label for="signup_username" class="form-label bg-light-orange">Login</label><small style="color: red" class="bg-light-orange">*</small>
                    <input type="text" class="form-control bg-light-orange" id="signup_username" placeholder="Login" required>
                </div>
                <div class="mb-3 bg-light-orange">
                    <label for="signup_email" class="form-label bg-light-orange">Email</label><small style="color: red" class="bg-light-orange">*</small>
                    <input type="email" class="form-control bg-light-orange" id="signup_email" placeholder="Email" required>
                </div>
                <div class="mb-3 bg-light-orange">
                    <label for="signup_password" class="form-label bg-light-orange">Hasło</label><small style="color: red" class="bg-light-orange">*</small>
                    <input type="password" class="form-control bg-light-orange" id="signup_password" placeholder="Hasło" required>
                </div>
                <div class="mb-3 bg-light-orange">
                    <label for="signup_password_rep" class="form-label bg-light-orange">Powtórz hasło</label><small style="color: red" class="bg-light-orange">*</small>
                    <input type="password" class="form-control bg-light-orange" id="signup_password_rep" placeholder="Powtórz hasło" required>
                </div>
                <div class="mb-3 bg-light-orange">
                    <label for="signup_name" class="form-label bg-light-orange">Imię</label><small style="color: red" class="bg-light-orange">*</small>
                    <input type="text" class="form-control bg-light-orange" id="signup_name" placeholder="Imię" required>
                </div>
                <div class="mb-3 bg-light-orange">
                    <label for="signup_surname" class="form-label bg-light-orange">Nazwisko</label><small style="color: red" class="bg-light-orange">*</small>
                    <input type="text" class="form-control bg-light-orange" id="signup_surname" placeholder="Nazwisko" required>
                </div>
                <div class="mb-3 bg-light-orange">
                    <label for="signup_birthday" class="form-label bg-light-orange">Data urodzenia</label><small style="color: red" class="bg-light-orange">*</small>
                    <input type="date" class="form-control bg-light-orange" id="signup_birthday" required>
                </div>
                <button type="submit" class="btn btn-primary mb-3">Dodaj</button>
            </form>
            <button id="hide_form" class="btn btn-primary mb-3">Ukryj formularz</button>
        </div>
        <div class="col-md-5 rounded shadow p-4 m-4 bg-light-orange" id="users_list">
            <h4>Lista użytkowników</h4>
        </div>
        <div class="col-md-5 rounded shadow p-4 m-4 bg-light-orange">
            <h4>Lista grup</h4>
        </div>
        <div class="col-md-5 rounded shadow p-4 m-4 bg-light-orange">
            <h4>Pokaż parowania modlitw</h4>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#sign-up-form').hide();
        $('#hide_form').hide();

        $("#sign-up-form").submit(function(){
            let username = $("#signup_username").val();
            let email = $("#signup_email").val();
            let password = $("#signup_password").val();
            let name = $("#signup_name").val();
            let surname = $("#signup_surname").val();
            let birthday = $("#signup_birthday").val();
            let data = {
                username:username,
                password:password,
                email:email,
                name:name,
                surname:surname,
                phone:phone,
                birthday:birthday,
                city:city,
            }
            $.post("./sign/ajax_sign.php?action=sign_in", {data:data}, function(data){
                console.log(data);
                if(data == "success"){
                    location.href = "/index.php?nav=index";
                }
            })
        });
    })

    $(document).on('click', '#sign_up', function(){
        if($('#sign-up-form').css('display') == 'none'){
            $('#sign-up-form').fadeIn();
            $('#hide_form').fadeIn();
        }
    })

    $(document).on('click', '#hide_form', function(){
        if($('#sign-up-form').css('display') != 'none'){
            $('#sign-up-form').fadeOut();
            $('#hide_form').fadeOut();
        }
    })
    
    $(document).on('click', '#users_list', function(){
        location.href ="index.php?nav=users_list";
    })
</script>
<?php
    }
?>