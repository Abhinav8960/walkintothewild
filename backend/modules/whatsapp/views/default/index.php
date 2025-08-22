<?php

use support\assets\WhatsappAsset;
/* @var $this yii\web\View */

$this->title = 'WhatsApp Chat Panel';
WhatsappAsset::register($this);

// Get the S3 endpoint from Yii application parameters
$s3Endpoint = \Yii::$app->params['s3_endpoint'] ?? '';
?>


<div class="container-fluid" style="margin-top: 100px;">
    <div class="row chat-container shadow-sm rounded">
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
            </div>
        </div>

        <div class="col-md-8 col-lg-9 p-0">
            <div id="chatPlaceholder" class="chat-placeholder">
                <div class="chat-placeholder-content">
                    <i class="bi bi-chat-dots" style="font-size: 3rem;"></i>
                    <h4 class="mt-3">Select a contact to start messaging</h4>
                </div>
            </div>

            <div id="chatbox" style="display: none;">
                <div class="chat-messages">
                    <div class="p-3 bg-white border-bottom" id="chatHeader">
                        <div class="d-flex align-items-center">
                            <div class="profile-circle me-3 d-flex align-items-center justify-content-center" id="currentContactInitial"></div>
                            <div>
                                <h6 class="mb-0" id="currentContactName">Select a contact</h6>
                                <small class="text-muted" id="currentContactStatus">offline</small>
                            </div>
                        </div>
                    </div>

                    <div class="messages-container" id="messagesContainer">
                    </div>

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


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

