<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 17.07.17
 */
return [
    /**
     * название класса-провайдера
     * Доступные провайдеры:
     * * \Nutnet\LaravelSms\Providers\Log (alias: log)
     * * \Nutnet\LaravelSms\Providers\Smpp (alias: smpp)
     * * \Nutnet\LaravelSms\Providers\SmscRu (alias: smscru)
     * * \Nutnet\LaravelSms\Providers\SmsRu (alias: smsru)
     * * \Nutnet\LaravelSms\Providers\IqSmsRu (alias: iqsmsru)
     * @see Nutnet\LaravelSms\Providers
     */
    'provider' => env('NUTNET_SMS_PROVIDER', 'log'),

    /**
     * настройки, специфичные для провайдера
     */
    'providers' => [
        'log' => [
            // данный провайдер не имеет настроек
        ],
        'smpp' => [
            // все настройки провадера находятся в конфиг. файле franzose/laravel-smpp
        ],
        'smscru' => [
            'login' => env('SMSCRU_LOGIN'),
            'password' => env('SMSCRU_PASSWORD'),
            'message_defaults' => [],
        ],
        'smsru' => [
            'login' => env('SMSRU_LOGIN'),
            'password' => env('SMSRU_PASSWORD'),
            'message_defaults' => [],
        ],
        'iqsmsru' => [
            'login' => env('IQSMS_LOGIN'),
            'password' => env('IQSMS_PASSWORD'),
            'message_defaults' => [],
        ],
    ],
];
