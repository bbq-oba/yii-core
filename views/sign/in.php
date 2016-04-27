<script type="javascript">
    $(function(){
        var username = '<?php echo $signIn['UserName']?>';
        var password = '<?php echo $signIn['Password']?>';
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

<!--<form id="signIn">-->
<!---->
<!--</form>-->
<!--<script type="text/javascript">-->
<!--    var form = document.getElementById('signIn');-->
<!--    form.method = 'post';-->
<!--    form.action = '--><?php //echo $signIn['url'];?>//';
<!--//    form.UserName = '--><?php ////echo $signIn['UserName']?><!--//';-->
<!--//    form.Password = '--><?php ////echo $signIn['Password']?><!--//';-->
<!--//    form.submit();-->
<!--//</script>-->