import {initializeApp} from 'https://www.gstatic.com/firebasejs/9.1.3/firebase-app.js';
import {getMessaging, getToken, onMessage} from 'https://www.gstatic.com/firebasejs/9.1.3/firebase-messaging.js';

initializeApp(firebaseConfig);

const messaging = getMessaging();

getToken(messaging).then((currentToken) => {
    if (currentToken) {
        console.log(currentToken);
    } else {
        console.log('No registration token available. Request permission to generate one.');
    }
}).catch((err) => {
    console.log('An error occurred while retrieving token. ', err);
});

onMessage(messaging, (payload) => {
    if (typeof onNotify() === 'function') {
        onNotify(payload);
    } else {
        console.log('New notification received, implement the onNotify function to receive it', payload);
    }
});