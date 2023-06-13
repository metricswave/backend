const urlRef = (new URLSearchParams(window.location.search)).get("utm_source")
if (urlRef !== null) {
    localStorage.setItem("metricswave:referrer", urlRef)
} else if (
    document.referrer
    && document.referrer !== window.location.hostname
    && localStorage.getItem("metricswave:referrer") === null
) {
    localStorage.setItem("metricswave:referrer", document.referrer)
}

const goToApp = () => {
    window.location.href = 'https://app.metricswave.com?utm_source=' + localStorage.getItem("metricswave:referrer")
}

document.querySelectorAll('.linkToApp').forEach((el) => {
    el.addEventListener('click', function (e) {
        e.preventDefault();
        goToApp()
    });
})
