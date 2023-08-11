class FilterInputs {
    constructor() {
        this.#initResetFiltersButton()
        this.#initFiltersInput()
        this.#setPagination()
        this.#setPaginationRange()
    }

    // fetch data from database
    #getData(url) {
        const paginator = document.getElementById('pagination-list')
        const paginatorTitle = document.getElementById('pagination-title')
        const carsListItems = document.getElementById('cars-list-container')
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
                    new TriggerFormBtn(document.querySelectorAll('.trigerFormModal'))
                    this.#setPagination()
                }
            })
            .catch(error => {
                console.log(error)
            })
    }

    // init reset button filters
    #initResetFiltersButton() {
        const resetButton = document.getElementById('filters-btn-reset')
        const selectPagination = document.getElementById('pagination-select')
        resetButton.addEventListener('click', e => {
            const url = new URL(window.location.href)
            url.searchParams.append('ajax', '1')
            url.searchParams.set('selectPagination', selectPagination.value)
            url.searchParams.set('page', '1')
            this.#getData(url)
        })
    }

    // init ajax filters
    #initFiltersInput() {
        const filtersInput = document.querySelectorAll("#filters-form input")
        const selectPagination = document.getElementById('pagination-select')
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
                this.#getData(url)
            })
        })
    }

    // Handle pagination list with ajax
    #setPagination() {
        const paginationlinks = document.querySelectorAll('#pagination-list a')
        const selectPagination = document.getElementById('pagination-select')
        paginationlinks.forEach(a => {
            a.addEventListener('click', e => {
                e.preventDefault()
                const url = new URL(e.target.href)
                url.searchParams.set('ajax', '1')
                url.searchParams.set('page', url.searchParams.get('page'))
                url.searchParams.set('selectPagination', selectPagination.value)
                this.#getData(url)
            })
        })
    }

    // Handle pagination range with ajax
    #setPaginationRange() {
        const selectPagination = document.getElementById('pagination-select')
        selectPagination.addEventListener('change', function(e) {
            const filtersForm = document.getElementById('filters-form')
            const form = new FormData(filtersForm)
            const url = new URL(window.location.href)
            url.searchParams.append('ajax', '1')
            url.searchParams.set('page', '1')
            url.searchParams.append('selectPagination', selectPagination.value)
            form.forEach((val, key) => url.searchParams.append(key,val))
            this.#getData(url)
        }.bind(this))
    }
}