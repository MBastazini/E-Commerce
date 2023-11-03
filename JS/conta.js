

document.addEventListener('DOMContentLoaded', function () {
    const edit_btn = document.getElementsByClassName("edit_btn")[0];
    const forms = this.querySelectorAll('.inp > input');
    const btn_submit = document.getElementById('btn_submit');
    edit_btn.classList.add('disabled');
    btn_submit.classList.remove('enabled');
    forms.forEach((form) => {
        form.disabled = true;
        form.parentElement.classList.add('disabled');

    });


    edit_btn.addEventListener('click', function () {
        forms.forEach((form) => {
            if (form.disabled == true)
            {
                form.disabled = false;
                form.parentElement.classList.remove('disabled');
                edit_btn.classList.add('enabled');
                btn_submit.classList.add('enabled');
            }
        });
    });

    const compras = this.querySelectorAll('.compra');
    compras.forEach((compra) => {
        compra.addEventListener('click', function () {
            if (compra.classList.contains('enabled'))
            {
                compra.classList.remove('enabled');
            }
            else{
                compra.classList.add('enabled');
            }
        });
    });
});