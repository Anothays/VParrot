import * as bootstrap from "bootstrap";

window.addEventListener('DOMContentLoaded', () => {
    initPage()
})

// init Page elements (filters, form, modals)
function initPage() {
    preFillForm()

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
        console.log(this.action)
        fetch(this.action, {
            body: new FormData(e.target),
            method: 'POST',
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



// Fill the form with the associated informations
function preFillForm() {
    const buttons = document.querySelectorAll('.trigerFormModal')
    buttons.forEach(button => {
        button.addEventListener('click', (e) => {
            const id = button.id.slice(4)
            const licensePlate = document.getElementById(`licensePlate-${id}`).innerText
            const objectForm = document.getElementById('contact_subject')
            const brand = document.getElementById(`brand-${id}`).innerText
            const model = document.getElementById(`model-${id}`).innerText
            const modalTitle = document.getElementById('staticBackdropLabel')
            objectForm.value = `${brand} ${model} : ${licensePlate}`
            modalTitle.innerText = `${licensePlate}`
        })
    })
}
