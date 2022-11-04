const sidebar = document.getElementById('sidebar')
const menu = document.getElementById('menu-wrapper')
const btnOpen = document.getElementById('btn-open')
const btnClose = document.getElementById('btn-close')
const btnWrapperOpen = document.getElementById('btn-wrapper-open')
const btnWrapperClose = document.getElementById('btn-wrapper-close')

function displayMenu() {
    btnOpen.addEventListener('click', () => {
        menu.classList.toggle('d-none')
        sidebar.classList.remove('col-1')
        sidebar.classList.add('col-12')
        sidebar.classList.add('position-absolute')
        btnWrapperOpen.classList.add('d-none')
        btnWrapperClose.classList.remove('d-none')
    })
}

function hideMenu() {
    btnClose.addEventListener('click', () => {
        menu.classList.toggle('d-none')
        sidebar.classList.add('col-1')
        sidebar.classList.remove('col-12')
        sidebar.classList.remove('position-absolute')
        btnWrapperOpen.classList.remove('d-none')
        btnWrapperClose.classList.add('d-none')
    })
}

displayMenu()
hideMenu()