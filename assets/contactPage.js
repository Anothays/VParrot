import * as bootstrap from "bootstrap";

window.addEventListener('DOMContentLoaded', () => {
    initPage()
})

function initPage() {

    // notification toast
    const toastLiveExample = document.getElementById('liveToast')
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)

    // handle formSubmit
    const form = document.getElementById('contactForm')
    form.addEventListener('submit', function(e) {
        e.preventDefault()
        fetch(this.action, {
            body: new FormData(e.target),
            method: 'POST',
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        })
            .then(res => res.json())
            .then(_ => {
                toastBootstrap.show()
                e.target.reset()
            })
            .catch(error => console.log(error))
    })
    // form.addEventListener('submit', (e) => {
    //     e.preventDefault()
    //     const url = new URL(window.location.href)
    //     const params = new URLSearchParams()
    //     params.append('ajax', 'formSubmit')
    //     const data = document.getElementById('contactForm')
    //     const form = new FormData(data)
    //     form.forEach((val, key) => params.append(key, val))
    //     fetch(`${url}?${params.toString()}`, {
    //         method: 'POST',
    //             headers: {
    //                 "X-Requested-With": "XMLHttpRequest"
    //             }
    //     })
    //         .then(res => res.json())
    //         .then(data => {
    //             toastBootstrap.show()
    //             e.target.reset()
    //         })
    //         .catch(error => console.log(error))
    // })
}