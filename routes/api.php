<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/sendsms', 'UserController@getCode'); // phone
Route::post('/register', 'UserController@register'); // phone,code,name
Route::post('/getlogin', 'UserController@getlogin'); // phone
Route::post('/login', 'UserController@login'); // phone,code
Route::post('/gettoken', 'ApiTokenController@update')->name('gettoken'); // user_id

Route::middleware('auth:api')->group(function () {
    Route::post('/activate', 'ActivationController@create');
    Route::post('/show', 'ActivationController@show');
    Route::get('/phonebooks', 'PhoneBookController@apiall');
});

// Описание

// Без авторизации:

// Запрос на получение смс
// method:post
// url:/api/sendsms
// params: phone

// Ошибки:
// Если пользователь уже зарегистрирован
// response: ['response'=>'Уже зарегистрирован']
// Если не прошла минута с последненго запроса с этим номером
// response: ['response'=>'Не прошла минута']

// Успешно:
// response: ['success'=>'success']

// Запрос на получение смс при логине
// method:post
// url:/api/getlogin
// params: phone

// Ошибки:
// Если пользователь не зарегистрирован
// response: ['response'=>'Пользователь не зарегистрирован']
// Если не прошла минута с последненго запроса с этим номером
// response: ['response'=>'Не прошла минута']

// Успешно:
// response: ['success'=>'success']

// Запрос на регистрацию
// method:post
// url:/api/register
// params: phone, code, name

// Ошибки:
// Если пользователь уже зарегистрирован
// response: ['response'=>'Уже зарегистрирован']
// Если пользователю не высылался код
// response: ['response'=>'Нет кода для этого пользователя']
// Если прошло более 10 минут с момента отправки кода (expires_at - формируется на серваке)
// response: ['response'=>'Код уже не действует']
// Если неверный код
// response: ['response'=>'Неверный код']

// Успешно:
// response: ['token' => $token]

// Запрос на логин
// method:post
// url:/api/login
// params: phone, code

// Ошибки:
// Если пользователь не зарегистрирован
// response: ['response'=>'Пользователь не зарегистрирован']
// Если пользователю не высылался код
// response: ['response'=>'Нет кода для этого пользователя']
// Если прошло более 10 минут с момента отправки кода (expires_at - формируется на серваке)
// response: ['response'=>'Код уже не действует']
// Если неверный код
// response: ['response'=>'Неверный код']

// Успешно:
// response: ['token' => $token]


// С авторизацией
// Запрос на "активацию" кода для пользователя
// method:post
// url:/api/activate
// params: code - 12-ти значный код активации
// authentification: bearer - token

// Ошибки:
// Нет зарегистрированного пользователя
// response: ['error'=>'No such user']
// Нет такого кода
// response: ['error'=>'No such code']
// Пользователь уже вактивировал этот код
// response: ['error'=>'У пользователя уже есть доступ к этому справочнику']
// Внутренние ошибки сервера (отвалилась база и т.д.)
// response: ['error'=>$e->getMessage()]
// Если у кода активации закончилось разрешенное число активаций
// response: ['error'=>'Превышено число лицензионных ключей']
// Код верный, но справочник удалили и т.д.
// response: ['error'=>'Ошибка - нет такого справочника']

// Успешно:
// response: json справочник 
// {
//   "data": {
//     "id": 2,
//     "phonebooks": [
//       {
//         "id": 3,
//         "phonebooks": [],
//         "contacts": [
//           {
//             "id": 1,
//             "phonebook_id": 3,
//             "first_name": "Игорь",
//             "last_name": "Петров",
//             "patronymic": "Валентинович",
//             "position": "Министр культуры",
//             "birthday": "2\/20\/1987",
//             "phone1": "79855558585",
//             "phone2": "79996665522",
//             "phone3": null,
//             "fax": "84955522336",
//             "email": "mm@mail.ru",
//             "created_at": "2020-04-25T11:19:57.000000Z",
//             "updated_at": "2020-04-25T11:19:57.000000Z"
//           }
//         ]
//       }
//     ]
//     "contacts": []
//     }
// }

// Запрос на показ справочника
// method:post
// url:/api/show
// params: code - 12-ти значный код активации
// authentification: bearer - token

// Ошибки:
// Нет зарегистрированного пользователя
// response: ['error'=>'No such user']
// Нет такого кода
// response: ['error'=>'No such code']
// Пользователь не активировал код
// response: ['error'=>'У пользователя нет доступа к этому справочнику']
// Код верный, но справочник удалили и т.д.
// response: ['error'=>'Ошибка - нет такого справочника']
// Успешно:
// response: json справочник 

// Запрос на все справочники
// method:post
// url:/api/phonebooks
// authentification: bearer - token

// Ошибки:

