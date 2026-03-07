<style>
    :root {
        --primary: #01233f;
        --secondary: #ff7f00;
        --bg: #f6f8fb;
        --card: #ffffff;
        --ink: #0f172a;
        --muted: #6b7280;
        --stroke: rgba(15, 23, 42, .10);
        --shadow: 0 18px 60px rgba(1, 35, 63, .10);
        --shadow2: 0 10px 24px rgba(15, 23, 42, .08);
        --r12: 12px;
        --r16: 16px;
        --r18: 18px;
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
        font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
        color: var(--ink);
        background: var(--bg);
    }

    a {
        color: inherit;
        text-decoration: none
    }

    .container {
        max-width: 1240px;
        margin: 0 auto;
        padding: 0 18px
    }

    /* Topbar (promoteur) */
    .topbar {
        position: sticky;
        top: 0;
        z-index: 30;
        background: linear-gradient(180deg, rgba(1, 35, 63, .98), rgba(1, 35, 63, .92));
        color: #fff;
        box-shadow: 0 10px 30px rgba(1, 35, 63, .22);
        border-bottom: 1px solid rgba(255, 255, 255, .08);
    }

    .topbar .row {
        height: 62px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 900;
        letter-spacing: .2px;
        min-width: 220px;
    }

    .brand .logo {
        width: 34px;
        height: 34px;
        border-radius: 12px;
        background: radial-gradient(120% 120% at 30% 20%, rgba(255, 255, 255, .26), rgba(255, 255, 255, .06));
        border: 1px solid rgba(255, 255, 255, .18);
        display: grid;
        place-items: center;
        overflow: hidden;
    }

    .brand .logo svg {
        width: 26px;
        height: 26px;
        display: block
    }

    .brand small {
        display: block;
        font-weight: 700;
        opacity: .85;
        margin-top: -2px
    }

    .nav {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
        font-weight: 700;
    }

    .nav a {
        padding: 10px 12px;
        border-radius: 12px;
        opacity: .92;
        transition: .15s ease;
        border: 1px solid transparent;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .nav a:hover {
        background: rgba(255, 255, 255, .10)
    }

    .nav a.active {
        background: rgba(255, 127, 0, .18);
        border-color: rgba(255, 127, 0, .24);
        opacity: 1;
    }

    .nav svg {
        width: 16px;
        height: 16px;
        opacity: .9
    }

    .user {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 220px;
        justify-content: flex-end;
    }

    .user .name {
        font-weight: 800;
        opacity: .92
    }

    .avatar {
        width: 34px;
        height: 34px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .14);
        border: 1px solid rgba(255, 255, 255, .18);
        display: grid;
        place-items: center;
        box-shadow: 0 10px 24px rgba(0, 0, 0, .18);
    }

    .avatar svg {
        width: 18px;
        height: 18px;
        opacity: .92
    }

    /* Page header */
    .page {
        padding: 16px 0 44px;
    }

    .crumbs {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        color: rgba(15, 23, 42, .65);
        font-weight: 700;
        margin: 12px 0 8px;
    }

    .crumbs .sep {
        opacity: .35
    }

    .headrow {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 14px;
        margin: 6px 0 14px;
    }

    h1 {
        margin: 0;
        font-size: 28px;
        letter-spacing: -.02em;
    }

    .kpis {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .kpi {
        background: #fff;
        border: 1px solid var(--stroke);
        border-radius: 14px;
        padding: 10px 12px;
        box-shadow: var(--shadow2);
        min-width: 170px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .kpi .label {
        font-size: 12px;
        color: var(--muted);
        font-weight: 800
    }

    .kpi .value {
        font-size: 16px;
        font-weight: 900;
        letter-spacing: .2px
    }

    .kpi .badge {
        padding: 6px 10px;
        border-radius: 999px;
        background: rgba(255, 127, 0, .12);
        border: 1px solid rgba(255, 127, 0, .22);
        color: #7a2f00;
        font-weight: 900;
        font-size: 12px;
    }

    /* Layout */
    .layout {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 14px;
        align-items: start;
    }

    .card {
        background: var(--card);
        border: 1px solid var(--stroke);
        border-radius: var(--r18);
        box-shadow: var(--shadow2);
    }

    .card .card-h {
        padding: 14px 14px 10px;
        font-weight: 900;
        letter-spacing: .2px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid rgba(15, 23, 42, .06);
    }

    .card .card-b {
        padding: 14px
    }

    /* Filter */
    .field {
        margin-bottom: 10px
    }

    .label {
        font-size: 12px;
        color: var(--muted);
        font-weight: 900;
        margin: 0 0 6px;
    }

    .control {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 10px;
        background: #fff;
        border: 1px solid rgba(15, 23, 42, .12);
        border-radius: 12px;
        padding: 10px 12px;
        transition: .15s ease;
    }

    .control:focus-within {
        box-shadow: 0 0 0 4px rgba(255, 127, 0, .16)
    }

    .control select,
    .control input {
        width: 100%;
        border: 0;
        outline: 0;
        background: transparent;
        font-size: 14px;
        font-weight: 700;
        color: var(--ink);
    }

    .control svg {
        width: 18px;
        height: 18px;
        opacity: .55
    }

    .hint {
        margin-top: 10px;
        padding: 12px;
        border-radius: 14px;
        background: rgba(1, 35, 63, .04);
        border: 1px dashed rgba(1, 35, 63, .18);
        color: rgba(15, 23, 42, .72);
        font-size: 12px;
        font-weight: 800;
        line-height: 1.35;
    }

    .hint b {
        color: var(--primary)
    }

    .btn {
        width: 100%;
        height: 42px;
        border-radius: 12px;
        border: 1px solid rgba(255, 127, 0, .28);
        background: linear-gradient(180deg, rgba(255, 127, 0, 1), rgba(255, 127, 0, .92));
        color: #fff;
        font-weight: 900;
        letter-spacing: .2px;
        cursor: pointer;
        box-shadow: 0 16px 28px rgba(255, 127, 0, .18);
        transition: .15s ease;
    }

    .btn:hover {
        transform: translateY(-1px)
    }

    .btn.secondary {
        margin-top: 10px;
        background: #fff;
        color: var(--primary);
        border: 1px solid rgba(15, 23, 42, .12);
        box-shadow: var(--shadow2);
    }

    /* Table */
    .tableWrap {
        overflow: hidden
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 13px;
    }

    thead th {
        text-align: left;
        padding: 12px 12px;
        color: rgba(15, 23, 42, .62);
        font-weight: 900;
        background: rgba(15, 23, 42, .02);
        border-bottom: 1px solid rgba(15, 23, 42, .08);
    }

    tbody td {
        padding: 12px 12px;
        border-bottom: 1px solid rgba(15, 23, 42, .06);
        vertical-align: middle;
        color: rgba(15, 23, 42, .86);
        font-weight: 700;
    }

    tbody tr:hover td {
        background: rgba(255, 127, 0, .05)
    }

    .session {
        color: var(--secondary);
        font-weight: 1000;
        letter-spacing: .15px;
    }

    .small {
        font-size: 12px;
        color: rgba(15, 23, 42, .58);
        font-weight: 800;
        margin-top: 3px;
        line-height: 1.25;
    }

    .status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 10px;
        border-radius: 999px;
        background: rgba(16, 185, 129, .12);
        border: 1px solid rgba(16, 185, 129, .25);
        color: rgba(6, 95, 70, .95);
        font-weight: 900;
        font-size: 12px;
    }

    .status .dot {
        width: 8px;
        height: 8px;
        border-radius: 99px;
        background: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, .15)
    }

    .money {
        white-space: nowrap
    }

    .mono {
        font-variant-numeric: tabular-nums;
        font-feature-settings: "tnum" 1;
    }

    .tableFooter {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 12px;
        background: #fff;
        border-top: 1px solid rgba(15, 23, 42, .06);
    }

    .ghost {
        border: 1px solid rgba(15, 23, 42, .12);
        background: #fff;
        border-radius: 12px;
        padding: 10px 12px;
        font-weight: 900;
        cursor: pointer;
        box-shadow: var(--shadow2);
        transition: .15s ease;
    }

    .ghost:hover {
        transform: translateY(-1px)
    }

    .meta {
        font-size: 12px;
        color: rgba(15, 23, 42, .62);
        font-weight: 900;
    }

    /* Responsive */
    @media (max-width: 1020px) {
        .layout {
            grid-template-columns: 1fr
        }

        .brand,
        .user {
            min-width: auto
        }

        .nav {
            display: none
        }

        .kpis {
            justify-content: flex-start
        }
    }

    @media (max-width: 560px) {
        .headrow {
            flex-direction: column;
            align-items: flex-start
        }

        .kpi {
            min-width: 160px
        }

        thead {
            display: none
        }

        table,
        tbody,
        tr,
        td {
            display: block;
            width: 100%
        }

        tbody tr {
            border-bottom: 1px solid rgba(15, 23, 42, .08)
        }

        tbody td {
            border: 0;
            padding: 8px 12px
        }

        tbody td[data-label]::before {
            content: attr(data-label);
            display: block;
            color: rgba(15, 23, 42, .55);
            font-weight: 900;
            font-size: 11px;
            margin-bottom: 4px;
        }
    }

    .pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 7px 10px;
        border-radius: 999px;
        border: 1px solid var(--line);
        font-weight: 800;
        font-size: 12px;
        color: var(--primary);
        background: rgba(1, 35, 63, .04);
    }

    .foot {
        text-align: center;
        color: var(--muted);
        font-weight: 700;
        font-size: 12px;
        margin: 18px 0 4px;
    }
</style>
