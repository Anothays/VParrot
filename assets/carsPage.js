import * as bootstrap from "bootstrap";

window.addEventListener('DOMContentLoaded', () => {
    initPage()
})

// init Page elements (filters, form, modals)
function initPage() {
    initFilters()
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
        const formData = new FormData(e.target)
        console.log(formData)
        fetch(this.action, {
            body: formData,
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

    // set and handle pagination links
    setPagination()

    //
    setPaginationRange()
}

// init AJAX filters
function initFilters() {
    const filtersInput = document.querySelectorAll("#filters-form input")
    const selectPagination = document.getElementById('pagination-select')

    initResetFiltersButton(filtersInput)
    filtersInput.forEach(input => {
        const initialValue = input.value
        let valueBeforeChanged = input.value
        input.addEventListener('focusin', (e) => {
            e.preventDefault()
            valueBeforeChanged = e.target.value
        })
        input.addEventListener('change', (e) => {
            e.preventDefault()
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
                    if (e.target.value > initialValue) {
                        e.target.value = initialValue
                    }
                    break
                case 'min':
                    oppositeInput = document.getElementById(`${idField}-max`)
                    oppositeInputValue = parseInt(oppositeInput.value)
                    if (e.target.value > oppositeInputValue) {
                        e.target.value = oppositeInputValue
                    }
                    if (e.target.value < initialValue) {
                        e.target.value = initialValue
                    }
                    break
                default:
                    break
            }
            // on récupère l'élément html form représentant les filtres
            const filtersForm = document.getElementById('filters-form')
            const form = new FormData(filtersForm)
            const url = new URL(window.location.href)
            url.searchParams.append('ajax', '1')
            url.searchParams.set('page', '1')
            url.searchParams.append('selectPagination', selectPagination.value)
            form.forEach((val, key) => url.searchParams.append(key,val))
            getData(url)
        })
    })
}

// init reset button filters
function initResetFiltersButton() {
    const resetButton = document.getElementById('filters-btn-reset')
    const selectPagination = document.getElementById('pagination-select')
    resetButton.addEventListener('click', e => {
        const url = new URL(window.location.href)
        url.searchParams.append('ajax', '1')
        url.searchParams.set('selectPagination', selectPagination.value)
        url.searchParams.set('page', '1')
        getData(url)
    })
}

// Get data from database
function getData(url) {
    console.log(url.searchParams.get('selectPagination'))
    const paginator = document.getElementById('pagination-list')
    const paginatorTitle = document.getElementById('pagination-title')
    const carsListItems = document.getElementById('cars-list-container')
    // carsListItems.innerHTML = '<div class="text-center vh-100"><p class="">Chargement...</p></div>'
    carsListItems.innerHTML = '<div class="text-center vh-100"><div class="spinner-border" role="status"><span class="visually-hidden">Chargement...</span></div></div>'
    fetch(url.href, {
        headers: {
            "X-Requested-With": "XMLHttpRequest"
        }
    })
    .then(res => res.json())
    .then(data => {
        paginator.innerHTML = data.pagination.content
        paginatorTitle.innerText = `${data.contentCount} annonce${data.contentCount > 1 ? 's' : ''} auto`
        if (data.contentCount === 0) {
            carsListItems.innerHTML = "<div class='alert alert-info'><p class='text-info text-xl-center'>Aucun véhicule ne correspond à vos critères de recherche !</p></div>"
        } else {
            carsListItems.innerHTML = data.content.content
            // On pré-remplie le formulaire avec la référence de l'annonce
            preFillForm()
            setPagination()
        }
    })
    .catch(error => {
        console.log(error)
    })
}

// Fill the form with the associated informations
function preFillForm() {
    const buttons = document.querySelectorAll('.trigerFormModal')
    buttons.forEach(button => {
        button.addEventListener('click', (e) => {
            const id = button.id.slice(4)
            const licensePlate = document.getElementById(`licensePlate-${id}`).innerText
            const subjectForm = document.getElementById('contact_message_subject')
            const brand = document.getElementById(`brand-${id}`).innerText
            const model = document.getElementById(`model-${id}`).innerText
            const modalTitle = document.getElementById('staticBackdropLabel')
            subjectForm.value = `${brand} ${model} : ${licensePlate}`
            subjectForm.setAttribute("readonly","true")
            modalTitle.innerText = `${licensePlate}`
        })
    })
}

// Handle pagination list with Ajax
function setPagination() {
    const paginationlinks = document.querySelectorAll('#pagination-list a')
    const selectPagination = document.getElementById('pagination-select')
    paginationlinks.forEach(a => {
        a.addEventListener('click', e => {
            e.preventDefault()
            const url = new URL(e.target.href)
            console.log(+url.searchParams.get('page'))
            url.searchParams.set('ajax', '1')
            url.searchParams.set('page', url.searchParams.get('page'))
            url.searchParams.set('selectPagination', selectPagination.value)
            getData(url)
        })
    })
}

// Handle pagination range with Ajax
function setPaginationRange() {
    const selectPagination = document.getElementById('pagination-select')
    selectPagination.addEventListener('change', function(e) {

        // on récupère l'élément html form représentant les filtres
        const filtersForm = document.getElementById('filters-form')
        const form = new FormData(filtersForm)
        const url = new URL(window.location.href)
        url.searchParams.append('ajax', '1')
        url.searchParams.set('page', '1')
        url.searchParams.append('selectPagination', selectPagination.value)
        form.forEach((val, key) => url.searchParams.append(key,val))
        getData(url)
    })
}