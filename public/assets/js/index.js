// Remove a modal após o usuário fazer o cadastro. 
const modal = document.querySelector('.modal-container');

document.querySelector('#btn-modal').addEventListener('click', () =>  hideElement(modal));
modal.addEventListener('click', e =>  e.target.classList[0] == 'modal-container' &&  hideElement(modal) );

function hideElement() {
  modal.classList.add('hide')
}