
<div class="section m-t-100 m-b-100">
    <div class="container animated fade__in">
        <div class="form" style="width: 300px; margin: 50px auto 0 auto;">

            <? if (empty(Cookie::get('reset_link'))): ?>

                <!-- SignIn Form -->
                <form class="form__body m-b-10" id="signin">
                    <div class="col-xs-12">
                        <p class="h3 bold text-center m-b-20">Авторизация</p>

                        <div class="form-group">
                            <div class="form-group__control-group">
                                <label for="signin_email" class="form-group__control-group-addon">
                                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                </label>
                                <input type="email" id="signin_email" name="email" class="form-group__control form-group__control-group-input" placeholder="Введите ваш email" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-group__control-group">
                                <label for="signin_password" class="form-group__control-group-addon">
                                    <i aria-hidden="true" class="fa fa-lock"></i>
                                </label>
                                <input type="password" id="signin_password" name="password" class="form-group__control form-group__control-group-input" placeholder="Ваш пароль" required="">
                            </div>
                        </div>

                        <input type="hidden" name="recover" value="1">
                        <input type="hidden" name="csrf" value="<?=Security::token(); ?>">
                        <button type="button" id="toReset" class="btn p-l-0 p-r-0">Забыли пароль?</button>
                        <button type="submit" class="btn btn--brand btn--round col-xs-5 fl_r m-r-0">Войти</button>
                    </div>
                </form>


                <!-- Forget Password Form -->
                <form class="form__body m-b-10" id="forget">
                    <div class="col-xs-12">
                        <p class="h3 bold text-center m-b-20">Востановить пароля</p>

                        <div class="form-group m-b-20">
                            <div class="form-group__control-group">
                                <label for="forget_email" class="form-group__control-group-addon">
                                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                </label>
                                <input type="email" id="forget_email" name="email" class="form-group__control form-group__control-group-input" placeholder="Введите ваш email" required="">
                            </div>
                        </div>

                        <input type="hidden" name="csrf" value="<?=Security::token(); ?>">
                        <button type="button" id="cancelForget" class="btn btn--default btn--round col-xs-5">Отмена</button>
                        <button type="submit" id="" class="btn btn--brand btn--round col-xs-6 fl_r m-r-0">Восстановить</button>
                    </div>
                </form>


                <!-- Registration Form -->
                <form class="form__body m-b-10" id="signup">
                    <div class="col-xs-12">
                        <p class="h3 bold text-center m-b-20">Регистрация</p>

                        <div class="form-group m-b-20">
                            <div class="form-group__control-group">
                                <label for="signup_email" class="form-group__control-group-addon">
                                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                </label>
                                <input type="email" id="signup_email" name="email" class="form-group__control form-group__control-group-input" placeholder="Введите ваш email" required="">
                            </div>
                        </div>

                        <div class="form-group m-b-20">
                            <div class="form-group__control-group">
                                <label for="signup_password" class="form-group__control-group-addon">
                                    <i aria-hidden="true" class="fa fa-lock"></i>
                                </label>
                                <input type="password" id="signup_password" name="password" class="form-group__control form-group__control-group-input" placeholder="Придумайте пароль" required="">
                            </div>
                        </div>

                        <span class="divider m-b-20" style="width: 15%"></span>

                        <div class="form-group m-b-20">
                            <div class="form-group__control-group">
                                <label for="signup_name" class="form-group__control-group-addon">
                                    <i aria-hidden="true" class="fa fa-user"></i>
                                </label>
                                <input type="text" id="signup_name" name="name" class="form-group__control form-group__control-group-input" placeholder="Введите имя и фамилию" required="">
                            </div>
                        </div>

                        <div class="text-center">
                            <input type="hidden" name="csrf" value="<?=Security::token(); ?>">
                            <button type="submit" class="btn btn--brand btn--round">Зарегистрироваться</button>
                        </div>
                    </div>
                </form>


                <a id="toSignUp" class="form__submit text-center text-brand">
                    Зарегистрироваться
                </a>

                <a id="toSignIn" class="form__submit text-center text-brand">
                    Авторизация
                </a>

            <? else: ?>

                <!-- Reset Password Form -->
                <form class="form__body m-b-20" id="reset">
                    <div class="col-xs-12 m-b-10">
                        <p class="h3 bold text-center m-b-20">Сброс пароля</p>

                        <div class="form-group m-b-20">
                            <div class="form-group__control-group">
                                <label for="reset_password" class="form-group__control-group-addon">
                                    <i aria-hidden="true" class="fa fa-lock"></i>
                                </label>
                                <input type="password" id="reset_password" name="password" class="form-group__control form-group__control-group-input" placeholder="Введите новый пароль" required="">
                            </div>
                        </div>

                        <div class="form-group m-b-20">
                            <div class="form-group__control-group">
                                <label for="reset_password1" class="form-group__control-group-addon">
                                    <i aria-hidden="true" class="fa fa-lock"></i>
                                </label>
                                <input type="password" id="reset_password1" name="password1" class="form-group__control form-group__control-group-input" placeholder="Повторите пароль" required="">
                            </div>
                        </div>

                        <input type="hidden" name="csrf" value="<?=Security::token(); ?>">
                        <button type="button" id="cancelReset" class="btn btn--default btn--round col-xs-5">Отмена</button>
                        <button type="submit" id="" class="btn btn--brand btn--round col-xs-6 fl_r m-r-0">Восстановить</button>
                    </div>
                </form>

            <? endif; ?>

        </div>
    </div>
</div>


<!-- =============== PAGE SCRIPTS ===============-->
<script type="text/javascript" src="<?=$assets; ?>static/js/auth.js"></script>
