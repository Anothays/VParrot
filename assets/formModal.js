window.onload = () => {
    const buttons = document.querySelectorAll('.trigerFormModal')
    console.log(buttons)
    buttons.forEach(button => {
        button.addEventListener('click', (e) => {
            const id = button.id.slice(4)
            const ref = +document.getElementById(`ref-${id}`).innerText.slice(5)
            const objectForm = document.getElementById('contact_subject')
            const brand = document.getElementById(`brand-${id}`).innerText
            const model = document.getElementById(`model-${id}`).innerText
            const modalTitle = document.getElementById('staticBackdropLabel')
            console.log(objectForm)
            objectForm.value = `ref : ${ref} - ${brand} ${model}`
            modalTitle.innerText = `ref : ${ref}`
        })
    })
}