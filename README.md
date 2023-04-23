# Yii2 Firebase Cloud Messaging

Yii2 frameworki uchun [Firebase Cloud Messaging](https://firebase.google.com/docs/cloud-messaging) orqali push xabar yuborish va veb saytda qabul qilish uchun kengaytma.

> **Eslatma:** Ushbu kengaytma, Cloud Messaging API (Legacy) dan foydalanadi.

Avvalam bor [firebase](https://firebase.google.com) saytidan ro'yhatdan o'tishingiz va loyiha yaratishingiz lozim.
So'ng, yangi loyihangizning sozlamalaridan "Cloud Messaging" bo'limiga kirib, Cloud Messaging API (Legacy) ni faollashtirish kerak bo'ladi.

Faollashtirganingizdan so'ng `Server key` beriladi. Ushbu `Key`ni keyinroq config/web.php fayliga yozish kerak bo'ladi.

------------------

## O'rnatish

```bash
composer require uzdevid/yii2-fcm
```

yoki

```bash
php composer.phar require uzdevid/yii2-fcm
```

yoki `composer.json` fayliga ushbu qatorni qo'shing

```json
"uzdevid/yii2-fcm": "*"
```

------------------

## Sozlash

config/web.php

```php
return [
    // ...
    'components' => [
        // ...
        'notifier' => [
            'class' => 'uzdevid\fcm\Notifier',
            'serverKey' => '{serverKey}', // Cloud Messaging API (Legacy) ni faollashtirganingizdan so'ng, "Server key" beriladi.
        ],
        // ...
    ],
    // ...
]
````

## Push habar yuborish

```php
$token = "frYfozsx0K7e..."; // Push habar qabul qiluvchi qurilmaning tokeni
$notification = [
    'title' => 'Salom, dunyo!',
    'body' => 'Bu birinchi push habarim',
    'data' => [
        // qo'shimcha ma'lumotlar
    ]
];

$params = [
    // qo'shimcha parametrlar (majburiy emas)
];

Yii::app()->notifier->notify($token, $notification, $params);
```

> **Eslatma:** Push habar qabul qiluvchi qurilmaning tokenini mijoz (veb, mobil, ...) ilovalari serverga yuborishi kerak bo'ladi.

> **Eslatma:** Yuqorida foydalanilgan `notify()` metodida xatolik yuz bersa `Exception` va `BadRequestHttpException` istisnolarini larni qaytarishi mumkin.

Shular bilan server tomonidan qilinadigan ishlar tugadi.

------------------

## Veb saytda push habar qabul qilish

> **Eslatma:** Push habarlarni qabul qilish va uni ustida qandaydir amal bajarish faqat mijoz tarafida amalga oshiriladi. Hozirgi holatda mijoz bu veb sayt.

> **Eslatma:** Push habarlar foydalanuvchiga ko'rsatilishi uchun Operatsion tizim (Windows, Android, ...) brauzerga ruxsat bergan bo'lishi va brauzer ham
> veb saytga ruxsat bergan bo'lishi hamda veb sayt `https` holatida ishlashi shart.


Firebase loyihangizning bosh sahifasida veb ilova yaratishingiz lozim. Ilova yaratilganidan so'ng, Sizga mijoz tarafni sozlash uchun kerakli ma'lumotlar beriladi.

### 1. Sozlash

Yuqorida berilgan ma'lumotlarni `config/params.php` fayliga yozishingiz kerak.

```php
return [
    // ...
    'fcm' => [
        'apiKey' => '{apiKey}',
        'authDomain' => '{authDomain}',
        'databaseURL' => '{databaseURL}',
        'projectId' => '{projectId}',
        'storageBucket' => '{storageBucket}',
        'messagingSenderId' => '{messagingSenderId}',
        'appId' => '{appId}',
        'measurementId' => '{measurementId}',
        'vapidKey' => '{vapidKey}',
    ],
    // ...
];
```

yoki `<head>` tegi ichiga quyidagi konstantani yozishingiz kerak.

```javascript
const firebaseConfig = {
    apiKey: "{apiKey}",
    authDomain: "{authDomain}",
    databaseURL: "{databaseURL}",
    projectId: "{projectId}",
    storageBucket: "{storageBucket}",
    messagingSenderId: "{messagingSenderId}",
    appId: "{appId}",
    measurementId: "{measurementId}",
    vapidKey: "{vapidKey}"
};
```

> **Eslatma:** `vapidKey` parametrini olish uchun Web Push Certificate yaratishingiz kerak bo'ladi. Web Push Certificates (Project settings/Cloud Messaging/Web configuration) bo'limida yaratib olishingiz mumkin.

------------------

### 2. Fayllarni ulash

`layouts/main.php` - faylingizga (yoki boshqa umumiy layout fayliga) ushbu qatorni qo'shing. Ushbu qator sahifaga kerakli bo'lgan js fayllarini ulaydi.

```php
\uzdevid\fcm\FcmAsset::register($this);
```

### 3. Qurilma tokenini qabul qilish va serverga yuborish

`<head>` tegi ichiga quyidagi javascript funksiyani yarating va serverga yuborish uchun kodni yozing. Ushbu funksiya qurilma tokeni qabul qilinganda kengaytma tomonidan ishga tushuriladi

```javascript
function saveToken(token) {
    // serverga yuborish uchun kodni yozing
}
```

### 4. Push habarni sahifada qabul qilish

`<head>` tegi ichiga quyidagi javascript kodni yozing. Ushbu funksiya yangi push habar kelganida kengaytma tomonidan ishga tushuriladi.
`payload` - serverdan yuborilgan ma'lumotlar

```javascript
function onNotify(payload) {
    // habarni foydalanuvchiga ko'rsatish, yoki boshqa amallarni bajarish uchun kodni yozing
}
```

 `onNotify()` funksiyasi foydalanuvchi veb sahifada faol bo'lgan vaqti kelgan push habarni ko'rsatish uchun kerak bo'ladi.

### 5. Brauzer faol bo'lmagan vaqti push habarlarni qabul qilish

`web` papkasi ichiga `firebase-messaging-sw.js` faylini yarating va quyidagi kodni yozing.

web/firebase-messaging-sw.js

```javascript
importScripts("https://www.gstatic.com/firebasejs/9.1.3/firebase-app-compat.js");
importScripts("https://www.gstatic.com/firebasejs/9.1.3/firebase-messaging-compat.js");

firebase.initializeApp({
    apiKey: "{apiKey}",
    authDomain: "{authDomain}",
    projectId: "{projectId}",
    storageBucket: "{storageBucket}",
    messagingSenderId: "{messagingSenderId}",
    appId: "{appId}",
    measurementId: "{measurementId}",
    vapidKey: "{vapidKey}"
});

const messaging = firebase.messaging();
```

Ushbu kod faylni brauzeringiz `Service worker` sifatida faollashtiradi.
Tekshirib ko'rishingiz uchun `ctrl+shift+i` tugmalarini bosing va `Application/Service workers` bo'limiga o'ting.

------------------

### 6. Tekshirish

Barchasini sozlab bo'lganingizdan so'ng, server yoki curl, postman yoki boshqa yo'llar orqali push habar yuborib tekshirib ko'rishingiz mumkin.

```bash
curl --location 'https://fcm.googleapis.com/fcm/send' \
--header 'Authorization: key={serverKey}' \
--header 'Content-Type: application/json' \
--data '{
    "to": "{token}",
    "notification": {
        "title": "test",
        "body": "test",
        "data": {}
    }
}'
```

------------------

- Taklif va shikoyatlar uchun: https://devid.uz

- Moddiy taraflama qo'llab quvvatlash uchun: https://payme.uz/@uzdevid