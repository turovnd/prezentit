<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Восстановление пароля | <?=$_SERVER['SITE_NAME']; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
    </head>

    <body style="font-size: 16px;color: #212121;font-family: -apple-system, BlinkMacSystemFont, sans-serif;">

<center style="width:100%;table-layout:fixed;">
    <table align="center" style="border-spacing:0;border-collapse:collapse;width:100%;max-width:580px;">
        <tbody>

            <tr align="left" style="text-align:left;">
                <td align="left" valign="top" style="vertical-align:top;text-align:left;padding: 15px 0;">
                    <table width="100%" style="border-spacing: 0;border: 15px solid #008DA7;">
                        <tbody>
                            <tr align="left" style="text-align:left;">
                                <td align="left" valign="top" style="vertical-align:top;text-align:left;background:#ffffff;padding: 15px 35px;">
                                    <p style="margin:0 0 18px;font-weight: bold;font-size: 2em;">Восстановление пароля</p>
                                    <p style="font-size: 1.1em;line-height: 1.5em;"><?= $user->name; ?>, для восстановления вашего пароля на сайте <a href="//<?=$_SERVER['SITE_URI']; ?>" style="text-decoration: none;color: #008DA7;padding-bottom: 2px;border-bottom: 2px solid #008DA7;"><?=$_SERVER['SITE_URI']; ?></a>, Вам надо пройти по следующей ссылке и следовать дальнейшим инструкциям:</p>
                                </td>
                            </tr>
                            <tr align="left" style="text-align:left;">
                                <td align="left" valign="top" style="vertical-align:top;text-align:left;background:#ffffff;padding: 0 35px;">
                                    <a href="http://<?= $_SERVER['HTTP_HOST'] . '/auth/reset/'. $hash; ?>" style="display: block;border-radius: 3px;text-align: center;color: #FCFCFC;background: #008DA7;padding: 20px;font-size: 1.3em;text-decoration: none;cursor: pointer;">
                                        Сбросить пароль
                                    </a>
                                </td>
                            </tr>
                            <tr align="left" style="text-align:left;">
                                <td align="left" valign="top" style="vertical-align:top;text-align:left;background:#ffffff;text-align:center; padding: 10px 35px;">
                                    <p style="font-size: 1.1em;line-height: 1.5em;">Эта ссылка будет действительна в течение часа.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

            <tr align="left" style="text-align:left;">
                <td align="left" valign="top" style="padding-top:0;vertical-align:top;text-align:left;background:#ffffff;">
                    <p style="font-size: 1em; line-height: 1.3em;">
                        Если вы не осуществляли данное действие на нашем сайте, проигнорируйте это письмо. Ссылка будет удалена через час. Если у Вас возникли вопросы, обратитесь в службу поддержки по эл.почте:
                        <a href="mailto: <?=$_SERVER['SUPPORT_EMAIL']; ?>" style="text-decoration: none;color: #008DA7;padding-bottom: 2px;border-bottom: 2px solid #008DA7;"><?=$_SERVER['SUPPORT_EMAIL']; ?></a>.
                    </p>
                </td>
            </tr>

        </tbody>
    </table>
</center>





    </body>
</html>
