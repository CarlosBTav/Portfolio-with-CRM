import './bootstrap';
import './public-faq-accordion.js';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const tbody = document.getElementById('project-sortable-tbody');
const reorderUrl = tbody?.dataset?.reorderUrl;
if (tbody && reorderUrl) {
    import('sortablejs').then(({ default: Sortable }) => {
        Sortable.create(tbody, {
            animation: 150,
            handle: '.project-drag-handle',
            ghostClass: 'opacity-50',
            onEnd: () => {
                const ids = [...tbody.querySelectorAll('tr[data-project-id]')].map((row) =>
                    parseInt(row.dataset.projectId, 10),
                );
                window.axios
                    .patch(reorderUrl, { project_ids: ids })
                    .catch(() => {
                        window.location.reload();
                    });
            },
        });
    });
}
