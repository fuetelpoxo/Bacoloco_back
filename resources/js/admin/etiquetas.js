document.addEventListener('DOMContentLoaded', function () {
    const wrappers = document.querySelectorAll('.etiquetas-wrapper');

    wrappers.forEach(wrapper => {
        const select = wrapper.querySelector('.etiquetas-select');
        const container = wrapper.querySelector('.etiquetas-contenedor');

        if (!select || !container) return;

        // Crear dinámicamente el contenedor del mensaje de error justo debajo del select
        let errorContainer = wrapper.querySelector('.etiquetas-error');
        if (!errorContainer) {
            errorContainer = document.createElement('div');
            errorContainer.className = 'etiquetas-error text-danger small mt-1 fw-semibold';
            select.parentNode.insertBefore(errorContainer, select.nextSibling);
        }

        // Función para añadir la chapa/badge
        function addBadge(id, name) {
            // Crear chapa visual
            const badge = document.createElement('span');
            badge.className = 'badge bg-dark text-white p-2 d-inline-flex align-items-center gap-2 rounded';
            badge.setAttribute('data-badge-id', id);
            badge.innerHTML = `
                ${name}
                <button type="button" class="btn-close btn-close-white p-0" style="font-size: 0.65rem;" data-id="${id}"></button>
            `;

            // Crear input oculto para enviar al backend
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'etiquetas[]';
            hiddenInput.value = id;

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
            // Borrar del DOM dentro de este contenedor específico
            const badge = container.querySelector(`[data-badge-id="${id}"]`);
            const hiddenInput = container.querySelector(`input[type="hidden"][value="${id}"]`);
            if (badge) badge.remove();
            if (hiddenInput) hiddenInput.remove();

            // Mostrar de nuevo la opción en el selector
            const option = select.querySelector(`option[value="${id}"]`);
            if (option) {
                option.disabled = false;
                option.style.display = 'block';
            }

            // Limpiar mensaje de error si existiera ya que ahora hay menos de 4
            if (errorContainer) {
                errorContainer.textContent = '';
            }
        }

        // Escuchar cambios en el selector dropdown
        select.addEventListener('change', function () {
            const selectedId = this.value;
            const selectedText = this.options[this.selectedIndex].text;

            if (selectedId) {
                const count = container.querySelectorAll('input[type="hidden"]').length;
                if (count >= 4) {
                    // Mostrar error dinámico debajo del select
                    if (errorContainer) {
                        errorContainer.textContent = 'No puedes seleccionar más de 4 etiquetas.';
                    }
                    this.value = '';
                    return;
                }

                // Limpiar error previo si la acción es válida
                if (errorContainer) {
                    errorContainer.textContent = '';
                }

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
                const badge = container.querySelector(`[data-badge-id="${id}"]`);
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
});
