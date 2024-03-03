<style>
    #signup_allergy_missing, #signup_diet_missing{
        text-decoration: underline;
        cursor: pointer;
    }
    #signup_blik_div{
        display: none;
    }
</style>
<link href="../system/css/select2.min.css" rel="stylesheet"/>
<link href="./css/color_theme.css" rel="stylesheet">
<nav class="navbar navbar-expand-lg border-bottom bg-orange d-flex justify-content-between">
    <a class="navbar-brand txt-white-orange" href="./index.php?nav=index">DA Sandał</a>
    <img src="./graphics/sandal_logo_xsm.png"alt="Logo Sandał" class="img-fluid" style="max-height: 45px;">
</nav>
<div class="container">
    <div class="row justify-content-center bg-white-orange">
        <div class="col-md-5 rounded shadow p-4 m-4 bg-light-orange" id="login">
            <h2 class="bg-light-orange">Zaloguj się</h2>
            <form id="login-form" class="bg-light-orange" action="#">
                <div class="mb-3 bg-light-orange">
                    <label for="loginEmail" class="form-label bg-light-orange">Email lub login</label><small style="color: red" class="bg-light-orange">*</small>
                    <input type="text" class="form-control bg-light-orange" id="loginEmail" aria-describedby="emailHelp"
                        placeholder="Email lub login" required>
                </div>
                <div class="mb-3 bg-light-orange">
                    <label for="loginPassword" class="form-label bg-light-orange">Hasło</label><small style="color: red" class="bg-light-orange">*</small>
                    <input type="password" class="form-control bg-light-orange" id="loginPassword" placeholder="Hasło" required>
                </div>
                <button type="submit" class="btn btn-primary mb-3 bg-light-orange">Zaloguj</button>
                <p class="login-register-change bg-light-orange">Nie masz jeszcze konta?</p>
            </form>
        </div>
        <div class="col-md-5 rounded shadow p-4 m-4 bg-light-orange" id="sign_up">
            <h2 class="bg-light-orange">Zarejestruj się</h2>
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
                <button type="submit" class="btn btn-primary mb-3">Zarejestruj</button>
                <p class="login-register-change bg-light-orange">Masz już konto?</p>
            </form>
        </div>
    </div>
</div>
<script src="../system/js/select2.min.js"></script>
<script src="../system/js/jquery.maskedinput.min.js"></script>
<script>
    $(document).ready(function() {
        $('#sign_up').hide();

        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

        $("#login-form").submit(function(){
            let login = $("#loginEmail").val();
            let password = $("#loginPassword").val();
            $.post("./sign/ajax_sign.php?action=login", {login:login, password:password}, function(data){
                console.log(data);
                if(data == "success"){
                    location.reload();
                }else{
                    console.log("Błąd logowania");
                }
            })
        });

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

        $(document).on('click', '.login-register-change', function(){
            if($('#sign_up').css('display') == 'none'){
                $('#login').hide();
                $('#sign_up').show();
            }else{
                $('#sign_up').hide();
                $('#login').show();
            }
        });
    });
</script>