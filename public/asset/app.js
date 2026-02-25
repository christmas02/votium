
(function(){
  const role = document.body.getAttribute('data-role') || 'Promoteur';
  const pill = document.getElementById('rolePill');
  if(pill){
    const span = pill.querySelector('span');
    if(span) span.textContent = role;
  }
  // active link
  const here = location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.topbar .nav a').forEach(a=>{
    const href = (a.getAttribute('href')||'').split('?')[0];
    if(href === here){
      a.classList.add('active');
    }
  });
})();


/* ---------- Role dropdown (Promoteur/Admin) ---------- */
function initRoleMenu(){
  const pill = document.getElementById('rolePill');
  if(!pill) return;

  const page = (location.pathname.split('/').pop() || '').toLowerCase();

  // Wrap pill to position dropdown
  const wrap = document.createElement('div');
  wrap.className = 'role-wrap';
  pill.parentNode.insertBefore(wrap, pill);
  wrap.appendChild(pill);

  const menu = document.createElement('div');
  menu.className = 'role-menu';

  // Public vs espace promoteur
  const publicPages = new Set(['home.html','index.html','login.html','inscription.html']);
  const isPublic = publicPages.has(page);

  // Build menu items based on context
  let itemsHtml = '';
  if(isPublic){
    // Sur la home (grand public) : uniquement Connexion + Inscription
    itemsHtml = `
      <a href="login.html">Connexion</a>
      <a href="inscription.html">Inscription</a>
    `;
  } else {
    // Dans l'espace promoteur : uniquement Se déconnecter
    itemsHtml = `<a href="#" data-logout="1">Se déconnecter</a>`;
  }

  menu.innerHTML = itemsHtml;
  wrap.appendChild(menu);

  const close = ()=>{ menu.classList.remove('show'); wrap.classList.remove('show'); };
  const toggle = (e)=>{ e.preventDefault(); menu.classList.toggle('show'); wrap.classList.toggle('show'); };

  pill.addEventListener('click', toggle);

  // Logout behavior
  menu.addEventListener('click', (e)=>{
    const a = e.target.closest('a');
    if(!a) return;
    if(a.dataset.logout === '1'){
      e.preventDefault();
      try{ localStorage.removeItem('votium_auth'); }catch(_){}
      location.href = (location.pathname.includes('/promoteur/') || location.pathname.includes('/super_admin/')) ? '../home.html' : 'home.html';
    }
  });

  document.addEventListener('click', (e)=>{
    if(!wrap.contains(e.target)) close();
  });
  document.addEventListener('keydown', (e)=>{
    if(e.key === 'Escape') close();
  });
}

/* ---------- Session persist (front) ---------- */
function initSessionPersist(){
  const KEY = 'votium_selected_session';
  const selects = document.querySelectorAll('select[data-session-select], select#sessionSelect, .filter select');
  const stored = localStorage.getItem(KEY);

  // Helper: set selects to stored text if found
  function applySelection(label){
    if(!label) return;
    selects.forEach(sel=>{
      const options = Array.from(sel.options || []);
      const match = options.find(o => (o.textContent || '').trim() === label || (o.value || '').trim() === label);
      if(match){
        sel.value = match.value;
      }
    });
    document.querySelectorAll('[data-session-name]').forEach(el=>{ el.textContent = label; });
  }

  if(stored) applySelection(stored);

  selects.forEach(sel=>{
    sel.addEventListener('change', ()=>{
      const label = (sel.selectedOptions && sel.selectedOptions[0]) ? sel.selectedOptions[0].textContent.trim() : (sel.value || '').trim();
      if(label){
        localStorage.setItem(KEY, label);
        applySelection(label);
      }
    });
  });
}

document.addEventListener('DOMContentLoaded', ()=>{
  try{ initRoleMenu(); }catch(e){}
  try{ initSessionPersist(); }catch(e){}
});
