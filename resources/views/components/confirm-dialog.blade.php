<div
    x-data="{
        show: false,
        title: '',
        message: '',
        confirmText: 'Confirmar',
        confirmColor: 'bg-red-600 hover:bg-red-700',
        formAction: '',
        formMethod: 'POST',
        onConfirm() {
            this.show = false;
            const form = document.createElement('form');
            form.method = this.formMethod;
            form.action = this.formAction;
            form.style.display = 'none';
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);
            if (this.formMethod !== 'GET') {
                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = this.formMethod;
                form.appendChild(method);
            }
            document.body.appendChild(form);
            form.submit();
        }
    }"
    x-on:show-confirm.window="
        show = true;
        title = $event.detail.title || '¿Estás seguro?';
        message = $event.detail.message || 'Esta acción no se puede deshacer.';
        confirmText = $event.detail.confirmText || 'Confirmar';
        confirmColor = $event.detail.confirmColor || 'bg-red-600 hover:bg-red-700';
        formAction = $event.detail.formAction || '';
        formMethod = $event.detail.formMethod || 'POST';
    "
    x-on:keydown.escape.window="show = false"
    x-show="show"
    class="fixed inset-0 z-[90] flex items-center justify-center px-4"
    style="display: none;"
>
    <div class="absolute inset-0 bg-gray-500 opacity-75" @click="show = false"></div>

    <div
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="relative bg-white rounded-xl shadow-xl max-w-sm w-full p-6"
    >
        <div class="flex items-center gap-3 mb-4">
            <div class="shrink-0 w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            </div>
            <h3 x-text="title" class="text-lg font-semibold text-gray-900"></h3>
        </div>
        <p x-text="message" class="text-sm text-gray-600 mb-6"></p>
        <div class="flex justify-end gap-3">
            <button
                type="button"
                @click="show = false"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors"
            >
                Cancelar
            </button>
            <button
                type="button"
                @click="onConfirm()"
                :class="confirmColor"
                class="px-4 py-2 text-sm font-medium text-white rounded-lg transition-colors"
                x-text="confirmText"
            ></button>
        </div>
    </div>
</div>