<script>
    // Define the S3 endpoint in a JavaScript variable
    const S3_ENDPOINT = '<?= $s3Endpoint ?>';

    // Helper functions for location messages
    function copyToClipboard(text) {
        if (navigator.clipboard && window.isSecureContext) {
            // Use the modern Clipboard API
            navigator.clipboard.writeText(text).then(() => {
                // Show a temporary success message
                showToast('Coordinates copied to clipboard!');
            }).catch(err => {
                console.error('Failed to copy: ', err);
                fallbackCopyToClipboard(text);
            });
        } else {
            // Fallback for older browsers
            fallbackCopyToClipboard(text);
        }
    }

    function fallbackCopyToClipboard(text) {
        const textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.position = "fixed";
        textArea.style.opacity = "0";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();

        try {
            document.execCommand('copy');
            showToast('Coordinates copied to clipboard!');
        } catch (err) {
            console.error('Fallback: Failed to copy', err);
            showToast('Failed to copy coordinates');
        }

        document.body.removeChild(textArea);
    }

    function showToast(message, type = 'success') {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast-message toast-${type}`;
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#28a745' : '#dc3545'};
            color: white;
            padding: 12px 20px;
            border-radius: 4px;
            z-index: 9999;
            font-size: 14px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            transform: translateX(100%);
            transition: transform 0.3s ease;
        `;
        toast.textContent = message;

        document.body.appendChild(toast);

        // Animate in
        setTimeout(() => {
            toast.style.transform = 'translateX(0)';
        }, 100);

        // Remove after 3 seconds
        setTimeout(() => {
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (toast.parentNode) {
                    document.body.removeChild(toast);
                }
            }, 300);
        }, 3000);
    }

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

        // Enhanced renderMessages function with location support
        function renderMessages(messages, append = false) {
            const messagesContainer = document.getElementById('messagesContainer');
            let currentDate = '';

            const messagesList = messages.map(message => {
                const messageDate = new Date(message.created_at);
                const dateStr = formatMessageDate(messageDate);
                let dateSeparator = '';
                let messageContentHtml = '';

                // Add date separator if date changes
                if (dateStr !== currentDate) {
                    currentDate = dateStr;
                    dateSeparator = `
                        <div class="date-separator">
                            <span>${dateStr}</span>
                        </div>
                    `;
                }

                if (message.message_type === 'text' || message.message_type === 'template') {
                    messageContentHtml = `<div class="message-text">${message.content}</div>`;
                } else if (message.message_type === 'location') {
                    // Handle location messages
                    let latitude, longitude, locationName = '';

                    try {
                        // If location data is stored in content as JSON
                        if (message.content) {
                            const locationData = JSON.parse(message.content);
                            latitude = locationData.latitude || locationData.lat;
                            longitude = locationData.longitude || locationData.lng || locationData.long;
                            locationName = locationData.name || locationData.address || '';
                        }

                        // If latitude and longitude are separate fields in the message object
                        if (!latitude && !longitude) {
                            latitude = message.latitude;
                            longitude = message.longitude;
                            locationName = message.location_name || message.address || '';
                        }

                        if (latitude && longitude) {
                            const googleMapsUrl = `https://www.google.com/maps?q=${latitude},${longitude}`;
                            const staticMapUrl = `https://maps.googleapis.com/maps/api/staticmap?center=${latitude},${longitude}&zoom=15&size=300x200&markers=color:red%7C${latitude},${longitude}&key=YOUR_GOOGLE_MAPS_API_KEY`;

                            messageContentHtml = `
                                <div class="media-container location-container">
                                    <div class="location-preview mb-2">
                                        <img src="${staticMapUrl}" 
                                             alt="Location Map" 
                                             style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px; cursor: pointer;"
                                             onclick="window.open('${googleMapsUrl}', '_blank')"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                        <div style="display: none; padding: 20px; text-align: center; background: #f0f2f5; border-radius: 8px; cursor: pointer;" onclick="window.open('${googleMapsUrl}', '_blank')">
                                            <i class="bi bi-geo-alt-fill" style="font-size: 2rem; color: #007bff;"></i>
                                            <div class="mt-2">Click to open location</div>
                                        </div>
                                    </div>
                                    <div class="location-info">
                                        ${locationName ? `<div class="location-name fw-bold mb-1">${locationName}</div>` : ''}
                                        <div class="location-coordinates text-muted small mb-2">
                                            ${parseFloat(latitude).toFixed(6)}, ${parseFloat(longitude).toFixed(6)}
                                        </div>
                                        <div class="location-actions">
                                            <a href="${googleMapsUrl}" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                                                <i class="bi bi-geo-alt-fill"></i> Open in Google Maps
                                            </a>
                                            <button class="btn btn-sm btn-outline-secondary" onclick="copyToClipboard('${latitude},${longitude}')">
                                                <i class="bi bi-clipboard"></i> Copy Coordinates
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `;
                        } else {
                            // Fallback if coordinates are not available
                            messageContentHtml = `
                                <div class="location-error">
                                    <i class="bi bi-geo-alt text-muted"></i>
                                    <span class="text-muted">Location not available</span>
                                </div>
                            `;
                        }
                    } catch (error) {
                        console.error('Error parsing location data:', error);
                        messageContentHtml = `
                            <div class="location-error">
                                <i class="bi bi-geo-alt text-muted"></i>
                                <span class="text-muted">Invalid location data</span>
                            </div>
                        `;
                    }
                } else if (message.media_url) {
                    // Handle other media types
                    const fullMediaUrl = S3_ENDPOINT + '/' + message.media_url;
                    const downloadLink = `<a href="${fullMediaUrl}" download="${message.file_name || 'download'}" class="download-link"><i class="bi bi-download"></i></a>`;

                    if (message.message_type === 'image') {
                        messageContentHtml = `
                            <div class="media-container media-image">
                                <img src="${fullMediaUrl}" class="img-fluid rounded" alt="Image">
                                ${downloadLink}
                            </div>
                        `;
                    } else if (message.message_type === 'video') {
                        messageContentHtml = `
                            <div class="media-container media-video">
                                <video controls class="w-100 rounded">
                                    <source src="${fullMediaUrl}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                ${downloadLink}
                            </div>
                        `;
                    } else if (message.message_type === 'audio') {
                        messageContentHtml = `
                            <div class="media-container media-audio">
                                <audio controls class="w-100">
                                    <source src="${fullMediaUrl}" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                                ${downloadLink}
                            </div>
                        `;
                    } else { // document or other unsupported types
                        messageContentHtml = `
                            <div class="media-container media-document d-flex align-items-center">
                                <i class="bi bi-file-earmark-text-fill document-icon me-2"></i>
                                <span class="document-name">${message.file_name || 'Document'}</span>
                                <a href="${fullMediaUrl}" download="${message.file_name || 'document'}" class="ms-auto"><i class="bi bi-download"></i></a>
                            </div>
                        `;
                    }
                } else {
                    messageContentHtml = `<div class="message-text">${message.content}</div>`;
                }

                return `
                    ${dateSeparator}
                    <div class="message ${message.direction === 'outbound' ? 'sent' : 'received'} mb-2">
                        <div class="message-content p-2 rounded">
                            ${messageContentHtml}
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