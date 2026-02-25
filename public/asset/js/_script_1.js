
  // --- Demo data (fictif) ---
  const ALL = [
    {name:"Diomandé Souleymane", num:"00015", pct:25.20, tag:"Finaliste"},
    {name:"Ayepa Laroche", num:"00002", pct:24.05, tag:"Finaliste"},
    {name:"Guide Seri Pacôme", num:"00007", pct:14.73, tag:"Finaliste"},
    {name:"Tchama Edmond", num:"00016", pct:8.82, tag:"Finaliste"},
    {name:"N'guessan Nancy", num:"00012", pct:8.39, tag:"Finaliste"},
    {name:"N'guessan Franck", num:"00013", pct:3.07, tag:"Finaliste"},
    {name:"Yapi Elvis Maxime", num:"00017", pct:2.61, tag:"Finaliste"},
    {name:"Assale Tanoh Ackmel Rodrigue", num:"00001", pct:2.37, tag:"Finaliste"},
    {name:"Kouadio Severin", num:"00008", pct:2.19, tag:"Finaliste"},
    {name:"Bale Bi Zah Brice", num:"00003", pct:1.96, tag:"Finaliste"},
    {name:"Kouadio Constant", num:"00009", pct:1.92, tag:"Finaliste"},
    {name:"Dago Appolinaire", num:"00005", pct:1.74, tag:"Finaliste"},
    {name:"Kouassi Isaac", num:"00011", pct:1.58, tag:"Finaliste"},
    {name:"Douablé Alex", num:"00006", pct:0.59, tag:"Finaliste"},
    {name:"Ohouo Jonathan", num:"00014", pct:0.51, tag:"Finaliste"},
  ];

  // Pagination
  let pageSize = 10;
  let shown = 0;

  const cards = document.getElementById('cards');
  const q = document.getElementById('q');
  const more = document.getElementById('more');

  function esc(s){return String(s).replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));}

  // Tiny poster generator (data URI) so the demo works without external images.
  function posterDataURI(name, num){
    const initials = (name || "").trim().split(/\s+/).slice(0,2).map(x=>x[0]||"").join("").toUpperCase() || "V";
    const svg = `
      <svg xmlns="http://www.w3.org/2000/svg" width="1200" height="700" viewBox="0 0 1200 700">
        <defs>
          <linearGradient id="bg" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0" stop-color="#01233f"/>
            <stop offset="1" stop-color="#0b1220"/>
          </linearGradient>
          <radialGradient id="glow" cx="20%" cy="10%" r="80%">
            <stop offset="0" stop-color="#ff7f00" stop-opacity=".35"/>
            <stop offset="1" stop-color="#ff7f00" stop-opacity="0"/>
          </radialGradient>
        </defs>
        <rect width="1200" height="700" fill="url(#bg)"/>
        <rect width="1200" height="700" fill="url(#glow)"/>
        <rect x="44" y="44" width="1112" height="612" rx="42" fill="rgba(255,255,255,.04)" stroke="rgba(255,255,255,.12)" stroke-width="2"/>
        <text x="90" y="140" fill="rgba(255,255,255,.88)" font-size="34" font-family="Inter,system-ui,Arial" font-weight="800">VOTIUM • Démo</text>
        <text x="90" y="210" fill="rgba(255,255,255,.80)" font-size="28" font-family="Inter,system-ui,Arial" font-weight="700">Candidat #${esc(num)}</text>
        <text x="90" y="270" fill="rgba(255,255,255,.92)" font-size="54" font-family="Inter,system-ui,Arial" font-weight="900">${esc(name)}</text>

        <g transform="translate(90,360)">
          <rect width="170" height="170" rx="36" fill="rgba(255,127,0,.18)" stroke="rgba(255,127,0,.35)" stroke-width="2"/>
          <text x="85" y="112" text-anchor="middle" fill="white" font-size="72" font-family="Inter,system-ui,Arial" font-weight="900">${initials}</text>
        </g>

        <text x="90" y="610" fill="rgba(255,255,255,.72)" font-size="26" font-family="Inter,system-ui,Arial" font-weight="700">Sélectionnez un pack et validez (simulation)</text>
      </svg>
    `.trim();
    return "data:image/svg+xml;charset=UTF-8," + encodeURIComponent(svg);
  }

  function cardTpl(item){
    return `
      <article class="card" data-name="${esc(item.name.toLowerCase())}" data-num="${esc(item.num)}">
        <div class="coverimg">
          <div class="tag"><span class="dot"></span> ${esc(item.tag)}</div>
        </div>
        <div class="body">
          <div class="name">${esc(item.name)}</div>
          <div class="sub">Candidat(e) / Nominé(e)</div>
          <div class="stats">
            <div class="num"><div><span>Numéro</span><br>${esc(item.num)}</div></div>
            <div class="pct"><div><span>votes</span><br>${Number(item.pct).toFixed(2)}%</div></div>
          </div>
        </div>
        <div class="actions">
          <button class="iconbtn" type="button" aria-label="Partager" onclick="shareCandidate('${esc(item.name)}','${esc(item.num)}')">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
              <path d="M18 8a3 3 0 1 0-2.8-4" stroke="var(--primary)" stroke-width="1.8" stroke-linecap="round"/>
              <path d="M6 14a3 3 0 1 0 2.8 4" stroke="var(--primary)" stroke-width="1.8" stroke-linecap="round"/>
              <path d="M8.5 13.2l7-3.7M8.5 14.8l7 3.7" stroke="var(--primary)" stroke-width="1.8" stroke-linecap="round"/>
            </svg>
          </button>
          <button class="vote" type="button" onclick="openVote('${esc(item.num)}','${esc(item.name)}')">Voter</button>
        </div>
      </article>
    `;
  }

  function currentFiltered(){
    const term = q.value.trim().toLowerCase();
    if(!term) return ALL;
    return ALL.filter(x => (x.name.toLowerCase().includes(term) || x.num.includes(term)));
  }

  function render(reset=false){
    if(reset){
      cards.innerHTML = "";
      shown = 0;
    }
    const items = currentFiltered();
    const slice = items.slice(shown, shown + pageSize);
    slice.forEach(it => cards.insertAdjacentHTML('beforeend', cardTpl(it)));
    shown += slice.length;
    more.style.display = shown < items.length ? "inline-flex" : "none";
    if(items.length === 0){
      cards.innerHTML = `<div style="grid-column:1/-1;background:#fff;border:1px solid rgba(15,23,42,.12);border-radius:16px;padding:16px;box-shadow:var(--shadow2);font-weight:800;">
        Aucun candidat ne correspond à votre recherche.
      </div>`;
      more.style.display = "none";
    }
  }

  // --- Vote simulation (packs) ---
  const VOTIUM = {
    unitPrice: 200,
    packs: [2,5,10,20,50,100,500],
    currency: "FCFA"
  };

  const voteModal = document.getElementById("voteModal");
  const voteModalPoster = document.getElementById("voteModalPoster");
  const voteModalTitle = document.getElementById("voteModalTitle");
  const voteModalNum = document.getElementById("voteModalNum");
  const voteModalPacks = document.getElementById("voteModalPacks");
  const voteModalSubmit = document.getElementById("voteModalSubmit");
  const voteModalShare = document.getElementById("voteModalShare");
  const toastEl = document.getElementById("toast");

  // --- Checkout (paiement simulé) ---
  const checkoutModal = document.getElementById("checkoutModal");
  const checkoutSub = document.getElementById("checkoutSub");
  const checkoutAmount = document.getElementById("checkoutAmount");
  const checkoutMethods = document.getElementById("checkoutMethods");
  const checkoutHint = document.getElementById("checkoutHint");
  const checkoutBack = document.getElementById("checkoutBack");
  const checkoutPay = document.getElementById("checkoutPay");
  const checkoutDone = document.getElementById("checkoutDone");
  const checkoutSuccess = document.getElementById("checkoutSuccess");
  const checkoutBody = document.getElementById("checkoutBody");
  const payRef = document.getElementById("payRef");
  const payPhone = document.getElementById("payPhone");
  const payName = document.getElementById("payName");
  const phoneField = document.getElementById("phoneField");
  const cardField = document.getElementById("cardField");
  const checkoutOtp = document.getElementById("checkoutOtp");
  const otpCode = document.getElementById("otpCode");
  const otpResend = document.getElementById("otpResend");
  const otpCancel = document.getElementById("otpCancel");
  const otpConfirm = document.getElementById("otpConfirm");
  const otpHint = document.getElementById("otpHint");
  const checkoutProcessing = document.getElementById("checkoutProcessing");
  const processingText = document.getElementById("processingText");
  const processingTimeline = document.getElementById("processingTimeline");
  const processingCancel = document.getElementById("processingCancel");
  const checkoutReceipt = document.getElementById("checkoutReceipt");
  const receiptCard = document.getElementById("receiptCard");
  const receiptDownload = document.getElementById("receiptDownload");
  const receiptDone = document.getElementById("receiptDone");

  let _processingTimers = [];


  let checkoutState = { method:null, target:null, qty:0, amount:0 };

  const METHODS = [
    {id:"wave", name:"Wave", badge:"Mobile Money", desc:"Paiement instantané via Wave (simulation).", needs:"phone"},
    {id:"om", name:"Orange Money", badge:"Mobile Money", desc:"Valide avec un numéro OM (simulation).", needs:"phone"},
    {id:"mtn", name:"MTN MoMo", badge:"Mobile Money", desc:"Valide avec un numéro MTN (simulation).", needs:"phone"},
    {id:"moov", name:"Moov Money", badge:"Mobile Money", desc:"Valide avec un numéro Moov (simulation).", needs:"phone"},
    {id:"card", name:"Carte bancaire", badge:"VISA / MasterCard", desc:"Simulation carte (aucune vraie transaction).", needs:"name"},
  ];

  function closeCheckoutModal(){
    if(!checkoutModal) return;
    checkoutModal.classList.remove("is-open");
    checkoutModal.setAttribute("aria-hidden","true");
    document.body.classList.remove("modal-open");
    // reset view
    if(_processingTimers && _processingTimers.length){
      _processingTimers.forEach(t=>clearTimeout(t));
      _processingTimers = [];
    }
    if(checkoutSuccess) checkoutSuccess.style.display = "none";
    if(checkoutOtp) checkoutOtp.style.display = "none";
    if(checkoutProcessing) checkoutProcessing.style.display = "none";
    if(checkoutReceipt) checkoutReceipt.style.display = "none";
    if(checkoutBody) checkoutBody.style.display = "";
    if(checkoutPay) { checkoutPay.disabled = true; checkoutPay.textContent = "Payer"; }
    if(checkoutHint) checkoutHint.textContent = "Choisis un moyen de paiement pour continuer.";
    if(phoneField) phoneField.style.display = "none";
    if(cardField) cardField.style.display = "none";
    if(payPhone) payPhone.value = "";
    if(payName) payName.value = "";
    if(otpCode) otpCode.value = "";
    if(otpHint) otpHint.textContent = "Astuce démo : le code s'affiche ici après l'envoi.";
    if(processingText) processingText.textContent = "Initialisation…";
    if(processingTimeline) processingTimeline.innerHTML = "";
    checkoutState.method = null;

  }

  function openCheckoutModal(target, qty){
    if(!checkoutModal) return;
    const amount = (qty || 0) * VOTIUM.unitPrice;
    checkoutState = { method:null, target, qty, amount };
    if(checkoutSub) checkoutSub.textContent = `${target.name} • #${target.num} • ${qty} votes`;
    if(checkoutAmount) checkoutAmount.textContent = `${money(amount)} ${VOTIUM.currency}`;
    if(payRef) payRef.value = `VOT-${target.num}-${qty}-${Date.now().toString().slice(-6)}`;
    buildMethods();
    setCheckoutStep("form");
    checkoutModal.classList.add("is-open");
    checkoutModal.setAttribute("aria-hidden","false");
    document.body.classList.add("modal-open");
  }

  function buildMethods(){
    if(!checkoutMethods) return;
    checkoutMethods.innerHTML = "";
    METHODS.forEach(m => {
      const b = document.createElement("button");
      b.type = "button";
      b.className = "methodBtn";
      b.dataset.id = m.id;
      b.innerHTML = `
        <div class="top">
          <div class="name">${m.name}</div>
          <div class="badge">${m.badge}</div>
        </div>
        <div class="desc">${m.desc}</div>
      `;
      b.addEventListener("click", () => selectMethod(m.id));
      checkoutMethods.appendChild(b);
    });
  }

  function selectMethod(id){
    checkoutState.method = id;
    if(checkoutMethods){
      [...checkoutMethods.querySelectorAll(".methodBtn")].forEach(btn=>{
        btn.classList.toggle("is-selected", btn.dataset.id === id);
      });
    }
    const m = METHODS.find(x=>x.id===id);
    const needs = m ? m.needs : null;

    if(phoneField) phoneField.style.display = (needs==="phone") ? "" : "none";
    if(cardField) cardField.style.display = (needs==="name") ? "" : "none";
    if(checkoutHint){
      checkoutHint.textContent = (needs==="phone")
        ? "Entre ton numéro (démo) puis clique sur Payer."
        : (needs==="name")
          ? "Entre le nom du titulaire (démo) puis clique sur Payer."
          : "Clique sur Payer pour valider.";
    }
    if(checkoutPay){
      checkoutPay.disabled = false;
      checkoutPay.textContent = `Payer • ${money(checkoutState.amount)} ${VOTIUM.currency}`;
    }
  }

  function validateCheckout(){
    const m = METHODS.find(x=>x.id===checkoutState.method);
    if(!m) return {ok:false, msg:"Choisis un moyen de paiement."};
    if(m.needs==="phone" && (!payPhone || !payPhone.value.trim())) return {ok:false, msg:"Renseigne un numéro Mobile Money."};
    if(m.needs==="name" && (!payName || !payName.value.trim())) return {ok:false, msg:"Renseigne le nom du titulaire."};
    return {ok:true, msg:"OK"};
  }

  
  function setCheckoutStep(step){
    // step: "form" | "otp" | "processing" | "receipt" | "success"
    if(checkoutBody) checkoutBody.style.display = (step==="form") ? "" : "none";
    if(checkoutOtp) checkoutOtp.style.display = (step==="otp") ? "" : "none";
    if(checkoutProcessing) checkoutProcessing.style.display = (step==="processing") ? "" : "none";
    if(checkoutReceipt) checkoutReceipt.style.display = (step==="receipt") ? "" : "none";
    if(checkoutSuccess) checkoutSuccess.style.display = (step==="success") ? "" : "none";
  }

  function sendDemoOtp(){
    const otp = String(Math.floor(100000 + Math.random()*900000));
    checkoutState.otp = otp;
    if(otpHint) otpHint.textContent = `Code démo : ${otp}`;
    return otp;
  }

  function showOtpStep(){
    setCheckoutStep("otp");
    sendDemoOtp();
    toast("Code OTP envoyé (simulation) 📩");
    if(otpCode){ otpCode.focus(); }
  }

  function buildTimeline(items){
    if(!processingTimeline) return;
    processingTimeline.innerHTML = items.map((x,i)=>(
      `<div class="titem ${x.done ? "is-done":""}" data-i="${i}">
         <div class="dot"></div>
         <div><div class="label">${esc(x.title)}</div><div class="muted">${esc(x.desc||"")}</div></div>
       </div>`
    )).join("");
  }

  function markTimelineDone(i){
    const el = processingTimeline && processingTimeline.querySelector(`.titem[data-i="${i}"]`);
    if(el) el.classList.add("is-done");
  }

  function showProcessingStep(){
    setCheckoutStep("processing");
    const t = checkoutState.target;
    const methodName = (METHODS.find(x=>x.id===checkoutState.method)||{}).name || "Paiement";
    const items = [
      {title:"Initialisation", desc:"Création de la transaction…", done:false},
      {title:"Envoi", desc:`Demande envoyée via ${methodName}…`, done:false},
      {title:"En attente", desc:"Confirmation utilisateur…", done:false},
      {title:"Webhook", desc:"Réception callback / webhook…", done:false},
      {title:"Vote confirmé", desc:`${checkoutState.qty} votes attribués à ${t ? t.name : "candidat"}…`, done:false},
    ];
    buildTimeline(items);
    if(processingText) processingText.textContent = "Initialisation…";

    const steps = [
      {ms:800,  text:"Transaction créée…", done:0},
      {ms:1100, text:"Demande envoyée…", done:1},
      {ms:1400, text:"Confirmation en cours…", done:2},
      {ms:1200, text:"Webhook reçu ✅", done:3},
      {ms:900,  text:"Vote comptabilisé ✅", done:4, finish:true},
    ];

    let acc = 0;
    steps.forEach((s, idx)=>{
      acc += s.ms;
      _processingTimers.push(setTimeout(()=>{
        if(processingText) processingText.textContent = s.text;
        markTimelineDone(s.done);
        if(s.finish){
          toast("Paiement confirmé ✅ (simulation)");
          showReceiptStep();
        }
      }, acc));
    });
  }

  function showReceiptStep(){
    setCheckoutStep("receipt");
    const t = checkoutState.target;
    const methodName = (METHODS.find(x=>x.id===checkoutState.method)||{}).name || "Paiement";
    const now = new Date();
    const lines = [
      {k:"Référence", v: payRef ? payRef.value : "—"},
      {k:"Date", v: now.toLocaleString("fr-FR")},
      {k:"Candidat", v: t ? `${t.name} (#${t.num})` : "—"},
      {k:"Votes", v: String(checkoutState.qty || 0)},
      {k:"Montant", v: `${money(checkoutState.amount||0)} ${VOTIUM.currency}`},
      {k:"Moyen", v: methodName},
      {k:"Statut", v: "PAYÉ (simulation)"},
    ];
    if(receiptCard){
      receiptCard.innerHTML = lines.map(x=>(
        `<div class="rrow"><div class="k">${esc(x.k)}</div><div class="v">${esc(x.v)}</div></div>`
      )).join("");
    }
  }

  function downloadReceipt(){
    const html = `<!doctype html><html lang="fr"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Reçu VOTIUM</title>
    <style>
      body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial;margin:24px;color:#0f172a}
      .card{border:1px solid rgba(15,23,42,.15);border-radius:14px;padding:16px;max-width:640px}
      h1{margin:0 0 10px;font-size:18px}
      .row{display:flex;justify-content:space-between;gap:12px;padding:8px 0;border-bottom:1px dashed rgba(15,23,42,.15)}
      .row:last-child{border-bottom:none}
      .k{color:#6b7280}
      .v{font-weight:800}
      .small{color:#6b7280;margin-top:10px;font-size:12px}
    </style></head><body>
    <div class="card">
      <h1>Reçu de paiement — VOTIUM (simulation)</h1>
      ${receiptCard ? receiptCard.innerHTML.replaceAll('class="rrow"', 'class="row"').replaceAll('class="k"', 'class="k"').replaceAll('class="v"', 'class="v"') : ""}
      <div class="small">Ce reçu est une simulation front-only pour maquette / démonstration.</div>
    </div>
    <script>window.print();