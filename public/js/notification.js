function updateUnreadNotifications() {
    const badge = document.getElementById('notifications_badge');
    if (!badge) return;
    
    fetch('/notifications/unread-count')
    .then(res => res.json())
    .then(data => {
        const currentCount = parseInt(badge.textContent || 0);
        
        if (data.unread > 0) {
            badge.textContent = data.unread;
            badge.style.display = 'inline-block';
        } else {
            badge.textContent = '';
            badge.style.display = 'none';
        }
        
        // Se o número aumentou E estamos na página de notificações
        if (data.unread > currentCount && 
            (window.location.pathname === '/notifications')) {
            // Recarrega a página automaticamente
            setTimeout(() => {
                window.location.reload();
            }, 1000); // Espera 1 segundo
        }
    })
    .catch(err => console.error('Erro:', err));
}

// Atualiza a cada 1 segundos
setInterval(updateUnreadNotifications, 1000);
updateUnreadNotifications();