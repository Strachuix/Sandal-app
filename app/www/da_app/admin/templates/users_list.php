<div class="container">
    <div class="row justify-content-center bg-white-orange">
        <div class="col-md-12">

        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        loadUsers();
    })
    function loadUsers() {
        $.post('/admin/ajax.php',{api:'get_users_list', filter:{}}, function(data){
            data = JSON.parse(data);
            let html = "<table class='table table-striped table-bordered><thead><tr><th>ID</th><th>Username</th><th>Role</th><th>Name</th><th>Surname</th><th>Email</th><th>Birthdate</th><th>Phone</th></tr></theead><tbody>";
            // while(user = data){
                console.log(data);
            // }
        })
    }
</script>