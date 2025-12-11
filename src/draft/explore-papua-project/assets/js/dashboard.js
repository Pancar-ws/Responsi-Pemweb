const pastOrders = [
    { id: "INV-170123456", name: "Festival Lembah Baliem", date: "2024-08-10", pax: 2, total: "Rp 17.000.000", status: "paid" },
    { id: "INV-169876543", name: "Kuliner Otentik Jayapura", date: "2023-12-05", pax: 1, total: "Rp 500.000", status: "paid" }
];

window.addEventListener('load', () => {
    const container = document.getElementById('orderContainer');
    container.innerHTML = '';
    const newOrderJson = localStorage.getItem('currentBooking');
    let allOrders = [...pastOrders];
    if (newOrderJson) {
        const newOrder = JSON.parse(newOrderJson);
        const formattedNewOrder = { id: newOrder.orderId, name: newOrder.tourName, date: newOrder.date, pax: newOrder.pax, total: newOrder.totalPrice, status: "paid" };
        allOrders.unshift(formattedNewOrder);
    }
    allOrders.forEach(order => {
        const html = `
            <div class="order-card">
                <div class="order-info"><h4>${order.name}</h4><div class="order-meta"><span>📅 ${order.date}</span><span>👥 ${order.pax} Orang</span><span class="order-id">#${order.id}</span></div><div class="order-price">${order.total}</div></div>
                <div class="order-actions"><button class="btn-download" onclick="alert('Download PDF...')">⬇ Unduh Tiket</button></div>
            </div>`;
        container.innerHTML += html;
    });
});