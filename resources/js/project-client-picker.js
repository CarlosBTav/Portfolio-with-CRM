/**
 * Selector de clientes en edición de proyecto (guardado parcial por PATCH).
 * Debe registrarse con Alpine.data antes de Alpine.start().
 */
export function registerProjectClientPicker(Alpine) {
    Alpine.data('projectClientPicker', (config) => ({
        csrf: config.csrf,
        patchUrl: config.patchUrl,
        savedInternal: Boolean(config.initialInternal),
        savedClientIds: [...(config.initialClientIds || []).map((id) => Number(id))],
        clientsMeta: config.clientsMeta || [],
        pickerOpen: false,
        draftInternal: false,
        draftClientIds: [],
        saving: false,
        ajaxError: '',

        init() {
            const handler = (e) => {
                if (this.pickerOpen && this.draftDiffersFromSaved()) {
                    e.preventDefault();
                    e.returnValue = '';
                }
            };
            window.addEventListener('beforeunload', handler);
        },

        clientName(id) {
            const row = this.clientsMeta.find((c) => Number(c.id) === Number(id));
            if (row && row.name) {
                return row.name;
            }

            return id ? `Cliente #${id}` : '';
        },

        clientUrl(id) {
            const row = this.clientsMeta.find((c) => Number(c.id) === Number(id));

            return row ? row.show_url : '#';
        },

        linkLabel(id) {
            if (this.savedClientIds.length === 1) {
                return 'Ir a cliente';
            }

            return 'Ir a ' + this.clientName(id);
        },

        openPicker() {
            this.ajaxError = '';
            this.draftInternal = this.savedInternal;
            this.draftClientIds = [...this.savedClientIds];
            this.pickerOpen = true;
        },

        cancelPicker() {
            if (this.saving) {
                return;
            }
            this.pickerOpen = false;
            this.ajaxError = '';
        },

        pickerPrimaryAction() {
            if (!this.pickerOpen) {
                this.openPicker();

                return;
            }
            this.submitClientAssignment();
        },

        draftDiffersFromSaved() {
            if (Boolean(this.draftInternal) !== Boolean(this.savedInternal)) {
                return true;
            }
            const a = [...this.draftClientIds].map(Number).sort((x, y) => x - y);
            const b = [...this.savedClientIds].map(Number).sort((x, y) => x - y);
            if (a.length !== b.length) {
                return true;
            }

            return a.some((v, i) => v !== b[i]);
        },

        isDraftClientChecked(id) {
            return !this.draftInternal && this.draftClientIds.map(Number).includes(Number(id));
        },

        toggleDraftClient(id, checked) {
            id = Number(id);
            if (checked) {
                this.draftInternal = false;
                if (!this.draftClientIds.includes(id)) {
                    this.draftClientIds.push(id);
                }
            } else {
                this.draftClientIds = this.draftClientIds.filter((x) => Number(x) !== id);
            }
        },

        setDraftInternal(val) {
            this.draftInternal = Boolean(val);
            if (this.draftInternal) {
                this.draftClientIds = [];
            }
        },

        async submitClientAssignment() {
            if (!this.draftDiffersFromSaved()) {
                this.pickerOpen = false;

                return;
            }
            this.saving = true;
            this.ajaxError = '';
            try {
                const res = await fetch(this.patchUrl, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                        'X-CSRF-TOKEN': this.csrf,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({
                        is_internal: this.draftInternal,
                        clients: this.draftInternal ? [] : this.draftClientIds.map(Number),
                    }),
                });
                let data = {};
                try {
                    data = await res.json();
                } catch (_) {
                    /* ignore */
                }
                if (!res.ok) {
                    let msg = data.message || 'No se pudo guardar.';
                    if (data.errors) {
                        const parts = Object.values(data.errors).flat();
                        if (parts.length) {
                            msg = parts.join(' ');
                        }
                    }
                    this.ajaxError = msg;

                    return;
                }
                this.savedInternal = Boolean(data.is_internal);
                this.savedClientIds = (data.clients || []).map((c) => Number(c.id));
                this.pickerOpen = false;
            } finally {
                this.saving = false;
            }
        },
    }));
}
