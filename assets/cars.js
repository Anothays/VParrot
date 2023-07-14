import * as bootstrap from "bootstrap";

window.onload = () => {
    const filtersInput = document.querySelectorAll("#filters-form input")
    filtersInput.forEach(input => {
        let initialValue = input.value
        input.addEventListener('focusin', (e) => {
            e.preventDefault()
            initialValue = e.target.value
        })
        input.addEventListener('change', (e) => {
            e.preventDefault()
            const [idField,idSuffix] = e.target.id.split('-')
            let oppositeInput = null
            let oppositeInputValue = null
            switch (idSuffix) {
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
            if (e.target.value !== initialValue) {
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
                    }
                })
                .catch(error => {
                    console.log(error)
                })
            }
        })
    })

    // Notification Toast
    const toastLiveExample = document.getElementById('liveToast')
    const modalForm = document.getElementById('staticBackdrop')
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
    const modalFormBootstrap = bootstrap.Modal.getOrCreateInstance(modalForm)
    const modalFormSubmitButton = document.getElementById('modalFormSubmitButton')
    modalFormSubmitButton.addEventListener('click', (e) => {
        e.preventDefault()
        toastBootstrap.show()
        const url = new URL(window.location.href)
        const params = new URLSearchParams()
        const data = document.getElementById('contactForm')
        const form = new FormData(data)
        form.forEach((val, key) => params.append(key, val))
        fetch(`${url}?${params.toString()}`, {
            method: 'POST',
        })
            .then(res => res.json())
            .then(data => {
                console.log(data)
                modalFormBootstrap.hide()
            })
            .catch(error => console.log(error))
    })
}


