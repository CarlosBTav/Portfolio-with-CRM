/**
 * Apuntes en /documentacion/*: envío y borrado sin recargar la página (evita saltos de scroll por withFragment + scroll-smooth).
 */
function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function escapeAttr(text) {
    return escapeHtml(text).replace(/"/g, '&quot;');
}

function formatNoteBodyHtml(text) {
    return escapeHtml(text).replace(/\n/g, '<br>\n');
}

function buildDeleteForm(destroyUrl, confirmMessage) {
    if (!destroyUrl) {
        return '';
    }
    const token = getCsrfToken();
    return `
        <form method="post" action="${escapeHtml(destroyUrl)}" class="shrink-0" data-documentation-delete-form data-confirm="${escapeAttr(confirmMessage)}">
            <input type="hidden" name="_token" value="${escapeHtml(token)}">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="text-xs font-semibold text-red-700 underline decoration-red-300 underline-offset-2 hover:text-red-600 dark:text-red-400 dark:decoration-red-500/50 dark:hover:text-red-300">
                Eliminar
            </button>
        </form>`;
}

function buildPendingNoteLi(note) {
    const deleteBlock = buildDeleteForm(
        note.destroy_url,
        '¿Eliminar esta respuesta de forma permanente?',
    );
    return `
        <li class="rounded-lg border border-gray-200/80 bg-white/90 px-3 py-2 dark:border-gray-600/80 dark:bg-gray-800/60">
            <div class="flex flex-wrap items-start justify-between gap-2">
                <p class="text-xs text-gray-500 dark:text-gray-400">${escapeHtml(note.created_at)}</p>
                ${deleteBlock}
            </div>
            <div class="mt-1.5 whitespace-pre-wrap text-sm text-gray-900 dark:text-gray-100">${formatNoteBodyHtml(note.body)}</div>
        </li>`;
}

function buildGeneralNoteLi(note) {
    const deleteBlock = buildDeleteForm(
        note.destroy_url,
        '¿Eliminar este apunte de forma permanente?',
    );
    return `
        <li class="rounded-xl border border-amber-200/80 bg-white/80 px-4 py-3 dark:border-amber-800/40 dark:bg-gray-900/40">
            <div class="flex flex-wrap items-start justify-between gap-2">
                <p class="text-xs text-amber-800/80 dark:text-amber-300/70">${escapeHtml(note.created_at)}</p>
                ${deleteBlock}
            </div>
            <div class="mt-2 whitespace-pre-wrap text-sm text-gray-900 dark:text-gray-100">${formatNoteBodyHtml(note.body)}</div>
        </li>`;
}

function showFormError(form, message) {
    const box = form.querySelector('.documentation-note-form-error');
    if (!box) {
        return;
    }
    box.textContent = message;
    box.classList.remove('hidden');
}

function clearFormError(form) {
    const box = form.querySelector('.documentation-note-form-error');
    if (!box) {
        return;
    }
    box.textContent = '';
    box.classList.add('hidden');
}

function firstValidationMessage(payload) {
    if (!payload || typeof payload !== 'object') {
        return 'No se pudo guardar. Inténtalo de nuevo.';
    }
    if (typeof payload.message === 'string' && payload.message) {
        return payload.message;
    }
    const errors = payload.errors;
    if (errors && typeof errors === 'object') {
        const firstKey = Object.keys(errors)[0];
        const arr = errors[firstKey];
        if (Array.isArray(arr) && arr[0]) {
            return arr[0];
        }
    }
    return 'No se pudo guardar. Inténtalo de nuevo.';
}

function showDeleteSuccessBanner(apuntesSection) {
    const banner = document.createElement('div');
    banner.className =
        'documentation-delete-flash rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900 dark:border-emerald-800/80 dark:bg-emerald-950/50 dark:text-emerald-100';
    banner.setAttribute('role', 'status');
    banner.textContent = 'Apunte eliminado.';
    apuntesSection.insertBefore(banner, apuntesSection.firstChild);
    window.setTimeout(() => banner.remove(), 4500);
}

function syncGeneralNotesEmptyState() {
    const listEl = document.getElementById('documentation-general-notes-list');
    const emptyEl = document.getElementById('documentation-general-notes-empty');
    if (!listEl || !emptyEl) {
        return;
    }
    const hasItems = listEl.querySelectorAll(':scope > li').length > 0;
    if (hasItems) {
        listEl.classList.remove('hidden');
        emptyEl.classList.add('hidden');
    } else {
        listEl.classList.add('hidden');
        emptyEl.classList.remove('hidden');
    }
}

function syncPendingListEmptyState(listEl) {
    if (!listEl) {
        return;
    }
    const hasItems = listEl.querySelectorAll(':scope > li').length > 0;
    if (hasItems) {
        listEl.classList.remove('hidden');
    } else {
        listEl.classList.add('hidden');
    }
}

async function submitDeleteNoteForm(form, apuntesSection) {
    const action = form.getAttribute('action');
    if (!action) {
        return;
    }

    const confirmMessage = form.getAttribute('data-confirm') || '¿Eliminar de forma permanente?';
    if (!window.confirm(confirmMessage)) {
        return;
    }

    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) {
        submitBtn.disabled = true;
    }

    const fd = new FormData();
    fd.append('_token', getCsrfToken());
    fd.append('_method', 'DELETE');

    const listItem = form.closest('li');

    try {
        const res = await fetch(action, {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': getCsrfToken(),
            },
            body: fd,
            credentials: 'same-origin',
        });

        let data = null;
        try {
            const raw = await res.text();
            data = raw ? JSON.parse(raw) : null;
        } catch {
            data = null;
        }

        if (!res.ok || !data?.deleted) {
            window.alert(firstValidationMessage(data) || 'No se pudo eliminar. Inténtalo de nuevo.');
            return;
        }

        const pendingList = listItem?.parentElement;
        listItem?.remove();

        if (pendingList?.id?.startsWith('documentation-pending-notes-list-')) {
            syncPendingListEmptyState(pendingList);
        } else {
            syncGeneralNotesEmptyState();
        }

        if (apuntesSection) {
            showDeleteSuccessBanner(apuntesSection);
        }
    } catch {
        window.alert('Error de red. Comprueba la conexión e inténtalo de nuevo.');
    } finally {
        if (submitBtn) {
            submitBtn.disabled = false;
        }
    }
}

