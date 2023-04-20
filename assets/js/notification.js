import {initializeApp} from 'https://www.gstatic.com/firebasejs/9.1.3/firebase-app.js';
import {getMessaging, getToken, onMessage} from 'https://www.gstatic.com/firebasejs/9.1.3/firebase-messaging.js';

initializeApp(firebaseConfig);

const messaging = getMessaging();

getToken(messaging).then((token) => {
    if (token) {
        if (typeof saveToken === 'function') {
            saveToken(token);
        } else {
            console.log('The token is received, implement the saveToken function to receive it', token);
        }
    } else {
        console.log('No registration token available. Request permission to generate one.');
    }
}).catch((err) => {
    console.log('An error occurred while retrieving token. ', err);
});

onMessage(messaging, (payload) => {
    if (typeof onNotify === 'function') {
        onNotify(payload);
    } else {
        console.log('New notification received, implement the onNotify function to receive it', payload);
    }
});