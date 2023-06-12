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

const urlRef = (new URLSearchParams(window.location.search)).get("utm_source")
if (urlRef !== null) {
    localStorage.setItem("nw:referrer", urlRef)
} else if (
    document.referrer
    && document.referrer !== window.location.hostname
    && localStorage.getItem("nw:referrer") === null
) {
    localStorage.setItem("nw:referrer", document.referrer)
}

const goToApp = () => {
    window.location.href = 'https://app.metricswave.com?utm_source=' + localStorage.getItem("nw:referrer")
}

document.querySelectorAll('.linkToApp').forEach((el) => {
    el.addEventListener('click', function (e) {
        e.preventDefault();
        goToApp()
    });
})
