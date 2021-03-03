<?php
    setcookie("Counter", 0, time()+3600);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<div class="wrapper">
    <div class="title">Talking with yoda</div>
    <div class="form">
        <div class="bot-inbox inbox">
        </div>
    </div>
    <div class="typing-field">
        <div class="input-data">
            <input id="data" type="text" placeholder="Type something here.." required>
            <button id="send-btn">Send</button>
        </div>
    </div>
</div>
<div class="ajax-loader">
    <img class="img-responsive" />
</div>
<script>
    $(document).ready(function(){
        $("#send-btn").on("click", function(){
            $value = $("#data").val();
            $msg = '<div class="user-inbox inbox"><div class="msg-header"><p>'+ $value +'</p></div></div>';
            $(".form").append($msg);
            $("#data").val('');

            // start ajax code
            $('.ajax-loader').css("visibility", "visible");
            $.ajax({
                url: 'conversation.php',
                type: 'POST',
                data: 'text='+$value,
                success: function(result){

                    $replay = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-user"></i></div><div class="msg-header"><p>'+ result +'</p></div></div>';
                    $(".form").append($replay);
                    // when chat goes down the scroll bar automatically comes to the bottom
                    $(".form").scrollTop($(".form")[0].scrollHeight);
                    $('.ajax-loader').css("visibility", "hidden");
                }
            });
        });
    });
</script>

</body>
</html>
