/**
 * Carga la información "Sobre Nosotros" desde la API y la muestra en cards.
 */
function cargarAbout() {
    // Muestra el mensaje de carga y oculta errores previos
    document.getElementById('loading-msg').style.display = 'block';
    document.getElementById('error-msg').style.display = 'none';
    document.getElementById('about-list').innerHTML = '';

    // Configuración de la API y cabeceras
    const headerParams = { 'Authorization': 'Bearer backcrispity' };
    const proxyUrl = "";
    const apiUrl = "http://localhost/api/nosotros?lenguaje=esp";

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

        // Si no hay datos, muestra mensaje de error
        if (!data.data || data.data.length === 0) {
            document.getElementById('error-msg').textContent = 'No hay información disponible.';
            document.getElementById('error-msg').style.display = 'block';
            return;
        }

        // Renderiza cada card de "Sobre Nosotros"
        const aboutList = document.getElementById('about-list');
        data.data.forEach(item => {
            const card = document.createElement('div');
            card.className = 'about-card';

            // Título en español
            const title = document.createElement('div');
            title.className = 'about-title-card';
            title.textContent = item.titulo || '';
            card.appendChild(title);

            // Descripción en español
            const desc = document.createElement('div');
            desc.className = 'about-desc';
            desc.textContent = item.descripcion || '';
            card.appendChild(desc);

            aboutList.appendChild(card);
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
document.addEventListener("DOMContentLoaded", cargarAbout);