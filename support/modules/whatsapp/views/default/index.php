<?php

use support\assets\WhatsappAsset;
/* @var $this yii\web\View */

$this->title = 'WhatsApp Chat Panel';
WhatsappAsset::register($this);
?>

<!-- Main Container -->
<div class="container-fluid mt-4">
    <div class="row chat-container shadow-sm rounded">
        <!-- Contacts List -->
        <div class="col-md-4 col-lg-3 p-0 chat-list auto-s overflow-hidden">
            <div class="p-3 bg-white border-bottom">
                <div class="input-group">
                    <input type="text"
                        class="form-control search-input"
                        placeholder="Search by name or phone number..."
                        id="searchContacts"
                        autocomplete="off">
                    <span class="search-icon">
                        <i class="bi bi-search"></i>
                    </span>
                </div>
            </div>
            <div id="contactsList">
                <!-- Contacts will be loaded here dynamically -->
            </div>
        </div>

        <!-- Chat Area -->
        <div class="col-md-8 col-lg-9 p-0">
            <!-- Chat Placeholder -->
            <div id="chatPlaceholder" class="chat-placeholder">
                <div class="chat-placeholder-content">
                    <i class="bi bi-chat-dots" style="font-size: 3rem;"></i>
                    <h4 class="mt-3">Select a contact to start messaging</h4>
                </div>
            </div>

            <!-- Chat Box (Initially Hidden) -->
            <div id="chatbox" style="display: none;">
                <div class="chat-messages">
                    <!-- Chat Header -->
                    <div class="p-3 bg-white border-bottom" id="chatHeader">
                        <div class="d-flex align-items-center">
                            <div class="profile-circle me-3 d-flex align-items-center justify-content-center" id="currentContactInitial"></div>
                            <div>
                                <h6 class="mb-0" id="currentContactName">Select a contact</h6>
                                <small class="text-muted" id="currentContactStatus">offline</small>
                            </div>
                        </div>
                    </div>

                    <!-- Messages Container -->
                    <div class="messages-container" id="messagesContainer">
                        <!-- Messages will be loaded here dynamically -->
                    </div>

                    <!-- Chat Input -->
                    <div class="chat-input">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Type a message" id="messageInput">
                            <button class="btn btn-primary" type="button" id="sendMessage">
                                <i class="bi bi-send"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">


