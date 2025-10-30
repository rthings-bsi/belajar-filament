document.addEventListener('DOMContentLoaded', function() {
    // Counter Animation
    function animateCounter(element, target, duration = 1500) {
        const start = 0;
        const increment = target / (duration / 16);
        let current = start;

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target.toLocaleString();
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current).toLocaleString();
            }
        }, 16);
    }

    // Initialize counters
    const counters = document.querySelectorAll('.counter-value');
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.dataset.counted) {
                const target = parseInt(entry.target.dataset.target);
                animateCounter(entry.target, target);
                entry.target.dataset.counted = 'true';
            }
        });
    }, observerOptions);

    counters.forEach(counter => observer.observe(counter));

    // Card interactions
    const statsCards = document.querySelectorAll('.stats-card');

    statsCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.zIndex = '10';
        });

        card.addEventListener('mouseleave', function() {
            this.style.zIndex = '1';
        });

        // Add ripple effect on click
        card.addEventListener('click', function(e) {
            const ripple = document.createElement('div');
            ripple.classList.add('ripple');
            this.appendChild(ripple);

            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';

            setTimeout(() => ripple.remove(), 600);
        });
    });

    // Auto refresh data every 30 seconds
    setInterval(() => {
        if (window.Livewire) {
            window.Livewire.emit('refreshWidgetData');
        }
    }, 30000);

    // Add percentage animation
    const percentages = document.querySelectorAll('.percentage-value');
    percentages.forEach(el => {
        const value = parseFloat(el.dataset.value);
        const color = value > 5 ? 'text-red-600' : (value > 2 ? 'text-yellow-600' : 'text-green-600');
        el.classList.add(color);
    });
});

// Alpine.js data helpers
window.widgetHelpers = {
    formatNumber(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    },

    formatPercentage(num) {
        return num.toFixed(2) + '%';
    },

    getStatusColor(percentage) {
        if (percentage > 5) return 'red';
        if (percentage > 2) return 'yellow';
        return 'green';
    }
};
