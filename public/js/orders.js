const addToOrderBtn = document.querySelectorAll('.add-to-order-btn');

addToOrderBtn.forEach((element, index) => {
    element.addEventListener('click', () => {
        const loopIndex = index + 1;
        console.log(loopIndex);
        const worksitesLinks = document.querySelectorAll('.worksites-links-' + loopIndex);
        console.log(worksitesLinks);

        worksitesLinks.forEach(element => {
            element.addEventListener('click', (event) => {
                event.preventDefault();

                const inputQtty = document.getElementById('input-qtty-' + loopIndex);
                console.log(inputQtty);

                const qtty = inputQtty.value;
                // console.log(qtty);
                const href = element.href;

                if(qtty === ''){
                    return alert('Sélectionner une quantité');
                } else {
                    const cutQtty = href.split('/0');
                    // console.log(cutQtty);
                    const newHref = cutQtty[0] + '/' + qtty;
                    // console.log(newHref);
                    location.href = newHref;
                }
            })
        });
    })
});

