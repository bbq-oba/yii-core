<?php

$js = <<<EOF
        var username = '$username';
        var password = '$password';
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
EOF;


\yii::$app->controller->view->registerJs($js,\yii\web\View::POS_READY);
?>