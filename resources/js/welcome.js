(function() {
    var hamburger = document.getElementById('hamburgerBtn');
    var menu = document.getElementById('mobileMenu');
    if (hamburger && menu) {
        function toggleMenu() {
            var isOpen = menu.classList.toggle('open');
            hamburger.classList.toggle('open', isOpen);
            document.body.style.overflow = isOpen ? 'hidden' : '';
        }
        hamburger.addEventListener('click', toggleMenu);
        menu.querySelectorAll('a').forEach(function(link) {
            link.addEventListener('click', function() {
                menu.classList.remove('open');
                hamburger.classList.remove('open');
                document.body.style.overflow = '';
            });
        });
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                menu.classList.remove('open');
                hamburger.classList.remove('open');
                document.body.style.overflow = '';
            }
        });
    }

    var env = document.getElementById('env3d');
    var scene = document.getElementById('envScene');
    var label = document.getElementById('envLabel');
    var progress = document.getElementById('envProgress');
    var pct = document.getElementById('envPct');
    var fill = document.getElementById('envFill');
    var hasOpened = false;
    var particlesEl = document.getElementById('particles');
    var heroScroll = document.getElementById('heroScroll');
    var navbar = document.getElementById('navbar');
    var ticking = false;
    var body = document.body;
    var sitePrimary = body.dataset.sitePrimary || '#d4a61e';
    var siteSecondary = body.dataset.siteSecondary || '#e05278';

    var envWrap = document.querySelector('.env-sticky');
    if (envWrap && env) {
        envWrap.addEventListener('mousemove', function(e) {
            if (hasOpened || window.innerWidth < 768) return;
            var rect = envWrap.getBoundingClientRect();
            var x = (e.clientX - rect.left) / rect.width;
            var y = (e.clientY - rect.top) / rect.height;
            var tiltX = (y - 0.5) * -12;
            var tiltY = (x - 0.5) * 12;
            env.classList.add('tilt');
            env.style.transform = 'rotateX(' + tiltX + 'deg) rotateY(' + tiltY + 'deg)';
        });
        envWrap.addEventListener('mouseleave', function() {
            if (hasOpened) return;
            env.classList.remove('tilt');
            env.style.transform = '';
        });
    }

    function updateNavbar() {
        if (window.scrollY > 40) {
            navbar.classList.add('shadow-sm');
            heroScroll.classList.add('hidden');
        } else {
            navbar.classList.remove('shadow-sm');
            heroScroll.classList.remove('hidden');
        }
    }

    function updateEnvelopeScroll() {
        if (!scene) return;
        var rect = scene.getBoundingClientRect();
        var winH = window.innerHeight;
        var prog = Math.max(0, Math.min(1, (winH - rect.top) / winH));

        var translateY = prog * 50;
        var scale = 1 - prog * 0.35;
        scene.style.transform = 'translateY(' + translateY + 'px) scale(' + Math.max(scale, 0.4) + ')';
        scene.style.opacity = Math.max(1 - prog * 0.5, 0.15);

        var pctVal = Math.round(prog * 100);
        pct.textContent = '%' + pctVal;
        fill.style.width = Math.min(prog * 100, 100) + '%';
        progress.classList.add('visible');

        if (prog > 0.12) {
            label.classList.add('hidden');
        } else {
            label.classList.remove('hidden');
        }

        if (prog > 0.18 && !hasOpened) {
            hasOpened = true;
            env.classList.add('open');
            if (env.classList.contains('tilt')) {
                env.classList.remove('tilt');
                env.style.transform = '';
            }
            setTimeout(function() { spawnParticles(); }, 600);
            setTimeout(function() { spawnConfetti(); }, 900);
        }

        var reveals = document.querySelectorAll('.animate-reveal, .animate-step, .animate-feature');
        reveals.forEach(function(el) {
            var r = el.getBoundingClientRect();
            if (r.top < winH - 60) {
                el.classList.add('visible');
            }
        });

        var steps = document.querySelectorAll('.step');
        steps.forEach(function(s) {
            var r = s.getBoundingClientRect();
            if (r.top < winH - 40) {
                s.classList.add('visible');
            }
        });

        var cards = document.querySelectorAll('.feature-card');
        cards.forEach(function(c) {
            var r = c.getBoundingClientRect();
            if (r.top < winH - 40) {
                c.classList.add('visible');
            }
        });
    }

    function onScroll() {
        if (!ticking) {
            requestAnimationFrame(function() {
                updateNavbar();
                updateEnvelopeScroll();
                ticking = false;
            });
            ticking = true;
        }
    }
    window.addEventListener('scroll', onScroll, { passive: true });

    function spawnParticles() {
        var colors = [sitePrimary, siteSecondary, '#f59e0b', '#ec4899', '#6366f1', '#10b981', '#f97316'];
        for (var i = 0; i < 50; i++) {
            var p = document.createElement('div');
            p.className = 'env-particle';
            p.style.left = (10 + Math.random() * 80) + '%';
            p.style.top = (20 + Math.random() * 60) + '%';
            p.style.background = colors[Math.floor(Math.random() * colors.length)];
            p.style.width = p.style.height = (3 + Math.random() * 8) + 'px';
            p.style.animationDelay = (Math.random() * 2) + 's';
            p.style.animationDuration = (2 + Math.random() * 2.5) + 's';
            particlesEl.appendChild(p);
            setTimeout(function() { p.remove(); }, 5000);
        }
    }

    var contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            var btn = contactForm.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.innerHTML = '<span>Gönderiliyor...</span>';
            var formData = new FormData(contactForm);
            fetch(contactForm.action, {
                method: 'POST',
                body: formData,
                headers: { 'Accept': 'application/json' }
            }).then(function(r) { return r.json(); }).then(function(data) {
                contactForm.style.display = 'none';
                document.getElementById('contactSuccess').style.display = 'block';
            }).catch(function() {
                btn.disabled = false;
                btn.innerHTML = '<span>Mesajı Gönder</span><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>';
            });
        });
    }

    function togglePricing() {
        var el = document.getElementById('pricingToggle');
        if (!el) return;
        var isYearly = el.classList.toggle('active');
        document.getElementById('toggleMonthlyLabel').classList.toggle('active', !isYearly);
        document.getElementById('toggleYearlyLabel').classList.toggle('active', isYearly);
        document.querySelectorAll('.monthly-price, .monthly-period').forEach(function(e) { e.style.display = isYearly ? 'none' : ''; });
        document.querySelectorAll('.yearly-price, .yearly-period').forEach(function(e) { e.style.display = isYearly ? '' : 'none'; });
    }

    function spawnConfetti() {
        var container = document.getElementById('confettiContainer');
        var colors = [sitePrimary, siteSecondary, '#f59e0b', '#ec4899', '#6366f1', '#10b981', '#f97316', '#54a0ff', '#5f27cd'];
        var rect = container.getBoundingClientRect();
        var cx = rect.width / 2;
        var cy = rect.height / 2;

        for (var i = 0; i < 50; i++) {
            var c = document.createElement('div');
            c.className = 'confetti';
            c.style.background = colors[Math.floor(Math.random() * colors.length)];
            c.style.width = (5 + Math.random() * 8) + 'px';
            c.style.height = (5 + Math.random() * 8) + 'px';
            c.style.left = (cx + (Math.random() - 0.5) * 120) + 'px';
            c.style.top = (cy + (Math.random() - 0.5) * 100) + 'px';
            var angle = -Math.PI / 2 + (Math.random() - 0.5) * Math.PI * 0.8;
            var dist = 80 + Math.random() * 300;
            c.style.setProperty('--tx', Math.cos(angle) * dist + 'px');
            c.style.setProperty('--ty', Math.sin(angle) * dist + 'px');
            c.style.animationDelay = (Math.random() * 0.6) + 's';
            c.style.borderRadius = Math.random() > 0.5 ? '50%' : '2px';
            container.appendChild(c);
            requestAnimationFrame(function() { c.classList.add('burst'); });
        }
        setTimeout(function() {
            container.querySelectorAll('.confetti').forEach(function(el) { el.remove(); });
        }, 3500);
    }
})();
