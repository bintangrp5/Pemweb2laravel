<div class="d-flex flex-column align-items-center mt-2 mb-5">
    <div id="liveAlertPlaceholder" class="mb-3" style="width: 50%;"></div>
    <button type="button" class="btn btn-primary" id="liveAlertBtn">Show live alert</button>
</div>

<script>
    const alertPlaceholder = document.getElementById('liveAlertPlaceholder');
    
    const appendAlert = (message, type, imageUrl) => {
        const wrapper = document.createElement('div');
        wrapper.innerHTML = [
            `<div class="alert alert-${type} alert-dismissible fade show d-flex align-items-center" role="alert">`,
            `   <img src="${imageUrl}" alt="Logo" style="width: 50px; height: 50px; margin-right: 15px;">`,
            `   <div><strong>${message}</strong></div>`,
            '   <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>',
            '</div>'
        ].join('');

        alertPlaceholder.append(wrapper);
    };

    const alertTrigger = document.getElementById('liveAlertBtn');
    if (alertTrigger) {
        alertTrigger.addEventListener('click', () => {
            appendAlert(
                'Selamat Datang di Toko Kami – New Balance',
                'success',
                'https://images.seeklogo.com/logo-png/49/2/new-balance-logo-png_seeklogo-490558.png'
            );
        });
    }
</script>
