<style>
    :root {
        --p: #01233f;
        --s: #ff7f00;
        --bg: #f5f7fb;
        --card: #ffffff;
        --text: #0b1320;
        --muted: #6b778c;
        --line: #e7edf6;
        --shadow: 0 18px 55px rgba(1, 35, 63, 0.14);
        --shadow2: 0 10px 30px rgba(1, 35, 63, 0.1);
        --r: 16px;
        --r2: 20px;
    }

    * {
        box-sizing: border-box;
    }

    html,
    body {
        height: 100%;
    }

    body {
        margin: 0;
        font-family:
            ui-sans-serif,
            system-ui,
            -apple-system,
            Segoe UI,
            Roboto,
            "Helvetica Neue",
            Arial,
            "Noto Sans",
            "Liberation Sans",
            sans-serif;
        color: var(--text);
        background:
            radial-gradient(1200px 500px at 20% -10%,
                rgba(255, 127, 0, 0.08),
                transparent 55%),
            radial-gradient(900px 420px at 90% 0%,
                rgba(1, 35, 63, 0.1),
                transparent 60%),
            var(--bg);
        overflow-x: hidden;
    }

    a {
        color: inherit;
        text-decoration: none;
    }

    .wrap {
        max-width: 1200px;
        margin: 0 auto;
        padding: 18px 18px 40px;
    }

    /* Topbar */
    .topbar {
        position: sticky;
        top: 0;
        z-index: 10;
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(14px);
        border-bottom: 1px solid var(--line);
    }

    .topbar .inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 12px 18px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 220px;
    }

    .logo {
        width: 34px;
        height: 34px;
        border-radius: 12px;
        background: linear-gradient(180deg, #0a3257, #01233f);
        display: grid;
        place-items: center;
        position: relative;
        box-shadow: 0 10px 25px rgba(1, 35, 63, 0.25);
    }

    .logo:after {
        content: "";
        position: absolute;
        right: -2px;
        top: -2px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: radial-gradient(circle at 30% 30%, #ffd2a6, var(--s));
        box-shadow: 0 8px 20px rgba(255, 127, 0, 0.35);
    }

    .logo svg {
        width: 20px;
        height: 20px;
        fill: #fff;
    }

    .brand b {
        letter-spacing: 0.2px;
    }

    .brand small {
        display: block;
        color: var(--muted);
        font-size: 12px;
        margin-top: 2px;
    }

    .nav {
        display: flex;
        align-items: center;
        gap: 8px;
        flex: 1;
        overflow: auto;
    }

    .nav a {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 12px;
        border-radius: 12px;
        color: #233047;
        font-weight: 600;
        font-size: 14px;
        border: 1px solid transparent;
        white-space: nowrap;
    }

    .nav a svg {
        width: 16px;
        height: 16px;
        opacity: 0.85;
    }

    .nav a.active {
        background: linear-gradient(180deg,
                rgba(255, 127, 0, 0.14),
                rgba(255, 127, 0, 0.07));
        border-color: rgba(255, 127, 0, 0.22);
        color: #1b2a3d;
    }

    .nav a:hover {
        background: rgba(1, 35, 63, 0.06);
    }

    .right {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .chip {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 10px;
        border-radius: 14px;
        border: 1px solid var(--line);
        background: #fff;
        box-shadow: 0 10px 30px rgba(1, 35, 63, 0.06);
    }

    .avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: radial-gradient(circle at 30% 20%, #bfe0ff, #1d4f7a);
        display: grid;
        place-items: center;
        color: #fff;
        font-weight: 800;
        font-size: 13px;
    }

    .chip .who {
        line-height: 1.05;
    }

    .chip .who b {
        display: block;
        font-size: 12px;
    }

    .chip .who span {
        display: block;
        font-size: 11px;
        color: var(--muted);
    }

    .btn {
        border: 0;
        cursor: pointer;
        font-weight: 800;
        border-radius: 14px;
        padding: 10px 14px;
        color: #fff;
        background: linear-gradient(180deg, var(--s), #ff9b3b);
        box-shadow: 0 14px 30px rgba(255, 127, 0, 0.22);
        transition:
            transform 0.15s ease,
            box-shadow 0.15s ease,
            filter 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        white-space: nowrap;
    }

    .btn svg {
        width: 16px;
        height: 16px;
    }

    .btn:hover {
        transform: translateY(-1px);
        filter: saturate(1.05);
    }

    .btn:active {
        transform: translateY(0px);
    }

    .btn.secondary {
        background: #fff;
        color: #102338;
        border: 1px solid var(--line);
        box-shadow: 0 10px 22px rgba(1, 35, 63, 0.08);
        font-weight: 800;
    }

    .btn.ghost {
        background: transparent;
        color: #102338;
        border: 1px solid var(--line);
        box-shadow: none;
    }

    /* Page header */
    .pagehead {
        padding: 18px 0 8px;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;
    }

    .crumb {
        color: var(--muted);
        font-size: 13px;
    }

    .crumb b {
        color: #22324a;
    }

    .title {
        font-size: 38px;
        letter-spacing: -0.8px;
        margin: 4px 0 0;
    }

    .subtitle {
        color: var(--muted);
        margin: 6px 0 0;
        max-width: 740px;
        font-size: 14px;
    }

    .tools {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .search {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 10px 12px;
        min-width: 280px;
        box-shadow: var(--shadow2);
    }

    .search svg {
        width: 18px;
        height: 18px;
        opacity: 0.6;
    }

    .search input {
        border: 0;
        outline: none;
        flex: 1;
        font-size: 14px;
    }

    .kpi {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 16px;
        padding: 10px 12px;
        box-shadow: var(--shadow2);
        color: #193048;
        font-weight: 800;
    }

    .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: radial-gradient(circle at 30% 30%, #ffd2a6, var(--s));
        box-shadow: 0 10px 20px rgba(255, 127, 0, 0.28);
    }

    /* Table card */
    .card {
        margin-top: 14px;
        background: rgba(255, 255, 255, 0.88);
        border: 1px solid var(--line);
        border-radius: var(--r2);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 840px;
    }

    .scroll {
        overflow: auto;
        max-width: 100%;
    }

    thead th {
        text-align: left;
        font-size: 12px;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #60708a;
        padding: 16px 16px;
        border-bottom: 1px solid var(--line);
        background: rgba(245, 247, 251, 0.65);
        position: sticky;
        top: 0;
        z-index: 1;
    }

    tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid var(--line);
        vertical-align: middle;
        font-size: 14px;
        color: #203148;
        background: transparent;
    }

    tbody tr:hover td {
        background: rgba(1, 35, 63, 0.03);
    }

    .name {
        font-weight: 900;
        color: #0f243c;
    }

    .name .tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 6px;
        color: var(--muted);
        font-size: 12px;
        font-weight: 700;
    }

    .pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 10px;
        border-radius: 999px;
        font-weight: 800;
        font-size: 12px;
        border: 1px solid;
        white-space: nowrap;
    }

    .pill.ok {
        background: rgba(34, 197, 94, 0.12);
        border-color: rgba(34, 197, 94, 0.25);
        color: #146a33;
    }

    .pill.no {
        background: rgba(255, 127, 0, 0.12);
        border-color: rgba(255, 127, 0, 0.25);
        color: #8a3a00;
    }

    .muted {
        color: var(--muted);
        font-weight: 700;
    }

    .link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #0f355c;
        font-weight: 900;
    }

    .link svg {
        width: 16px;
        height: 16px;
        opacity: 0.75;
    }

    .actions {
        display: flex;
        align-items: center;
        gap: 8px;
        justify-content: flex-end;
    }

    .iconbtn {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        border: 1px solid var(--line);
        background: #fff;
        display: grid;
        place-items: center;
        cursor: pointer;
        box-shadow: 0 10px 22px rgba(1, 35, 63, 0.08);
        transition:
            transform 0.12s ease,
            background 0.12s ease;
    }

    .iconbtn:hover {
        transform: translateY(-1px);
        background: rgba(1, 35, 63, 0.03);
    }

    .iconbtn svg {
        width: 18px;
        height: 18px;
        opacity: 0.9;
    }

    .iconbtn.primary {
        border-color: rgba(255, 127, 0, 0.35);
    }

    .iconbtn.danger {
        border-color: rgba(239, 68, 68, 0.25);
        background: rgba(239, 68, 68, 0.06);
    }

    .iconbtn.danger svg {
        fill: #b42318;
        opacity: 1;
    }

    .iconbtn.purple {
        border-color: rgba(99, 102, 241, 0.25);
        background: rgba(99, 102, 241, 0.06);
    }

    .iconbtn.purple svg {
        fill: #3f43c8;
        opacity: 1;
    }

    /* .foot {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 16px;
        color: var(--muted);
        font-size: 13px;
        gap: 10px;
        flex-wrap: wrap;
        background: rgba(245, 247, 251, 0.65);
    } */

    .foot .pager {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .mini {
        padding: 8px 10px;
        border-radius: 12px;
        border: 1px solid var(--line);
        background: #fff;
        font-weight: 900;
        color: #203148;
        cursor: pointer;
    }

    .mini:hover {
        background: rgba(1, 35, 63, 0.03);
    }

    /* Modal */
    .overlay {
        position: fixed;
        inset: 0;
        background: rgba(1, 35, 63, 0.55);
        backdrop-filter: blur(10px);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 18px;
        z-index: 50;
    }

    .overlay.show {
        display: flex;
    }

    .modal {
        width: min(720px, 100%);
        max-height: calc(100vh - 36px);
        display: flex;
        flex-direction: column;
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 22px;
        box-shadow: 0 30px 120px rgba(1, 35, 63, 0.45);
        overflow: hidden;
        transform: translateY(8px);
        animation: pop 0.18s ease-out forwards;
    }

    @keyframes pop {
        to {
            transform: translateY(0);
        }
    }

    .mhead {
        position: sticky;
        top: 0;
        z-index: 2;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        padding: 18px 18px 10px;
        background:
            radial-gradient(900px 240px at 15% -10%,
                rgba(255, 127, 0, 0.18),
                transparent 60%),
            radial-gradient(900px 240px at 90% 0%,
                rgba(1, 35, 63, 0.14),
                transparent 60%),
            rgba(245, 247, 251, 0.6);
        border-bottom: 1px solid var(--line);
    }

    .mhead h3 {
        margin: 0;
        font-size: 26px;
        letter-spacing: -0.5px;
    }

    .mhead p {
        margin: 6px 0 0;
        color: var(--muted);
        font-weight: 700;
        font-size: 13px;
    }

    .close {
        width: 40px;
        height: 40px;
        border-radius: 14px;
        border: 1px solid var(--line);
        background: #fff;
        cursor: pointer;
        display: grid;
        place-items: center;
        box-shadow: 0 10px 22px rgba(1, 35, 63, 0.08);
    }

    .close svg {
        width: 18px;
        height: 18px;
    }

    .mbody {
        padding: 16px 18px 18px;
        overflow: auto;
        flex: 1;
    }

    .grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .field {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .field label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #60708a;
        font-weight: 900;
    }

    .inp,
    .ta,
    .sel {
        border: 1px solid var(--line);
        background: #fff;
        border-radius: 14px;
        padding: 12px 12px;
        font-size: 14px;
        outline: none;
        box-shadow: 0 10px 22px rgba(1, 35, 63, 0.06);
    }

    .ta {
        min-height: 92px;
        resize: vertical;
    }

    .upload {
        border: 1px dashed rgba(1, 35, 63, 0.25);
        background: rgba(1, 35, 63, 0.03);
        border-radius: 16px;
        padding: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .upload .hint {
        color: var(--muted);
        font-weight: 700;
        font-size: 13px;
    }

    .row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        border: 1px solid var(--line);
        background: rgba(245, 247, 251, 0.5);
        border-radius: 16px;
        padding: 12px 12px;
        margin-top: 12px;
    }

    .row b {
        font-size: 14px;
    }

    .row small {
        display: block;
        color: var(--muted);
        font-weight: 700;
        margin-top: 2px;
    }

    .seg {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 6px;
        box-shadow: 0 10px 22px rgba(1, 35, 63, 0.06);
    }

    .seg button {
        border: 0;
        background: transparent;
        cursor: pointer;
        padding: 10px 12px;
        border-radius: 12px;
        font-weight: 900;
        color: #22324a;
    }

    .seg button.active {
        background: linear-gradient(180deg,
                rgba(255, 127, 0, 0.18),
                rgba(255, 127, 0, 0.08));
        color: #1a2a3d;
        border: 1px solid rgba(255, 127, 0, 0.22);
    }

    .footbtns {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 14px;
        flex-wrap: wrap;
        position: sticky;
        bottom: 0;
        padding: 12px 0 0;
        background: linear-gradient(to top,
                rgba(245, 247, 251, 0.98),
                rgba(245, 247, 251, 0));
    }

    .note {
        margin-top: 10px;
        color: var(--muted);
        font-size: 12px;
        font-weight: 700;
    }

    /* Responsive */
    @media (max-width: 860px) {
        .brand {
            min-width: unset;
        }

        .title {
            font-size: 30px;
        }

        .search {
            min-width: unset;
            flex: 1;
        }
    }

    @media (max-width: 720px) {
        .grid {
            grid-template-columns: 1fr;
        }

        .nav {
            gap: 4px;
        }

        .nav a {
            padding: 10px 10px;
        }
    }

    .upload {
        position: relative;
    }

    .upload.hasimg {
        background-size: cover;
        background-position: center;
    }

    .upload.hasimg .hint {
        color: rgba(255, 255, 255, 0.9);
        text-shadow: 0 6px 18px rgba(0, 0, 0, 0.55);
    }

    .upload.hasimg .btn.ghost {
        background: rgba(0, 0, 0, 0.35);
        border-color: rgba(255, 255, 255, 0.35);
        color: #fff;
    }

    /* Toast */
    .toast {
        position: fixed;
        left: 50%;
        bottom: 22px;
        transform: translateX(-50%);
        padding: 12px 16px;
        border-radius: 999px;
        background: rgba(1, 35, 63, 0.92);
        color: #fff;
        font-weight: 800;
        font-size: 13px;
        letter-spacing: 0.2px;
        box-shadow: 0 18px 40px rgba(1, 35, 63, 0.25);
        opacity: 0;
        pointer-events: none;
        transition:
            opacity 0.2s ease,
            transform 0.2s ease;
        z-index: 9999;
        max-width: min(720px, calc(100vw - 32px));
        text-align: center;
    }

    .toast.show {
        opacity: 1;
        transform: translateX(-50%) translateY(-2px);
    }

   .foot {
        text-align: center;
        color: var(--muted);
        font-weight: 700;
        font-size: 12px;
        margin: 18px 0 4px;
    }
</style>
