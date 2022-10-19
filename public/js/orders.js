// Get all btns
const btnsPlus = document.querySelectorAll('.btn-plus')
const btnsMinus = document.querySelectorAll('.btn-minus')
const btnsValidate = document.querySelectorAll('.btn-validate')
// Get order price container
const tdOrderPrice = document.querySelector('#td-price')
// 
btnsPlus.forEach((element, index) => {
    element.addEventListener('click', (event) => {
        event.preventDefault()
        // Get link href
        const href = element.href
        // Get loopIndex
        const loopIndex = index +1
        // Get input 
        const inputQtty = document.querySelector('#input-qtty-' + loopIndex)
        // Get materials ordered price container
        const tdMatPrice = document.querySelector('#td-price-mat-' + loopIndex)
        // Call method fetching the datas
        fetchDatas(href, inputQtty, tdOrderPrice, tdMatPrice)
    })
});

btnsMinus.forEach((element, index) => {
    element.addEventListener('click', (event) => {
        event.preventDefault()
        // Get link href
        const href = element.href
        // Get loopIndex
        let loopIndex = index +1
        // Get input
        const inputQtty = document.querySelector('#input-qtty-' + loopIndex)
        // Get materials ordered price container
        const tdMatPrice = document.querySelector('#td-price-mat-' + loopIndex)
        // Call method fetching the datas
        fetchDatas(href, inputQtty, tdOrderPrice, tdMatPrice)
    })
});

btnsValidate.forEach((element, index) => {
    element.addEventListener('click', (event) => {
        event.preventDefault()
        // Get loopIndex
        let loopIndex = index +1
        // Get input and input value
        const inputQtty = document.querySelector('#input-qtty-' + loopIndex)
        const inputQttyValue = inputQtty.value
        // Get btn form action and building new href
        const href = element.form.action
        const hrefSplit = href.split('/')
        hrefSplit.pop()
        const newHref = hrefSplit.join('/') + '/' + inputQttyValue
        // Get materials ordered price container
        const tdMatPrice = document.querySelector('#td-price-mat-' + loopIndex)
        // Call method fetching the datas
        fetchDatas(newHref, inputQtty, tdOrderPrice, tdMatPrice)
    })
});

function fetchDatas(uri, input, orderPriceContainer, materialsPriceContainer) {
    fetch(uri)
        .then((response) => response.json())
        .then((response) => {
            input.value = response[0]
            orderPriceContainer.innerHTML = ''
            orderPriceContainer.innerHTML = response[1] + ' €'
            materialsPriceContainer.innerHTML = ''
            materialsPriceContainer.innerHTML = response[2] + ' €'
        })
}