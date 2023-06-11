// Make a get request to the next URL with current path if not localhost
// https://notifywave.com/webhooks/fbe17995-b16b-45d5-b33e-7a43b9a41313?path={value}
// Example: https://notifywave.com/webhooks/fbe17995-b16b-45d5-b33e-7a43b9a41313?path=/home

if (window.location.hostname !== 'localhost' && window.location.hostname !== 'notifywave.test') {
    fetch(
        'https://notifywave.com/webhooks/fbe17995-b16b-45d5-b33e-7a43b9a41313?' +
        'path=' + window.location.pathname +
        '&language=' + window.navigator.language +
        '&userAgent=' + window.navigator.userAgent +
        '&platform=' + window.navigator.platform +
        '&referrer=' + document.referrer
    )
} else {
    console.log('Tracking visit', {path: window.location.pathname})
}
