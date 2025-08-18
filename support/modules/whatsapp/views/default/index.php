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
        <div class="col-md-4 col-lg-3 p-0 chat-list">
            <div class="p-3 bg-white">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search contacts..." id="searchContacts">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="bi bi-search"></i>
                    </button>
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

<style>
    .profile-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background-color: #152f1b;
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
        min-width: 45px;
    }

    .messages-container {
        height: calc(100vh - 200px);
        overflow-y: auto;
        background-color: #f5f5f5;
        padding: 1rem;
    }

    .loading-more {
        padding: 0.5rem;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 10px;
        margin: 0.5rem 0;
    }

    .spinner-border {
        width: 2rem;
        height: 2rem;
    }

    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
    }
</style>

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

        function renderContacts(contacts, append = false) {
            const contactsList = document.getElementById('contactsList');
            const contactsHtml = contacts.map(contact => `
                <div class="contact-item p-3 border-bottom" data-id="${contact.id}" data-name="${contact.name}" data-phone="${contact.phone_number}">
                    <div class="d-flex align-items-center">
                        <div class="profile-circle me-3 d-flex align-items-center justify-content-center">
                            ${contact.name.charAt(0).toUpperCase()}
                        </div>
                        <div>
                            <h6 class="mb-0">${contact.name}</h6>
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
            const newContacts = append 
                ? contactsList.querySelectorAll('.contact-item:not([data-initialized])')
                : contactsList.querySelectorAll('.contact-item');
                
            newContacts.forEach(item => {
                item.setAttribute('data-initialized', 'true');
                item.addEventListener('click', function() {
                    const contactId = this.dataset.id;
                    const contactName = this.dataset.name;

                    // Remove active class from all contacts
                    document.querySelectorAll('.contact-item').forEach(el =>
                        el.classList.remove('active'));

                    // Add active class to clicked contact
                    this.classList.add('active');

                    // Show chat and load messages
                    showChat(contactId, contactName);
                });
            });
        }

        function showChat(contactId, contactName) {
            // Hide placeholder and show chatbox
            chatPlaceholder.style.display = 'none';
            chatbox.style.display = 'block';

            // Show loading state
            const messagesContainer = document.getElementById('messagesContainer');
            messagesContainer.innerHTML = '<div class="text-center p-3"><div class="spinner-border text-primary" role="status"></div><div class="mt-2">Loading messages...</div></div>';

            // Update contact info in header
            document.getElementById('currentContactName').textContent = contactName;
            document.getElementById('currentContactStatus').textContent = 'online';
            document.getElementById('currentContactInitial').textContent = contactName.charAt(0).toUpperCase();

            // Reset pagination and states for new contact
            currentMessagesPage = 1;
            hasMoreMessages = true;
            isLoadingMessages = false;
            
            // Update current contact ID and load chat
            currentContactId = contactId;
            loadChat(contactId);
        }

        function loadChat(contactId, append = false) {
            // Prevent loading if already loading or no more messages (except for first load)
            if (isLoadingMessages || (!append && !hasMoreMessages)) return;
            
            // Verify we're still on the same contact
            if (contactId !== currentContactId) return;
            
            isLoadingMessages = true;
            const messagesContainer = document.getElementById('messagesContainer');
            
            // Show loading indicator for initial load
            if (!append && !messagesContainer.children.length) {
                messagesContainer.innerHTML = '<div class="text-center p-3"><div class="spinner-border text-primary" role="status"></div><div class="mt-2">Loading messages...</div></div>';
            }
            
            // Add loading indicator for pagination
            if (append) {
                const loadingDiv = document.createElement('div');
                loadingDiv.className = 'text-center p-2 loading-more';
                loadingDiv.innerHTML = '<div class="spinner-border spinner-border-sm text-primary" role="status"></div>';
                messagesContainer.insertAdjacentElement('afterbegin', loadingDiv);
            }
            
            fetch(`/whatsapp/default/get-messages?contactId=${contactId}&page=${currentMessagesPage}`, {
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
                // Verify we're still on the same contact
                if (contactId !== currentContactId) return;
                
                if (data.success) {
                    // Remove loading-more indicator if it exists
                    const loadingMore = messagesContainer.querySelector('.loading-more');
                    if (loadingMore) loadingMore.remove();
                    
                    renderMessages(data.messages, append);
                    hasMoreMessages = data.hasMore;
                    if (hasMoreMessages && append) currentMessagesPage++;
                } else {
                    throw new Error(data.error || 'Failed to load messages');
                }
            })
            .catch(error => {
                console.error('Error loading messages:', error);
                if (!append) {
                    messagesContainer.innerHTML = `
                        <div class="text-center p-3 text-danger">
                            <i class="bi bi-exclamation-circle"></i>
                            <div class="mt-2">Failed to load messages. Click to try again.</div>
                        </div>
                    `;
                    // Add retry functionality
                    messagesContainer.querySelector('div').addEventListener('click', () => {
                        if (contactId === currentContactId) {
                            loadChat(contactId);
                        }
                    });
                }
            })
            .finally(() => {
                isLoadingMessages = false;
            });
        }

        function renderMessages(messages, prepend = false) {
            const messagesContainer = document.getElementById('messagesContainer');
            const messagesHtml = messages.map(message => `
                <div class="message ${message.direction === 'outbound' ? 'message-sent' : 'message-received'}">
                    <div class="message-content">${message.content}</div>
                    <small class="message-time">${formatMessageTime(message.created_at)}</small>
                </div>
            `).join('');

            if (prepend) {
                messagesContainer.insertAdjacentHTML('afterbegin', messagesHtml);
            } else {
                messagesContainer.innerHTML = messagesHtml;
                // Only scroll to bottom for new messages
                scrollToBottom();
            }
        }

        function formatMessageTime(timestamp) {
            return new Date(timestamp).toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        function scrollToBottom() {
            const messagesContainer = document.getElementById('messagesContainer');
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function sendMessage() {
            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value.trim();

            if (message && currentContactId) {
                fetch('/whatsapp/default/send-message', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-Token': '<?= Yii::$app->request->csrfToken ?>'
                        },
                        body: JSON.stringify({
                            contact_id: parseInt(currentContactId),
                            message: message,
                            type: 'text'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Add message to UI immediately
                            const messagesContainer = document.getElementById('messagesContainer');
                            const messageElement = document.createElement('div');
                            messageElement.className = 'message message-sent';
                            messageElement.innerHTML = `
                            <div class="message-content">${message}</div>
                            <small class="message-time">${formatMessageTime(new Date())}</small>
                        `;
                            messagesContainer.appendChild(messageElement);

                            // Clear input and scroll to bottom
                            messageInput.value = '';
                            scrollToBottom();
                        } else {
                            alert(data.error || 'Failed to send message');
                        }
                    })
                    .catch(error => {
                        console.error('Error sending message:', error);
                        alert('Failed to send message. Please try again.');
                    });
            }
        }

        // Event Listeners
        document.getElementById('sendMessage').addEventListener('click', sendMessage);
        document.getElementById('messageInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        document.getElementById('searchContacts').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            document.querySelectorAll('.contact-item').forEach(item => {
                const name = item.querySelector('h6').textContent.toLowerCase();
                const phone = item.dataset.phone.toLowerCase();
                item.style.display = (name.includes(searchTerm) || phone.includes(searchTerm)) ? 'block' : 'none';
            });
        });

        // Function to load contacts from the server
        function loadContacts(append = false) {
            if (isLoadingContacts || !hasMoreContacts) return;
            
            isLoadingContacts = true;
            const contactsList = document.getElementById('contactsList');
            
            if (!append) {
                contactsList.innerHTML = '<div class="p-3 text-center">Loading contacts...</div>';
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
                if (data.success && Array.isArray(data.contacts)) {
                    if (data.contacts.length === 0 && !append) {
                        contactsList.innerHTML = '<div class="p-3 text-center">No contacts found</div>';
                    } else {
                        renderContacts(data.contacts, append);
                        hasMoreContacts = data.hasMore;
                        if (hasMoreContacts) currentContactsPage++;
                    }
                } else {
                    throw new Error('Invalid data format received');
                }
            })
            .catch(error => {
                console.error('Error loading contacts:', error);
                if (!append) {
                    contactsList.innerHTML = `
                    <div class="p-3 text-center text-danger">
                        Error loading contacts. Please try again.
                    </div>`;
                }
            })
            .finally(() => {
                isLoadingContacts = false;
            });
        }

        // Add scroll listeners for infinite scrolling
        const contactsListDiv = document.getElementById('contactsList');
        const messagesContainerDiv = document.getElementById('messagesContainer');

        // Contacts infinite scroll
        contactsListDiv.addEventListener('scroll', () => {
            if (contactsListDiv.scrollHeight - contactsListDiv.scrollTop <= contactsListDiv.clientHeight + 100) {
                loadContacts(true);
            }
        });

        // Messages infinite scroll (loading older messages when scrolling up)
        messagesContainerDiv.addEventListener('scroll', () => {
            if (messagesContainerDiv.scrollTop <= 100 && hasMoreMessages && currentContactId) {
                const oldScrollHeight = messagesContainerDiv.scrollHeight;
                
                loadChat(currentContactId, true);
                
                // Use requestAnimationFrame to maintain scroll position after DOM update
                requestAnimationFrame(() => {
                    const newScrollHeight = messagesContainerDiv.scrollHeight;
                    messagesContainerDiv.scrollTop = newScrollHeight - oldScrollHeight;
                });
            }
        });

        // Reset pages when loading new contact
        function resetPagination() {
            currentMessagesPage = 1;
            hasMoreMessages = true;
            isLoadingMessages = false;
        }

        // Initial load of contacts
        loadContacts();
    });
</script>