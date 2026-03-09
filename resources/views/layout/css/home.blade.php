<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet" />
<link href="{{ asset('asset/app.css') }}" rel="stylesheet" />

<style>
    :root {
        --navy: #01233f;
        --navy2: #001a31;
        --orange: #ff7f00;
        --bg: #071320;
        --bg2: #0b1b2c;
        --card: rgba(255, 255, 255, .06);
        --card2: rgba(255, 255, 255, .09);
        --line: rgba(255, 255, 255, .14);
        --text: #eaf2ff;
        --muted: rgba(234, 242, 255, .72);
        --shadow: 0 30px 90px rgba(0, 0, 0, .45);
    }

    * {
        box-sizing: border-box
    }

    html,
    body {
        height: 100%
    }

    body {
        margin: 0;
        font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial;
        background: radial-gradient(1200px 800px at 15% 10%, rgba(255, 127, 0, .18), transparent 55%),
            radial-gradient(1100px 900px at 85% 15%, rgba(0, 174, 255, .16), transparent 55%),
            radial-gradient(900px 900px at 60% 90%, rgba(67, 255, 184, .10), transparent 55%),
            linear-gradient(180deg, var(--bg), var(--bg2));
        color: var(--text);
        overflow-x: hidden;
    }

    a {
        color: inherit
    }

    .topbar {
        position: sticky;
        top: 0;
        z-index: 50;
        background: linear-gradient(180deg, rgba(1, 35, 63, .86), rgba(1, 35, 63, .66));
        border-bottom: 1px solid rgba(255, 255, 255, .10);
        backdrop-filter: blur(12px);
    }

    .topbar .inner {
        width: 100%;
        margin: 0 auto;
        padding: 14px 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none
    }

    .brand .logo {
        width: 40px;
        height: 40px;
        border-radius: 14px;
        background: rgba(255, 255, 255, .08);
        border: 1px solid rgba(255, 255, 255, .14);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        box-shadow: 0 12px 30px rgba(0, 0, 0, .25);
    }

    .brand .logo img {
        width: 24px;
        height: 24px;
        object-fit: contain
    }

    .brand .txt {
        display: flex;
        flex-direction: column;
        line-height: 1.05
    }

    .brand .txt b {
        font-size: 14px;
        letter-spacing: .35px
    }

    .brand .txt span {
        font-size: 12px;
        color: rgba(255, 255, 255, .70)
    }

    .right {
        display: flex;
        align-items: center;
        gap: 10px
    }

    .pill {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .08);
        border: 1px solid rgba(255, 255, 255, .14);
        color: #fff;
        font-weight: 800;
        cursor: pointer;
        user-select: none;
    }

    .pill .dot {
        width: 10px;
        height: 10px;
        border-radius: 999px;
        background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, .92), rgba(255, 255, 255, 0)),
            linear-gradient(180deg, rgba(255, 127, 0, 1), rgba(255, 127, 0, .55));
        box-shadow: 0 0 0 4px rgba(255, 127, 0, .18);
    }

    .wrap {
        width: 100%;
        max-width: 1440px;
        margin: 0 auto;
        padding: 22px clamp(16px, 3vw, 34px) 70px;
    }

    .hero {
        position: relative;
        margin-top: 16px;
        border-radius: 26px;
        border: 1px solid rgba(255, 255, 255, .12);
        background:
            radial-gradient(900px 500px at 18% 30%, rgba(255, 127, 0, .22), transparent 60%),
            radial-gradient(900px 500px at 88% 32%, rgba(0, 174, 255, .18), transparent 60%),
            linear-gradient(180deg, rgba(255, 255, 255, .05), rgba(255, 255, 255, .02));
        box-shadow: var(--shadow);
        overflow: hidden;
        padding: 26px;
        min-height: calc(100vh - 92px);
        display: flex;
        align-items: stretch;
    }

    /* Animated glow blobs */
    .blob {
        position: absolute;
        inset: auto;
        width: 540px;
        height: 540px;
        border-radius: 999px;
        filter: blur(45px);
        opacity: .55;
        animation: floaty 8s ease-in-out infinite;
        pointer-events: none;
    }

    .blob.b1 {
        left: -220px;
        top: -240px;
        background: rgba(255, 127, 0, .55)
    }

    .blob.b2 {
        right: -240px;
        top: -220px;
        background: rgba(0, 174, 255, .50);
        animation-delay: -2.3s;
    }

    .blob.b3 {
        right: 120px;
        bottom: -280px;
        background: rgba(67, 255, 184, .40);
        animation-delay: -4.1s;
    }

    @keyframes floaty {

        0%,
        100% {
            transform: translateY(0) translateX(0) scale(1)
        }

        50% {
            transform: translateY(18px) translateX(14px) scale(1.03)
        }
    }

    .hero-grid {
        position: relative;
        display: grid;
        grid-template-columns: 1.05fr .95fr;
        gap: 18px;
        align-items: stretch;
        width: 100%;
        flex: 1;
    }

    @media (max-width: 980px) {
        .hero-grid {
            grid-template-columns: 1fr;
        }
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(255, 127, 0, .10);
        border: 1px solid rgba(255, 127, 0, .25);
        color: #ffd4a6;
        font-weight: 800;
        font-size: 12px;
    }

    .badge .spark {
        width: 18px;
        height: 18px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 127, 0, .18);
        border: 1px solid rgba(255, 127, 0, .30);
    }

    h1 {
        margin: 14px 0 10px;
        font-size: 44px;
        letter-spacing: -.9px;
        line-height: 1.03;
    }

    h1 .accent {
        color: var(--orange)
    }

    .sub {
        margin: 0;
        color: var(--muted);
        font-size: 15.5px;
        line-height: 1.65;
        max-width: 62ch;
    }

    .cta {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 18px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        height: 46px;
        padding: 0 16px;
        border-radius: 16px;
        font-weight: 900;
        text-decoration: none;
        border: 1px solid transparent;
        transition: transform .15s ease, box-shadow .2s ease, background .2s ease, border-color .2s ease;
        will-change: transform;
    }

    .btn:active {
        transform: translateY(1px) scale(.99)
    }

    .btn.primary {
        background: linear-gradient(180deg, rgba(255, 127, 0, 1), rgba(255, 127, 0, .84));
        color: #1a1100;
        box-shadow: 0 18px 50px rgba(255, 127, 0, .25);
    }

    .btn.primary:hover {
        box-shadow: 0 22px 60px rgba(255, 127, 0, .32)
    }

    .btn.ghost {
        background: rgba(255, 255, 255, .06);
        border-color: rgba(255, 255, 255, .16);
        color: var(--text);
    }

    .btn.ghost:hover {
        background: rgba(255, 255, 255, .08);
        border-color: rgba(255, 255, 255, .22)
    }

    .btn .ic {
        width: 18px;
        height: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: rgba(0, 0, 0, .12);
        border: 1px solid rgba(255, 255, 255, .12);
    }

    .proof {
        margin-top: 18px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    @media (max-width: 720px) {
        .proof {
            grid-template-columns: 1fr;
        }
    }

    .kpi {
        background: rgba(255, 255, 255, .05);
        border: 1px solid rgba(255, 255, 255, .12);
        border-radius: 18px;
        padding: 14px 14px 12px;
    }

    .kpi b {
        font-size: 16px
    }

    .kpi p {
        margin: 6px 0 0;
        color: var(--muted);
        font-size: 13px;
        line-height: 1.5
    }

    .preview {
        border-radius: 22px;
        border: 1px solid rgba(255, 255, 255, .14);
        background: linear-gradient(180deg, rgba(255, 255, 255, .06), rgba(255, 255, 255, .03));
        overflow: hidden;
        box-shadow: 0 22px 70px rgba(0, 0, 0, .35);
        display: flex;
        flex-direction: column;
    }

    .preview .bar {
        padding: 12px 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        border-bottom: 1px solid rgba(255, 255, 255, .10);
        background: rgba(0, 0, 0, .10);
    }

    .dots {
        display: flex;
        gap: 6px
    }

    .dot {
        width: 10px;
        height: 10px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .25)
    }

    .dot.o {
        background: rgba(255, 127, 0, .9)
    }

    .dot.b {
        background: rgba(0, 174, 255, .85)
    }

    .dot.g {
        background: rgba(67, 255, 184, .75)
    }

    .mini-nav {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        justify-content: flex-end
    }

    .chip {
        font-size: 12px;
        font-weight: 800;
        padding: 7px 10px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .06);
        border: 1px solid rgba(255, 255, 255, .14);
        color: rgba(234, 242, 255, .92);
        text-decoration: none;
        transition: transform .15s ease, background .2s ease, border-color .2s ease;
    }

    .chip:hover {
        transform: translateY(-1px);
        background: rgba(255, 255, 255, .08);
        border-color: rgba(255, 255, 255, .22)
    }

    .preview .content {
        padding: 14px
    }

    .live-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 10px
    }

    .live-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border-radius: 18px;
        border: 1px solid rgba(255, 255, 255, .12);
        background: rgba(255, 255, 255, .05);
    }

    .avatar {
        width: 44px;
        height: 44px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #1a1100;
        font-weight: 1000;
        background: linear-gradient(180deg, rgba(255, 127, 0, 1), rgba(255, 127, 0, .72));
        box-shadow: 0 14px 40px rgba(255, 127, 0, .25);
        flex: 0 0 auto;
    }

    .lc-txt {
        flex: 1;
        min-width: 0
    }

    .lc-txt b {
        display: block;
        font-size: 14px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis
    }

    .lc-txt span {
        display: block;
        margin-top: 4px;
        font-size: 12.5px;
        color: var(--muted)
    }

    .barline {
        height: 10px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .10);
        overflow: hidden;
        margin-top: 8px;
        border: 1px solid rgba(255, 255, 255, .12)
    }

    .barline>i {
        display: block;
        height: 100%;
        width: 40%;
        background: linear-gradient(90deg, rgba(0, 174, 255, .92), rgba(67, 255, 184, .70));
        border-radius: 999px
    }

    .amount {
        text-align: right;
        flex: 0 0 auto;
        font-weight: 900;
    }

    .amount small {
        display: block;
        color: var(--muted);
        font-weight: 700;
        font-size: 11px;
        margin-top: 2px
    }

    .glow {
        display: inline-block;
        padding: 9px 12px;
        border-radius: 14px;
        border: 1px solid rgba(255, 127, 0, .30);
        background: rgba(255, 127, 0, .10);
        box-shadow: 0 14px 60px rgba(255, 127, 0, .15);
        font-weight: 900;
        color: #ffd4a6;
        font-size: 12px;
    }

    /* Sections */
    .section {
        margin-top: 22px
    }

    .section h2 {
        margin: 0;
        font-size: 22px;
        letter-spacing: -.3px;
    }

    .section p.lead {
        margin: 8px 0 0;
        color: var(--muted);
        line-height: 1.65;
        max-width: 72ch;
        font-size: 14.5px;
    }

    .grid3 {
        margin-top: 14px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px
    }

    @media (max-width: 980px) {
        .grid3 {
            grid-template-columns: 1fr;
        }
    }

    .panel {
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, .12);
        background: rgba(255, 255, 255, .05);
        padding: 16px;
        box-shadow: 0 18px 60px rgba(0, 0, 0, .22);
    }

    .panel .icon {
        width: 40px;
        height: 40px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 174, 255, .12);
        border: 1px solid rgba(0, 174, 255, .24);
        margin-bottom: 10px;
    }

    .panel b {
        display: block;
        font-size: 14px
    }

    .panel span {
        display: block;
        margin-top: 6px;
        color: var(--muted);
        font-size: 13.5px;
        line-height: 1.55
    }

    .split {
        margin-top: 14px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    @media (max-width: 980px) {
        .split {
            grid-template-columns: 1fr;
        }
    }

    .cta-banner {
        margin-top: 18px;
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, .12);
        background:
            radial-gradient(700px 380px at 20% 35%, rgba(255, 127, 0, .22), transparent 60%),
            radial-gradient(700px 380px at 85% 40%, rgba(0, 174, 255, .18), transparent 60%),
            linear-gradient(180deg, rgba(255, 255, 255, .05), rgba(255, 255, 255, .03));
        padding: 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        box-shadow: var(--shadow);
    }

    @media (max-width: 820px) {
        .cta-banner {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    .cta-banner b {
        font-size: 16px
    }

    .cta-banner span {
        display: block;
        margin-top: 6px;
        color: var(--muted);
        line-height: 1.55
    }

    .footer {
        margin-top: 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        color: rgba(234, 242, 255, .60);
        font-size: 12px;
        padding: 10px 2px 0;
    }

    .footer a {
        color: rgba(234, 242, 255, .72);
        text-decoration: none
    }

    .footer a:hover {
        text-decoration: underline
    }

    /* Subtle reveal */
    .reveal {
        opacity: 0;
        transform: translateY(10px);
        transition: opacity .55s ease, transform .55s ease
    }

    .reveal.on {
        opacity: 1;
        transform: translateY(0)
    }

    /* --- Smart campaigns slider --- */
    .sec-head {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap
    }

    .carousel {
        position: relative;
        margin-top: 18px
    }

    .car-viewport {
        overflow: hidden;
        border-radius: 22px
    }

    .car-track {
        display: flex;
        gap: 14px;
        will-change: transform;
        transition: transform .5s cubic-bezier(.2, .9, .2, 1);
        padding: 14px
    }

    .camp-card {
        min-width: 320px;
        max-width: 360px;
        flex: 0 0 auto;
        background: rgba(255, 255, 255, .06);
        border: 1px solid rgba(255, 255, 255, .08);
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, .35);
        overflow: hidden
    }

    .camp-card .top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 14px 14px 10px
    }

    .badge-live {
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 999px;
        background: rgba(255, 140, 0, .15);
        border: 1px solid rgba(255, 140, 0, .28);
        color: #ffb36a
    }

    .camp-card h3 {
        font-size: 15px;
        margin: 0
    }

    .meta {
        color: var(--muted);
        font-size: 12px
    }

    .camp-card .body {
        padding: 0 14px 14px
    }

    .pbar {
        height: 10px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .08);
        overflow: hidden;
        margin: 10px 0 12px
    }

    .pbar>i {
        display: block;
        height: 100%;
        width: 50%;
        background: linear-gradient(90deg, rgba(0, 224, 255, .9), rgba(255, 140, 0, .95))
    }

    .camp-card .ctaRow {
        display: flex;
        gap: 10px
    }

    .camp-card .ctaRow a {
        flex: 1;
        height: 40px;
        border-radius: 14px;
        font-size: 13px
    }

    .car-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 44px;
        height: 44px;
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, .14);
        background: rgba(10, 20, 30, .55);
        backdrop-filter: blur(10px);
        color: rgba(255, 255, 255, .92);
        font-size: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 2
    }

    .car-btn:hover {
        background: rgba(10, 20, 30, .7)
    }

    .car-btn.prev {
        left: -10px
    }

    .car-btn.next {
        right: -10px
    }

    @media (max-width: 920px) {
        .car-viewport {
            overflow: auto;
            -webkit-overflow-scrolling: touch
        }

        .car-track {
            transition: none
        }

        .car-btn {
            display: none
        }

        .camp-card {
            min-width: 280px
        }
    }
</style>
