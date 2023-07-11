window.onload = () => {
    // const mileageMinInitialValue = document.getElementById('mileage-min').value
    // const mileageMaxInitialValue = document.getElementById('mileage-max').value
    // const priceMinInitialValue = document.getElementById('price-min').value
    // const priceMaxInitialValue = document.getElementById('price-max').value
    // const yearMinInitialValue = document.getElementById('year-min').value
    // const yearMaxInitialValue = document.getElementById('year-max').value
    // const filtersResetButton =  document.getElementById('filters-btn-reset')
    // filtersResetButton.addEventListener('click', (e) => {
    //     e.preventDefault()
    //     document.getElementById('mileage-min').value = mileageMinInitialValue
    //     document.getElementById('mileage-max').value = mileageMaxInitialValue
    //     document.getElementById('price-min').value = priceMinInitialValue
    //     document.getElementById('price-max').value = priceMaxInitialValue
    //     document.getElementById('year-min').value = yearMinInitialValue
    //     document.getElementById('year-max').value = yearMaxInitialValue
    // })

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
                params.append('ajax', '1')
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
}


