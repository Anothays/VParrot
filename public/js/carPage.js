window.addEventListener('DOMContentLoaded', () => {
    new TriggerFormBtn(document.querySelectorAll('.trigerFormModal'))
    const notification = new NotificationToast('liveToast')
    const modal = new Modal('staticBackdrop')

    // handle formSubmit
    const form = document.getElementById('contactForm')
    form.addEventListener('submit', function(e) {
        e.preventDefault()
        fetch(this.action, {
            body: new FormData(e.target),
            method: 'POST',
            headers: {"X-Requested-With": "XMLHttpRequest"}
        })
            .then(res => res.json())
            .then(res => {
                notification.setMessage(res.message)
                modal.hide()
                notification.show()
                e.target.reset()
            })
            .catch(error => console.log(error))
    })
})



