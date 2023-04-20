# Notification

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

config/params.php

```php
return [
'notification' => [
    'firebaseConfig' => [
        'apiKey' => '{apiKey}',
        'authDomain' => '{authDomain}',
        'databaseURL' => '{databaseURL}',
        'projectId' => '{projectId}',
        'storageBucket' => '{storageBucket}',
        'messagingSenderId' => '{messagingSenderId}',
        'appId' => '{appId}',
        'measurementId' => '{measurementId}',
        'vapidKey' => '{vapidKey}',
    ]
];
```