// Успешно:
// response: json справочники
// {
//   "phonebooks": [
//     {
//       "id": 1,
//       "parent_id": 0,
//       "title": "АГРОПРОМЫШЛЕННЫЙ КОМПЛЕКС РОССИИ",
//       "full_name": "АГРОПРОМЫШЛЕННЫЙ КОМПЛЕКС РОССИИ",
//       "description": "Описание",
//       "site": "website.ru",
//       "address": "г. Москва, ул. Красная площадь, д.2",
//       "email": "rusagro@mail.ru",
//       "created_at": "2020-04-25T10:01:11.000000Z",
//       "updated_at": "2020-04-25T10:01:11.000000Z",
//       "phonebooks": []
//     },
//     {
//       "id": 2,
//       "parent_id": 0,
//       "title": "ФЕДЕРАЛЬНЫЕ ОРГАНЫ ВЛАСТИ РОССИЙСКОЙ ФЕДЕРАЦИИ",
//       "full_name": "ФЕДЕРАЛЬНЫЕ ОРГАНЫ ВЛАСТИ РОССИЙСКОЙ ФЕДЕРАЦИИ",
//       "description": "Описание",
//       "site": "goverment.ru",
//       "address": "г. Москва, ул. Красная площадь, д.1",
//       "email": "rusfov@mail.ru",
//       "created_at": "2020-04-25T10:01:11.000000Z",
//       "updated_at": "2020-04-25T10:01:11.000000Z",
//       "phonebooks": [
//         {
//           "id": 3,
//           "parent_id": 2,
//           "title": "СОВЕТ ФЕДЕРАЦИИ ФЕДЕРАЛЬНОГО СОБРАНИЯ РОССИЙСКОЙ ФЕДЕРАЦИИ",
//           "full_name": "СОВЕТ ФЕДЕРАЦИИ ФЕДЕРАЛЬНОГО СОБРАНИЯ РОССИЙСКОЙ ФЕДЕРАЦИИ",
//           "description": "Описание",
//           "site": "fedsobr.ru",
//           "address": "г. Москва, ул. Большая Дмитровка, д.15",
//           "email": "fedsobr@mail.ru",
//           "created_at": "2020-04-25T10:01:11.000000Z",
//           "updated_at": "2020-04-25T10:01:11.000000Z",
//           "phonebooks": []
//         },
//         {
//           "id": 4,
//           "parent_id": 2,
//           "title": "ГОСУДАРСТВЕННАЯ ДУМА ФЕДЕРАЛЬНОГО СОБРАНИЯ РОССИЙСКОЙ ФЕДЕРАЦИИ",
//           "full_name": "СОВЕТ ФЕДЕРАЦИИ ФЕДЕРАЛЬНОГО СОБРАНИЯ РОССИЙСКОЙ ФЕДЕРАЦИИ",
//           "description": "Описание",
//           "site": "fedsobr.ru",
//           "address": "г. Москва, ул. Большая Дмитровка, д.15",
//           "email": "fedsobr@mail.ru",
//           "created_at": "2020-04-25T10:01:11.000000Z",
//           "updated_at": "2020-04-25T10:01:11.000000Z",
//           "phonebooks": []
//         },
//         {
//           "id": 5,
//           "parent_id": 2,
//           "title": "ГОСУДАРСТВЕННАЯ ДУМА ФЕДЕРАЛЬНОГО СОБРАНИЯ РОССИЙСКОЙ ФЕДЕРАЦИИ",
//           "full_name": "МИНИСТЕРСТВО СЕЛЬСКОГО ХОЗЯЙСТВА РОССИЙСКОЙ ФЕДЕРАЦИИ",
//           "description": "Описание",
//           "site": "fedsobr.ru",
//           "address": "г. Москва, ул. Большая Дмитровка, д.15",
//           "email": "fedsobr@mail.ru",
//           "created_at": "2020-04-25T10:01:11.000000Z",
//           "updated_at": "2020-04-25T10:01:11.000000Z",
//           "phonebooks": []
//         },
//         {
//           "id": 6,
//           "parent_id": 2,
//           "title": "ФЕДЕРАЛЬНАЯ СЛУЖБА ПО ВЕТЕРИНАРНОМУ И ФИТОСАНИТАРНОМУ НАДЗОРУ (РОССЕЛЬХОЗНАДЗОР)",
//           "full_name": "ФЕДЕРАЛЬНАЯ СЛУЖБА ПО ВЕТЕРИНАРНОМУ И ФИТОСАНИТАРНОМУ НАДЗОРУ (РОССЕЛЬХОЗНАДЗОР)",
//           "description": "Описание",
//           "site": "fedsobr.ru",
//           "address": "г. Москва, ул. Большая Дмитровка, д.15",
//           "email": "fedsobr@mail.ru",
//           "created_at": "2020-04-25T10:01:11.000000Z",
//           "updated_at": "2020-04-25T10:01:11.000000Z",
//           "phonebooks": []
//         }
//       ]
//     }
//   ]
// }


// Регистрация:
// /sendsms
// /register

// Логин:
// /getlogin
// /login

// Активация кода:
// /activate   - требуется авторизация(токен)

// Все справочники:
// /phonebooks - требуется авторизация(токен)

// Доступные контакты:
// /show       - требуется авторизация(токен) и лицензионный код