function initDocumentationNotes() {
    const root = document.querySelector('[data-documentation-client-notes]');
    if (!root) {
        return;
    }

    const apuntesSection = document.getElementById('apuntes-cliente');
    const deleteBannerTarget = apuntesSection ?? root;

    root.addEventListener('submit', async (event) => {
        const form = event.target;
        if (!(form instanceof HTMLFormElement)) {
            return;
        }

        if (form.matches('[data-documentation-delete-form]')) {
            event.preventDefault();
            await submitDeleteNoteForm(form, deleteBannerTarget);
            return;
        }

        if (!form.matches('[data-documentation-note-form]')) {
            return;
        }
        event.preventDefault();

        clearFormError(form);

        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
        }

        const fd = new FormData(form);
        const action = form.getAttribute('action');
        if (!action) {
            if (submitBtn) {
                submitBtn.disabled = false;
            }
            return;
        }

        try {
            const res = await fetch(action, {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': getCsrfToken(),
                },
                body: fd,
                credentials: 'same-origin',
            });

            const raw = await res.text();
            let data = null;
            try {
                data = raw ? JSON.parse(raw) : null;
            } catch {
                data = null;
            }

            if (res.status === 422 && data) {
                showFormError(form, firstValidationMessage(data));
                return;
            }

            if (!res.ok || !data?.note) {
                showFormError(form, firstValidationMessage(data) || 'No se pudo guardar. Inténtalo de nuevo.');
                return;
            }

            const { note } = data;

            if (note.pending_item_index !== null && note.pending_item_index !== undefined) {
                const list = document.getElementById(`documentation-pending-notes-list-${note.pending_item_index}`);
                if (list) {
                    list.classList.remove('hidden');
                    list.insertAdjacentHTML('beforeend', buildPendingNoteLi(note));
                }
            } else {
                const emptyEl = document.getElementById('documentation-general-notes-empty');
                const listEl = document.getElementById('documentation-general-notes-list');
                if (emptyEl) {
                    emptyEl.classList.add('hidden');
                }
                if (listEl) {
                    listEl.classList.remove('hidden');
                    listEl.insertAdjacentHTML('beforeend', buildGeneralNoteLi(note));
                }
            }

            form.reset();
        } catch {
            showFormError(form, 'Error de red. Comprueba la conexión e inténtalo de nuevo.');
        } finally {
            if (submitBtn) {
                submitBtn.disabled = false;
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', initDocumentationNotes);
