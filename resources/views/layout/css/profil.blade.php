<style>
    :root {
        --p: #01233f;
        --p2: #0b355c;
        --accent: #ff7f00;
        --bg: #f5f7fb;
        --card: #ffffff;
        --text: #0f172a;
        --muted: #64748b;
        --line: #e6ebf3;
        --shadow: 0 14px 40px rgba(1, 35, 63, .10);
        --radius: 18px;
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
        background: linear-gradient(180deg, #ffffff 0%, var(--bg) 42%, #f3f6fb 100%);
    }

    a {
        color: inherit;
        text-decoration: none
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 18px
    }

    /* Topbar */
    .topbar {
        position: sticky;
        top: 0;
        z-index: 50;
        background: linear-gradient(180deg, rgba(1, 35, 63, .98), rgba(1, 35, 63, .92));
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(255, 255, 255, .08);
    }

    .topbar .inner {
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 190px;
    }

    .logoMark {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: grid;
        place-items: center;
        background: rgba(255, 255, 255, .10);
        border: 1px solid rgba(255, 255, 255, .14);
    }

    .brand .name {
        display: flex;
        flex-direction: column;
        line-height: 1.05
    }

    .brand .name strong {
        color: #fff;
        letter-spacing: .3px
    }

    .brand .name span {
        color: rgba(255, 255, 255, .72);
        font-size: 12px
    }

    .nav {
        display: flex;
        align-items: center;
        gap: 2px;
        flex-wrap: wrap;
        justify-content: center
    }

    .nav a {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 12px;
        color: rgba(255, 255, 255, .80);
        border-radius: 12px;
        transition: .18s ease;
        font-weight: 600;
        font-size: 14px;
    }

    .nav a:hover {
        background: rgba(255, 255, 255, .08);
        color: #fff
    }

    .nav a.active {
        background: rgba(255, 127, 0, .16);
        color: #fff;
        border: 1px solid rgba(255, 127, 0, .35);
    }

    .right {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 190px;
        justify-content: flex-end
    }

    .pill {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 10px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .10);
        border: 1px solid rgba(255, 255, 255, .14);
        color: #fff;
        font-weight: 700;
        font-size: 13px;
    }

    .avatar {
        width: 32px;
        height: 32px;
        border-radius: 999px;
        background: radial-gradient(circle at 30% 30%, rgba(255, 127, 0, .9), rgba(255, 127, 0, .25));
        border: 1px solid rgba(255, 255, 255, .18);
    }

    .btnTop {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border-radius: 14px;
        border: 1px solid rgba(255, 127, 0, .40);
        background: linear-gradient(180deg, rgba(255, 127, 0, .98), rgba(255, 127, 0, .88));
        color: #102a43;
        font-weight: 900;
        box-shadow: 0 12px 26px rgba(255, 127, 0, .20);
        cursor: pointer;
        transition: .18s ease;
        white-space: nowrap;
    }

    .btnTop:hover {
        transform: translateY(-1px);
        filter: saturate(1.05)
    }

    /* Page */
    .page {
        padding: 26px 0 60px
    }

    .crumbs {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--muted);
        font-weight: 700;
        font-size: 13px;
        margin-bottom: 12px
    }

    .crumbs .sep {
        opacity: .45
    }

    .titleRow {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 18px
    }

    h1 {
        margin: 0;
        font-size: 38px;
        letter-spacing: -.5px
    }

    .hint {
        margin-top: 6px;
        color: var(--muted);
        font-weight: 600
    }

    .homeBtn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border-radius: 14px;
        border: 1px solid rgba(255, 127, 0, .30);
        background: rgba(255, 127, 0, .12);
        color: var(--p);
        font-weight: 900;
        cursor: pointer;
        white-space: nowrap;
    }

    /* Card layout */
    .shell {
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 22px;
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .shellGrid {
        display: grid;
        grid-template-columns: 260px 1fr;
        min-height: 520px;
    }

    .side {
        padding: 18px;
        background: linear-gradient(180deg, #ffffff 0%, #fbfcff 100%);
        border-right: 1px solid var(--line);
    }

    .side .tab {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 12px;
        border-radius: 14px;
        border: 1px solid transparent;
        font-weight: 900;
        color: #0f172a;
        background: transparent;
        cursor: pointer;
        transition: .15s ease;
        text-align: left;
    }

    .side .tab:hover {
        background: #f4f7ff
    }

    .side .tab.active {
        background: rgba(255, 127, 0, .14);
        border-color: rgba(255, 127, 0, .30);
        color: #0b2440;
    }

    .tabIcon {
        width: 34px;
        height: 34px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        background: #f1f5ff;
        border: 1px solid #e8efff;
        color: var(--p);
        flex: 0 0 34px;
    }

    .tab.active .tabIcon {
        background: rgba(255, 127, 0, .18);
        border-color: rgba(255, 127, 0, .30);
        color: var(--accent);
    }

    .main {
        padding: 20px!important;
    }

    .sectionTitle {
        font-size: 28px;
        margin: 0;
        letter-spacing: -.3px;
    }

    .sectionSub {
        margin: 6px 0 18px;
        color: var(--muted);
        font-weight: 600;
    }

    .divider {
        height: 1px;
        background: var(--line);
        margin: 14px 0 18px
    }

    /* Form */
    .formGrid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px 18px;
    }

    .field {
        display: flex;
        flex-direction: column;
        gap: 8px
    }

    .label {
        font-weight: 900;
        color: #1f2a44;
        font-size: 13px
    }

    .control {
        position: relative;
        display: flex;
        align-items: center;
        gap: 10px;
        border: 1px solid #dfe6f2;
        background: #fff;
        border-radius: 14px;
        padding: 12px 12px;
        transition: .15s ease;
        min-height: 46px;
    }

    .control:focus-within {
        border-color: rgba(255, 127, 0, .55);
        box-shadow: 0 0 0 4px rgba(255, 127, 0, .12);
    }

    input,
    select {
        width: 100%;
        border: 0;
        outline: 0;
        font-size: 14px;
        background: transparent;
        color: var(--text);
        font-weight: 700;
    }

    input::placeholder {
        color: #94a3b8;
        font-weight: 700
    }

    .ic {
        width: 18px;
        height: 18px;
        opacity: .75;
        flex: 0 0 auto;
    }

    .span2 {
        grid-column: span 2
    }

    /* Upload row */
    .uploadRow {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        border: 1px solid #dfe6f2;
        background: #fff;
        border-radius: 16px;
        padding: 14px;
    }

    .logoPreview {
        width: 46px;
        height: 46px;
        border-radius: 999px;
        background: radial-gradient(circle at 35% 35%, rgba(255, 127, 0, .75), rgba(1, 35, 63, .15));
        border: 1px solid #e6ebf3;
        display: grid;
        place-items: center;
        overflow: hidden;
    }

    .logoPreview img {
        width: 100%;
        height: 100%;
        object-fit: cover
    }

    .uploadBtn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border-radius: 14px;
        border: 1px solid rgba(125, 93, 255, .0);
        background: linear-gradient(180deg, #7c3aed, #6d28d9);
        color: #fff;
        font-weight: 900;
        cursor: pointer;
        white-space: nowrap;
        box-shadow: 0 12px 26px rgba(109, 40, 217, .18);
    }

    .trashBtn {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        border: 1px solid rgba(220, 38, 38, .25);
        background: rgba(220, 38, 38, .10);
        display: grid;
        place-items: center;
        cursor: pointer;
    }

    .trashBtn:hover {
        background: rgba(220, 38, 38, .16)
    }

    .actions {
        display: flex;
        justify-content: flex-start;
        margin-top: 18px;
    }

    .save {
        padding: 12px 18px;
        border-radius: 14px;
        border: 1px solid rgba(255, 127, 0, .45);
        background: linear-gradient(180deg, rgba(255, 127, 0, .98), rgba(255, 127, 0, .88));
        color: #0b2440;
        font-weight: 950;
        cursor: pointer;
        box-shadow: 0 14px 30px rgba(255, 127, 0, .18);
    }

    .toast {
        position: fixed;
        right: 18px;
        bottom: 18px;
        z-index: 70;
        background: rgba(1, 35, 63, .96);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, .12);
        border-radius: 16px;
        padding: 12px 14px;
        box-shadow: 0 16px 40px rgba(1, 35, 63, .28);
        display: flex;
        align-items: flex-start;
        gap: 10px;
        min-width: 280px;
        transform: translateY(14px);
        opacity: 0;
        pointer-events: none;
        transition: .18s ease;
    }

    .toast.show {
        transform: translateY(0);
        opacity: 1;
        pointer-events: auto
    }

    .toast strong {
        display: block
    }

    .toast small {
        display: block;
        opacity: .82;
        font-weight: 700;
        margin-top: 2px
    }

    .dot {
        width: 10px;
        height: 10px;
        border-radius: 999px;
        background: var(--accent);
        margin-top: 4px
    }

    footer {
        margin-top: 18px;
        color: #94a3b8;
        font-weight: 700;
        text-align: center;
        font-size: 12px;
    }

    /* Responsive */
    @media (max-width: 980px) {
        .nav {
            display: none
        }

        .shellGrid {
            grid-template-columns: 1fr
        }

        .side {
            border-right: 0;
            border-bottom: 1px solid var(--line)
        }

        .formGrid {
            grid-template-columns: 1fr
        }

        .span2 {
            grid-column: span 1
        }

        h1 {
            font-size: 30px
        }
    }

    .foot {
        text-align: center;
        color: var(--muted);
        font-weight: 700;
        font-size: 12px;
        margin: 18px 0 4px;
    }
</style>
