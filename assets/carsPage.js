import * as bootstrap from "bootstrap";

window.addEventListener('DOMContentLoaded', () => {
    initPage()
})

// init AJAX filters
function initFilters() {
    const filtersInput = document.querySelectorAll("#filters-form input")
    filtersInput.forEach(input => {
        let initialValue = input.value
        input.addEventListener('focusin', (e) => {
            e.preventDefault()
            initialValue = e.target.value
        })
        input.addEventListener('change', (e) => {
            e.preventDefault()
            console.log(initialValue)
            const [idField,idSuffix] = e.target.id.split('-')
            let oppositeInput = null
            let oppositeInputValue = null
            switch (idSuffix) { // On empêche le max d'être inférieur au min et vice-versa
                case 'max':
                    oppositeInput = document.getElementById(`${idField}-min`)
                    oppositeInputValue = parseInt(oppositeInput.value)
                    if (e.target.value < oppositeInputValue) {
                        e.target.value = oppositeInputValue
                    }
                    break
                case 'min':
                    oppositeInput = document.getElementById(`${idField}-max`)
                    oppositeInputValue = parseInt(oppositeInput.value)
                    if (e.target.value > oppositeInputValue) {
                        e.target.value = oppositeInputValue
                    }
                    break
                default:
                    break
            }
            // on récupère l'élément html form
            const filtersForm = document.getElementById('filters-form')
            const form = new FormData(filtersForm)
            const params = new URLSearchParams()
            params.append('ajax', 'filters')
            const url = new URL(window.location.href)
            form.forEach((val, key) => params.append(key,val))
            fetch(`${url}?${params.toString()}`, {
                headers: {
                    content: 'application/json'
                }
            })
                .then(res => res.json())
                .then(data => {
                    // console.log(data)
                    const carsListItems = document.getElementById('cars-list-content')
                    if (data.contentLength === 0) {
                        carsListItems.innerHTML = "<div class='alert alert-info'><p class='text-info text-xl-center'>Aucun véhicule ne correspond à vos critères de recherche !</p></div>"
                    } else {
                        carsListItems.innerHTML = data.content.content
                        // On pré-remplie le formulaire avec la référence de l'annonce
                        preFillForm()
                    }
                })
                .catch(error => {
                    console.log(error)
                })
        })
    })
}

// On pré-remplie le formulaire avec la référence de l'annonce
function preFillForm() {
    const buttons = document.querySelectorAll('.trigerFormModal')
    buttons.forEach(button => {
        button.addEventListener('click', (e) => {
            const id = button.id.slice(4)
            const ref = +document.getElementById(`ref-${id}`).innerText.slice(5)
            const objectForm = document.getElementById('contact_subject')
            const brand = document.getElementById(`brand-${id}`).innerText
            const model = document.getElementById(`model-${id}`).innerText
            const modalTitle = document.getElementById('staticBackdropLabel')
            objectForm.value = `ref : ${ref} - ${brand} ${model}`
            modalTitle.innerText = `ref : ${ref}`
        })
    })
}

// init boostrap item
function initPage() {
    initFilters()
    preFillForm()
    // notification toast
    const toastLiveExample = document.getElementById('liveToast')
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
    // form modal
    const modalForm = document.getElementById('staticBackdrop')
    const modalFormBootstrap = bootstrap.Modal.getOrCreateInstance(modalForm)
    // bouton submit du formulaire contenu dans la modale
    const modalFormSubmitButton = document.getElementById('FormSubmitButton')
    modalFormSubmitButton.addEventListener('click', (e) => {
        e.preventDefault()
        toastBootstrap.show()
        const url = new URL(window.location.href)
        const params = new URLSearchParams()
        params.append('ajax', 'formSubmit')
        const data = document.getElementById('contactForm')
        const form = new FormData(data)
        form.forEach((val, key) => params.append(key, val))
        fetch(`${url}?${params.toString()}`, {
            method: 'POST',
        })
            .then(res => res.json())
            .then(data => {
                console.log(data)
                if (modalFormBootstrap) {
                    modalFormBootstrap.hide()
                }
            })
            .catch(error => console.log(error))
    })
}