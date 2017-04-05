<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Подтверждение эл.почты | <?=$_SERVER['SITE_NAME']; ?></title>
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
                                    <p style="margin:0 0 18px;font-weight: bold;font-size: 2em;">Добро пожаловать в <?=$_SERVER['SITE_NAME']; ?>!</p>
                                    <p style="margin:12px 0 24px;font-size: 1.3em;"><?=$user->name; ?>,  поздравляем вас с успешной регистрацией на сайте <?=$_SERVER['SITE_URI']; ?>!</p>
                                    <table style="border-spacing:0;width:100%;">
                                        <tbody>
                                            <tr align="left" style="text-align:left;">
                                                <td align="left" valign="top" style="vertical-align:top;text-align:left;background:#EEEEEE;padding:18px 24px;">
                                                    <p style="margin: 7px 0;font-size: 1.3em;">
                                                        <img alt="" src="https://resize.yandex.net/mailservice?url=https%3A%2F%2Fimg.reg.ru%2Fmail%2Fnew_user%2Fb-mail-new-user__customer.png&amp;proxy=yes&amp;key=74f42c69f9f045fbe48cd2731db72876">
                                                        <b>Ваш логин:</b> <a style="text-decoration: none;color: #008DA7;padding-bottom: 2px;border-bottom: 2px solid #008DA7;"><?=$user->email; ?></a>
                                                    </p>
                                                    <p style="margin: 7px 0;font-size: 1.3em;">
                                                        <img alt="" src="https://resize.yandex.net/mailservice?url=https%3A%2F%2Fimg.reg.ru%2Fmail%2Fnew_user%2Fb-mail-new-user__lock.png&amp;proxy=yes&amp;key=709ee8fbd4918c19390d60947faca210">
                                                        <b>Ваш пароль:</b> <?=$password; ?>
                                                    </p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p style="font-size: 1.1em;line-height: 1.5em;">
                                        Перейти к <a href="http://<?= $_SERVER['HTTP_HOST']; ?>/app" style="text-decoration: none;color: #008DA7;padding-bottom: 2px;border-bottom: 2px solid #008DA7;">презентациям</a>
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
                                                    Для активации аккаунта, пожалуйста, <a href="http://<?= $_SERVER['HTTP_HOST'] . '/auth/confirm/' . $hash ?>" style="text-decoration: none;color: #008DA7;padding-bottom: 2px;border-bottom: 2px solid #008DA7;">подтвердите регистрацию</a> на сайте <?=$_SERVER['SITE_URI']; ?>.
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <tr align="left" style="text-align:left;">
                                <td align="left" valign="top" style="vertical-align:top;text-align:left;background:#ffffff;padding: 35px;">
                                    <a href="http://<?= $_SERVER['HTTP_HOST'] . '/auth/confirm/' . $hash ?>" style="display: block;border-radius: 3px;text-align: center;color: #FCFCFC;background: #008DA7;padding: 20px;font-size: 1.3em;text-decoration: none;cursor: pointer;">
                                        Подтвердить регистрацию
                                    </a>
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
