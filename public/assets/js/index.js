// Remove a modal após o usuário fazer o cadastro.  
const button_modal = document.querySelector('#btn-modal');
const modal = document.querySelector('.modal-container');

button_modal.addEventListener('click', () =>  hideElement(modal));

modal.addEventListener('click', e =>  e.target.classList[0] == 'modal-container' &&  hideElement(modal) );

function hideElement(element) {
  element.classList.add('hide')
}

