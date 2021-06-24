document.querySelector('.fa-pen').addEventListener('click', () => {

  const node_list_of_paragraphs = document.querySelectorAll('.contact-data-item p');
  const container = document.querySelector('.contact-details');
  const contact_item = document.querySelectorAll('.contact-data-item');
  const id_contact = window.location.href.substr(window.location.href.indexOf('id=') + 3, 2);
  
  // Verifica se o form já foi adicionado a página
  if (node_list_of_paragraphs[0].firstChild.nodeName == "INPUT") {
    return
  }
  
  let form = document.createElement('form')
  form.action = `/editarContato?id_contato=${id_contact}`
  form.method = 'post'
  form.classList = 'contact-details'
  
  let div_button = document.createElement('div')
  div_button.classList = 'main-button border-radius d-flex-centralized'
  
  let button = document.createElement('button')
  button.type = 'submit'
  button.innerHTML = 'Salvar'
  
  // Transforma o NODE List em Array
  let array_list_of_paragraphs = Array.from(node_list_of_paragraphs)
  
  // Altera os elementos P do HTML pelos INPUTS
  array_list_of_paragraphs.map( (item, index) => {
    let text = item.textContent
    item.innerHTML = ""
                                      // Envia o valor do atributo name do input 
    addInputIntoParagraph(item, text, contact_item[index].children[0].textContent)
  })
  
  // Adiciona os inputs no formulário
  contact_item.forEach(element => {
    form.appendChild(element)
  });
  
  // Altera a DIV CONTAINER pelo formulário
  container.replaceWith(form)
  
  // Cria o input e seta os atributos
  function addInputIntoParagraph(element, content, name) {

    let inputContato = document.createElement('input')
    inputContato.classList = 'border-radius'
    inputContato.type = 'text'
    inputContato.value = content
    inputContato.name = name.toLowerCase();
  
    addAppendChild(element, inputContato)
  }
  
  function addAppendChild(parent, child) {
    parent.appendChild(child)
  }
  
  addAppendChild(div_button, button)
  addAppendChild(form, div_button)
})
  