<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!-- If you delete this meta tag, the ground will open and swallow you. -->
    <meta name="viewport" content="width=device-width"/>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title></title>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">

</head>

<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<table class="head-wrap" style="overflow: hidden;">
    <tr class="container">
        <td class="container" >
            <!-- content -->
            <div class="content" style="padding: 35px 15px 15px">
                <table>
                    <tr style="font-size:15px;">
                        <td width="10px"></td>
                        <td align="center">
                            <span style="padding:0 50px 10px; display: block; font-size: 25px; line-height: 1.8;">
                                Hi {{ $details['first_name'] . ' ' . $details['last_name'] }} ! <br>
                                <br><br>
                                is this you who are logging in ?
                                <br/>
                                <br/>
                                If yes, You can ignore this.
                                <br/>
                                <br/>
                                @php
                                  $e = $details['id']
                                 @endphp
                                If not, Please Click <a href=" {{ route('userManagement.resetPage',$e)}}">Here</a> to reset your password
                            </span>
                            <br>
                    
                            <br>
                        </td>
                    </tr>
                </table>
            </div><!-- /content -->

        </td>
    </tr>
</table>
</body>
</html>
