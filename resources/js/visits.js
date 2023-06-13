(function () {
    const w = window,
        l = w.location,
        n = w.navigator,
        d = w.document

    const t = (uuid, params) => {
        if (w._phantom || w.__nightmare || n.webdriver || w.Cypress) return
        if (l.hostname === 'localhost' || l.hostname.includes('.test')) {
            console.warn("Ignoring Event: localhost or .test")
            return
        }

        fetch(`https://metricswave.com/webhooks/${uuid}?` + (new URLSearchParams(params)).toString())
    }

    w.metricswave = t

    const push = () => {
        const r = localStorage.getItem('metricswave:referrer')
            || (new URLSearchParams(w.location.search)).get("utm_source")
            || document.referrer
        t(d.currentScript.getAttribute("event-uuid"), {
            f: 'script',
            path: l.pathname,
            domain: l.hostname,
            language: n.language,
            userAgent: n.userAgent,
            platform: n.platform,
            referrer: r
        })
    }

    let c, h = w.history;
    h.pushState && (c = h.pushState, h.pushState = function () {
        c.apply(this, arguments), push()
    }, w.addEventListener("popstate", push)), "prerender" === d.visibilityState ? d.addEventListener("visibilitychange", function () {
        n || "visible" !== d.visibilityState || push()
    }) : push()
})()
