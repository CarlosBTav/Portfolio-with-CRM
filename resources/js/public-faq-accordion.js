/**
 * Acordeón FAQ (estilo tarjeta tipo BichaTattoo) para [data-faq-group].
 */
(() => {
    const groups = document.querySelectorAll('[data-faq-group]');

    groups.forEach((group) => {
        const items = Array.from(group.querySelectorAll('[data-faq-item]'));
        let animationLock = false;

        const animateOpen = (item) =>
            new Promise((resolve) => {
                const trigger = item.querySelector('[data-faq-trigger]');
                const panel = item.querySelector('[data-faq-panel]');
                if (!trigger || !panel) {
                    resolve();
                    return;
                }

                item.classList.add('is-open');
                trigger.setAttribute('aria-expanded', 'true');
                panel.hidden = false;
                panel.style.height = '0px';
                panel.style.opacity = '0';
                panel.style.overflow = 'hidden';

                requestAnimationFrame(() => {
                    panel.style.transition = 'height 320ms ease, opacity 260ms ease';
                    panel.style.height = `${panel.scrollHeight}px`;
                    panel.style.opacity = '1';
                });

                const onEnd = (event) => {
                    if (event.propertyName !== 'height') {
                        return;
                    }

                    panel.style.height = 'auto';
                    panel.style.overflow = '';
                    panel.removeEventListener('transitionend', onEnd);
                    resolve();
                };

                panel.addEventListener('transitionend', onEnd);
            });

        const animateClose = (item) =>
            new Promise((resolve) => {
                const trigger = item.querySelector('[data-faq-trigger]');
                const panel = item.querySelector('[data-faq-panel]');
                if (!trigger || !panel || panel.hidden) {
                    resolve();
                    return;
                }

                trigger.setAttribute('aria-expanded', 'false');
                panel.style.height = `${panel.scrollHeight}px`;
                panel.style.opacity = '1';
                panel.style.overflow = 'hidden';

                requestAnimationFrame(() => {
                    panel.style.transition = 'height 280ms ease, opacity 220ms ease';
                    panel.style.height = '0px';
                    panel.style.opacity = '0';
                });

                const onEnd = (event) => {
                    if (event.propertyName !== 'height') {
                        return;
                    }

                    panel.hidden = true;
                    panel.style.height = '';
                    panel.style.opacity = '';
                    panel.style.overflow = '';
                    item.classList.remove('is-open');
                    panel.removeEventListener('transitionend', onEnd);
                    resolve();
                };

                panel.addEventListener('transitionend', onEnd);
            });

        items.forEach((item) => {
            const trigger = item.querySelector('[data-faq-trigger]');
            if (!trigger) {
                return;
            }

            trigger.addEventListener('click', async () => {
                if (animationLock) {
                    return;
                }

                animationLock = true;
                const isOpen = item.classList.contains('is-open');

                if (isOpen) {
                    await animateClose(item);
                    animationLock = false;
                    return;
                }

                const opened = items.filter(
                    (otherItem) => otherItem !== item && otherItem.classList.contains('is-open'),
                );
                await Promise.all(opened.map((openedItem) => animateClose(openedItem)));
                await animateOpen(item);
                animationLock = false;
            });
        });
    });
})();
