document.addEventListener('DOMContentLoaded', function() {
    const MAX_SIZE = 2 * 1024 * 1024; // 2MB

    document.querySelectorAll('.image-input').forEach(function(input) {
        input.addEventListener('change', function() {
            const files = this.files;
            let errors = [];
            const maxFiles = parseInt(this.getAttribute('data-max-files')) || 3;

            if (files.length > maxFiles) {
                if (maxFiles === 1) {
                    errors.push('Solo puedes subir un máximo de 1 imagen.');
                } else {
                    errors.push('Solo puedes subir un máximo de ' + maxFiles + ' imágenes.');
                }
            }

            for (let i = 0; i < files.length; i++) {
                if (files[i].size > MAX_SIZE) {
                    errors.push('"' + files[i].name + '" supera los 2MB permitidos.');
                }
            }

            if (errors.length > 0) {
                alert(errors.join('\n'));
                this.value = '';
            }
        });
    });
});
