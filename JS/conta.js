

document.addEventListener('DOMContentLoaded', function () {
    const edit_btn = document.getElementsByClassName("edit_btn")[0];
    const edit_btn_p = edit_btn.querySelector('p');
    const forms = this.querySelectorAll('.inp > input');
    edit_btn.addEventListener('click', function () {
        forms.forEach((form) => {
            if (form.disabled == false)
            {
                form.disabled = true;
                form.parentElement.classList.add('disabled');
                edit_btn_p.innerHTML = 'Editar informações';
            }
            else
            {
                form.disabled = false;
                form.parentElement.classList.remove('disabled');
                edit_btn_p.innerHTML = 'Salvar informações';
            }
        });
    });
});