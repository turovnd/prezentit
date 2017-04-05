<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Подтверждение эл.почты | Votepad</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
    </head>

    <body style="font-size: 16px;color: #212121;font-family: -apple-system, BlinkMacSystemFont, sans-serif;">

<center style="width:100%;table-layout:fixed;">
    <table align="center" style="border-spacing:0;border-collapse:collapse;width:100%;max-width:580px;">
        <tbody>

            <!-- Main Info -->
            <tr align="left" style="text-align:left;">
                <td align="left" valign="top" style="vertical-align:top;text-align:left;padding: 15px 0;">
                    <table width="100%" style="border-spacing: 0;border: 15px solid #008DA7;">
                        <tbody>
                            <tr align="left" style="text-align:left;">
                                <td align="left" valign="top" style="vertical-align:top;text-align:left;background:#ffffff;padding: 35px;">
                                    <p style="margin:0 0 18px;font-weight: bold;font-size: 2em;">Добро пожаловать в Votepad!</p>
                                    <p style="margin:12px 0 24px;font-size: 1.3em;"><?= $user->name ?>,  поздравляем вас с успешной регистрацией на сайте votepad.ru!</p>
                                    <table style="border-spacing:0;width:100%;">
                                        <tbody>
                                            <tr align="left" style="text-align:left;">
                                                <td align="left" valign="top" style="vertical-align:top;text-align:left;background:#EEEEEE;padding:18px 24px;">
                                                    <p style="margin: 7px 0;font-size: 1.3em;">
                                                        <img alt="" src="https://resize.yandex.net/mailservice?url=https%3A%2F%2Fimg.reg.ru%2Fmail%2Fnew_user%2Fb-mail-new-user__customer.png&amp;proxy=yes&amp;key=74f42c69f9f045fbe48cd2731db72876">
                                                        <b>Ваш логин:</b> <a style="text-decoration: none;color: #008DA7;padding-bottom: 2px;border-bottom: 2px solid #008DA7;"><?= $user->email; ?></a>
                                                    </p>
                                                    <p style="margin: 7px 0;font-size: 1.3em;">
                                                        <img alt="" src="https://resize.yandex.net/mailservice?url=https%3A%2F%2Fimg.reg.ru%2Fmail%2Fnew_user%2Fb-mail-new-user__lock.png&amp;proxy=yes&amp;key=709ee8fbd4918c19390d60947faca210">
                                                        <b>Ваш пароль:</b> <?= $password ?>
                                                    </p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p style="font-size: 1.1em;line-height: 1.5em;">
                                        Войти в <a href="<?= $_SERVER['HTTP_HOST'].'/user/'.$user->id ?>" style="text-decoration: none;color: #008DA7;padding-bottom: 2px;border-bottom: 2px solid #008DA7;">Личный кабинет</a>
                                    </p>
                                </td>
                            </tr>

                            <tr align="left" style="text-align:left;">
                                <td align="left" valign="top" style="vertical-align:top;text-align:left;background:#EEEEEE;padding: 24px 34px;">
                                    <table style="border-spacing:0;width:100%;">
                                        <tbody>
                                            <tr align="left" style="text-align:left;">
                                                <td style="padding: 10px" align="left" valign="top" style="vertical-align:top;text-align:left;">
                                                    <img alt="" src="https://resize.yandex.net/mailservice?url=https%3A%2F%2Fi.reg.ru%2Fi%2Fmail%2Fimg%2Fmail-icon-alert.png&amp;proxy=yes&amp;key=dada823f08ed77f3029a82a7d6c8ec5f">
                                                </td>
                                                <td style="vertical-align:middle;line-height:1.5em" align="left" valign="middle">
                                                    Для активации аккаунта, пожалуйста, <a href="<?= $_SERVER['HTTP_HOST'].'/confirm/'.$hash ?>" style="text-decoration: none;color: #008DA7;padding-bottom: 2px;border-bottom: 2px solid #008DA7;">подтвердите регистрацию</a> на сайте votepad.ru.
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <tr align="left" style="text-align:left;">
                                <td align="left" valign="top" style="vertical-align:top;text-align:left;background:#ffffff;padding: 35px;">
                                    <a href="<?= $_SERVER['HTTP_HOST'].'/confirm/'.$hash ?>" style="display: block;border-radius: 3px;text-align: center;color: #FCFCFC;background: #008DA7;padding: 20px;font-size: 1.3em;text-decoration: none;cursor: pointer;">
                                        Подтвердить регистрацию
                                    </a>
                                </td>
                            </tr>

                            <tr align="left" style="text-align:left;">
                                <td align="left" valign="top" style="padding-top:0;vertical-align:top;text-align:left;background:#ffffff;padding: 35px;">
                                    <p style="font-size: 1.1em;line-height: 1.5em;">
                                        Если вы не осуществляли регистрацию на нашем сайте, проигнорируйте это письмо. В таком случае аккаунт не будет активирован и будет автоматически удалён через месяц. Для быстрого удаления обратитесь в службу поддержки по эл.почте:
                                        <a href="mailto: votepad@ya.ru" style="text-decoration: none;color: #008DA7;padding-bottom: 2px;border-bottom: 2px solid #008DA7;">votepad@ya.ru</a>.
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>


            <!-- Links to Social networks -->
            <tr align="left" style="text-align:left;">
                <td align="left" valign="top" style="padding:50px 0;vertical-align:top;text-align:left;">
                    <table style="border-spacing:0;width:100%;">
                        <tbody>
                            <tr align="left" style="text-align:left;">
                                <td align="center" valign="top" style="background:#EEEEEE;padding:18px 24px;text-align:center;vertical-align:top;text-align:left;">
                                    <p style="margin:0 0 18px;font-weight: bold;font-size: 2em;">Присоединяйтесь</p>
                                    <p style="font-size: 1.1em;line-height: 1.5em;">Подписывайтесь на наши группы в социальных сетях, чтобы постоянно быть в курсе всего самого интересного.</p>
                                    <table align="center" style="border-spacing:0;width:100%;">
                                        <tbody>
                                            <tr align="left" style="text-align:left;">
                                                <td style="vertical-align:top;text-align:left;text-align:center" align="center" valign="top">
                                                    <div style="max-width: 150px; display:inline-block; width:100%;" align="left">
                                                        <table style="border-spacing:0;width:100%;">
                                                            <tbody>
                                                                <tr align="left" style="text-align:left;">
                                                                    <td align="left" valign="top" style="vertical-align:top;text-align:left;text-align:center">
                                                                        <a href="//vk.com/votepad">
                                                                            <img alt="" width="44" height="44" style="border:0;" src="https://resize.yandex.net/mailservice?url=https%3A%2F%2Fimg.reg.ru%2Fmail%2Fb-mail-socailnets%2Fb-mail-socialnets__icon_mode_vk.png&amp;proxy=yes&amp;key=9d348c064fe34052fa13656889b15d3a">
                                                                        </a>
                                                                    </td>
                                                                    <td align="left" valign="top" style="vertical-align:top;text-align:left;text-align:center">
                                                                        <a href="//twitter.com/votepadevent">
                                                                            <img alt="" width="44" height="44" style="border:0;" src="https://resize.yandex.net/mailservice?url=https%3A%2F%2Fimg.reg.ru%2Fmail%2Fb-mail-socailnets%2Fb-mail-socialnets__icon_mode_twitter.png&amp;proxy=yes&amp;key=c851df1c2ca0f4ddadc0a6fb730ac073">

                                                                        </a>
                                                                    </td>
                                                                    <!--<td align="left" valign="top" style="vertical-align:top;text-align:left;">
                                                                        <a href="">
                                                                            <img alt="" width="44" height="44" style="border:0;" src="https://resize.yandex.net/mailservice?url=https%3A%2F%2Fimg.reg.ru%2Fmail%2Fb-mail-socailnets%2Fb-mail-socialnets__icon_mode_fb.png&amp;proxy=yes&amp;key=4c08c1ac4f8432433063c386e1384bf4">
                                                                        </a>
                                                                    </td>-->
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

        </tbody>
    </table>
</center>





    </body>
</html>
