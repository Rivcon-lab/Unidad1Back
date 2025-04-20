// Espera a que el DOM esté completamente cargado antes de ejecutar cualquier código
document.addEventListener('DOMContentLoaded', function() {
    // --- ELEMENTOS DEL DOM ---
    const navToggle = document.getElementById('nav-toggle');
    const navMenu = document.getElementById('nav-menu');
    const themeToggle = document.getElementById('theme-toggle');
    const logo = document.getElementById('logo');
    const contactForm = document.getElementById('contact-form');
    const responseDiv = document.getElementById('contact-response'); // Asegúrate de tener este div en tu HTML
  
    // --- CONFIGURACIÓN INICIAL ---
    const savedTheme = localStorage.getItem('theme') || 'dark';
    document.body.setAttribute('data-theme', savedTheme);
    themeToggle.textContent = savedTheme === 'dark' ? '☀️' : '🌙';
  
    // --- FUNCIONES DE UTILIDAD ---
    // Función para actualizar el logo según tema y tamaño
    function updateLogo() {
        const currentTheme = document.body.getAttribute('data-theme');
        const isSmall = window.innerWidth <= 600;
        
        // Precargar la imagen antes de cambiarla
        const newImage = new Image();
        const newSrc = currentTheme === 'dark' 
            ? (isSmall ? 'img/logowsmall.png' : 'img/logow.png')
            : (isSmall ? 'img/logobsmall.png' : 'img/logob.png');
            
        newImage.onload = function() {
            logo.src = newSrc;
        };
        newImage.src = newSrc;
    }
  
    // Función para alternar el tema
    function toggleTheme() {
        const currentTheme = document.body.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        document.body.setAttribute('data-theme', newTheme);
        themeToggle.textContent = newTheme === 'dark' ? '☀️' : '🌙';
        localStorage.setItem('theme', newTheme);
        updateLogo();
    }
  
    // --- EVENTOS DE NAVEGACIÓN ---
    // Toggle del menú hamburguesa
    navToggle.addEventListener('click', () => {
        navMenu.classList.toggle('active');
    });
  
    // Cerrar menú al hacer click en enlaces
    const navLinks = document.querySelectorAll('#nav-menu a');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            navMenu.classList.remove('active');
        });
    });
  
    // Cerrar menú al hacer click fuera
    document.addEventListener('click', (event) => {
        const isClickInsideNav = navMenu.contains(event.target);
        const isClickOnToggle = navToggle.contains(event.target);
        
        if (!isClickInsideNav && !isClickOnToggle && navMenu.classList.contains('active')) {
            navMenu.classList.remove('active');
        }
    });
  
    // --- EVENTOS DE REDIMENSIONAMIENTO Y TEMA ---
    // Manejar redimensionamiento con debounce para mejor rendimiento
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            if (window.innerWidth > 768) {
                navMenu.classList.remove('active');
            }
            updateLogo();
        }, 250); // Espera 250ms después del último evento resize
    });
  
    // Evento para cambio de tema
    themeToggle.addEventListener('click', toggleTheme);
  
    // --- MANEJO DEL FORMULARIO DE CONTACTO ---
    if (contactForm) {
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();
  
            // Obtener y limpiar valores
            const formData = {
                name: document.getElementById('name').value.trim(),
                email: document.getElementById('email').value.trim(),
                service: document.getElementById('service').value.trim(),
                message: document.getElementById('message').value.trim()
            };
  
            // Validación
            if (Object.values(formData).some(value => !value)) {
                if (responseDiv) {
                    responseDiv.textContent = 'Por favor, completa todos los campos.';
                    responseDiv.style.color = 'red';
                } else {
                    alert('Por favor, completa todos los campos.');
                }
                return;
            }
  
            // Enviar datos al backend usando fetch
            fetch('api/contact/procesar_contacto.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (responseDiv) {
                    responseDiv.textContent = data.message;
                    responseDiv.style.color = data.success ? 'green' : 'red';
                } else {
                    alert(data.message);
                }
                if (data.success) contactForm.reset();
            })
            .catch(error => {
                if (responseDiv) {
                    responseDiv.textContent = 'Error al enviar el formulario.';
                    responseDiv.style.color = 'red';
                } else {
                    alert('Error al enviar el formulario.');
                }
                console.error(error);
            });
        });
    }
  
    // --- INICIALIZACIÓN ---
    // Actualizar logo inicial
    updateLogo();
  
    // Precargar todas las versiones del logo para cambios más suaves
    const logoVersions = [
        'img/logob.png',
        'img/logobsmall.png',
        'img/logow.png',
        'img/logowsmall.png'
    ];
    logoVersions.forEach(src => {
        const img = new Image();
        img.src = src;
    });
  });