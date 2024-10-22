<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Verify User Account</title>
</head>
<body>
    <div class="">
        <div class="aHl"></div>
        <div id=":tj" tabindex="-1"></div>
        <div id=":sz" class="ii gt"
            jslog="20277; u014N:xr6bB; 1:WyIjdGhyZWFkLWY6MTY5NTkzMjc2MTExNTcwMTY0MyIsbnVsbCxudWxsLG51bGwsbnVsbCxudWxsLG51bGwsbnVsbCxudWxsLG51bGwsbnVsbCxudWxsLG51bGwsW11d; 4:WyIjbXNnLWY6MTY5NTkzMjc2MTExNTcwMTY0MyIsbnVsbCxbXV0.">
            <div id=":sy" class="a3s aiL msg-1061312980294369947"><u></u>
                <div style="background:#f9f9f9">
                    <div style="background-color:#f9f9f9">

                        <div style="margin:0px auto;max-width:640px;background:transparent">
                            <table role="presentation" cellpadding="0" cellspacing="0"
                                style="font-size:0px;width:100%;background:transparent" align="center" border="0">
                                <tbody>
                                    <tr>
                                        <td
                                            style="text-align:center;vertical-align:top;direction:ltr;font-size:0px;padding:40px 0px">
                                            <div aria-labelledby="mj-column-per-100"
                                                class="m_-1061312980294369947mj-column-per-100"
                                                style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%">
                                                <table role="presentation" cellpadding="0" cellspacing="0" width="100%"
                                                    border="0">
                                                    <tbody>
                                                        <tr>
                                                            <td style="word-break:break-word;font-size:0px;padding:0px"
                                                                align="center">
                                                                <table role="presentation" cellpadding="0"
                                                                    cellspacing="0"
                                                                    style="border-collapse:collapse;border-spacing:0px"
                                                                    align="center" border="0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="width:138px"><a href=""
                                                                                    target="_blank"
                                                                                    data-saferedirecturl=""><img alt=""
                                                                                        title="" height="38px"
                                                                                        src="{{ asset('black/img/logo1.png') }}" width="138"
                                                                                        class="CToWUd"
                                                                                        data-bit="iit"></a></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div style="max-width:640px;margin:0 auto;border-radius:4px;overflow:hidden; box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px,
                        rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;">
                            <div style="margin:0px auto;max-width:640px;background:#ffffff">
                                <table role="presentation" cellpadding="0" cellspacing="0"
                                    style="font-size:0px;width:100%;background:#ffffff" align="center" border="0">
                                    <tbody>
                                        <tr>
                                            <td
                                                style="text-align:center;vertical-align:top;direction:ltr;font-size:0px;padding:40px 50px">
                                                <div aria-labelledby="mj-column-per-100"
                                                    class="m_-1061312980294369947mj-column-per-100"
                                                    style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%">
                                                    <table role="presentation" cellpadding="0" cellspacing="0"
                                                        width="100%" border="0">
                                                        <tbody>
                                                            <tr>
                                                                <td style="word-break:break-word;font-size:0px;padding:0px"
                                                                    align="left">
                                                                    <div
                                                                        style="color:#737f8d;font-family:Whitney,Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:16px;line-height:24px;text-align:left">

                                                                        <h2
                                                                            style="font-family:Whitney,Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-weight:500;font-size:20px;color:#4f545c;letter-spacing:0.27px">
                                                                            Hey {{ $user->username }},</h2>
                                                                        <p>Thanks for registering for an account on
                                                                            Famefeet! Before we get started, we just
                                                                            need to confirm that this is you. Click
                                                                            below to <span class="il">verify</span> your
                                                                            email address:</p>

                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="word-break:break-word;font-size:0px;padding:10px 25px;padding-top:20px"
                                                                    align="center">
                                                                    <table role="presentation" cellpadding="0"
                                                                        cellspacing="0" style="border-collapse:separate"
                                                                        align="center" border="0">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="border:none;border-radius:25px;color:white;padding:15px 19px"
                                                                                    align="center" valign="middle"
                                                                                    bgcolor="#0097a7"><a href="{{config('famefeet.client_base_url')."auth/email-acknowledge?token=".$verifyUser->token}}"
                                                                                        style="text-decoration:none;line-height:100%;background:#0097a7;color:white;font-family:Ubuntu,Helvetica,Arial,sans-serif;font-size:15px;font-weight:normal;text-transform:none;margin:0px"
                                                                                        target="_blank" <span
                                                                                        class="il">Verify</span>
                                                                                        Email
                                                                                    </a></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td
                                                                    style="word-break:break-word;font-size:0px;padding:30px 0px">
                                                                    <p
                                                                        style="font-size:1px;margin:0px auto;border-top:1px solid #dcddde;width:100%">
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="word-break:break-word;font-size:0px;padding:0px"
                                                                    align="left">
                                                                    <div
                                                                        style="color:#747f8d;font-family:Whitney,Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:13px;line-height:16px;text-align:left">
                                                                        <p>Need help?
                                                                            <a href="{{config('famefeet.client_base_url')."contact"}}" style="font-family:Whitney,Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;color:#7289da" target="_blank">Contact us</a>
                                                                            <br>
                                                                        </p>

                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div style="margin:0px auto;max-width:640px;background:transparent">
                            <table role="presentation" cellpadding="0" cellspacing="0"
                                style="font-size:0px;width:100%;background:transparent" align="center" border="0">
                                <tbody>
                                    <tr>
                                        <td
                                            style="text-align:center;vertical-align:top;direction:ltr;font-size:0px;padding:20px 0px">
                                            <div aria-labelledby="mj-column-per-100"
                                                class="m_-1061312980294369947mj-column-per-100"
                                                style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%">
                                                <table role="presentation" cellpadding="0" cellspacing="0" width="100%"
                                                    border="0">
                                                    <tbody>
                                                        <tr>
                                                            <td style="word-break:break-word;font-size:0px;padding:0px"
                                                                align="center">
                                                                <div
                                                                    style="color:#99aab5;font-family:Whitney,Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:12px;line-height:24px;text-align:center">
                                                                    Sent by Famefeet
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="word-break:break-word;font-size:0px;padding:0px"
                                                                align="center">
                                                                <div
                                                                    style="color:#99aab5;font-family:Whitney,Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:12px;line-height:24px;text-align:center">
                                                                    136 Kingsland Road
                                                                    #1075
                                                                    Clifton, New Jersey 07014
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
