(function () {
    const w = window,
        l = w.location,
        n = w.navigator,
        d = w.document
    const uuid = d.currentScript.getAttribute("event-uuid")

    let deviceName = localStorage.getItem("mw:dn")
    if (!deviceName) {
        deviceName = (() => ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, a => (a ^ Math.random() * 16 >> a / 4).toString(16)))()
        localStorage.setItem("mw:dn", deviceName)
    }

    const t = (uuid, params) => {
        if (w._phantom || w.__nightmare || n.webdriver || w.Cypress) return
        if (l.hostname === 'localhost' || l.hostname.includes('.test')) {
            console.warn("Ignoring Event: localhost or .test", {uuid, params})
            return
        }

        fetch(`https://metricswave.com/webhooks/${uuid}?` + (new URLSearchParams(params)).toString())
    }

    w.metricswave = t

    const push = () => {
        const u = new URL(l)
        t(uuid, {
            f: 'script',
            visit: sessionStorage.getItem('mw') ? 0 : 1,
            deviceName: deviceName,
            path: l.pathname,
            domain: l.hostname,
            language: n.language,
            userAgent: n.userAgent,
            platform: n.platform,
            referrer: d.referrer,
            utm_source: u.searchParams.get('utm_source'),
            utm_medium: u.searchParams.get('utm_medium'),
            utm_campaign: u.searchParams.get('utm_campaign'),
            utm_term: u.searchParams.get('utm_term'),
            utm_content: u.searchParams.get('utm_content'),
        })
        sessionStorage.setItem('mw', '1')
    }

    let c, h = w.history;
    h.pushState && (c = h.pushState, h.pushState = function () {
        c.apply(this, arguments), push()
    }, w.addEventListener("popstate", push)), "prerender" === d.visibilityState ? d.addEventListener("visibilitychange", function () {
        n || "visible" !== d.visibilityState || push()
    }) : push()
})()
