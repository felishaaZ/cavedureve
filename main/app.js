// app.js - SPA (home/join/menu/order) with login, stok edit, logout modal, transfer proof required
const KEY = 'rdr_site_v3';
const DEFAULT = {
  user: null,
  menu: [
  {
    id: 1,
    name: 'Baguette Sandwich',
    price: 55000,
    stock: 5,
    img: 'https://i.pinimg.com/736x/69/1b/99/691b9944ff2772ecead5cb8f1ee759b4.jpg'
  },
  {
    id: 2,
    name: 'Ratatouille',
    price: 40000,
    stock: 6,
    img: 'https://i.pinimg.com/1200x/ac/2b/87/ac2b8712745b5e5212d3a727b6fed95e.jpg'
  },
  {
    id: 3,
    name: 'Vegetable Soup',
    price: 35000,
    stock: 8,
    img: 'https://i.pinimg.com/1200x/38/a5/b7/38a5b7c978cb1b2913dd12287035a224.jpg'
  },
  {
    id: 4,
    name: 'Macaroon Tower',
    price: 25000,
    stock: 10,
    img: 'https://i.pinimg.com/736x/89/5e/46/895e463c3f4e464796d1ab4672bb2c8d.jpg'
  },
  {
    id: 5,
    name: 'Chocolate Soufflé Omelett',
    price: 30000,
    stock: 7,
    img: 'https://i.pinimg.com/736x/2a/f6/3c/2af63c44447560a6d7b051e50c783f46.jpg'
  },
  {
    id: 6,
    name: 'Synesthesia Cheese Plate',
    price: 45000,
    stock: 4,
    img: 'https://i.pinimg.com/1200x/c0/db/86/c0db861a417cdd3ade6ec800f86f8b5d.jpg'
  }
  ],
  cart: [],
  transferProof: null
};

function load(){ try{ const r = localStorage.getItem(KEY); return r?JSON.parse(r):JSON.parse(JSON.stringify(DEFAULT)); }catch(e){ return JSON.parse(JSON.stringify(DEFAULT)); } }
function save(){ localStorage.setItem(KEY, JSON.stringify(state)); }
function $(s){ return document.querySelector(s); }
function $all(s){ return Array.from(document.querySelectorAll(s)); }
function fmtRp(n){ return 'Rp' + n.toLocaleString('id-ID'); }
function toast(msg, color='var(--accent)'){ const t=document.createElement('div'); t.textContent=msg; Object.assign(t.style,{position:'fixed',left:'50%',transform:'translateX(-50%)',bottom:'18px',background:color,color:'#2b170f',padding:'8px 12px',borderRadius:'10px',fontWeight:800,zIndex:999}); document.body.appendChild(t); setTimeout(()=>t.remove(),1600); }

let state = load();

// Navigation & panels
const panels = {
  home: $('#home'),
  join: $('#join'),
  menu: $('#menu'),
  order: $('#order')
};
function hideAll(){ Object.values(panels).forEach(p => p && p.classList.add('hidden')); }
function show(name){
  hideAll();
  panels[name] && panels[name].classList.remove('hidden');
  // update nav active
  $all('.nav-btn').forEach(b => b.classList.toggle('active', b.dataset.target === name));
  // on show render specific
  if(name === 'menu') renderMenu();
  if(name === 'order') renderCart();
}
$all('.nav-btn').forEach(b => b.addEventListener('click', ()=> show(b.dataset.target)));
$('#btn-hero-join').addEventListener('click', ()=> show('join'));
$('#btn-join').addEventListener('click', ()=> show('join'));

// Header update
function updateHeader(){
  const btnJoin = $('#btn-join');
  const btnLogout = $('#btn-logout');
  if(state.user){
    btnJoin.classList.add('hidden');
    btnLogout.classList.remove('hidden');
    btnLogout.textContent = `Logout (${state.user.name.split(' ')[0]})`;
  } else {
    btnJoin.classList.remove('hidden');
    btnLogout.classList.add('hidden');
  }
}
updateHeader();

