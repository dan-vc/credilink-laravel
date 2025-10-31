import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Generar contraseña de empleado
document.getElementById('generatePassword').addEventListener('click', function () {
    const length = 12; // puedes cambiarlo
    const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-+=";
    let password = "";

    for (let i = 0; i < length; i++) {
        const randomIndex = Math.floor(Math.random() * charset.length);
        password += charset[randomIndex];
    }

    // Mostrar la contraseña en el input
    const input = document.getElementById('password');
    input.value = password;

    // (Opcional) cambiar el tipo a texto por unos segundos
    input.type = 'text';
    setTimeout(() => input.type = 'password', 2000);
});

document.getElementById('copyPassword').addEventListener('click', async function () {
        const input = document.getElementById('password');
        const copyMessage = document.getElementById('copyMessage');

        try {
            await navigator.clipboard.writeText(input.value);
            copyMessage.classList.remove('hidden');
            copyMessage.classList.remove('text-red-500');
            copyMessage.textContent = 'Contraseña copiada';
            setTimeout(() => copyMessage.classList.add('hidden'), 2000);
        } catch (err) {
            copyMessage.classList.remove('hidden');
            copyMessage.classList.add('text-red-500');
            copyMessage.textContent = 'Error al copiar';
        }
    });