<div class="as-card" id="login_form">
    <h1>Подтверждение регистрации</h1>
    <p><strong><?php echo $user_name;?></strong>, для завершения регистрации Вам необходимо придумать пароль для доступа в систему.</p>
    <form action="javascript:void(null);" id="FormConfirmRegistration">   
        <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>" />
        <input type="hidden" name="user_mail" id="user_mail" value="<?php echo $user_mail; ?>" />
        <input type="hidden" name="hash" id="hash" value="<?php echo $hash; ?>" />
        <input type="hidden" name="user_name" id="user_name" value="<?php echo $user_name; ?>" />
        <div class="form-group">
            <p>Ваш логин: <?php echo $user_mail; ?></p>
        </div> 
        <div class="form-group">
            <input type="password" required="required" name="password"/>
            <label class="control-label" for="input">Пароль*</label><i class="bar"></i>
            <div class="form_error" id="form_error_password"></div>
        </div>     
        <div class="form-group">
            <input type="password" required="required" name="password_dubl"/>
            <label class="control-label" for="input">Повторите пароль*</label><i class="bar"></i>
            <div class="form_error" id="form_error_password_dubl"></div>
        </div>     
        <div id="authorization_error" class="form_error"></div>
        <input class="button" type="submit" value="Сохранить" name="send" onclick="xajax_Confirm_Registration(xajax.getFormValues('FormConfirmRegistration'));" />
    </form>
</div>
