import * as bootstrap from "bootstrap";
import NotificationToast from "./NotificationToast";
import Modal from "./Modal";

window.addEventListener('DOMContentLoaded', () => {
    initPage()
})

function initPage() {
    initBtn()
    const notification = new NotificationToast('liveToast')
    const modal = new Modal('staticBackdrop')
    // handle formSubmit
    const form = document.getElementById('testimonialForm')
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

}

function initBtn() {
    const testimonialsModalToggleBtn = document.getElementById('toggleTestimonials')
    testimonialsModalToggleBtn.addEventListener('click',  function(e) {
        const modalBody = document.querySelector('#testimonialsModal .modal-body')
        modalBody.innerHTML = '<div class="text-center vh-100"><div class="spinner-border" role="status"><span class="visually-hidden">Chargement...</span></div></div>'
        const url = new URL(document.location.href)
        url.searchParams.append('ajax', '1')
        url.searchParams.append('page', '1')
        // console.log(url)
        fetch(url, {headers: {"X-Requested-With": "XMLHttpRequest"}})
        .then(res => res.json())
        .then(data => {
            const ul = document.createElement('ul')
            ul.className = "m-0 p-0 text-center"
            ul.id = 'testimonials-list'
            data.data.forEach(testimonial => {
                const li = createBootstrapCard(testimonial)
                ul.append(li)
            })
            modalBody.innerHTML = null
            // Mettre pagination avec createPagination
            modalBody.appendChild(createPagination(data.pages, url))
            modalBody.appendChild(ul)
        })
        .catch(error => console.log(error))
    })
}

function initLinks(a) {
    a.addEventListener('click', function (e) {
        e.preventDefault()
        const url = new URL(document.location.href)
        url.searchParams.append('ajax', '1')
        url.searchParams.append('page', a.innerText)
        fetch(url, {headers: {"X-Requested-With": "XMLHttpRequest"}})
        .then(res => res.json())
        .then(data => {
            const ul = document.getElementById('testimonials-list')
            ul.innerHTML = null
            data.data.forEach(testimonial => {
                const li = createBootstrapCard(testimonial)
                ul.append(li)
            })
            const allLinks = document.querySelectorAll('#pagination-list a')
            allLinks.forEach(a => {
                if (a !== e.target) {
                    a.className = a.className.replace('active', 'lol').replace('disabled', 'mdr')
                }
            } )
            e.target.className += 'active disabled'
        })
        .catch(error => console.log(error))
    })
}

function createPagination(pages, url) {
    const nav = document.createElement('nav')
    nav.id = "pagination"
    const ol = document.createElement('ol')
    ol.id = 'pagination-list'
    ol.className = "pagination pagination-sm justify-content-center"
    for (let i = 1; i <= pages; i++) {
        const li = document.createElement('li')
        const a = document.createElement('a')
        li.className = "page-item"
        a.className = `page-link ${+url.searchParams.get('page') === i ? 'active disabled' : ''}`
        url.searchParams.set('page', `${i}`)
        a.href = url.toString()
        a.innerText = i
        initLinks(a)

        li.appendChild(a)
        ol.appendChild(li)
    }
    nav.appendChild(ol)
    return nav
}

function createBootstrapCard(testimonial) {
    const li = document.createElement('li')
    li.className = "card rounded-3 bg-success-subtle m-4 "

    const header = document.createElement('div')
    header.className = "card-header"

    const author = document.createElement('p')
    author.className = "fw-bold p-0 m-0"
    author.innerText = testimonial.author
    header.appendChild(author)

    for (let i = 1; i <= 5; i++) {
        if (+testimonial.note - i >= 0) {
            header.innerHTML += `<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#fede32}</style><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/></svg>`
        } else {
            header.innerHTML += `<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M287.9 0c9.2 0 17.6 5.2 21.6 13.5l68.6 141.3 153.2 22.6c9 1.3 16.5 7.6 19.3 16.3s.5 18.1-5.9 24.5L433.6 328.4l26.2 155.6c1.5 9-2.2 18.1-9.6 23.5s-17.3 6-25.3 1.7l-137-73.2L151 509.1c-8.1 4.3-17.9 3.7-25.3-1.7s-11.2-14.5-9.7-23.5l26.2-155.6L31.1 218.2c-6.5-6.4-8.7-15.9-5.9-24.5s10.3-14.9 19.3-16.3l153.2-22.6L266.3 13.5C270.4 5.2 278.7 0 287.9 0zm0 79L235.4 187.2c-3.5 7.1-10.2 12.1-18.1 13.3L99 217.9 184.9 303c5.5 5.5 8.1 13.3 6.8 21L171.4 443.7l105.2-56.2c7.1-3.8 15.6-3.8 22.6 0l105.2 56.2L384.2 324.1c-1.3-7.7 1.2-15.5 6.8-21l85.9-85.1L358.6 200.5c-7.8-1.2-14.6-6.1-18.1-13.3L287.9 79z"/></svg>`
        }
    }

    const body = document.createElement('div')
    body.className = "card-body p-2 overflow-hidden"
    const comment = document.createElement('p')
    comment.className = "fst-italic text-start"
    comment.innerText = `"${testimonial.comment}"`
    body.appendChild(comment)

    const footer = document.createElement('div')
    footer.className = "card-footer fw-light"
    const date = new Date(testimonial.createdAt)
    footer.innerHTML = `<span>Publié le ${date.getDate()}/${date.getMonth()}/${date.getFullYear()}</span>`

    li.appendChild(header)
    li.appendChild(body)
    li.appendChild(footer)

    return li
}
