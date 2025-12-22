function escapeHtml(str) {
    return String(str)
        .replaceAll("&", "&amp;")
        .replaceAll("<", "&lt;")
        .replaceAll(">", "&gt;")
        .replaceAll('"', "&quot;")
        .replaceAll("'", "&#039;");
}

document.addEventListener("DOMContentLoaded", () => {
    const conversationId = window.conversationId;
    const authUserId = window.authUserId;

    if(!conversationId || !authUserId) return;

    const container = document.getElementById("messages");
    if (!container) return;

    window.Echo.private(`conversation.${conversationId}`)
        .subscribed(() => console.log("subscribed"))
        .error((e) => console.log("subscription error", e))
        .listen(".message.sent", (e) => {
            const mine = Number(e.sender_id) === Number(authUserId);

            const wrapper = document.createElement("div");
            wrapper.className = mine
                ? "d-flex flex-row justify-content-end mb-3"
                : "d-flex flex-row justify-content-start mb-3";

            wrapper.innerHTML = mine
                ? `
                    <div>
                        <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">${escapeHtml(e.body)}</p>
                        <p class="small me-3 mb-3 rounded-3 text-muted">just now</p>
                    </div>
                `
                : `
                    <div>
                        <p class="small p-2 ms-3 mb-1 rounded-3 bg-light">${escapeHtml(e.body)}</p>
                        <p class="small ms-3 mb-3 rounded-3 text-muted">just now</p>
                    </div>
                `;
            
            container.appendChild(wrapper);
            container.scrollTop = container.scrollHeight;
        });

    // scroll inicial para baixo
    container.scrollTop = container.scrollHeight;
});