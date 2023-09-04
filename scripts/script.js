if (document.querySelector(".logout-btn") !== null) {
const popupLinks = document.querySelectorAll('.edit-button')
const body = document.querySelector('body')
const lockPadding = document.querySelectorAll(".lockPadding");
const popupForm = document.querySelector('.popup-form')

let unlock = true

const timeout = 800;

if (popupLinks.length > 0){
    for (let index = 0; index < popupLinks.length; index++){
        const popupLink = popupLinks[index]
        popupLink.addEventListener("click", function(e){
            const popupName = popupLink.getAttribute('href').replace('#', '')
            const currentPopup = document.getElementById(popupName);
            popupOpen(currentPopup);
            e.preventDefault();
        })
    }
}

const popupCloseIcon = document.querySelectorAll('.close-popup')
if (popupCloseIcon.length >0){
    for (let index = 0; index < popupCloseIcon.length; index++){
        const el = popupCloseIcon[index]
        el.addEventListener('click', function(e){
            popupClose(el.closest('.popup'))
            e.preventDefault()
        })
    }
}

function popupOpen(currentPopup){
    if(currentPopup && unlock){
        const popupActive = document.querySelector('.popup-open')
        if (popupActive){
            popupClose(popupActive)
        }
        currentPopup.classList.add('open')
        currentPopup.addEventListener('click', function(e){
            if (!e.target.closest('.popup__content')){
                popupClose(e.target.closest('.popup'))
            }
        })
    }
}

function popupClose(popupActive){
    if (unlock){
        popupActive.classList.remove('open')
        //popupForm.reset()
        //console.log(popupForm)
        // for (let i = 0; i < popupForm.length; i++) {
        //     popupForm[i].textContent = '';
        // }
        // console.log(popupForm)
    }
}
}