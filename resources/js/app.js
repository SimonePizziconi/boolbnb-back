import './bootstrap';
import '~resources/scss/app.scss';
import '~icons/bootstrap-icons.scss';
import * as bootstrap from 'bootstrap';
import.meta.glob([
    '../img/**'
])

document.getElementById('togglePassword').addEventListener('click', function (e) {
    // Ottieni l'input della password
    const password = document.getElementById('password');

    // Ottieni il tipo di input attuale e alterna tra 'password' e 'text'
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);

    // Cambia l'icona dell'occhio
    this.querySelector('i').classList.toggle('fa-eye');
    this.querySelector('i').classList.toggle('fa-eye-slash');
});

