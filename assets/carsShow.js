import * as bootstrap from "bootstrap";

window.addEventListener('DOMContentLoaded', () => {
    initPage()
    document.querySelectorAll('.trigerFormModal').forEach(button => {
        new TriggerFormBtn(button)
    })
})

// init Page elements (filters, form, modals)
function initPage() {

    // notification toast
    const toastLiveExample = document.getElementById('liveToast')
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)

    // form modal
    const modalForm = document.getElementById('staticBackdrop')
    const modalFormBootstrap = bootstrap.Modal.getOrCreateInstance(modalForm)

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
            modalFormBootstrap.hide()
            toastBootstrap.show()
            e.target.reset()
        })
        .catch(error => console.log(error))
    })
}

