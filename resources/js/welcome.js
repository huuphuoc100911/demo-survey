const BrowserHistory = require('browser-history')

BrowserHistory.getChromeHistory((error, history) => {
    if (error) {
        console.error(error)
        return
    }

    for (let i = 0; i < 10; i++) {
        const page = history[i]
        console.log(`${i + 1}. ${page.title}: ${page.url}`)
    }
})