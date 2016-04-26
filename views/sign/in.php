<form id="signIn" method="post">

</form>
<script type="text/javascript">
    var form = document.getElementById('signIn')
    form.action = '<?php echo $signIn['url'];?>';
    form.UserName = '<?php echo $signIn['UserName']?>';
    form.Password = '<?php echo $signIn['Password']?>';
    form.submit();
</script>