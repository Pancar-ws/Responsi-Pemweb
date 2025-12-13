// Dashboard functionality - DO NOT add localStorage orders
// Orders should only come from database, not localStorage
window.addEventListener('load', () => {
    // Dashboard sudah menampilkan order dari database
    // Tidak perlu menambahkan dari localStorage
    console.log('Dashboard loaded');
});

/**
 * Download tiket sebagai PDF menggunakan window.print
 */
function downloadTicket(invoice, tourName, date, pax, totalPrice, userName, status) {
    // Buat window baru untuk print
    const printWindow = window.open('', '_blank', 'width=800,height=600');
    
    // HTML template untuk tiket
    const ticketHTML = `
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tiket - ${invoice}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Arial', sans-serif;
            padding: 40px;
            background: white;
        }
        .ticket-container {
            max-width: 700px;
            margin: 0 auto;
            border: 3px solid #006064;
            border-radius: 15px;
            overflow: hidden;
        }
        .ticket-header {
            background: linear-gradient(135deg, #006064 0%, #00838F 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .ticket-header h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        .ticket-header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        .ticket-body {
            padding: 30px;
            background: #f9f9f9;
        }
        .ticket-row {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #ddd;
        }
        .ticket-row:last-child {
            border-bottom: none;
        }
        .ticket-label {
            font-weight: bold;
            color: #555;
        }
        .ticket-value {
            color: #006064;
            font-weight: 600;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            background: #4CAF50;
            color: white;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
        }
        .ticket-footer {
            padding: 20px 30px;
            background: white;
            text-align: center;
            color: #666;
            font-size: 0.85rem;
        }
        .qr-code {
            text-align: center;
            padding: 20px;
        }
        .barcode {
            font-family: 'Courier New', monospace;
            font-size: 1.5rem;
            letter-spacing: 2px;
            color: #333;
            margin-top: 10px;
        }
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <div class="ticket-header">
            <h1>🏝️ EXPLORE PAPUA</h1>
            <p>E-Ticket Wisata</p>
        </div>
        
        <div class="ticket-body">
            <div class="ticket-row">
                <span class="ticket-label">No. Invoice:</span>
                <span class="ticket-value">${invoice}</span>
            </div>
            <div class="ticket-row">
                <span class="ticket-label">Nama Pemesan:</span>
                <span class="ticket-value">${userName}</span>
            </div>
            <div class="ticket-row">
                <span class="ticket-label">Paket Wisata:</span>
                <span class="ticket-value">${tourName}</span>
            </div>
            <div class="ticket-row">
                <span class="ticket-label">Tanggal Keberangkatan:</span>
                <span class="ticket-value">${date}</span>
            </div>
            <div class="ticket-row">
                <span class="ticket-label">Jumlah Peserta:</span>
                <span class="ticket-value">${pax} Orang</span>
            </div>
            <div class="ticket-row">
                <span class="ticket-label">Total Harga:</span>
                <span class="ticket-value">${totalPrice}</span>
            </div>
            <div class="ticket-row">
                <span class="ticket-label">Status:</span>
                <span class="status-badge">${status}</span>
            </div>
        </div>
        
        <div class="qr-code">
            <div class="barcode">||||| ${invoice.substring(0, 15)} |||||</div>
        </div>
        
        <div class="ticket-footer">
            <p><strong>Explore Papua</strong> - Your Gateway to Paradise</p>
            <p>Untuk informasi lebih lanjut, hubungi: info@explorepapua.com | +62 812-3456-7890</p>
            <p style="margin-top: 10px; font-size: 0.75rem;">Tiket ini sah dan dapat ditunjukkan saat check-in. Harap cetak atau simpan dalam bentuk digital.</p>
        </div>
    </div>
    
    <div style="text-align: center; margin-top: 20px;" class="no-print">
        <button onclick="window.print()" style="padding: 12px 30px; background: #006064; color: white; border: none; border-radius: 5px; font-size: 1rem; cursor: pointer;">
            🖨️ Cetak / Simpan PDF
        </button>
        <button onclick="window.close()" style="padding: 12px 30px; background: #666; color: white; border: none; border-radius: 5px; font-size: 1rem; cursor: pointer; margin-left: 10px;">
            ✖ Tutup
        </button>
    </div>
</body>
</html>
    `;
    
    printWindow.document.write(ticketHTML);
    printWindow.document.close();
    
    // Auto print setelah load (opsional)
    printWindow.onload = function() {
        // printWindow.print(); // Uncomment jika ingin auto print
    };
}