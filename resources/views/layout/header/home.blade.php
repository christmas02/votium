<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>VOTIUM — Vote & Campagnes en temps réel</title>
    <meta name="description"
        content="VOTIUM : votez en quelques secondes ou lancez une campagne de votes moderne, rapide et premium." />
    <link rel="icon" type="image/png" href="{{ asset('asset/favicon.png') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    {{-- start style css --}}
    @include('layout.css.home')
</head>

<body>
    <header class="topbar">
        <div class="inner">
            <a class="brand" href="{{ route('home') }}" aria-label="VOTIUM Accueil">
                <span class="logo"><img src="{{ asset('asset/logo.png') }}" alt="VOTIUM" /></span>
                <span class="txt">
                    <b>VOTIUM</b>
                    <span>Vote & campagnes</span>
                </span>
            </a>

            <div class="right">
                <a class="pill" href="{{ route('screenLogin') }}" title="Espace promoteur / admin">
                    <span class="dot"></span>
                    Accéder
                </a>
            </div>
        </div>
    </header>

    <main class="wrap">
        <!-- Start Content -->
        @yield('content')
        <!-- End Content -->

        @include('layout.footer.home')
    </main>

    <script>
        // Header role button stays, no extra tabs.
        document.getElementById('y').textContent = new Date().getFullYear();

        // Fake live campaigns preview (front-only)
        const live = [{
                name: "Queen Myriana — Finale",
                city: "Abidjan",
                pct: 68,
                votes: 12450
            },
            {
                name: "ARIEL SHENEY — Battle",
                city: "Cocody",
                pct: 52,
                votes: 8930
            },
            {
                name: "Oyoki Onanayo — Challenge",
                city: "Yopougon",
                pct: 41,
                votes: 5720
            },
            {
                name: "VDA — Top 10",
                city: "Marcory",
                pct: 76,
                votes: 16310
            },
        ];
        const grid = document.getElementById('liveGrid');

        function cardRow(item, idx) {
            const initials = (item.name || "V").trim().split(/\s+/).slice(0, 2).map(s => s[0]).join("").toUpperCase();
            return `
        <div class="live-card">
          <div class="avatar" aria-hidden="true">${initials}</div>
          <div class="lc-txt">
            <b title="${item.name}">${item.name}</b>
            <span>${item.city} • <b style="color:rgba(234,242,255,.92)">${item.votes.toLocaleString('fr-FR')}</b> votes</span>
            <div class="barline"><i style="width:${item.pct}%"></i></div>
          </div>
          <div class="amount">
            ${item.pct}%
            <small>progression</small>
          </div>
        </div>
      `;
        }

        function render() {
            grid.innerHTML = live.map(cardRow).join("");
        }
        render();

        // --- Campaigns slider (recent live) ---
        const carTrack = document.getElementById('carTrack');
        const carViewport = document.getElementById('carViewport');
        const btnPrev = document.querySelector('.car-btn.prev');
        const btnNext = document.querySelector('.car-btn.next');

        function campCard(item) {
            const initials = (item.name || "V").trim().split(/\s+/).slice(0, 2).map(s => s[0]).join("").toUpperCase();
            return `
        <article class="camp-card">
          <div class="top">
            <div style="display:flex;align-items:center;gap:10px">
              <div class="avatar" aria-hidden="true" style="width:42px;height:42px;border-radius:16px;background:rgba(255,140,0,.14);border:1px solid rgba(255,140,0,.25);display:grid;place-items:center;font-weight:800;color:#ffb36a">${initials}</div>
              <div>
                <h3>${item.name}</h3>
                <div class="meta">${item.city} • ${item.votes.toLocaleString('fr-FR')} votes</div>
              </div>
            </div>
            <span class="badge-live">LIVE</span>
          </div>
          <div class="body">
            <div class="pbar" aria-label="Progression">
              <i style="width:${Math.max(8, Math.min(92, item.pct||50))}%"></i>
            </div>
            <div class="ctaRow">
              <a class="btn primary" href="votes.html">Voter</a>
              <a class="btn ghost" href="inscription.html">Créer</a>
            </div>
          </div>
        </article>
      `;
        }

        let carIndex = 0;

        function renderCarousel() {
            if (!carTrack) return;
            carTrack.innerHTML = live.map(campCard).join("");
            carIndex = 0;
            updateCarousel();
        }

        function updateCarousel(dir = 0) {
            if (!carTrack || !carViewport) return;
            // On mobile we keep native scroll; desktop uses transform
            const isMobile = window.matchMedia('(max-width: 920px)').matches;
            if (isMobile) return;

            const cards = Array.from(carTrack.children);
            if (!cards.length) return;
            carIndex = (carIndex + dir + cards.length) % cards.length;

            const card = cards[carIndex];
            const left = card.offsetLeft;
            carTrack.style.transform = `translateX(${-left}px)`;
        }

        if (btnPrev) btnPrev.addEventListener('click', () => updateCarousel(-1));
        if (btnNext) btnNext.addEventListener('click', () => updateCarousel(1));
        window.addEventListener('resize', () => updateCarousel(0));

        renderCarousel();

        // Light auto-rotate by swapping first item
        setInterval(() => {
            live.push(live.shift());
            render();
            renderCarousel();
        }, 4200);

        // Auto-advance carousel (desktop only)
        setInterval(() => {
            updateCarousel(1);
        }, 5200);


        // Counters
        document.querySelectorAll('[data-count]').forEach(el => {
            const to = parseInt(el.getAttribute('data-count') || '0', 10);
            let cur = 0;
            const step = () => {
                cur += 1;
                el.textContent = cur;
                if (cur < to) requestAnimationFrame(step);
            };
            step();
        });

        // Reveal on load + scroll
        const revealEls = Array.from(document.querySelectorAll('.reveal'));
        const io = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) e.target.classList.add('on');
            });
        }, {
            threshold: 0.12
        });
        revealEls.forEach(el => io.observe(el));
    </script>
</body>

</html>
