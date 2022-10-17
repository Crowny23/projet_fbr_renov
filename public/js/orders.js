const addToOrderBtn = document.querySelectorAll('.add-to-order-btn')

addToOrderBtn.forEach((element, index) => {
    element.addEventListener('click', () => {
        // Get loop index to access correct element
        const loopIndex = index + 1
        // Get worksites link of opened modal
        const worksitesLinks = document.querySelectorAll('.worksites-links-' + loopIndex)
        // Get submit btn of opened modal
        const btnSubmitModal = document.getElementById('submit-order-modal-' + loopIndex)
        // Get input of opened modal
        const inputOrder = document.getElementById('input-order-modal-' + loopIndex)

        btnSubmitModal.addEventListener('click', (e) => {
            e.preventDefault()

            // Get element we need from worksitesLinks to build a new html code in fetchOrderByName()
            // Get href of a worksiteslink
            const worksitesLinksHref = worksitesLinks[0].href
            // Split href
            const splitHref = worksitesLinksHref.split('/')
            // Get a tag html
            const worksitesLinksOuterHtml = worksitesLinks[0].outerHTML
            // Split a tag
            const splitOuterHtml = worksitesLinksOuterHtml.split(' ')

            const value = inputOrder.value

            // Call XMLHttpRequest
            fetchOrderByName(value, splitHref, splitOuterHtml, loopIndex)

            // Get the qtty with getQtty() method after DOM modification
            getQtty(loopIndex)
        })
        // Get the qtty with getQtty() method
        getQtty(loopIndex)
    })
})

// getQtty method
function getQtty(index) {
    // get worksites links in case DOM has been modify when method called
    const worksitesLinks = document.querySelectorAll('.worksites-links-' + index)

    // Event listener for each worksite link
    worksitesLinks.forEach(element => {
        element.addEventListener('click', (event) => {
            event.preventDefault()

            // Get input where quantity is add
            const inputQtty = document.getElementById('input-qtty-' + index)
            // Get qauntity
            const qtty = inputQtty.value
            // Get link href
            const href = element.href

            // Check if quantity has been given
            if(qtty === ''){
                return alert('Sélectionner une quantité')
            } else {
                // Replace quantity default value (0) by value given into link href
                const cutQtty = href.split('/0')
                const newHref = cutQtty[0] + '/' + qtty
                // Assign new href
                location.href = newHref
            }
        })
    })
}

// XMLHttpRequest method
function fetchOrderByName(name, arrayHref, arrayOuterHtml, index) {
    // Get containers
    const listOrders = document.getElementById('list-orders-' + index)
    console.log(listOrders)

    // Open a new XMLHttpRequest
    const xhr = new XMLHttpRequest()

    xhr.open('GET', './ajax/orders/' + name, true)

    xhr.onreadystatechange = function () {
        // Test if XMLHttpRequest is complete and succesful
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            // Parse JSON Data into Object
            let datas = JSON.parse(this.responseText.replace(/&quot;/g,'"'))
            // Initialize variable that will contain new html code
            let listDom = ''
            
            // For each element of datas building the new html code
            for (let data of Object.values(datas)) {
                // Building new href
                let newHref = arrayHref[0] + '/' + arrayHref[1] + '/' + arrayHref[2] + '/' + arrayHref[3] + '/' + arrayHref[4] + '/' + data.id + '/' + arrayHref[6] + '/' + arrayHref[7]
                // Building new innerHtml
                let newInnerHtml = data.name
                // Building new OuterHtml
                let newOuterHtml =  '<a ' + arrayOuterHtml[1] + ' href="' + newHref + '">' + newInnerHtml + '</a><br>'
                // Add html code into the previously initialize variable
                listDom += newOuterHtml
            }
            // Adding new html code into all containers where html code should change
            
            listOrders.innerHTML = ''
            listOrders.innerHTML = listDom
        }
    }
    xhr.send()
}

