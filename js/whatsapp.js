// WhatsApp Order Sharing

function shareOrderViaWhatsApp(orderId) {
    const btn = document.getElementById('whatsappBtn');
    btn.disabled = true;
    btn.textContent = 'Loading...';

    // Request WhatsApp link from API
    fetch(`php/api.php?action=get_whatsapp_link&order_id=${orderId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.whatsapp_link) {
                // Open WhatsApp with pre-filled message
                window.open(data.whatsapp_link, '_blank');
                
                // Reset button
                setTimeout(() => {
                    btn.disabled = false;
                    btn.textContent = '🚀 Send Order via WhatsApp';
                }, 1000);
            } else {
                alert('Failed to generate WhatsApp link. Please try again.');
                btn.disabled = false;
                btn.textContent = '🚀 Send Order via WhatsApp';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
            btn.disabled = false;
            btn.textContent = '🚀 Send Order via WhatsApp';
        });
}
