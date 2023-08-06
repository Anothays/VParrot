import * as bootstrap from "bootstrap";

export default class Modal {
    constructor(elementId) {
        this.modalForm = document.getElementById(elementId)
        this.modalFormBootstrap = bootstrap.Modal.getOrCreateInstance(this.modalForm)
    }

    hide() {
        this.modalFormBootstrap.hide()
    }
}