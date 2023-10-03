let zIndexCounter = 1; // Inicialize o contador de z-index

function Moveitem({ movementX, movementY }) {
  const activeItem = document.querySelector('.dev.active');

  if (activeItem) {
    let left = parseInt(activeItem.style.left) || 0;
    let top = parseInt(activeItem.style.top) || 0;
    activeItem.style.left = `${left + movementX}px`;
    activeItem.style.top = `${top + movementY}px`;
  }
}

function addDragEvents(element, btn_element) {
  element.addEventListener('mousedown', function (e) {
    if (btn_element.classList.contains('enabled')) {
      element.classList.add('active');
      element.style.zIndex = zIndexCounter++; // Defina o z-index e incremente o contador
      element.addEventListener('mousemove', Moveitem);
    }
  });

  document.addEventListener('mouseup', function (e) {
    const activeElements = document.querySelectorAll('.dev.active');
    activeElements.forEach((activeElement) => {
      activeElement.classList.remove('active');
      activeElement.removeEventListener('mousemove', Moveitem);
    });
  });
}


function CopyMessage(element)
{
    var copyText = element.querySelector('h1');

    copyText = copyText.innerText.replace(/\+|\(|\)|\-/g, '');
    navigator.clipboard.writeText(copyText);
    /* Crate a messege on the mouse position */
    var msg = document.createElement('div');
    msg.id = 'msg';
    msg.innerText = 'Copiado!';
    msg.style.left = event.clientX + 'px';
    msg.style.top = event.clientY + scrollY + 'px';
    document.body.appendChild(msg);
    /* Remove the message after 1 second */
    setTimeout(function(){document.body.removeChild(msg)}, 1000);
    
}
document.addEventListener('DOMContentLoaded', function () {
  const devElements = document.querySelectorAll('.dev');
  const btn_desliga = document.querySelectorAll('.dev_btn');

  devElements.forEach((devElement, index) => {
    const btn_element = btn_desliga[index];
    addDragEvents(devElement, btn_element);
  });

  btn_desliga.forEach((btn_element) => {
    btn_element.addEventListener('click', function (e) {
      if (btn_element.classList.contains('enabled')) {
        btn_element.classList.remove('enabled');
        const parent_dev = btn_element.parentElement;
        parent_dev.classList.add('enabled');
      } else {
        btn_element.classList.add('enabled');
        const parent_dev = btn_element.parentElement;
        parent_dev.classList.remove('enabled');
      }
    });
  });

  
});
