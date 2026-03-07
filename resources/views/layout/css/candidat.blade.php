<style>
    :root {
        --primary: #01233f;
        --secondary: #ff7f00;
        --bg: #f6f8fb;
        --card: #ffffff;
        --text: #0b1b2c;
        --muted: #64748b;
        --line: rgba(2, 6, 23, .08);
        --shadow: 0 18px 50px rgba(2, 6, 23, .10);
        --shadow2: 0 10px 30px rgba(2, 6, 23, .10);
        --radius: 16px;
        --radius2: 20px;
        --ring: 0 0 0 4px rgba(255, 127, 0, .18);
        --good: #19a974;
        --danger: #e11d48;
        --warn: #f59e0b;
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
        background: radial-gradient(1200px 600px at 20% -10%, rgba(255, 127, 0, .12), transparent 60%),
            radial-gradient(900px 500px at 90% 0%, rgba(1, 35, 63, .18), transparent 55%),
            var(--bg);
        color: var(--text);
    }

    a {
        color: inherit;
        text-decoration: none
    }

    .container {
        max-width: 1220px;
        margin: 0 auto;
        padding: 18px 18px 42px
    }

    /* Top nav */
    .topbar {
        position: sticky;
        top: 0;
        z-index: 50;
        backdrop-filter: saturate(160を見る) blur(10px);
        background: rgba(1, 35, 63, .92);
        border-bottom: 1px solid rgba(255, 255, 255, .08);
    }

    .topbar-inner {
        max-width: 1220px;
        margin: 0 auto;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 170px
    }

    .logo {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: radial-gradient(120% 120% at 30% 20%, rgba(255, 127, 0, .9), rgba(255, 127, 0, .25) 40%, rgba(255, 127, 0, .05) 70%),
            linear-gradient(180deg, rgba(255, 255, 255, .10), rgba(255, 255, 255, 0));
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .14);
        display: grid;
        place-items: center;
        overflow: hidden;
    }

    .logo svg {
        width: 26px;
        height: 26px;
        filter: drop-shadow(0 10px 18px rgba(0, 0, 0, .25));
    }

    .brand strong {
        color: #fff;
        letter-spacing: .3px
    }

    .brand small {
        display: block;
        margin-top: 2px;
        color: rgba(255, 255, 255, .72);
        font-weight: 500
    }

    .nav {
        display: flex;
        align-items: center;
        gap: 6px;
        flex: 1;
        overflow: auto;
        scrollbar-width: none;
    }

    .nav::-webkit-scrollbar {
        display: none
    }

    .nav a {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 12px;
        border-radius: 12px;
        color: rgba(255, 255, 255, .88);
        font-weight: 600;
        letter-spacing: .1px;
        white-space: nowrap;
        transition: .2s ease;
    }

    .nav a:hover {
        background: rgba(255, 255, 255, .08)
    }

    .nav a.active {
        background: rgba(255, 127, 0, .16);
        color: #fff;
        box-shadow: inset 0 0 0 1px rgba(255, 127, 0, .28);
    }

    .nav svg {
        width: 16px;
        height: 16px;
        opacity: .95
    }

    .right {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-left: auto;
    }

    .pill {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .08);
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .10);
        color: #fff;
        min-width: 160px;
    }

    .avatar {
        width: 30px;
        height: 30px;
        border-radius: 999px;
        background: radial-gradient(120% 120% at 30% 20%, rgba(255, 127, 0, .9), rgba(255, 127, 0, .15) 55%, rgba(255, 255, 255, .05) 100%);
        display: grid;
        place-items: center;
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .16);
        font-weight: 800;
    }

    .pill .meta {
        line-height: 1.1
    }

    .pill .meta b {
        display: block;
        font-size: 13px
    }

    .pill .meta span {
        display: block;
        font-size: 12px;
        color: rgba(255, 255, 255, .74)
    }

    /* Page header */
    .page-head {
        padding: 22px 0 12px;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 12px;
    }

    .crumbs {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--muted);
        font-weight: 600;
    }

    .crumbs .sep {
        opacity: .5
    }

    h1 {
        margin: 8px 0 0;
        font-size: 44px;
        letter-spacing: -.8px;
        color: var(--text);
    }

    .actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .btn {
        border: 0;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 14px;
        border-radius: 14px;
        font-weight: 800;
        letter-spacing: .2px;
        transition: .18s ease;
        user-select: none;
    }

    .btn svg {
        width: 16px;
        height: 16px
    }

    .btn.primary {
        background: linear-gradient(135deg, var(--secondary), #ff9b2b);
        color: #111827;
        box-shadow: 0 18px 40px rgba(255, 127, 0, .22);
    }

    .btn.primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 22px 55px rgba(255, 127, 0, .26)
    }

    .btn.ghost {
        background: #fff;
        color: var(--primary);
        box-shadow: var(--shadow2);
    }

    .btn.ghost:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow)
    }

    .btn.outline {
        background: transparent;
        color: var(--primary);
        border: 1px solid rgba(1, 35, 63, .18);
    }

    .btn.outline:hover {
        background: rgba(1, 35, 63, .04)
    }

    /* Layout */
    .grid {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 18px;
        align-items: start;
    }

    .panel {
        background: rgba(255, 255, 255, .78);
        border: 1px solid var(--line);
        box-shadow: var(--shadow2);
        border-radius: var(--radius2);
        overflow: hidden;
    }

    .panel .pad {
        padding: 16px
    }

    .panel h3 {
        margin: 0 0 10px;
        font-size: 14px;
        letter-spacing: .4px;
        text-transform: uppercase;
        color: var(--muted);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .field {
        margin: 10px 0
    }

    label {
        display: block;
        font-size: 12px;
        font-weight: 800;
        color: var(--muted);
        margin-bottom: 7px;
    }

    select,
    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="date"] {
        width: 100%;
        padding: 12px 12px;
        border-radius: 14px;
        border: 1px solid rgba(2, 6, 23, .10);
        background: #fff;
        outline: none;
        transition: .15s ease;
        font-weight: 700;
        color: var(--text);
    }

    select:focus,
    input:focus {
        box-shadow: var(--ring);
        border-color: rgba(255, 127, 0, .55)
    }

    .select-wrap {
        position: relative
    }

    .select-wrap:after {
        content: "";
        position: absolute;
        right: 12px;
        top: 50%;
        width: 10px;
        height: 10px;
        border-right: 2px solid rgba(1, 35, 63, .55);
        border-bottom: 2px solid rgba(1, 35, 63, .55);
        transform: translateY(-60%) rotate(45deg);
        pointer-events: none;
    }

    select {
        appearance: none;
        padding-right: 34px
    }

    .cats-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 14px 16px;
        border-top: 1px solid var(--line);
        border-bottom: 1px solid var(--line);
        background: rgba(1, 35, 63, .02);
    }

    .cats-head b {
        font-size: 18px
    }

    .icon-btn {
        border: 0;
        cursor: pointer;
        width: 42px;
        height: 42px;
        border-radius: 14px;
        display: grid;
        place-items: center;
        background: #fff;
        box-shadow: var(--shadow2);
        transition: .18s ease;
    }

    .icon-btn:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow)
    }

    .cat-list {
        padding: 12px 14px 16px;
        display: grid;
        gap: 10px
    }

    .cat {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 12px 12px;
        border-radius: 14px;
        border: 1px solid rgba(2, 6, 23, .10);
        background: #fff;
    }

    .cat .left {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0
    }

    .cat .badge {
        width: 30px;
        height: 30px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        background: rgba(255, 127, 0, .16);
        color: var(--secondary);
        box-shadow: inset 0 0 0 1px rgba(255, 127, 0, .22);
    }

    .cat .name {
        font-weight: 900;
        color: var(--primary);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis
    }

    .cat .mini {
        font-size: 12px;
        font-weight: 800;
        color: var(--muted);
    }

    .cat .tools {
        display: flex;
        gap: 8px
    }

    .tiny {
        border: 0;
        cursor: pointer;
        width: 36px;
        height: 36px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        background: rgba(1, 35, 63, .05);
        transition: .15s ease;
    }

    .tiny:hover {
        background: rgba(1, 35, 63, .09)
    }

    .tiny svg {
        width: 16px;
        height: 16px
    }

    .export {
        padding: 14px 16px 16px;
        border-top: 1px solid var(--line);
        background: rgba(255, 127, 0, .06);
    }

    .export .btn {
        width: 100%;
        justify-content: center;
    }

    /* Main */
    .main-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 12px;
    }

    .search {
        flex: 1;
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .searchbox {
        flex: 1;
        position: relative;
    }

    .searchbox input {
        padding-left: 44px;
        background: rgba(255, 255, 255, .88);
        box-shadow: var(--shadow2);
    }

    .searchbox svg {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        width: 18px;
        height: 18px;
        color: rgba(1, 35, 63, .55);
        pointer-events: none;
    }

    .grid-cards {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .card {
        background: rgba(255, 255, 255, .92);
        border: 1px solid var(--line);
        border-radius: 18px;
        box-shadow: var(--shadow2);
        overflow: hidden;
        transition: .18s ease;
        position: relative;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow)
    }

    .card .top {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        padding: 12px 12px 10px;
    }

    .chk {
        width: 18px;
        height: 18px;
        border-radius: 6px;
        border: 1px solid rgba(2, 6, 23, .22);
        background: #fff;
        display: grid;
        place-items: center;
        margin-top: 2px;
        cursor: pointer;
    }

    .chk[data-on="1"] {
        border-color: rgba(255, 127, 0, .75);
        background: rgba(255, 127, 0, .18)
    }

    .thumb {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: linear-gradient(135deg, rgba(1, 35, 63, .92), rgba(1, 35, 63, .65));
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .08);
        display: grid;
        place-items: center;
        color: #fff;
        font-weight: 900;
        flex: 0 0 auto;
        overflow: hidden;
    }

    .thumb svg {
        width: 32px;
        height: 32px;
        opacity: .95
    }

    .meta2 {
        min-width: 0;
        flex: 1
    }

    .meta2 .name {
        font-weight: 1000;
        font-size: 14px;
        line-height: 1.15;
        letter-spacing: -.2px;
        color: var(--primary);
        margin-top: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .meta2 .sub {
        font-size: 12px;
        font-weight: 900;
        color: var(--secondary);
        margin-top: 3px;
    }

    .meta2 .age {
        font-size: 12px;
        font-weight: 800;
        color: var(--muted);
        margin-top: 4px;
    }

    .tools2 {
        display: flex;
        gap: 8px;
        margin-left: auto;
    }

    .tool {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        border: 1px solid rgba(2, 6, 23, .10);
        background: #fff;
        cursor: pointer;
        transition: .15s ease;
    }

    .tool:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow2)
    }

    .tool svg {
        width: 16px;
        height: 16px
    }

    .tool.danger {
        background: rgba(225, 29, 72, .08);
        border-color: rgba(225, 29, 72, .18)
    }

    .tool.danger svg {
        color: var(--danger)
    }

    .tool.edit {
        background: rgba(255, 127, 0, .10);
        border-color: rgba(255, 127, 0, .18)
    }

    .tool.edit svg {
        color: #b45309
    }

    .tool.view {
        background: rgba(25, 169, 116, .10);
        border-color: rgba(25, 169, 116, .18)
    }

    .tool.view svg {
        color: var(--good)
    }

    .card .bottom {
        padding: 0 12px 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .tag {
        display: flex;
        gap: 8px;
        align-items: center;
        padding: 8px 10px;
        border-radius: 999px;
        background: rgba(1, 35, 63, .05);
        color: rgba(1, 35, 63, .85);
        font-weight: 900;
        font-size: 12px;
        border: 1px solid rgba(1, 35, 63, .08);
        max-width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .tag .dot {
        width: 8px;
        height: 8px;
        border-radius: 999px;
        background: var(--secondary);
        box-shadow: 0 0 0 4px rgba(255, 127, 0, .12);
    }

    .badge-right {
        font-size: 12px;
        font-weight: 900;
        color: var(--muted);
    }

    .loadmore {
        margin-top: 16px;
        display: flex;
        justify-content: center;
    }

    .loadmore .btn.outline {
        background: rgba(255, 255, 255, .85);
        box-shadow: var(--shadow2)
    }

    /* Modal */
    .overlay {
        position: fixed;
        inset: 0;
        background: rgba(1, 35, 63, .55);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 18px;
        z-index: 1000;
    }

    .overlay.show {
        display: flex
    }

    .modal {
        width: min(860px, 100%);
        background: #fff;
        border-radius: 22px;
        box-shadow: 0 40px 120px rgba(0, 0, 0, .35);
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, .35);
        position: relative;
    }

    .modal-head {
        padding: 16px 18px;
        background: linear-gradient(180deg, rgba(1, 35, 63, .06), rgba(1, 35, 63, 0));
        border-bottom: 1px solid var(--line);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .modal-head h2 {
        margin: 0;
        font-size: 28px;
        letter-spacing: -.5px;
        color: var(--primary);
    }

    .close {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        border: 1px solid rgba(2, 6, 23, .10);
        background: #fff;
        cursor: pointer;
        display: grid;
        place-items: center;
        transition: .15s ease;
    }

    .close:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow2)
    }

    .modal-body {
        padding: 18px
    }

    .upload-row {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 10px;
        margin-bottom: 14px;
    }

    .uploader {
        border: 1px dashed rgba(1, 35, 63, .22);
        background: rgba(1, 35, 63, .03);
        border-radius: 14px;
        height: 56px;
        display: grid;
        place-items: center;
        cursor: pointer;
        transition: .15s ease;
        color: rgba(1, 35, 63, .60);
        font-weight: 900;
        position: relative;
        overflow: hidden;
    }

    .uploader:hover {
        background: rgba(255, 127, 0, .08);
        border-color: rgba(255, 127, 0, .35)
    }

    .uploader input {
        opacity: 0;
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        cursor: pointer
    }


    .uploader.has {
        border-style: solid;
        background-size: cover;
        background-position: center;
        border-color: rgba(255, 127, 0, .45);
    }

    .uploader.has svg {
        opacity: 0
    }

    .card.inactive {
        opacity: .55;
        filter: grayscale(.25);
    }

    .card .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        font-weight: 900;
        font-size: 12px;
        border: 1px solid rgba(1, 35, 63, .14);
        background: rgba(1, 35, 63, .04);
        color: rgba(1, 35, 63, .78);
    }

    .card.inactive .status-pill {
        background: rgba(255, 127, 0, .10);
        border-color: rgba(255, 127, 0, .25);
        color: rgba(255, 127, 0, .95);
    }

    .uploader svg {
        width: 18px;
        height: 18px
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .form-grid .full {
        grid-column: 1 / -1
    }

    .hint {
        font-size: 12px;
        color: var(--muted);
        margin-top: 8px;
        font-weight: 700;
    }

    .modal-foot {
        padding: 14px 18px;
        border-top: 1px solid var(--line);
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        background: rgba(1, 35, 63, .02);
    }

    .btn.light {
        background: #fff;
        border: 1px solid rgba(2, 6, 23, .12);
        color: var(--text);
    }

    .btn.light:hover {
        box-shadow: var(--shadow2);
        transform: translateY(-1px)
    }

    /* Responsive */
    @media (max-width: 1020px) {
        .grid {
            grid-template-columns: 1fr
        }

        .page-head {
            align-items: flex-start
        }

        h1 {
            font-size: 36px
        }

        .grid-cards {
            grid-template-columns: repeat(2, minmax(0, 1fr))
        }
    }

    @media (max-width: 640px) {
        .topbar-inner {
            gap: 10px
        }

        .brand {
            min-width: auto
        }

        .brand strong {
            display: none
        }

        .brand small {
            display: none
        }

        .pill {
            display: none
        }

        h1 {
            font-size: 30px
        }

        .grid-cards {
            grid-template-columns: 1fr
        }

        .upload-row {
            grid-template-columns: repeat(3, minmax(0, 1fr))
        }

        .form-grid {
            grid-template-columns: 1fr
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
