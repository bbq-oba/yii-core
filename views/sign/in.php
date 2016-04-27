<script type="javascript">
    $(function(){
        var username = '<?php echo $username;?>';
        var password = '<?php echo $password;?>';
        $.ajax({
            type: "GET",
            url: "http://www.lebao.ph/user/DoQuickLogin",
            data: {
                username:username,
                password:password
            },
            success: function (data) {
                if(data.success == 'true'){
                    window.location.href="http://www.lebao.ph/";
                }
            },
            dataType:"json"
        });
    })
</script>