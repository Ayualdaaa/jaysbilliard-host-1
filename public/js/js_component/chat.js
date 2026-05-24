// Chat Logic for Admin Dashboard with Database Sync
let chatData = JSON.parse(localStorage.getItem('billiard_chat_history'));

if (!chatData) {
    chatData = {
        1: { table: 'MEJA 01', status: 'TERISI', statusColor: '#00e5ff', user: 'Rian S.', messages: [] },
        2: { table: 'MEJA 02', status: 'TERSEDIA', statusColor: '#00e5ff', user: 'System', messages: [] },
        3: { table: 'MEJA 03', status: 'DIPESAN', statusColor: '#ffab00', user: 'Zaenal', messages: [] },
        4: { table: 'MEJA 04', status: 'TERISI', statusColor: '#00e5ff', user: 'Haecan', messages: [] }
    };
    localStorage.setItem('billiard_chat_history', JSON.stringify(chatData));
}

let activeAdminTableId = null;

function saveChatData() {
    localStorage.setItem('billiard_chat_history', JSON.stringify(chatData));
}

// Fetch CSRF Token from meta tag
function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

// Background Sync with DB
function syncChatWithDatabase() {
    const token = getCsrfToken();
    if (!token) return;

    fetch('/chat/sync', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ history: chatData })
    })
    .then(res => res.json())
    .then(res => {
        if (res.success && res.history) {
            chatData = res.history;
            saveChatData();
            updateAdminBadges();
            if (activeAdminTableId) {
                renderMessages(activeAdminTableId);
            }
        }
    })
    .catch(err => console.error('Admin chat sync error:', err));
}

function markTableAsRead(id) {
    const token = getCsrfToken();
    if (!token) return;

    fetch(`/chat/${id}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token
        }
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            if (chatData[id]) {
                chatData[id].hasUnreadForAdmin = false;
                saveChatData();
                updateAdminBadges();
            }
        }
    })
    .catch(err => console.error('Admin mark read error:', err));
}

function updateAdminBadges() {
    document.querySelectorAll('.adm-btn-chat[data-meja]').forEach(btn => {
        const id = btn.dataset.meja;
        let badge = btn.querySelector('.notif-badge');
        
        if (!badge) {
            badge = document.createElement('span');
            badge.className = 'notif-badge';
            badge.style.display = 'none';
            btn.appendChild(badge);
        }

        if (chatData[id] && chatData[id].hasUnreadForAdmin) {
            badge.style.display = 'flex';
            badge.innerText = '!';
        } else {
            badge.style.display = 'none';
        }
    });
}

function openChat(mejaId) {
    activeAdminTableId = mejaId;
    const data = chatData[mejaId]; 
    if (!data) return;
    
    // Clear unread flag for admin when opening chat
    markTableAsRead(mejaId);

    document.getElementById('chatTableName').textContent = data.table;
    document.getElementById('chatStatus').textContent = data.status;
    document.getElementById('chatStatus').style.color = data.statusColor;
    document.querySelector('.chat-popup-dot').style.color = data.statusColor;
    document.getElementById('chatUserName').textContent = data.user;
    
    renderMessages(mejaId);
    
    document.getElementById('chatOverlay').classList.add('active');
    document.getElementById('chatPopup').classList.add('active');
    
    const body = document.getElementById('chatBody');
    body.scrollTop = body.scrollHeight;

    setTimeout(() => {
        const input = document.getElementById('chatInput');
        if (input) input.focus();
    }, 150);
}

function renderMessages(mejaId) {
    const data = chatData[mejaId];
    if (!data) return;

    const body = document.getElementById('chatBody'); 
    body.innerHTML = '';
    
    data.messages.forEach(msg => {
        const wrapper = document.createElement('div'); 
        // Admin is on the right, user is on the left
        wrapper.className = 'chat-msg ' + (msg.from === 'admin' ? 'chat-msg--admin' : 'chat-msg--customer');
        
        const bubble = document.createElement('div'); 
        bubble.className = 'chat-bubble'; 
        bubble.textContent = msg.text;
        
        const meta = document.createElement('div'); 
        meta.className = 'chat-meta'; 
        meta.innerHTML = msg.time;
        
        wrapper.appendChild(bubble); 
        wrapper.appendChild(meta); 
        body.appendChild(wrapper);
    });
    
    body.scrollTop = body.scrollHeight;
}

function closeChat() { 
    activeAdminTableId = null;
    document.getElementById('chatOverlay').classList.remove('active'); 
    document.getElementById('chatPopup').classList.remove('active'); 
}

// Event Listeners
document.querySelectorAll('.adm-btn-chat[data-meja]').forEach(btn => {
    btn.addEventListener('click', () => openChat(btn.dataset.meja));
});

document.getElementById('chatClose').addEventListener('click', closeChat);
document.getElementById('chatOverlay').addEventListener('click', closeChat);

const chatSendBtn = document.getElementById('chatSend');
const chatInput = document.getElementById('chatInput');

if (chatSendBtn) {
    chatSendBtn.addEventListener('click', () => {
        if (!chatInput.value.trim() || !activeAdminTableId) return;
        
        const text = chatInput.value.trim();
        chatInput.value = ''; 

        const now = new Date(); 
        const timeStr = now.getHours().toString().padStart(2,'0') + ':' + now.getMinutes().toString().padStart(2,'0');
        
        if (!chatData[activeAdminTableId]) chatData[activeAdminTableId] = { messages: [] };
        
        // Optimistically render locally
        chatData[activeAdminTableId].messages.push({
            from: 'admin',
            text: text,
            time: timeStr
        });
        
        // Notify user there is an unread message
        chatData[activeAdminTableId].hasUnreadForUser = true;
        
        saveChatData();
        renderMessages(activeAdminTableId);

        // Save to database via dedicated endpoint
        const token = getCsrfToken();
        if (!token) return;

        fetch('/chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({
                table_id: activeAdminTableId,
                message: text
            })
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                syncChatWithDatabase();
            }
        })
        .catch(err => console.error('Admin send message error:', err));
    });

    chatInput.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            chatSendBtn.click();
        }
    });
}

// Listen for updates from User dashboard (if on same page/browser profile)
window.addEventListener('storage', (e) => {
    if (e.key === 'billiard_chat_history') {
        chatData = JSON.parse(e.newValue);
        updateAdminBadges();

        if (activeAdminTableId) {
            if (chatData[activeAdminTableId].hasUnreadForAdmin) {
                markTableAsRead(activeAdminTableId);
            }
            renderMessages(activeAdminTableId);
        }
    }
});

// Initial Setup & Polling Loop
updateAdminBadges();
syncChatWithDatabase();
setInterval(syncChatWithDatabase, 3000);
