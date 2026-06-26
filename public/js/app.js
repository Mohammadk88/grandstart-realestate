/* Grand Start Real Estate - Main JavaScript */

document.addEventListener('DOMContentLoaded', function () {

    // ===== AOS Init =====
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 700,
            easing: 'ease-out-cubic',
            once: true,
            offset: 80,
        });
    }

    // ===== Navbar Scroll Effect =====
    const navbar = document.getElementById('mainNav');
    if (navbar) {
        const handleScroll = () => {
            navbar.classList.toggle('scrolled', window.scrollY > 50);
        };
        window.addEventListener('scroll', handleScroll, { passive: true });
    }

    // ===== Animated Counter =====
    function animateCounter(el) {
        const target = parseInt(el.dataset.count || el.dataset.target || 0);
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;

        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            el.textContent = Math.floor(current).toLocaleString();
        }, 16);
    }

    // Observe stat numbers
    const counterEls = document.querySelectorAll('.stat-num, .counter');
    if (counterEls.length && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.3 });

        counterEls.forEach(el => observer.observe(el));
    }

    // ===== Hero Parallax =====
    const heroSection = document.querySelector('.hero-section');
    if (heroSection) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            heroSection.style.backgroundPositionY = `${scrolled * 0.4}px`;
        }, { passive: true });
    }

    // ===== Active Nav Link =====
    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-link').forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
        }
    });

    // ===== Form Loading State =====
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function (e) {
            const submitBtn = form.querySelector('[type="submit"]');
            if (submitBtn && !form.dataset.noLoading) {
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جارٍ الإرسال...';

                // Re-enable after 10s as fallback
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }, 10000);
            }
        });
    });

    // ===== Smooth Scroll =====
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // ===== Image Lazy Loading Fallback =====
    document.querySelectorAll('img[loading="lazy"]').forEach(img => {
        img.addEventListener('error', function () {
            if (!this.src.includes('placeholder')) {
                this.src = 'https://images.unsplash.com/photo-1486325212027-8081e485255e?w=600&q=60';
            }
        });
    });

    // ===== WhatsApp Float Animation =====
    const waFloat = document.querySelector('.whatsapp-float');
    if (waFloat) {
        setTimeout(() => {
            waFloat.style.opacity = '0';
            waFloat.style.transform = 'scale(0)';
            waFloat.style.transition = 'all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275)';

            setTimeout(() => {
                waFloat.style.opacity = '1';
                waFloat.style.transform = 'scale(1)';
            }, 1500);
        }, 100);
    }

    // ===== Auto-close Mobile Navbar on Click =====
    const navbarCollapse = document.querySelector('.navbar-collapse');
    if (navbarCollapse) {
        document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (navbarCollapse.classList.contains('show')) {
                    const toggler = document.querySelector('.navbar-toggler');
                    if (toggler) toggler.click();
                }
            });
        });
    }

    // ===== Flash Messages Auto-dismiss =====
    const flashMessages = document.querySelectorAll('.alert-success, .alert-danger, .alert-success-custom');
    flashMessages.forEach(msg => {
        setTimeout(() => {
            msg.style.transition = 'opacity 0.5s, height 0.5s, margin 0.5s, padding 0.5s';
            msg.style.opacity = '0';
            setTimeout(() => {
                msg.style.height = '0';
                msg.style.margin = '0';
                msg.style.padding = '0';
                msg.style.overflow = 'hidden';
                setTimeout(() => msg.remove(), 500);
            }, 500);
        }, 5000);
    });

    // ===== Hero Particles (Simple CSS-based) =====
    // Can be extended with particles.js if needed

});

// ===== Utility Functions =====
window.GrandStart = {
    // Format phone for WhatsApp
    formatWhatsApp: function(phone) {
        return phone.replace(/[^0-9]/g, '');
    },

    // Show toast notification
    showToast: function(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast-notification toast-${type}`;
        toast.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>${message}`;
        toast.style.cssText = `
            position: fixed; bottom: 2rem; right: 2rem; z-index: 10000;
            background: ${type === 'success' ? '#10b981' : '#ef4444'};
            color: #fff; padding: 1rem 1.5rem; border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3); font-weight: 600;
            transform: translateY(100px); opacity: 0;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        `;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.transform = 'translateY(0)';
            toast.style.opacity = '1';
        }, 50);

        setTimeout(() => {
            toast.style.transform = 'translateY(100px)';
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 400);
        }, 4000);
    }
};
