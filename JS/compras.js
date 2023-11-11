
document.addEventListener('DOMContentLoaded', function () {
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

