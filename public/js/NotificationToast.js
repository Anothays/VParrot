class NotificationToast {
    constructor(elementId) {
        this.toastLive = document.getElementById(elementId)
        this.toastBootstrap = bootstrap.Toast.getOrCreateInstance(this.toastLive)
        this.messageToast = document.getElementById('notificationMessage')
    }

    setMessage(message) {
        this.messageToast.innerText = message
    }

    show() {
        this.toastBootstrap.show()
    }

}