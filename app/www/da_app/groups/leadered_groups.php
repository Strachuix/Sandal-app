<div class="container" id="big">
    <div class="row p-4 justify-content-center" id="group-container">
    </div>
</div>
<script>
    $(document).on('click', '.goto-group', function(){
        let group_id = $(this).attr('group_id');
        location.href = './index.php?nav=group_info&group_id='+group_id;
    })

    function showLeaderedGroups(){
        $.post('/ajax/ajax.php', {
            action: 'show_leadered_groups'
        }, function(data) {
            data = JSON.parse(data);
            let html = ``;
            let lp = 0;
            $.each(data, function(key, value) {
                lp++;
                // if (lp > 7){$("#group-container").empty().append(html);return} //? debug zmiana ilości wyświetlanych kafelków
                let group_name = value.group_name;
                let group_id = value.group_id;
                let group_leader = value.group_leader;
                let group = `
                <div class='col-md-3 col-sm-6 mb-5'>
                    <div class='card bg-light-orange goto-group' style='cursor:pointer; min-height:200px' group_id='${group_id}'>
                    <div class='card-body-icon-container card-body'>
                        <h4 class='card-title'>${group_name}</h4>
                    </div>
                    </div>
                </div>
                `;
                html += group;
            })
            $("#group-container").empty().append(html);
        })
    }
    $(document).ready(function(){
        showLeaderedGroups();
    });
</script>