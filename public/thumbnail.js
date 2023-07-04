document.addEventListener('DOMContentLoaded', () => {

    //On crée le Wrapper image
    const imgContainer = document.createElement('div')
    imgContainer.className = 'LOL'
    imgContainer.style.maxWidth = imgContainer.style.maxWidth = '250px'
    imgContainer.style.position = 'relative'
    imgContainer.style.top = '40px'

    //On crée le Img qui va recevoir le fichier
    const img = document.createElement('img')
    img.style.width = '100%'
    img.style.height = '100%'
    imgContainer.appendChild(img)

    // On crée le reader
    const reader = new FileReader()
    reader.onload = e => {
        img.src = e.target.result

    }

    imgContainer.addEventListener('click', () => {
        console.log('CROP')
    })

    // Element input qui est hidden. Il permet de choisir l'image
    const carsImageInputFile = document.getElementById('Cars_image_name_file')

    // On ajoute le wrapper image au DOM
    carsImageInputFile.parentNode.parentNode.appendChild(imgContainer)



    carsImageInputFile.addEventListener('change', () => {
        if (carsImageInputFile.files) {
            const file = carsImageInputFile.files[0]
            console.log(file)
            reader.readAsDataURL(file)
        }
    })


})