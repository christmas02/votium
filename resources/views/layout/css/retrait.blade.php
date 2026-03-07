<style>
        :root {
            --primary: #01233f;
            --secondary: #ff7f00;
            --bg: #f5f7fb;
            --card: #ffffff;
            --muted: #6b7280;
            --text: #0b1220;
            --border: #e6eaf2;
            --success: #1f9d64;
            --success-bg: #dff6ea;
            --shadow: 0 16px 45px rgba(1, 35, 63, .10);
            --shadow-soft: 0 10px 25px rgba(15, 23, 42, .08);
            --radius: 16px;
            --radius-sm: 12px;
            --radius-xs: 10px;
            --font: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
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
            font-family: var(--font);
            background: var(--bg);
            color: var(--text);
        }

        a {
            color: inherit;
            text-decoration: none
        }

        /* Topbar */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            height: 64px;
            background: linear-gradient(180deg, rgba(1, 35, 63, .98), rgba(1, 35, 63, .92));
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            display: flex;
            align-items: center;
        }

        .topbar .wrap {
            width: min(1220px, 92vw);
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 170px;
            color: #fff;
            font-weight: 800;
            letter-spacing: .2px;
        }

        .brand-mark {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            background: rgba(255, 127, 0, .14);
            border: 1px solid rgba(255, 127, 0, .35);
            box-shadow: 0 10px 22px rgba(0, 0, 0, .18) inset;
            position: relative;
            overflow: hidden;
        }

        .brand-mark svg {
            display: block
        }

        .nav {
            display: flex;
            align-items: center;
            gap: 14px;
            color: rgba(255, 255, 255, .82);
            font-weight: 600;
        }

        .nav a {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 10px;
            border-radius: 12px;
            transition: .15s ease;
            white-space: nowrap;
        }

        .nav a:hover {
            background: rgba(255, 255, 255, .08);
            color: #fff
        }

        .nav a.active {
            color: #fff;
            background: rgba(255, 127, 0, .12);
            border: 1px solid rgba(255, 127, 0, .35);
        }

        .spacer {
            flex: 1
        }

        .user {
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255, 255, 255, .92);
            font-weight: 700;
        }

        .avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .18);
            display: grid;
            place-items: center;
            overflow: hidden;
        }

        .avatar svg {
            opacity: .9
        }

        /* Page header */
        .page {
            width: min(1220px, 92vw);
            margin: 22px auto 70px;
        }

        .crumbs {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--muted);
            font-weight: 600;
            margin: 12px 0 6px;
        }

        .crumbs .dot {
            opacity: .6
        }

        .page-title-row {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 14px;
            margin: 6px 0 16px;
        }

        h1 {
            margin: 0;
            font-size: 40px;
            letter-spacing: -.6px;
            line-height: 1.05;
        }

        .cta {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn {
            appearance: none;
            border: 0;
            cursor: pointer;
            border-radius: 14px;
            padding: 12px 16px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: .15s ease;
            box-shadow: var(--shadow-soft);
        }

        .btn-primary {
            background: var(--secondary);
            color: #0b1220;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            filter: saturate(1.05)
        }

        .btn-primary:active {
            transform: translateY(0px);
            filter: saturate(.98)
        }

        .btn svg {
            width: 18px;
            height: 18px
        }

        /* Layout */
        .grid {
            display: grid;
            grid-template-columns: 340px 1fr;
            gap: 22px;
            align-items: start;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }

        .card.pad {
            padding: 18px
        }

        .card h3 {
            margin: 0 0 12px;
            font-size: 18px;
            letter-spacing: -.2px;
        }

        .label {
            font-size: 12px;
            color: var(--muted);
            font-weight: 800;
            margin: 10px 0 8px;
            text-transform: none;
        }

        .field {
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 12px 12px;
            background: #fff;
            transition: .15s ease;
        }

        .field:focus-within {
            border-color: rgba(255, 127, 0, .55);
            box-shadow: 0 0 0 4px rgba(255, 127, 0, .14);
        }

        select,
        input {
            border: 0;
            outline: 0;
            width: 100%;
            font: inherit;
            background: transparent;
            color: var(--text);
        }

        input::placeholder {
            color: #9aa3b2
        }

        .icon {
            width: 18px;
            height: 18px;
            opacity: .65;
            flex: 0 0 auto;
        }

        .mini-card {
            border-radius: 14px;
            border: 1px solid var(--border);
            background: #fff;
            padding: 14px;
            box-shadow: 0 10px 22px rgba(15, 23, 42, .06);
            margin-top: 12px;
        }

        .mini-card.green {
            background: linear-gradient(180deg, rgba(31, 157, 100, .14), rgba(31, 157, 100, .07));
            border-color: rgba(31, 157, 100, .25);
        }

        .mini-card.dark {
            background: linear-gradient(180deg, rgba(1, 35, 63, .92), rgba(1, 35, 63, .80));
            border-color: rgba(1, 35, 63, .25);
            color: #fff;
        }

        .mini-card .k {
            font-size: 12px;
            font-weight: 800;
            color: var(--muted);
            margin-bottom: 6px;
        }

        .mini-card.green .k {
            color: rgba(11, 18, 32, .55)
        }

        .mini-card.dark .k {
            color: rgba(255, 255, 255, .75)
        }

        .money {
            display: flex;
            align-items: baseline;
            gap: 8px;
            font-weight: 900;
            letter-spacing: -.4px;
        }

        .money .amt {
            font-size: 34px
        }

        .money .ccy {
            font-size: 14px;
            font-weight: 900;
            opacity: .8
        }

        .mini-card.green .amt {
            color: var(--success)
        }

        .mini-card.green .ccy {
            color: rgba(31, 157, 100, .9)
        }

        .mini-card.dark .amt {
            color: #fff
        }

        .mini-card.dark .ccy {
            color: rgba(255, 255, 255, .85)
        }

        .note {
            margin-top: 12px;
            border-radius: 14px;
            padding: 14px;
            background: #eef2f9;
            border: 1px solid #dfe6f4;
            color: #1f2a44;
            font-weight: 700;
            line-height: 1.35;
        }

        .note b {
            color: #d12c2c
        }

        /* Table */
        .table-card {
            padding: 0
        }

        .table-head {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 10px;
            justify-content: space-between;
        }

        .table-head .title {
            font-weight: 900;
            letter-spacing: -.2px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 14px;
        }

        thead th {
            text-align: left;
            font-size: 12px;
            color: var(--muted);
            font-weight: 900;
            letter-spacing: .02em;
            padding: 12px 16px;
            background: #fbfcff;
            border-bottom: 1px solid var(--border);
        }

        tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            font-weight: 700;
        }

        tbody tr:hover td {
            background: #fbfdff
        }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: var(--success-bg);
            color: #0b5e3a;
            font-weight: 900;
            border: 1px solid rgba(31, 157, 100, .22);
        }

        .status .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--success);
            box-shadow: 0 0 0 4px rgba(31, 157, 100, .14);
        }

        .muted {
            color: var(--muted);
            font-weight: 700
        }

        .btn-more {
            margin: 14px 0 16px;
            background: #fff;
            border: 1px solid var(--border);
            padding: 12px 14px;
            border-radius: 14px;
            font-weight: 900;
            cursor: pointer;
            box-shadow: 0 10px 22px rgba(15, 23, 42, .06);
            transition: .15s ease;
        }

        .btn-more:hover {
            transform: translateY(-1px)
        }

        /* Modal */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(1, 35, 63, .55);
            backdrop-filter: blur(6px);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 18px;
            z-index: 50;
        }

        .modal {
            width: min(560px, 96vw);
            border-radius: 22px;
            background: #fff;
            border: 1px solid rgba(255, 255, 255, .25);
            box-shadow: 0 28px 80px rgba(0, 0, 0, .30);
            overflow: hidden;
        }

        .modal .mhead {
            padding: 16px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(180deg, rgba(255, 127, 0, .10), rgba(255, 127, 0, .03));
        }

        .modal .mhead .ttl {
            font-weight: 1000;
            letter-spacing: -.3px;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .xbtn {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            border: 1px solid var(--border);
            background: #fff;
            cursor: pointer;
            display: grid;
            place-items: center;
            transition: .15s ease;
        }

        .xbtn:hover {
            transform: translateY(-1px)
        }

        .modal .mbody {
            padding: 16px 18px 18px;
            display: grid;
            gap: 12px;
        }

        .grid2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .help {
            font-size: 12px;
            color: var(--muted);
            line-height: 1.4;
            margin-top: 2px;
            font-weight: 700;
        }

        .mfoot {
            padding: 14px 18px 18px;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            border-top: 1px solid var(--border);
            background: #fbfcff;
        }

        .btn-ghost {
            background: #fff;
            border: 1px solid var(--border);
            color: var(--text);
        }

        .btn-ghost:hover {
            transform: translateY(-1px)
        }

        .btn-primary2 {
            background: linear-gradient(180deg, var(--secondary), #ff983a);
            color: #0b1220;
            border: 0;
        }

        /* Footer */
        footer {
            padding: 18px 0 24px;
            text-align: center;
            color: var(--muted);
            font-weight: 700;
        }

        footer b {
            color: var(--primary)
        }

        /* Responsive */
        @media (max-width: 980px) {
            .grid {
                grid-template-columns: 1fr
            }

            h1 {
                font-size: 34px
            }

            .brand {
                min-width: auto
            }

            .nav {
                display: none
            }

            .page-title-row {
                align-items: flex-start
            }
        }

        /* Filters */
        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 12px
        }

        .fitem {
            display: flex;
            flex-direction: column;
            gap: 6px;
            min-width: 140px
        }

        .fitem.grow {
            flex: 1;
            min-width: 220px
        }

        .flabel {
            font-size: 11px;
            color: var(--muted);
            letter-spacing: .08em;
            text-transform: uppercase
        }

        .filters select,
        .filters input {
            height: 38px;
            border-radius: 12px;
            border: 1px solid var(--border);
            padding: 0 12px;
            background: #fff;
            outline: none;
            box-shadow: 0 6px 18px rgba(15, 23, 42, .05);
        }

        .filters input:focus,
        .filters select:focus {
            border-color: rgba(1, 35, 63, .35)
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
        padding: 18px 0 24px;
            text-align: center;
            color: var(--muted);
            font-weight: 700;
    }
    </style>