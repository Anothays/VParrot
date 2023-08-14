window.addEventListener('DOMContentLoaded', () => {
    initPage()
})

function initPage() {

    // notification toast
    const notification = new NotificationToast('liveToast')
    // const toastLiveExample = document.getElementById('liveToast')
    // const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)

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
                notification.show()
                e.target.reset()
            })
            .catch(error => console.log(error))
    })
}