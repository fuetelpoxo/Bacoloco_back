document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('etiquetas-select');
    const container = document.getElementById('etiquetas-contenedor');

    if (!select || !container) return;

    // Función para añadir la chapa/badge
    function addBadge(id, name) {
        // Crear chapa visual
        const badge = document.createElement('span');
        badge.className = 'badge bg-dark text-white p-2 d-inline-flex align-items-center gap-2 rounded';
        badge.id = 'badge-etiqueta-' + id;
        badge.innerHTML = `
            ${name}
            <button type="button" class="btn-close btn-close-white p-0" style="font-size: 0.65rem;" data-id="${id}"></button>
        `;

        // Crear input oculto para enviar al backend
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'etiquetas[]';
        hiddenInput.value = id;
        hiddenInput.id = 'input-etiqueta-' + id;

        // Añadir al DOM
        container.appendChild(badge);
        container.appendChild(hiddenInput);

        // Ocultar opción en el selector
        const option = select.querySelector(`option[value="${id}"]`);
        if (option) {
            option.disabled = true;
            option.style.display = 'none';
        }

        // Registrar evento para borrar
        badge.querySelector('.btn-close').addEventListener('click', function () {
            removeBadge(id);
        });
    }

    // Función para quitar chapa/badge
    function removeBadge(id) {
        // Borrar del DOM
        const badge = document.getElementById('badge-etiqueta-' + id);
        const hiddenInput = document.getElementById('input-etiqueta-' + id);
        if (badge) badge.remove();
        if (hiddenInput) hiddenInput.remove();

        // Mostrar de nuevo la opción en el selector
        const option = select.querySelector(`option[value="${id}"]`);
        if (option) {
            option.disabled = false;
            option.style.display = 'block';
        }
    }

    // Escuchar cambios en el selector dropdown
    select.addEventListener('change', function () {
        const selectedId = this.value;
        const selectedText = this.options[this.selectedIndex].text;

        if (selectedId) {
            addBadge(selectedId, selectedText);
            // Resetear el select a la opción por defecto
            this.value = '';
        }
    });

    // Precargar badges existentes si estamos en la vista de edición
    const existingInputs = container.querySelectorAll('input[type="hidden"]');
    existingInputs.forEach(input => {
        const id = input.value;
        const option = select.querySelector(`option[value="${id}"]`);
        if (option) {
            // Ocultar la opción original en el selector dropdown
            option.disabled = true;
            option.style.display = 'none';

            // Buscar la chapa asociada en el DOM y asignarle el evento de borrar
            const badge = document.getElementById('badge-etiqueta-' + id);
            if (badge) {
                const closeBtn = badge.querySelector('.btn-close');
                if (closeBtn) {
                    closeBtn.addEventListener('click', function () {
                        removeBadge(id);
                    });
                }
            }
        }
    });
});
