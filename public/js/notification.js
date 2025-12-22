const userId = document.querySelector('meta[name="user-id"]')?.getAttribute('content');

if (userId) {
    window.Echo.private(`notifications.${userId}`)
        .listen('.notification.new', (e) => {
            console.log('Nova notificação:', e);

            // atualizar badge
            const badge = document.querySelector('.badge');
            if (badge) {
                badge.textContent = parseInt(badge.textContent || 0) + 1;
                badge.style.display = 'inline-block';
            }
        });
}
