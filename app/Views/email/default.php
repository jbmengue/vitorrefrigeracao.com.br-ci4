<!DOCTYPE html>
<html lang="pt-br">

<body bgcolor="#EEEEEE"  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <table align="center"  width="100%" height="369" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="293" height="86" colspan="2" bgcolor="#2d914a"></td>
            <td width="205" height="86" bgcolor="#2d914a"></td>
            <td width="302" height="86" colspan="2" bgcolor="#2d914a"></td>
        </tr>
        <tr>
            <td width="140" height="60" bgcolor="#2d914a"></td>
            <td width="522" height="135" colspan="3" rowspan="2" vertical-align: top; bgcolor="#FFFFFF" style="font-family: Helvetica;font-size:14px;color:#696969;padding: 30px 25px;vertical-align: top;">
                <h1 style="text-align: center;margin-bottom:30px;color: #000;font-size:30px"><?= $title ?></h1>
                <div style="line-height:30px;color:#696969;">
                    <?= $content ?>
                </div>
            </td>
            <td width="138" height="60" bgcolor="#2d914a"></td>
        </tr>
        <tr>
            <td width="140" height="75" bgcolor="#EEEEEE"></td>
            <td width="138" height="75" bgcolor="#EEEEEE"></td>
        </tr>
        <tr>
            <td width="140" height="146" bgcolor="#EEEEEE"></td>
            <td width="522" height="147" colspan="3" rowspan="2" bgcolor="#EEEEEE" style="padding: 40px 0 20px;vertical-align: top; text-align:center;">
                <small style="color:#8ea2a4;">© <?= $appConfig->name .
                  " " .
                  date("Y") ?> - Todos os direitos reservados</small>
            </td>
            <td width="138" height="146" bgcolor="#EEEEEE"></td>
        </tr>
        <tr>
            <td width="140" height="1"></td>
            <td width="138" height="1"></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
</body>

</html>