// Logout modal handlers (defensive)
const logoutModal = $('#logout-modal');
$('#btn-logout').addEventListener('click', ()=>{
  if(!logoutModal.classList.contains('hidden')) return;
  logoutModal.classList.remove('hidden');
});
$('#logout-no').addEventListener('click', ()=> logoutModal.classList.add('hidden'));
$('#logout-yes').addEventListener('click', ()=>{
  state.user = null;
  state.cart = [];
  state.transferProof = null;
  save();
  updateHeader();
  logoutModal.classList.add('hidden');
  show('home');
  toast('Logout berhasil','lightgreen');
});

// JOIN form
const joinForm = $('#join-form');
joinForm.addEventListener('submit', (e)=>{
  e.preventDefault();
  const name = $('#input-name').value.trim();
  const phone = $('#input-phone').value.trim();
  const email = $('#input-email').value.trim();
  const msg = $('#join-msg');
  if(!name || !phone || !email){ msg.textContent = 'Lengkapi data'; msg.style.color='lightcoral'; return; }
  state.user = { name, phone, email };
  save();
  updateHeader();
  toast('Login berhasil','lightgreen');
  show('home');
  joinForm.reset();
});

// cancel join
$('#join-cancel').addEventListener('click', ()=> {
  $('#join-msg').textContent = '';
  joinForm.reset();
  show('home');
});

// RENDER MENU
function renderMenu(){
  const grid = $('#menu-grid');
  if(!grid) return;
  grid.innerHTML = '';
  state.menu.forEach(item => {
    const card = document.createElement('div'); card.className = 'card';
    card.innerHTML = `
      <div class="card-controls">
        <button class="icon-btn edit" data-id="${item.id}" title="Edit stok">✎</button>
      </div>
      <img class="thumb" src="${item.img}"">
      <h4>${item.name}</h4>
      <div class="price">${fmtRp(item.price)}</div>
      <div class="stock">Stok: <b id="stock-${item.id}">${item.stock}</b></div>
      <button class="add-btn" data-id="${item.id}" ${item.stock<=0?'disabled':''}>+</button>
    `;
    grid.appendChild(card);
  });

  // add handlers
  grid.querySelectorAll('.add-btn').forEach(b=>{
    b.addEventListener('click', ()=>{
      const id = Number(b.dataset.id);
      if(!state.user){ toast('Silakan login dulu', 'lightcoral'); show('join'); return; }
      addToCart(id);
      renderMenu();
    });
  });

  // edit stok
  grid.querySelectorAll('.edit').forEach(b=>{
    b.addEventListener('click', ()=>{
      const id = Number(b.dataset.id);
      const it = state.menu.find(m=>m.id===id);
      if(!it) return;
      const val = prompt(`Masukkan stok baru untuk "${it.name}" (angka >=0):`, String(it.stock));
      if(val === null) return;
      const n = Number(val);
      if(Number.isNaN(n) || n < 0){ toast('Stok harus angka valid','lightcoral'); return; }
      it.stock = n; save(); renderMenu(); toast('Stok diperbarui','lightgreen');
    });
  });
}

// CART functions
function addToCart(id){
  const m = state.menu.find(x=>x.id===id);
  if(!m || m.stock <= 0){ toast('Stok habis','lightcoral'); return; }
  m.stock -= 1;
  const c = state.cart.find(x=>x.id===id);
  if(c) c.qty += 1; else state.cart.push({ id:m.id, name:m.name, price:m.price, img:m.img, qty:1 });
  save();
}

function changeQty(id, delta){
  const c = state.cart.find(x=>x.id===id);
  const m = state.menu.find(x=>x.id===id);
  if(!c || !m) return;
  if(delta > 0){
    if(m.stock <= 0){ toast('Stok tidak cukup','lightcoral'); return; }
    c.qty += 1; m.stock -= 1;
  } else {
    c.qty -= 1; m.stock += 1;
    if(c.qty <= 0) state.cart = state.cart.filter(x=>x.id!==id);
  }
  save();
}

function removeFromCart(id){
  const c = state.cart.find(x=>x.id===id);
  if(!c) return;
  const m = state.menu.find(x=>x.id===id);
  if(m) m.stock += c.qty;
  state.cart = state.cart.filter(x=>x.id!==id);
  save();
}