<!-- JavaScript for WhatsApp Panel -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatbox = document.getElementById('chatbox');
        const chatPlaceholder = document.getElementById('chatPlaceholder');
        let currentContactId = null;
        let currentContactsPage = 1;
        let currentMessagesPage = 1;
        let isLoadingContacts = false;
        let isLoadingMessages = false;
        let hasMoreContacts = true;
        let hasMoreMessages = true;

        // Function to render contacts
        function renderContacts(contacts, append = false) {
            const contactsList = document.getElementById('contactsList');
            const contactsHtml = contacts.map(contact => `
                <div class="contact-item p-3 border-bottom" data-id="${contact.id}" data-name="${contact.name}" data-phone="${contact.phone_number}">
                    <div class="d-flex align-items-center">
                        <div class="profile-circle me-3 d-flex align-items-center justify-content-center">
                            ${contact.name ? contact.name.charAt(0).toUpperCase() : '#'}
                        </div>
                        <div>
                            <h6 class="mb-0">${contact.name || 'Unknown'}</h6>
                            <small class="text-muted">+${contact.phone_number}</small>
                        </div>
                    </div>
                </div>
            `).join('');

            if (append) {
                contactsList.insertAdjacentHTML('beforeend', contactsHtml);
            } else {
                contactsList.innerHTML = contactsHtml;
            }

            // Add click event listeners to newly added contacts only
            const newContacts = append ?
                contactsList.querySelectorAll('.contact-item:not([data-initialized])') :
                contactsList.querySelectorAll('.contact-item');

            newContacts.forEach(item => {
                item.setAttribute('data-initialized', 'true');
                item.addEventListener('click', function() {
                    const contactId = this.dataset.id;
                    const contactName = this.dataset.name;

                    // Remove active class from all contacts
                    document.querySelectorAll('.contact-item').forEach(el =>
                        el.classList.remove('active')
                    );

                    // Add active class to clicked contact
                    this.classList.add('active');

                    // Show chat
                    showChat(contactId, contactName);
                });
            });
        }

        // Function to load contacts from server
        function loadContacts(append = false) {
            if (isLoadingContacts) return;

            isLoadingContacts = true;
            const contactsList = document.getElementById('contactsList');

            if (!append) {
                currentContactsPage = 1;
                // Show initial loading state
                contactsList.innerHTML = '<div class="p-3 text-center"><div class="spinner-border spinner-border-sm text-primary" role="status"></div><div class="mt-2">Loading contacts...</div></div>';
            } else {
                // Show loading indicator for pagination
                const loadingDiv = document.createElement('div');
                loadingDiv.className = 'text-center p-2 loading-more';
                loadingDiv.innerHTML = '<div class="spinner-border spinner-border-sm text-primary" role="status"></div>';
                contactsList.appendChild(loadingDiv);
            }

            fetch(`/whatsapp/default/get-contacts?page=${currentContactsPage}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-Token': '<?= Yii::$app->request->csrfToken ?>'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    // Remove loading indicator if it exists
                    const loadingMore = contactsList.querySelector('.loading-more');
                    if (loadingMore) {
                        loadingMore.remove();
                    }

                    if (data.success) {
                        if (data.contacts.length === 0 && !append) {
                            contactsList.innerHTML = '<div class="p-3 text-center text-muted">No contacts found</div>';
                        } else {
                            renderContacts(data.contacts, append);
                            hasMoreContacts = data.hasMore;
                            if (data.hasMore && append) {
                                currentContactsPage++;
                            }
                        }
                    } else {
                        throw new Error(data.error || 'Failed to load contacts');
                    }
                })
                .catch(error => {
                    console.error('Error loading contacts:', error);
                    if (!append) {
                        contactsList.innerHTML = `
                        <div class="text-center p-3 text-danger">
                            <i class="bi bi-exclamation-circle"></i>
                            <div class="mt-2">Failed to load contacts</div>
                            <button class="btn btn-sm btn-outline-primary mt-2" onclick="loadContacts()">Retry</button>
                        </div>
                    `;
                    }
                })
                .finally(() => {
                    isLoadingContacts = false;
                });
        }

        // Replace scroll handler for infinite scrolling
        const contactsListDiv = document.getElementById('contactsList');
        contactsListDiv.addEventListener('scroll', () => {
            if (isLoadingContacts) return;

            const scrollPosition = contactsListDiv.scrollTop + contactsListDiv.clientHeight;
            const scrollHeight = contactsListDiv.scrollHeight;
            const scrollThreshold = 50; // pixels from bottom to trigger load

            const searchInput = document.getElementById('searchContacts');
            const searchTerm = searchInput ? searchInput.value.trim() : '';

            if (searchTerm.length === 0 && hasMoreContacts && (scrollHeight - scrollPosition <= scrollThreshold)) {
                currentContactsPage++;
                loadContacts(true);
            }
        });

        // Function to show chat
        function showChat(contactId, contactName) {
            currentContactId = contactId;
            currentMessagesPage = 1;
            hasMoreMessages = true;
            
            // Update UI elements
            chatPlaceholder.style.display = 'none';
            chatbox.style.display = 'block';
            document.getElementById('currentContactName').textContent = contactName;
            document.getElementById('currentContactInitial').textContent = contactName.charAt(0).toUpperCase();
            
            // Clear previous messages
            document.getElementById('messagesContainer').innerHTML = '';
            
            // Load messages
            loadMessages();
        }

        // Function to load messages
        function loadMessages(append = false) {
            if (isLoadingMessages || (!hasMoreMessages && append)) return;
            
            isLoadingMessages = true;
            const messagesContainer = document.getElementById('messagesContainer');
            
            if (!append) {
                messagesContainer.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"></div></div>';
            }

            fetch(`/whatsapp/default/get-messages?contactId=${currentContactId}&page=${currentMessagesPage}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-Token': '<?= Yii::$app->request->csrfToken ?>'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderMessages(data.messages, append);
                    hasMoreMessages = data.hasMore;
                    if (data.hasMore && append) {
                        currentMessagesPage++;
                    }
                } else {
                    throw new Error(data.error || 'Failed to load messages');
                }
            })
            .catch(error => {
                console.error('Error loading messages:', error);
                messagesContainer.innerHTML = `
                    <div class="text-center text-danger">
                        <i class="bi bi-exclamation-circle"></i>
                        <div>Failed to load messages</div>
                        <button class="btn btn-sm btn-outline-primary mt-2" onclick="loadMessages()">Retry</button>
                    </div>
                `;
            })
            .finally(() => {
                isLoadingMessages = false;
            });
        }

        function formatMessageDate(date) {
            const now = new Date();
            const messageDate = new Date(date);
            
            // Check if same day
            if (messageDate.toDateString() === now.toDateString()) {
                return 'Today';
            }
            
            // Check if yesterday
            const yesterday = new Date(now);
            yesterday.setDate(yesterday.getDate() - 1);
            if (messageDate.toDateString() === yesterday.toDateString()) {
                return 'Yesterday';
            }
            
            // If this year
            if (messageDate.getFullYear() === now.getFullYear()) {
                return messageDate.toLocaleDateString('en-US', { 
                    month: 'long', 
                    day: 'numeric'
                });
            }
            
            // If different year
            return messageDate.toLocaleDateString('en-US', { 
                year: 'numeric',
                month: 'long', 
                day: 'numeric'
            });
        }

        // Modify renderMessages function to include date separators
        function renderMessages(messages, append = false) {
            const messagesContainer = document.getElementById('messagesContainer');
            let currentDate = '';
            
            const messagesList = messages.map(message => {
                const messageDate = new Date(message.created_at);
                const dateStr = formatMessageDate(messageDate);
                let dateSeparator = '';
                
                // Add date separator if date changes
                if (dateStr !== currentDate) {
                    currentDate = dateStr;
                    dateSeparator = `
                        <div class="date-separator">
                            <span>${dateStr}</span>
                        </div>
                    `;
                }
                
                return `
                    ${dateSeparator}
                    <div class="message ${message.direction === 'outbound' ? 'sent' : 'received'} mb-2">
                        <div class="message-content p-2 rounded">
                            <div class="message-text">${message.content}</div>
                            <small class="message-time text-muted">
                                ${messageDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                            </small>
                        </div>
                    </div>
                `;
            }).join('');

            if (append) {
                messagesContainer.insertAdjacentHTML('afterbegin', messagesList);
            } else {
                messagesContainer.innerHTML = messagesList;
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        }

        // Add scroll handler for messages
        const messagesContainer = document.getElementById('messagesContainer');
        messagesContainer.addEventListener('scroll', () => {
            if (messagesContainer.scrollTop === 0 && hasMoreMessages && !isLoadingMessages) {
                currentMessagesPage++;
                loadMessages(true);
            }
        });

        // Add message sending functionality
        const messageInput = document.getElementById('messageInput');
        const sendButton = document.getElementById('sendMessage');

        function sendMessage() {
            const message = messageInput.value.trim();
            if (!message || !currentContactId) return;

            sendButton.disabled = true;
            messageInput.disabled = true;

            fetch('/whatsapp/default/send-message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': '<?= Yii::$app->request->csrfToken ?>'
                },
                body: JSON.stringify({
                    contact_id: currentContactId,
                    message: message,
                    type: 'text'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageInput.value = '';
                    loadMessages(); // Reload messages to show the new message
                } else {
                    alert('Failed to send message: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error sending message:', error);
                alert('Failed to send message');
            })
            .finally(() => {
                sendButton.disabled = false;
                messageInput.disabled = false;
            });
        }

        sendButton.addEventListener('click', sendMessage);
        messageInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        // Add search functionality
        const searchInput = document.getElementById('searchContacts');
        let searchTimeout = null;

        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            const searchTerm = e.target.value.trim();

            searchTimeout = setTimeout(() => {
                currentContactsPage = 1;
                if (searchTerm.length > 0) {
                    searchContacts(searchTerm);
                } else {
                    loadContacts(); // Load all contacts if search is empty
                }
            }, 500); // Debounce search for 500ms
        });

        function searchContacts(searchTerm) {
            isLoadingContacts = true;
            const contactsList = document.getElementById('contactsList');
            contactsList.innerHTML = '<div class="p-3 text-center"><div class="spinner-border spinner-border-sm text-primary" role="status"></div><div class="mt-2">Searching...</div></div>';

            fetch(`/whatsapp/default/search-contacts?search=${encodeURIComponent(searchTerm)}&page=${currentContactsPage}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-Token': '<?= Yii::$app->request->csrfToken ?>'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.contacts.length === 0) {
                        contactsList.innerHTML = '<div class="p-3 text-center text-muted">No contacts found</div>';
                    } else {
                        renderContacts(data.contacts);
                        hasMoreContacts = data.hasMore;
                    }
                } else {
                    throw new Error(data.error || 'Search failed');
                }
            })
            .catch(error => {
                console.error('Error searching contacts:', error);
                contactsList.innerHTML = `
                    <div class="text-center p-3 text-danger">
                        <i class="bi bi-exclamation-circle"></i>
                        <div class="mt-2">Search failed</div>
                    </div>
                `;
            })
            .finally(() => {
                isLoadingContacts = false;
            });
        }

        // Initial load of contacts
        loadContacts();
    });
</script>