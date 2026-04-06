/**
 * ============================================
 * SIAS - Main JavaScript
 * ============================================
 */

document.addEventListener('DOMContentLoaded', function () {

    // --- Sidebar Toggle (Mobile) ---
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const btnMenu = document.getElementById('btnMenu');

    if (btnMenu && sidebar && overlay) {
        btnMenu.addEventListener('click', function () {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        });

        overlay.addEventListener('click', function () {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
    }

    // Tutup sidebar saat klik nav-link di mobile
    document.querySelectorAll('.sidebar .nav-link').forEach(function (link) {
        link.addEventListener('click', function () {
            if (window.innerWidth < 992) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            }
        });
    });

    // --- Delete Confirmation Modal ---
    const deleteModal = document.getElementById('deleteModal');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    let deleteUrl = '';

    document.querySelectorAll('.btn-delete').forEach(function (btn) {
        btn.addEventListener('click', function () {
            deleteUrl = this.dataset.url;
            const name = this.dataset.name || 'data ini';
            const msg = document.getElementById('deleteMessage');
            if (msg) {
                msg.textContent = 'Apakah Anda yakin ingin menghapus "' + name + '"? Tindakan ini tidak dapat dibatalkan.';
            }
            if (deleteModal) {
                const modal = new bootstrap.Modal(deleteModal);
                modal.show();
            }
        });
    });

    if (confirmDeleteBtn && deleteModal) {
        confirmDeleteBtn.addEventListener('click', function () {
            if (deleteUrl) {
                // Buat form sementara untuk POST dengan CSRF
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = deleteUrl;

                // Tambahkan CSRF token
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = 'csrf_token';
                // Ambil token dari meta atau input yang ada
                const existingCsrf = document.querySelector('input[name="csrf_token"]');
                if (existingCsrf) {
                    csrfInput.value = existingCsrf.value;
                }
                form.appendChild(csrfInput);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    // --- Stat Card Count-up Animation ---
    document.querySelectorAll('.stat-value[data-count]').forEach(function (el) {
        const target = parseFloat(el.dataset.count);
        const decimal = parseInt(el.dataset.decimal) || 0;
        const duration = 1200;
        const start = performance.now();

        function animate(now) {
            const elapsed = now - start;
            const progress = Math.min(elapsed / duration, 1);

            // Easing: easeOutExpo
            const ease = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
            const current = target * ease;

            el.textContent = decimal > 0 ? current.toFixed(decimal) : Math.floor(current);

            if (progress < 1) {
                requestAnimationFrame(animate);
            }
        }

        // Gunakan IntersectionObserver untuk memulai animasi saat terlihat
        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    requestAnimationFrame(animate);
                    observer.unobserve(el);
                }
            });
        }, { threshold: 0.5 });

        observer.observe(el);
    });

    // --- Auto-dismiss flash messages setelah 5 detik ---
    document.querySelectorAll('.alert-dismissible').forEach(function (alert) {
        setTimeout(function () {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        }, 5000);
    });

});