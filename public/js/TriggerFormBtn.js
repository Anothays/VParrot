// Handle click event on button "Contacter le vendeur"
class TriggerFormBtn {
    constructor(buttons) {
        this.buttons = buttons
        this.buttons.forEach(button => {
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
}