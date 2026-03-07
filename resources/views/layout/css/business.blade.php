<style>
    :root {
        --primary: #01233f;
        --secondary: #ff7f00;
        --bg: #f5f7fb;
        --card: #ffffff;
        --text: #0b1220;
        --muted: #6b7280;
        --line: #e6eaf2;
        --success: #16a34a;
        --shadow: 0 10px 30px rgba(1, 35, 63, .10);
        --radius: 16px;
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
        color: var(--text);
        background: var(--bg);
        overflow-x: hidden;
    }

    a {
        color: inherit;
        text-decoration: none
    }

    .topbar {
        position: sticky;
        top: 0;
        z-index: 50;
        background: linear-gradient(180deg, rgba(1, 35, 63, 0.98), rgba(1, 35, 63, 0.92));
        border-bottom: 1px solid rgba(255, 255, 255, .08);
        backdrop-filter: saturate(140%) blur(10px);
    }

    .topbar .inner {
        max-width: 1240px;
        margin: 0 auto;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 800;
        letter-spacing: .2px;
        color: #fff;
        min-width: 190px;
    }

    .logo {
        width: 34px;
        height: 34px;
        border-radius: 12px;
        background: radial-gradient(circle at 25% 20%, rgba(255, 127, 0, .95), rgba(255, 127, 0, .65) 35%, rgba(255, 127, 0, 0) 60%),
            linear-gradient(180deg, rgba(255, 255, 255, .12), rgba(255, 255, 255, .05));
        border: 1px solid rgba(255, 255, 255, .18);
        box-shadow: 0 12px 30px rgba(0, 0, 0, .35);
        display: grid;
        place-items: center;
        position: relative;
        overflow: hidden;
    }

    .logo:after {
        content: "V";
        font-weight: 900;
        color: #fff;
        font-size: 18px;
        transform: translateY(-.5px);
        text-shadow: 0 10px 22px rgba(0, 0, 0, .35);
    }

    .brand small {
        display: block;
        font-weight: 600;
        opacity: .8;
        font-size: 12px;
        margin-top: 1px
    }

    .nav {
        display: flex;
        align-items: center;
        gap: 14px;
        color: rgba(255, 255, 255, .86);
        flex: 1;
        overflow: auto;
    }

    .nav a {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 9px 10px;
        border-radius: 12px;
        white-space: nowrap;
        font-weight: 650;
        font-size: 14px;
        opacity: .95;
        border: 1px solid transparent;
    }

    .nav a.active {
        background: rgba(255, 127, 0, .16);
        border-color: rgba(255, 127, 0, .22);
        color: #fff;
    }

    .chip {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 7px 10px;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, .16);
        color: #fff;
        background: rgba(255, 255, 255, .06);
        font-weight: 650;
        font-size: 13px;
    }

    .avatar {
        width: 32px;
        height: 32px;
        border-radius: 999px;
        background: linear-gradient(180deg, rgba(255, 255, 255, .18), rgba(255, 255, 255, .06));
        border: 1px solid rgba(255, 255, 255, .16);
        display: grid;
        place-items: center;
        color: #fff;
        font-weight: 800;
    }

    .shell {
        max-width: 1240px;
        margin: 0 auto;
        padding: 18px;
        overflow-x: hidden;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--muted);
        font-weight: 600;
        margin: 4px 0 14px;
        font-size: 13px;
    }

    .breadcrumb b {
        color: var(--text)
    }

    .page-title {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 14px;
    }

    .page-title h1 {
        margin: 0;
        font-size: 28px;
        letter-spacing: -.02em;
    }

    .page-title .subtitle {
        margin: 6px 0 0;
        color: var(--muted);
        font-weight: 600;
        font-size: 13px;
    }

    .session-title {
        color: var(--secondary);
        font-weight: 900;
        letter-spacing: .02em;
        font-size: 14px;
        text-transform: uppercase;
        text-align: center;
        margin: 0 0 14px;
    }

    .grid {
        display: grid;
        /* Prevent overflow caused by the middle column */
        grid-template-columns: minmax(260px, 320px) minmax(0, 1fr) minmax(260px, 320px);
        gap: 18px;
        align-items: start;
    }

    /* Stack earlier (some laptop widths) */
    @media (max-width: 1180px) {
        .grid {
            grid-template-columns: 1fr;
        }

        .right {
            order: 3
        }

        .main {
            order: 2
        }

        .left {
            order: 1
        }
    }

    @media (max-width: 1100px) {
        .grid {
            grid-template-columns: 1fr
        }

        .brand {
            min-width: auto
        }
    }

    .card {
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
    }

    .card .hd {
        padding: 14px 14px 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        border-bottom: 1px solid rgba(230, 234, 242, .7);
    }

    .card .hd h3 {
        margin: 0;
        font-size: 14px;
        font-weight: 800;
        letter-spacing: .01em;
    }

    .card .bd {
        padding: 14px
    }

    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
    }

    @media (max-width:1100px) {
        .kpi-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr))
        }
    }

    .kpi {
        padding: 14px;
        border-radius: 14px;
        border: 1px solid var(--line);
        background: linear-gradient(180deg, #fff, #fbfcff);
    }

    .kpi .label {
        color: var(--muted);
        font-weight: 700;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .dot {
        width: 8px;
        height: 8px;
        border-radius: 99px;
        background: var(--secondary);
        box-shadow: 0 0 0 4px rgba(255, 127, 0, .15);
    }

    .kpi .value {
        margin-top: 10px;
        font-size: 22px;
        font-weight: 900;
        letter-spacing: -.02em;
    }

    .kpi .unit {
        font-size: 12px;
        color: var(--muted);
        font-weight: 800;
        margin-left: 6px
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

    .btn {
        border: 0;
        cursor: pointer;
        border-radius: 12px;
        padding: 10px 12px;
        font-weight: 900;
        letter-spacing: .01em;
        font-size: 13px;
        transition: transform .08s ease, filter .15s ease;
    }

    .btn:active {
        transform: translateY(1px)
    }

    .btn.primary {
        background: var(--secondary);
        color: #fff
    }

    .btn.ghost {
        background: #fff;
        border: 1px solid var(--line);
        color: var(--primary)
    }

    .btn.small {
        padding: 8px 10px;
        border-radius: 10px
    }

    .stack {
        display: grid;
        gap: 12px
    }

    .filter-box {
        padding: 14px;
    }

    .filter-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 12px;
    }

    .tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 10px;
        border-radius: 999px;
        font-weight: 800;
        font-size: 12px;
        border: 1px solid var(--line);
        background: rgba(22, 163, 74, .10);
        color: #0d7a33;
    }

    .tag .live {
        width: 8px;
        height: 8px;
        border-radius: 99px;
        background: var(--success);
        box-shadow: 0 0 0 4px rgba(22, 163, 74, .12);
    }

    label {
        display: block;
        font-size: 12px;
        font-weight: 800;
        color: var(--muted);
        margin-bottom: 6px;
    }

    select,
    input {
        width: 100%;
        padding: 11px 12px;
        border-radius: 12px;
        border: 1px solid var(--line);
        background: #fff;
        font-weight: 700;
        color: var(--text);
        outline: none;
    }

    input::placeholder {
        color: #9aa3b2
    }

    .note {
        margin-top: 12px;
        padding: 12px;
        border-radius: 14px;
        border: 1px dashed rgba(255, 127, 0, .35);
        background: rgba(255, 127, 0, .08);
        color: #8a3b00;
        font-weight: 750;
        font-size: 12px;
        line-height: 1.35;
    }

    .split {
        display: grid;
        grid-template-columns: 320px 1fr 320px;
        gap: 18px;
    }

    .charts {
        display: grid;
        grid-template-columns: 360px 1fr 320px;
        gap: 12px;
    }

    @media (max-width:1100px) {
        .charts {
            grid-template-columns: 1fr
        }
    }

    .chart-wrap {
        height: 240px
    }

    canvas {
        width: 100% !important;
        height: 100% !important
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-weight: 700;
        font-size: 13px;
    }

    .table th {
        text-align: left;
        color: var(--muted);
        font-size: 11px;
        letter-spacing: .05em;
        text-transform: uppercase;
        padding: 10px 10px;
        border-bottom: 1px solid var(--line);
    }

    .table td {
        padding: 12px 10px;
        border-bottom: 1px solid rgba(230, 234, 242, .6);
        vertical-align: middle;
    }

    .muted {
        color: var(--muted);
        font-weight: 700
    }

    .status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 10px;
        border-radius: 999px;
        font-weight: 900;
        font-size: 12px;
        background: rgba(22, 163, 74, .10);
        color: #0d7a33;
        border: 1px solid rgba(22, 163, 74, .20);
    }

    .status .s-dot {
        width: 8px;
        height: 8px;
        border-radius: 99px;
        background: var(--success)
    }

    .leaders {
        display: grid;
        gap: 10px;
    }

    .leader {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 10px 12px;
        border: 1px solid var(--line);
        border-radius: 14px;
        background: linear-gradient(180deg, #fff, #fbfcff);
    }

    .leader .who {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
    }

    .thumb {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(255, 127, 0, .35), rgba(1, 35, 63, .25));
        border: 1px solid rgba(1, 35, 63, .12);
    }

    .leader .name {
        font-weight: 900;
        font-size: 13px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 160px;
    }

    .leader .meta {
        font-size: 12px;
        color: var(--muted);
        font-weight: 800;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 54px;
        padding: 8px 10px;
        border-radius: 999px;
        background: rgba(1, 35, 63, .06);
        border: 1px solid rgba(1, 35, 63, .10);
        font-weight: 900;
        color: var(--primary);
        font-size: 12px;
    }

    .right-top {
        padding: 14px;
        display: grid;
        gap: 12px;
    }

    .balance {
        padding: 14px;
        border-radius: 14px;
        border: 1px solid var(--line);
        background: linear-gradient(180deg, #fff, #fbfcff);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .balance .t {
        font-weight: 900
    }

    .balance .v {
        font-weight: 950;
        font-size: 22px;
        color: #0f7a33
    }

    .balance .v span {
        font-size: 12px;
        color: var(--muted);
        margin-left: 6px
    }

    .money-ico {
        width: 34px;
        height: 34px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        background: rgba(255, 127, 0, .12);
        border: 1px solid rgba(255, 127, 0, .25);
        color: var(--secondary);
        font-weight: 900;
    }

    .foot {
        text-align: center;
        color: var(--muted);
        font-weight: 700;
        font-size: 12px;
        margin: 18px 0 4px;
    }
</style>


