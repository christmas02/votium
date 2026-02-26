<!DOCTYPE html>

<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>VOTIUM — Page de vote</title>
    <link rel="icon" href="{{ asset('asset/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('asset/favicon.png') }}">
    <meta content="#01233f" name="theme-color" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #01233f;
            --secondary: #ff7f00;
            --bg: #f6f8fb;
            --card: #ffffff;
            --muted: #6b7280;
            --ink: #0f172a;
            --shadow: 0 18px 60px rgba(1, 35, 63, .12);
            --shadow2: 0 10px 24px rgba(15, 23, 42, .10);
            --radius: 14px;
            --radius2: 18px;
            --stroke: rgba(15, 23, 42, .10);
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
            font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji";
            color: var(--ink);
            /* background: var(--bg); */
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
            background: linear-gradient(180deg, rgba(1, 35, 63, .98), rgba(1, 35, 63, .92));
            color: #fff;
            position: sticky;
            top: 0;
            z-index: 20;
            box-shadow: 0 8px 26px rgba(1, 35, 63, .22);
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
            font-weight: 800;
            letter-spacing: .3px;
        }

        .logo {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            background: radial-gradient(120% 120% at 30% 20%, rgba(255, 255, 255, .28), rgba(255, 255, 255, .06));
            border: 1px solid rgba(255, 255, 255, .18);
            overflow: hidden;
        }

        .logo svg {
            width: 26px;
            height: 26px;
            display: block
        }

        .brand small {
            display: block;
            font-weight: 600;
            opacity: .85;
            margin-top: -2px
        }

        .nav {
            display: flex;
            align-items: center;
            gap: 18px;
            font-weight: 600;
            opacity: .95;
        }

        .nav a {
            padding: 10px 10px;
            border-radius: 12px;
            transition: .18s ease;
        }

        .nav a:hover {
            background: rgba(255, 255, 255, .10)
        }

        .nav .active {
            background: rgba(255, 127, 0, .18);
            border: 1px solid rgba(255, 127, 0, .25);
        }

        .flag {
            width: 26px;
            height: 18px;
            border-radius: 4px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .22);
            box-shadow: 0 6px 18px rgba(0, 0, 0, .18);
            flex: 0 0 auto;
        }

        .flag .b {
            height: 100%
        }

        .flag .fr {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr
        }

        .flag .fr div:nth-child(1) {
            background: #0055A4
        }

        .flag .fr div:nth-child(2) {
            background: #ffffff
        }

        .flag .fr div:nth-child(3) {
            background: #EF4135
        }

        /* Cover */
        .cover {
            background:
                radial-gradient(1200px 420px at 20% 10%, rgba(255, 127, 0, .18), transparent 55%),
                radial-gradient(900px 420px at 70% 30%, rgba(255, 255, 255, .12), transparent 60%),
                linear-gradient(160deg, rgba(1, 35, 63, .96), rgba(1, 35, 63, .78)),
                linear-gradient(90deg, rgba(0, 0, 0, .0), rgba(0, 0, 0, .0));
            color: #fff;
            border-bottom: 1px solid rgba(15, 23, 42, .12);
            position: relative;
            overflow: hidden;
        }

        .cover:before {
            content: "";
            position: absolute;
            inset: -80px -160px auto auto;
            width: 520px;
            height: 520px;
            border-radius: 60px;
            transform: rotate(18deg);
            background: radial-gradient(closest-side, rgba(255, 127, 0, .55), rgba(255, 127, 0, .0));
            filter: blur(0px);
            opacity: .75;
        }

        .cover:after {
            content: "";
            position: absolute;
            inset: auto -220px -220px auto;
            width: 520px;
            height: 520px;
            border-radius: 80px;
            background: radial-gradient(closest-side, rgba(255, 255, 255, .20), rgba(255, 255, 255, 0));
            opacity: .35;
            transform: rotate(-10deg);
        }

        .cover .grid {
            position: relative;
            display: grid;
            grid-template-columns: 1.15fr .85fr;
            gap: 18px;
            padding: 22px 0 18px;
            align-items: end;
        }

        .event-title {
            padding: 18px 0 12px;
        }

        .event-title h1 {
            margin: 0 0 8px;
            font-size: clamp(22px, 2.6vw, 30px);
            letter-spacing: .2px;
            line-height: 1.15;
        }

        .event-title p {
            margin: 0;
            opacity: .9;
            max-width: 60ch;
            line-height: 1.45;
            font-weight: 500;
        }

        .event-meta {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 14px;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .18);
            font-weight: 700;
            font-size: 12px;
            letter-spacing: .2px;
            backdrop-filter: blur(10px);
        }

        .pill .dot {
            width: 8px;
            height: 8px;
            border-radius: 99px;
            background: var(--secondary);
            box-shadow: 0 0 0 3px rgba(255, 127, 0, .18);
        }

        .org-card {
            justify-self: end;
            width: min(340px, 100%);
            padding: 14px;
            border-radius: var(--radius2);
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .18);
            backdrop-filter: blur(12px);
            box-shadow: 0 18px 60px rgba(0, 0, 0, .25);
        }

        .org-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px
        }

        .org {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 800;
        }

        .org-badge {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .18);
            display: grid;
            place-items: center;
            overflow: hidden;
        }

        .org-badge svg {
            width: 28px;
            height: 28px;
            opacity: .92
        }

        .org small {
            display: block;
            font-weight: 700;
            opacity: .85;
            margin-top: -2px
        }

        .org-links {
            display: flex;
            gap: 8px
        }

        .chip {
            width: 38px;
            height: 38px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: rgba(255, 255, 255, .10);
            border: 1px solid rgba(255, 255, 255, .16);
            cursor: pointer;
            transition: .16s ease;
        }

        .chip:hover {
            transform: translateY(-1px);
            background: rgba(255, 255, 255, .14)
        }

        .chip svg {
            width: 18px;
            height: 18px;
            opacity: .92
        }

        /* Status bar */
        .statusbar {
            background: linear-gradient(90deg, rgba(255, 127, 0, .22), rgba(255, 127, 0, .14));
            border-top: 1px solid rgba(255, 127, 0, .22);
            border-bottom: 1px solid rgba(15, 23, 42, .08);
            color: #071a2b;
        }

        .statusbar .inner {
            padding: 10px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-weight: 800;
            letter-spacing: .2px;
        }

        .statusbar .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .65);
            border: 1px solid rgba(15, 23, 42, .10);
            box-shadow: 0 10px 20px rgba(15, 23, 42, .06);
        }

        .statusbar .badge .ring {
            width: 10px;
            height: 10px;
            border-radius: 99px;
            background: var(--secondary);
            box-shadow: 0 0 0 3px rgba(255, 127, 0, .18);
        }

        /* Main */
        main {
            padding: 18px 0 44px
        }

        .toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 16px;
        }

        .lefttools {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap
        }

        .backbtn {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            border: 1px solid rgba(15, 23, 42, .12);
            background: #fff;
            box-shadow: var(--shadow2);
            display: grid;
            place-items: center;
            cursor: pointer;
            transition: .16s ease;
        }

        .backbtn:hover {
            transform: translateY(-1px)
        }

        .catpill {
            padding: 10px 14px;
            border-radius: 12px;
            background: rgba(255, 127, 0, .14);
            color: #7a2f00;
            border: 1px solid rgba(255, 127, 0, .22);
            font-weight: 900;
            letter-spacing: .25px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 20px rgba(255, 127, 0, .10);
        }

        .catpill .mini {
            width: 10px;
            height: 10px;
            border-radius: 99px;
            background: var(--secondary);
            box-shadow: 0 0 0 3px rgba(255, 127, 0, .18);
        }

        .search {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fff;
            border: 1px solid rgba(15, 23, 42, .12);
            border-radius: 14px;
            padding: 10px 12px;
            min-width: min(420px, 100%);
            box-shadow: var(--shadow2);
        }

        .search svg {
            width: 18px;
            height: 18px;
            opacity: .6
        }

        .search input {
            width: 100%;
            border: 0;
            outline: 0;
            font-size: 14px;
            background: transparent;
        }

        /* Cards grid */
        .gridcards {
            margin-top: 16px;
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 14px;
        }

        .card {
            background: var(--card);
            border: 1px solid rgba(15, 23, 42, .10);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 16px 36px rgba(15, 23, 42, .08);
            transition: .18s ease;
            display: flex;
            flex-direction: column;
            min-height: 340px;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 22px 50px rgba(15, 23, 42, .12);
        }

        .coverimg {
            height: 166px;
            background:
                radial-gradient(160px 120px at 25% 20%, rgba(255, 127, 0, .35), transparent 60%),
                radial-gradient(180px 130px at 75% 30%, rgba(1, 35, 63, .25), transparent 60%),
                linear-gradient(135deg, rgba(1, 35, 63, .95), rgba(1, 35, 63, .75));
            position: relative;
        }

        .coverimg .thumb {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 22px;
        }

        .coverimg:after {
            content: "";
            position: absolute;
            inset: 10px;
            border-radius: 12px;
            border: 1px dashed rgba(255, 255, 255, .22);
            opacity: .55;
        }

        .coverimg .tag {
            position: absolute;
            left: 10px;
            top: 10px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 10px;
            border-radius: 999px;
            background: rgba(0, 0, 0, .25);
            border: 1px solid rgba(255, 255, 255, .16);
            color: #fff;
            font-weight: 800;
            font-size: 11px;
            backdrop-filter: blur(8px);
        }

        .coverimg .tag .dot {
            width: 8px;
            height: 8px;
            border-radius: 99px;
            background: var(--secondary);
            box-shadow: 0 0 0 3px rgba(255, 127, 0, .18)
        }

        .body {
            padding: 12px 12px 10px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
        }

        .name {
            font-weight: 900;
            font-size: 15px;
            letter-spacing: .1px;
        }

        .sub {
            color: var(--muted);
            font-size: 12px;
            margin-top: -4px;
            font-weight: 600;
        }

        .stats {
            margin-top: auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            align-items: center;
        }

        .num {
            background: rgba(15, 23, 42, .04);
            border: 1px solid rgba(15, 23, 42, .08);
            border-radius: 12px;
            padding: 10px;
            font-weight: 900;
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            gap: 8px;
        }

        .num span {
            color: var(--muted);
            font-weight: 700;
            font-size: 11px
        }

        .pct {
            background: rgba(255, 127, 0, .12);
            border: 1px solid rgba(255, 127, 0, .22);
            border-radius: 12px;
            padding: 10px;
            font-weight: 900;
            color: #7a2f00;
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            gap: 8px;
        }

        .pct span {
            color: #9a4a18;
            font-weight: 800;
            font-size: 11px
        }

        .actions {
            display: flex;
            gap: 10px;
            padding: 10px 12px 12px;
            align-items: center;
        }

        .iconbtn {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            border: 1px solid rgba(15, 23, 42, .12);
            background: #fff;
            box-shadow: var(--shadow2);
            display: grid;
            place-items: center;
            cursor: pointer;
            transition: .16s ease;
            flex: 0 0 auto;
        }

        .iconbtn:hover {
            transform: translateY(-1px)
        }

        .iconbtn svg {
            width: 18px;
            height: 18px;
            opacity: .85
        }

        .vote {
            flex: 1;
            height: 42px;
            border-radius: 12px;
            border: 1px solid rgba(255, 127, 0, .32);
            background: linear-gradient(180deg, rgba(255, 127, 0, 1), rgba(255, 127, 0, .92));
            color: #fff;
            font-weight: 900;
            letter-spacing: .2px;
            cursor: pointer;
            box-shadow: 0 16px 28px rgba(255, 127, 0, .22);
            transition: .16s ease;
        }

        .vote:hover {
            transform: translateY(-1px)
        }

        .bottomrow {
            margin-top: 18px;
            display: flex;
            justify-content: flex-start;
        }

        .more {
            background: #fff;
            border: 1px solid rgba(15, 23, 42, .12);
            border-radius: 12px;
            padding: 10px 14px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: var(--shadow2);
            transition: .16s ease;
        }

        .more:hover {
            transform: translateY(-1px)
        }

        /* Footer */
        footer {
            padding: 18px 0 24px;
            color: rgba(255, 255, 255, .82);
            background: linear-gradient(180deg, rgba(1, 35, 63, .98), rgba(1, 35, 63, .94));
        }

        footer .foot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            flex-wrap: wrap;
        }

        footer .copy {
            opacity: .85;
            font-weight: 600
        }

        footer .mini-links {
            display: flex;
            gap: 10px;
            opacity: .92
        }

        footer .mini-links a {
            padding: 8px 10px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, .12)
        }

        footer .mini-links a:hover {
            background: rgba(255, 255, 255, .08)
        }

        /* Responsive */
        @media (max-width: 1100px) {
            .gridcards {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .cover .grid {
                grid-template-columns: 1fr
            }

            .org-card {
                justify-self: start
            }

            .nav {
                display: none
            }
        }

        @media (max-width: 720px) {
            .gridcards {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .search {
                min-width: 0;
                width: 100%;
            }

            .toolbar {
                flex-direction: column;
                align-items: stretch
            }

            .lefttools {
                justify-content: space-between
            }

            .event-title p {
                max-width: unset
            }
        }

        @media (max-width: 430px) {
            .gridcards {
                grid-template-columns: 1fr;
            }

            .card {
                min-height: 330px;
            }
        }

        /* Modal (Vote packs) */
        body.modal-open {
            overflow: hidden;
        }

        .modal {
            position: fixed;
            inset: 0;
            display: none;
            z-index: 50;
        }

        .modal.is-open {
            display: block;
        }

        .modal__overlay {
            position: absolute;
            inset: 0;
            background: rgba(1, 35, 63, .55);
            backdrop-filter: blur(6px);
        }

        .modal__panel {
            position: relative;
            width: min(520px, calc(100vw - 28px));
            margin: min(10vh, 80px) auto 0;
            border-radius: 22px;
            background: rgba(255, 255, 255, .92);
            box-shadow: 0 26px 70px rgba(0, 0, 0, .25);
            /* Important: allow the modal to work on small screens.
     The previous version could clip the CTA, making it look like you can't continue. */
            max-height: 90vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .modal__close {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 38px;
            height: 38px;
            border-radius: 12px;
            border: 1px solid rgba(1, 35, 63, .10);
            background: rgba(255, 255, 255, .9);
            color: var(--ink);
            display: grid;
            place-items: center;
            cursor: pointer;
        }

        .voteModal__hero {
            padding: 18px 18px 0;
        }

        .voteModal__posterWrap {
            width: 100%;
            height: 200px;
            border-radius: 10px;
            overflow: hidden;
            background: radial-gradient(1200px 600px at 10% 10%, rgba(255, 127, 0, .20), transparent 55%),
                radial-gradient(900px 500px at 90% 40%, rgba(1, 35, 63, .20), transparent 60%),
                #0b1220;
            border: 1px solid rgba(1, 35, 63, .08);
        }

        .voteModal__poster {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center top;
            display: block;
        }

        .voteModal__content {
            padding: 16px 18px 18px;
            /* scroll content if needed so the validate button is always reachable */
            overflow: auto;
            -webkit-overflow-scrolling: touch;
        }

        .voteModal__name {
            margin: 4px 0 6px;
            font-size: 28px;
            line-height: 1.1;
            letter-spacing: -.02em;
        }

        .voteModal__sub {
            color: var(--muted);
            font-size: 14px;
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }

        .voteModal__sub .dot {
            opacity: .6;
        }

        .voteModal__packs {
            margin-top: 14px;
            background: rgba(255, 255, 255, .9);
            border: 1px solid rgba(1, 35, 63, .10);
            border-radius: 18px;
            padding: 8px;
        }

        .packRow {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 14px 14px;
            border-radius: 14px;
            border: 1px solid transparent;
            background: transparent;
            cursor: pointer;
            color: var(--ink);
        }

        .packRow+.packRow {
            margin-top: 6px;
        }

        .packRow__left {
            font-size: 22px;
            color: var(--ink);
        }

        .packRow__right {
            font-size: 18px;
            color: #7f8796;
        }

        .packRow__right .cur {
            font-size: 14px;
        }

        .packRow:hover {
            background: rgba(1, 35, 63, .04);
        }

        .packRow.is-selected {
            background: rgba(255, 127, 0, .10);
            border-color: rgba(255, 127, 0, .35);
        }

        .voteModal__actions {
            margin-top: 14px;
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .iconBtn {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            border: 1px solid rgba(1, 35, 63, .12);
            background: #fff;
            color: var(--primary);
            display: grid;
            place-items: center;
            cursor: pointer;
        }

        .primaryBtn {
            flex: 1;
            height: 54px;
            border-radius: 16px;
            border: 2px solid rgba(255, 127, 0, .0);
            background: var(--primary);
            color: #fff;
            font-weight: 800;
            letter-spacing: .01em;
            cursor: pointer;
            box-shadow: 0 14px 32px rgba(1, 35, 63, .30);
        }

        .primaryBtn:hover {
            filter: brightness(1.03);
        }

        .primaryBtn:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(255, 127, 0, .22), 0 14px 32px rgba(1, 35, 63, .30);
        }

        .voteModal__hint {
            margin: 10px 2px 0;
            font-size: 12px;
            color: var(--muted);
        }

        /* Toast */
        .toast {
            position: fixed;
            left: 50%;
            bottom: 20px;
            transform: translateX(-50%);
            padding: 12px 14px;
            border-radius: 14px;
            background: rgba(1, 35, 63, .92);
            color: #fff;
            font-size: 13px;
            box-shadow: 0 20px 55px rgba(0, 0, 0, .25);
            opacity: 0;
            pointer-events: none;
            transition: opacity .2s ease, transform .2s ease;
            z-index: 60;
        }

        .toast.is-show {
            opacity: 1;
            transform: translateX(-50%) translateY(-6px);
        }


        /* --- Checkout (paiement simulé) --- */
        .modal__panel--wide {
            max-width: 860px;
        }

        .checkout {
            padding: 30px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            flex-wrap: wrap;
        }

        .checkout__head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: nowrap;
            flex-direction: row;
            gap: 14px;
        }

        .checkout__head .kicker {
            font-size: 12px;
            opacity: .75;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .checkout__head .sub {
            font-size: 13px;
            opacity: .8;
            margin-top: 6px;
        }

        .checkout__amount {
            background: rgba(1, 35, 63, .06);
            border: 1px solid rgba(1, 35, 63, .12);
            border-radius: 14px;
            padding: 12px 14px;
            min-width: auto;
            text-align: right;
        }

        .checkout__amount .label {
            font-size: 12px;
            opacity: .7;
        }

        .checkout__amount .value {
            font-size: 18px;
            font-weight: 800;
            margin-top: 4px;
            color: var(--primary);
        }

        .checkout__body {
            display: grid;
            /* grid-template-columns: 1.1fr .9fr; */
            grid-template-columns: 1.1fr;
            gap: 14px;
        }

        .sectionTitle {
            font-weight: 800;
            margin-bottom: 10px;
        }

        .methods {
            display: grid;
            gap: 10px;
        }

        .methodBtn {
            width: 100%;
            text-align: center;
            border-radius: 14px;
            border: 1px solid rgba(207, 103, 5, 0.14);
            /* background: rgba(255, 255, 255, .92); */
            padding: 12px 12px;
            cursor: pointer;
            transition: transform .12s ease, border-color .12s ease, box-shadow .12s ease;
        }

        .methodBtn:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 30px rgba(209, 112, 0, 0.1);
        }

        .methodBtn.is-selected {
            border-color: rgba(255, 127, 0, .9);
            box-shadow: 0 10px 30px rgba(255, 127, 0, .14);
        }

        .methodBtn .top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .methodBtn .left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .methodIcon {
            width: 46px;
            height: 28px;
            object-fit: contain;
            border-radius: 10px;
            background: #fff;
            border: 1px solid rgba(1, 35, 63, .10);
            padding: 4px;
        }

        .methodBtn .name {
            font-weight: 900;
        }

        .methodBtn .badge {
            font-size: 11px;
            padding: 4px 8px;
            border-radius: 999px;
            background: rgba(1, 35, 63, .08);
        }

        .methodBtn .desc {
            font-size: 12px;
            opacity: .8;
            margin-top: 6px;
        }

        .checkout__form {
            border: 1px solid rgba(1, 35, 63, .12);
            background: rgba(255, 255, 255, .86);
            border-radius: 16px;
            padding: 12px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin: 10px 0;
        }

        .field label {
            font-size: 12px;
            opacity: .75;
        }

        .field input {
            border-radius: 12px;
            border: 1px solid rgba(1, 35, 63, .16);
            /* padding: 10px 12px; */
            outline: none;
        }

        .field input:focus {
            border-color: rgba(255, 127, 0, .9);
            box-shadow: 0 0 0 4px rgba(255, 127, 0, .12);
        }

        .hint {
            font-size: 12px;
            opacity: .75;
            margin-top: 8px;
        }

        .actions {
            display: flex;
            gap: 10px;
            justify-content: space-between;
            margin-top: 12px;
        }

        .successIcon {
            width: 64px;
            height: 64px;
            border-radius: 999px;
            display: grid;
            place-items: center;
            background: rgba(0, 160, 90, .12);
            border: 1px solid rgba(0, 160, 90, .28);
            font-size: 28px;
            font-weight: 900;
            margin: 10px auto 0;
        }

        .checkout__success {
            text-align: center;
            padding: 10px 0 0;
        }

        @media (max-width: 860px) {
            .checkout__body {
                grid-template-columns: 1fr;
            }

            .checkout__amount {
                text-align: left;
                width: 100%;
            }
        }


        /* Checkout steps (OTP / Processing / Receipt) */
        .otpRow {
            display: flex;
            gap: 10px;
            align-items: center;
            margin: 14px 0
        }

        .otpRow input {
            flex: 1;
            height: 46px;
            border-radius: 12px;
            border: 1px solid var(--stroke);
            padding: 0 14px;
            font-size: 16px;
            outline: none;
            background: #fff;
        }

        .otpIcon {
            font-size: 34px;
            margin-bottom: 6px
        }

        .checkout__processing,
        .checkout__otp,
        .checkout__receipt {
            padding: 6px 2px
        }

        .spinner {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            border: 4px solid rgba(1, 35, 63, .18);
            border-top-color: var(--primary);
            margin: 6px auto 10px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg)
            }
        }

        .timeline {
            display: grid;
            gap: 10px;
            margin: 14px 0 6px
        }

        .titem {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            padding: 10px 12px;
            border: 1px solid var(--stroke);
            border-radius: 12px;
            background: rgba(255, 255, 255, .65);
        }

        .titem .dot {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: rgba(107, 114, 128, .55);
            margin-top: 6px;
            flex: none;
        }

        .titem.is-done .dot {
            background: var(--secondary)
        }

        .titem .label {
            font-weight: 800
        }

        .receiptCard {
            border: 1px solid var(--stroke);
            border-radius: 16px;
            background: rgba(255, 255, 255, .75);
            padding: 14px;
            box-shadow: var(--shadow2);
            display: grid;
            gap: 10px;
        }

        .rrow {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap
        }

        .rrow .k {
            color: var(--muted)
        }

        .rrow .v {
            font-weight: 800
        }

        /* --- Ajouts pour la logique Blade --- */

        /* Compte à rebours */
        .countdown-wrapper {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 40px 0;
            text-align: center;
        }

        .countdown-item {
            background: var(--card);
            padding: 20px;
            border-radius: var(--radius);
            border: 1px solid var(--stroke);
            box-shadow: var(--shadow2);
            min-width: 100px;
        }

        .countdown-value {
            display: block;
            font-size: 32px;
            font-weight: 900;
            color: var(--primary);
            line-height: 1;
        }

        .countdown-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--muted);
            margin-top: 5px;
            display: block;
        }

        /* Grille Catégories */
        .cat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 14px;
            margin-bottom: 30px;
        }

        .cat-card {
            display: flex;
            align-items: center;
            gap: 14px;
            background: #fff;
            padding: 14px;
            border-radius: var(--radius);
            border: 1px solid var(--stroke);
            transition: 0.2s ease;
            cursor: pointer;
        }

        .cat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow2);
        }

        .cat-card.active {
            border-color: var(--secondary);
            background: rgba(255, 127, 0, 0.05);
        }

        .cat-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: rgba(1, 35, 63, 0.05);
            color: var(--primary);
            display: grid;
            place-items: center;
            font-size: 20px;
        }

        .cat-info h5 {
            margin: 0 0 2px 0;
            font-size: 15px;
            font-weight: 800;
        }

        .cat-info small {
            color: var(--muted);
            font-weight: 600;
            font-size: 12px;
        }

        /* Messages d'état */
        .state-message {
            text-align: center;
            margin: 60px;
            padding: 10px 10px;
            background: #fff;
            border-radius: var(--radius2);
            border: 1px solid var(--stroke);
            color: var(--muted);
        }

        .state-icon {
            font-size: 40px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .section-label {
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--muted);
            margin: 30px 0 14px;
        }
    </style>
    <link href="{{ asset('asset/app.css') }}" rel="stylesheet" />
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script defer="True" src="{{ asset('asset/app.js') }}"></script>
</head>

<body class="has-topbar" data-role="Promoteur">
    <!-- Header -->
    @include('siteCampagne.layouts.header')

    <!-- Contenu Spécifique à la page -->
    @yield('content')

    <!-- Footer -->
    @include('siteCampagne.layouts.footer')

    <!-- Scripts Globaux -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Zone pour injecter le JS spécifique -->
    @stack('scripts')

</body>

</html>
