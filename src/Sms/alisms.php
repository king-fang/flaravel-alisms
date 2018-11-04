<?php

return [

    'driver' => 'code',

    'app_key' => env('ALISMS_APPKEY'),
    'app_secret' => env('ALISMS_SECRET'),

    //短信签名
    'sign' => '多米诺',

    'json_params' => [

        //验证码
        'code' => [
        //  'sms_code' => 'SMS_123456',
        //   'msg' => '验证码${code}，感谢您的支持!'
        ],
        //TODO
    ]
];