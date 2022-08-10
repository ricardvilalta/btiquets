<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>   
<script type="text/javascript" src="/js/sha512.js"></script>
<script type="text/javascript" src="/js/forms.js"></script>

<?php

    include_once './../../php/common.php';
    include_once './../../php/funcions.php';

    $redirect = "experiencies";

    if(isset($_GET['redirect']))
        $redirect = $_GET['redirect'];

?>

<script type="text/javascript">
    
    $(document).ready(function()
    {
        $('#login_button').click(function(){
            formhash($(this).parent().parent(), $(this).parent().parent().find('#password'),$(this).parent().find('#pl'));
        });
        
        $('#password').keypress(function(event){
            if(event.keyCode == 13){
                $('#login_button').click();
            }
        });
    });
    
</script>    

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <div class="admin-logo"><img src="/front/assets/images/logo.png" alt="Logo"></div>
                    <h3 class="panel-title">Sisplau, identifica't</h3>
                </div>
                <div class="panel-body">
                    <form role="form" action="/php/process_login.php" method="post" name="login_form">
                        <fieldset>
                            <input type="hidden" name="redirect" value="<?php echo $redirect; ?>"/>
                            <input type="hidden" id="pl" name="p" value=""/>
                            <div class="form-group">
                                <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" id="password" name="password" type="password" value="">
                            </div>
<!--
                            <div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                </label>
                            </div>
-->
                            <!-- Change this to a button or input when using this as a form -->
                            <a id="login_button" class="btn btn-lg btn-success btn-block">Entra</a>              
<!--                            <a href="/recovery"><?php echo translate("Has oblidat la contrasenya?", $lang);?></a><br>-->
<!--
                            <?php echo translate("Encara no t'has registrat?", $lang); ?> 
                            <a href="/register"><?php echo translate("Registra't", $lang);?></a>                            
-->
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
