<div class="as-card">
    <form action="" method="post">                
            <div class="form-group">
                <input type="text" required="required" name="login"/>
                <label class="control-label" for="input">Логин</label><i class="bar"></i>
            </div> 
            <div class="form-group">
                <input type="password" required="required" name="pass"/>
                <label class="control-label" for="input">Пароль</label><i class="bar"></i>
            </div>     
            <div id="authorization_error" class="form_error"><? echo $auth_error; ?></div>
            <input class="button" type="submit" value="Войти" name="send" />
            <a href="#">Забыли пароль?</a>
    </form>
</div>
