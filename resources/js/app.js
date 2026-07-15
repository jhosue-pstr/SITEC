import SignaturePad from 'signature_pad';

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-signature-pad]').forEach(container => {
        const canvas = container.querySelector('canvas');
        if (!canvas) return;
        const tipo = container.dataset.tipo;

        const pad = new SignaturePad(canvas, {
            backgroundColor: 'rgb(255, 255, 255)',
            penColor: '#000000',
        });

        function resizeCanvas() {
            const rect = canvas.getBoundingClientRect();
            canvas.width = rect.width;
            canvas.height = rect.height;
        }
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);

        const clearBtn = container.querySelector('[data-clear]');
        if (clearBtn) {
            clearBtn.addEventListener('click', () => {
                pad.clear();
                const hidden = document.getElementById(`firma_${tipo}_data`);
                if (hidden) hidden.value = '';
            });
        }

        const saveBtn = container.querySelector('[data-save]');
        if (saveBtn) {
            saveBtn.addEventListener('click', async () => {
                if (pad.isEmpty()) {
                    alert('Dibuja tu firma antes de guardar.');
                    return;
                }

                const formatoId = container.dataset.formatoId;
                const data = pad.toDataURL('image/png');
                saveBtn.disabled = true;
                saveBtn.textContent = 'Guardando...';

                try {
                    const response = await fetch(`/formatos-atencion/${formatoId}/firma`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ firma: data, tipo }),
                    });

                    if (!response.ok) throw new Error('Error al guardar');
                    const result = await response.json();

                    const previewContainer = container.querySelector('[data-preview]');
                    if (previewContainer) {
                        previewContainer.innerHTML = `<img src="${result.url}" alt="Firma" class="max-h-24 mx-auto border border-gray-200 rounded-lg">`;
                    }

                    const formContainer = container.querySelector('[data-form]');
                    if (formContainer) formContainer.remove();
                } catch (e) {
                    alert('Error al guardar la firma. Intenta de nuevo.');
                    saveBtn.disabled = false;
                    saveBtn.textContent = 'Firmar';
                }
            });
        }

        canvas.addEventListener('endStroke', () => {
            const hidden = document.getElementById(`firma_${tipo}_data`);
            if (hidden && !pad.isEmpty()) {
                hidden.value = pad.toDataURL('image/png');
            }
        });
    });
});
