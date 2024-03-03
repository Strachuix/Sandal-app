<div class="container" id="big">
    <div class="row p-4">
        <?php
        $html = "";
        foreach ($User->getGroups() as $group) {
            $group_id = $group['group_id'];
            $group_name = $group['group_name'];
            $html .= "  <div class='col-md-6 mb-5'>
                            <div class='card bg-light-orange goto-group' style='cursor:pointer; min-height:200px' group_id='$group_id'>
                            <div class='card-body-icon-container card-body'>
                                <h4 class='card-title'>$group_name</h4>
                            </div>
                            </div>
                        </div>";
        }
        echo $html;
        ?>
    </div>
</div>
<script>
    $(document).on('click', '.goto-group', function(){
        let group_id = $(this).attr('group_id');
        location.href = './index.php?nav=group_info&group_id='+group_id;
    })
</script>