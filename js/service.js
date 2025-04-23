/**
 * Carga los servicios desde la API y los muestra en cards con íconos.
 */
function cargarDatos() {
    // Muestra el mensaje de carga y oculta errores previos
    document.getElementById('loading-msg').style.display = 'block';
    document.getElementById('error-msg').style.display = 'none';
    document.getElementById('services-list').innerHTML = '';

    // Configuración de la API y cabeceras
    const headerParams = { 'Authorization': 'Bearer backcrispity' };
    const proxyUrl = "";
    const apiUrl = "https://website.crispity.tech/Backend/api/servicios?lenguaje=esp";

    const iconMapping = {
        0: 'fa-solid fa-briefcase',         // Primer servicio
        1: 'fa-solid fa-earth-americas',    // Segundo servicio
        2: 'fa-solid fa-cogs',              // Tercer servicio
        3: 'fa-solid fa-code',              // Cuarto servicio
        4: 'fa-solid fa-lightbulb',         // Quinto servicio 

    };
    // Solicitud a la API usando fetch
    fetch(proxyUrl + apiUrl, {
        method: 'GET',
        headers: headerParams
    })
    .then(response => {
        if (!response.ok) throw new Error('Error en la respuesta de la API');
        return response.json();
    })
    .then(data => {
        document.getElementById('loading-msg').style.display = 'none';

        // Si no hay servicios, muestra mensaje de error
        if (!data.data || data.data.length === 0) {
            document.getElementById('error-msg').textContent = 'No hay servicios disponibles.';
            document.getElementById('error-msg').style.display = 'block';
            return;
        }

        // Renderiza cada card de servicio
        const servicesList = document.getElementById('services-list');
        data.data.forEach((item, index) => {
            const card = document.createElement('div');
            card.className = 'service-card';

            // Ícono (usando el mapeo local)
            const iconClass = iconMapping[index];
            if (iconClass) {
                const icon = document.createElement('i');
                icon.className = iconClass;
                card.appendChild(icon);
            }

            // Título del servicio
            const title = document.createElement('div');
            title.className = 'service-title';
            title.textContent = item.titulo || '';

            // Descripción del servicio
            const desc = document.createElement('div');
            desc.className = 'service-desc';
            desc.textContent = item.descripcion || '';

            // Agrega título y descripción a la card
            card.appendChild(title);
            card.appendChild(desc);

            // Agrega la card a la lista de servicios
            servicesList.appendChild(card);
        });
    })
    .catch(error => {
        // Muestra mensaje de error si la API falla
        document.getElementById('loading-msg').style.display = 'none';
        document.getElementById('error-msg').textContent = 'Error al cargar los datos: ' + error.message;
        document.getElementById('error-msg').style.display = 'block';
    });
}

// Ejecuta la función al cargar el DOM
document.addEventListener("DOMContentLoaded", cargarDatos);