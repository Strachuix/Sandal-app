
<link href="../system/css/select2.min.css" rel="stylesheet"/>
<style>
    #signup_allergy_missing, #signup_diet_missing{
        text-decoration: underline;
        cursor: pointer;
    }
    #signup_blik_div{
        display: none;
    }
</style>
<div class="border rounded shadow p-4 m-4 bg-light-orange" id="sign_up">
    <form id="edit_user" action="#">
        <div class="mb-3">
            <label for="signup_nickame" class="form-label">Login</label><small style="color: red">*</small>
            <input type="text" class="form-control" id="signup_nickname" placeholder="Login" value="<?php echo $User -> username ?>">
        </div>
        <div class="mb-3">
            <label for="signup_email" class="form-label">Email</label><small style="color: red">*</small>
            <input type="email" class="form-control" id="signup_email" placeholder="Email" value="<?php echo $User -> email ?>">
        </div>
        <div class="mb-3">
            <label for="signup_password" class="form-label">Hasło</label><small style="color: red">*</small>
            <input type="password" class="form-control" id="signup_password" placeholder="Puste = bez zmian">
        </div>
        <div class="mb-3">
            <label for="signup_password_rep" class="form-label">Powtórz hasło</label><small style="color: red">*</small>
            <input type="password" class="form-control" id="signup_password_rep" placeholder="Puste = bez zmian">
        </div>
        <div class="mb-3">
            <label for="signup_name" class="form-label">Imię</label><small style="color: red">*</small>
            <input type="text" class="form-control" id="signup_name" placeholder="Imię" value="<?php echo $User -> name ?>">
        </div>
        <div class="mb-3">
            <label for="signup_surname" class="form-label">Nazwisko</label><small style="color: red">*</small>
            <input type="text" class="form-control" id="signup_surname" placeholder="Nazwisko" value="<?php echo $User -> surname ?>">
        </div>
        <div class="mb-3">
            <label for="signup_phone" class="form-label">Nr telefonu <small> (opcjonalne)</small></label>
            <input type="text" class="form-control" id="signup_phone" placeholder="Numer telefonu"  value="<?php echo $User -> phone ?>">
        </div>
        <button type="button" class="btn btn-primary" id="save">Zapisz</button>
    </form>
</div>
<script src="../system/js/select2.min.js"></script>
<script src="../system/js/jquery.maskedinput.min.js"></script>
<script>
    $(document).ready(function() {
        $('#signup_allergy').select2({placeholder: 'Brak'});
        $('#signup_diet').select2({placeholder: 'Brak'});
        $("#signup_phone").mask('999999999');

        $(document).on("change", "#signup_allergy", function() {
            console.log($(this).val());
            if($.inArray('none', $(this).val()) !== -1 && $(this).val().length > 1 ){
                $(this).val([]);
                $(this).trigger("change");
            }
        });

        $(document).on("change", "#signup_diet", function() {
            console.log($(this).val());
            if($.inArray('none', $(this).val()) !== -1 && $(this).val().length > 1 ){
                $(this).val([]);
                $(this).trigger("change");
            }
        });

        $(document).on('click', "#signup_phone", function(){
            phone_num = $(this).val().replace(/\_/g, "");
            if(phone_num == ''){
                $(this).val('');
            }
        });

        $(document).on('click', "#signup_diet_missing", function(){
            $("#signup_diet_additional").css('display', 'block').focus();
        });

        $(document).on('click', "#signup_allergy_missing", function(){
            $("#signup_allergy_additional").css('display', 'block').focus();
        });

        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

        $("#save").click(function(){
            let login = $("#signup_nickname").val();
            let email = $("#signup_email").val();
            let password = $("#signup_password").val();
            let name = $("#signup_name").val();
            let surname = $("#signup_surname").val();
            let birthday = $("#signup_birthday").val();
            let city = $("#signup_city").val();
            let phone = $("#signup_phone").val();
            let blik = $("#signup_blik").prop('checked');
            let diet = $("#signup_diet").val();
            let diet_additional = $("#signup_diet_additional").val();
            let allergy = $("#signup_allergy").val();
            let allergy_additional = $("#signup_allergy_additional").val();
            let data = {
                login:login,
                password:password,
                email:email,
                name:name,
                surname:surname,
                phone:phone,
                birthday:birthday,
                city:city,
                blik:blik,
                diet:diet,
                diet_additional:diet_additional,
                allergy:allergy,
                allergy_additional:allergy_additional
            }
            $.post("./sign/ajax_sign.php?action=update_user", {data:data}, function(data){
                console.log(data);
                if(data == true){
                    location.href = "/index.php";
                }
            })
        });
    });
</script>