// render cart
function renderCart(){
  const list = $('#cart-list');
  if(!list) return;
  list.innerHTML = '';
  if(state.cart.length === 0){ list.innerHTML = '<p class="empty">Belum ada pesanan.</p>'; $('#total-items').textContent = '0'; $('#total-price').textContent = 'Rp0'; return; }
  state.cart.forEach(it=>{
    const el = document.createElement('div'); el.className = 'cart-item';
    el.innerHTML = `
      <img src="${it.img}" alt="${it.name}">
      <div class="info">
        <h4>${it.name}</h4>
        <small>${fmtRp(it.price)}</small>
        <div class="cart-controls">
          <button class="btn ghost qty" data-id="${it.id}" data-d="-1">−</button>
          <strong>${it.qty}</strong>
          <button class="btn ghost qty" data-id="${it.id}" data-d="1">+</button>
        </div>
      </div>
      <div><button class="btn ghost remove" data-id="${it.id}">✕</button></div>
    `;
    list.appendChild(el);
  });

  // handlers
  list.querySelectorAll('.qty').forEach(b=>{
    b.addEventListener('click', ()=>{
      const id = Number(b.dataset.id), d = Number(b.dataset.d);
      changeQty(id, d); renderCart(); renderMenu();
    });
  });
  list.querySelectorAll('.remove').forEach(b=>{
    b.addEventListener('click', ()=>{
      const id = Number(b.dataset.id);
      removeFromCart(id); renderCart(); renderMenu();
    });
  });

  const totalQty = state.cart.reduce((a,c)=>a+c.qty,0);
  const totalPrice = state.cart.reduce((a,c)=>a + c.qty * c.price,0);
  $('#total-items').textContent = totalQty;
  $('#total-price').textContent = fmtRp(totalPrice);
}

// payment method and transfer proof
$('#payment-method').addEventListener('change', ()=>{
  const val = $('#payment-method').value;
  $('#transfer-area').classList.toggle('hidden', val !== 'Transfer');
});

// transfer file preview
$('#transfer-proof').addEventListener('change', (e)=>{
  const f = e.target.files[0];
  const preview = $('#proof-preview');
  if(!f){ state.transferProof = null; preview.innerHTML = ''; save(); return; }
  const url = URL.createObjectURL(f);
  preview.innerHTML = `<img src="${url}" style="width:100%;border-radius:8px">`;
  state.transferProof = { name: f.name, time: Date.now() };
  save();
});

// confirm order
$('#confirm-order').addEventListener('click', ()=>{
  if(state.cart.length === 0){ $('#order-msg').textContent = 'Keranjang kosong'; $('#order-msg').style.color = 'lightcoral'; return; }
  if(!state.user){ toast('Login dulu sebelum konfirmasi','lightcoral'); show('join'); return; }
  const pm = $('#payment-method').value;
  if(pm === 'Transfer' && !state.transferProof){ $('#order-msg').textContent = 'Upload bukti transfer dulu'; $('#order-msg').style.color='lightcoral'; return; }
  $('#order-msg').textContent = `Pesanan berhasil dikonfirmasi. Metode: ${pm}`; $('#order-msg').style.color = 'lightgreen';
  // clear cart and transfer proof
  state.cart = []; state.transferProof = null;
  save();
  renderCart(); renderMenu();
  setTimeout(()=>{ $('#order-msg').textContent = ''; }, 4000);
});

// clear cart
$('#clear-cart').addEventListener('click', ()=>{
  if(state.cart.length === 0) return;
  if(!confirm('Hapus semua pesanan?')) return;
  state.cart.forEach(c => {
    const m = state.menu.find(mm => mm.id === c.id);
    if(m) m.stock += c.qty;
  });
  state.cart = []; save(); renderCart(); renderMenu(); toast('Semua pesanan dihapus','lightgreen');
});

// initial render + safety
document.addEventListener('DOMContentLoaded', ()=>{
  updateHeader();
  show('home');
  renderMenu();
  renderCart();
});

document.getElementById('landingForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch('submit.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => alert(data))
    .catch(error => console.error('Error:', error));
});

