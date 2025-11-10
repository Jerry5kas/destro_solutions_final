<header class="admin-header">
    <div class="header-left">
        <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle menu">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>
    
    <div class="header-right">
        <div class="user-selector">
            <div class="user-avatar-small">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <span class="user-name-small">{{ auth()->user()->name }}</span>
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
        
        <div class="notification-wrapper" data-notification-wrapper>
            <button type="button" class="notification-bell" aria-label="Notifications" data-notification-toggle>
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="notification-dot hidden" data-notification-dot></span>
                <span class="notification-count hidden" data-notification-count></span>
            </button>

            <div class="notification-panel hidden" data-notification-panel>
                <div class="notification-panel__header">
                    <span>{{ __('Notifications') }}</span>
                    <button type="button" class="notification-panel__mark-all" data-notification-mark-all>
                        {{ __('Mark all as read') }}
                    </button>
                </div>
                <div class="notification-panel__body">
                    <ul class="notification-list" data-notification-list></ul>
                    <div class="notification-empty hidden" data-notification-empty>
                        <p>{{ __("You're all caught up!") }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <form method="POST" action="{{ route('admin.logout') }}" style="display: inline;">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </div>
</header>

@once
    @push('styles')
<style>
    .notification-wrapper {
        position: relative;
    }

    .notification-bell {
        position: relative;
        padding: 0.625rem;
        cursor: pointer;
        border-radius: 10px;
        transition: all 0.2s ease;
        color: #6b7280;
        border: none;
        background: transparent;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .notification-bell:hover,
    .notification-bell[aria-expanded="true"] {
        background: #f9fafb;
        color: #0D0DE0;
    }

    .notification-dot {
        position: absolute;
        top: 0.35rem;
        right: 0.35rem;
        width: 10px;
        height: 10px;
        background: #ef4444;
        border-radius: 50%;
        border: 2px solid #fff;
        animation: pulse 2s infinite;
    }

    .notification-count {
        position: absolute;
        top: 0.2rem;
        right: -0.35rem;
        min-width: 18px;
        height: 18px;
        background: #ef4444;
        color: #fff;
        border-radius: 999px;
        font-size: 0.65rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 0.25rem;
        border: 2px solid #fff;
        line-height: 1;
    }

    .notification-panel {
        position: absolute;
        top: calc(100% + 0.75rem);
        right: 0;
        width: 320px;
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.15);
        border: 1px solid #e5e7eb;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        z-index: 1000;
    }

    .notification-panel__header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #f1f5f9;
        font-weight: 600;
        color: #111827;
        font-size: 0.95rem;
    }

    .notification-panel__mark-all {
        font-size: 0.75rem;
        font-weight: 600;
        color: #0D0DE0;
        background: transparent;
        border: none;
        cursor: pointer;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        transition: background 0.2s ease;
    }

    .notification-panel__mark-all:hover {
        background: rgba(13, 13, 224, 0.08);
    }

    .notification-panel__body {
        max-height: 360px;
        overflow-y: auto;
    }

    .notification-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .notification-item {
        padding: 0.85rem 1rem;
        border-bottom: 1px solid #f3f4f6;
        transition: background 0.2s ease;
        cursor: pointer;
        display: block;
    }

    .notification-item:last-child {
        border-bottom: none;
    }

    .notification-item:hover {
        background: #f8fafc;
    }

    .notification-item--unread {
        background: rgba(13, 13, 224, 0.05);
    }

    .notification-item__title {
        font-size: 0.85rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 0.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
    }

    .notification-item__message {
        font-size: 0.8rem;
        color: #475569;
        line-height: 1.4;
    }

    .notification-item__time {
        font-size: 0.7rem;
        color: #94a3b8;
        font-weight: 500;
        white-space: nowrap;
    }

    .notification-empty {
        text-align: center;
        padding: 2rem 1.5rem;
        color: #94a3b8;
        font-size: 0.85rem;
    }
    .notification-empty p {
        margin: 0;
    }
</style>
    @endpush
@endonce

@once
    @push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const wrapper = document.querySelector('[data-notification-wrapper]');
        if (!wrapper || typeof window.axios === 'undefined') {
            return;
        }

        const toggleButton = wrapper.querySelector('[data-notification-toggle]');
        const panel = wrapper.querySelector('[data-notification-panel]');
        const dot = wrapper.querySelector('[data-notification-dot]');
        const countBadge = wrapper.querySelector('[data-notification-count]');
        const markAllBtn = wrapper.querySelector('[data-notification-mark-all]');
        const list = wrapper.querySelector('[data-notification-list]');
        const emptyState = wrapper.querySelector('[data-notification-empty]');

        let notifications = [];
        let pollingTimer = null;

        const endpoints = {
            index: @json(route('admin.notifications.index')),
            markRead: (id) => @json(route('admin.notifications.read', ':id')).replace(':id', id),
            markAll: @json(route('admin.notifications.read_all')),
        };

        const escapeHtml = (value) => {
            if (typeof value !== 'string') {
                return '';
            }

            return value
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        };

        function closePanel() {
            if (!panel.classList.contains('hidden')) {
                panel.classList.add('hidden');
                toggleButton.setAttribute('aria-expanded', 'false');
            }
        }

        function openPanel() {
            if (panel.classList.contains('hidden')) {
                panel.classList.remove('hidden');
                toggleButton.setAttribute('aria-expanded', 'true');
            }
        }

        function togglePanel() {
            if (panel.classList.contains('hidden')) {
                openPanel();
            } else {
                closePanel();
            }
        }

        function renderNotifications() {
            if (!notifications.length) {
                emptyState.classList.remove('hidden');
                list.innerHTML = '';
            } else {
                emptyState.classList.add('hidden');
                list.innerHTML = notifications.map((notification) => {
                    const { id, data, read_at: readAt, time_ago: timeAgo } = notification;
                    const unreadClass = readAt ? '' : 'notification-item--unread';
                    const safeTitle = escapeHtml(data?.title ?? 'Notification');
                    const safeMessage = escapeHtml(data?.message ?? '');
                    const rawActionUrl = typeof data?.action_url === 'string' ? data.action_url : '';
                    const actionUrl = escapeHtml(rawActionUrl);

                    const wrapperTagOpen = actionUrl
                        ? `<a href="${actionUrl}" class="notification-item ${unreadClass}" data-notification-id="${id}" data-notification-action="${actionUrl}" data-notification-read="${readAt ? '1' : ''}">`
                        : `<div class="notification-item ${unreadClass}" data-notification-id="${id}" data-notification-read="${readAt ? '1' : ''}">`;
                    const wrapperTagClose = actionUrl ? '</a>' : '</div>';

                    return `
                        ${wrapperTagOpen}
                            <div class="notification-item__title">
                                <span>${safeTitle}</span>
                                <span class="notification-item__time">${timeAgo ?? ''}</span>
                            </div>
                            <div class="notification-item__message">${safeMessage}</div>
                        ${wrapperTagClose}
                    `;
                }).join('');
            }
        }

        function updateIndicators(unreadCount) {
            if (unreadCount > 0) {
                dot.classList.remove('hidden');
                countBadge.classList.remove('hidden');
                countBadge.textContent = unreadCount > 99 ? '99+' : unreadCount;
            } else {
                dot.classList.add('hidden');
                countBadge.classList.add('hidden');
                countBadge.textContent = '';
            }
        }

        async function fetchNotifications() {
            try {
                const { data } = await window.axios.get(endpoints.index, {
                    headers: { Accept: 'application/json' },
                });

                notifications = data.notifications ?? [];
                renderNotifications();
                updateIndicators(Number(data.unread_count ?? 0));
            } catch (error) {
                console.error('Unable to load notifications', error);
            }
        }

        async function markNotificationAsRead(id) {
            const target = notifications.find((item) => item.id === id);
            if (!target || target.read_at) {
                return;
            }

            try {
                await window.axios.post(endpoints.markRead(id), {}, {
                    headers: { Accept: 'application/json' },
                });

                target.read_at = new Date().toISOString();
                renderNotifications();
                const unreadCount = notifications.filter((item) => !item.read_at).length;
                updateIndicators(unreadCount);
            } catch (error) {
                console.error('Unable to update notification', error);
            }
        }

        async function markAllNotificationsAsRead() {
            try {
                await window.axios.post(endpoints.markAll, {}, {
                    headers: { Accept: 'application/json' },
                });

                notifications = notifications.map((notification) => ({
                    ...notification,
                    read_at: notification.read_at ?? new Date().toISOString(),
                }));
                renderNotifications();
                updateIndicators(0);
            } catch (error) {
                console.error('Unable to mark notifications as read', error);
            }
        }

        toggleButton.addEventListener('click', () => {
            togglePanel();
        });

        document.addEventListener('click', (event) => {
            if (!wrapper.contains(event.target)) {
                closePanel();
            }
        });

        list.addEventListener('click', async (event) => {
            const item = event.target.closest('[data-notification-id]');
            if (!item) {
                return;
            }

            const notificationId = item.getAttribute('data-notification-id');
            const actionUrl = item.getAttribute('data-notification-action');

            if (!item.getAttribute('data-notification-read')) {
                await markNotificationAsRead(notificationId);
                item.setAttribute('data-notification-read', '1');
            }

            if (actionUrl) {
                event.preventDefault();
                window.location.href = actionUrl;
            }
        });

        if (markAllBtn) {
            markAllBtn.addEventListener('click', (event) => {
                event.preventDefault();
                markAllNotificationsAsRead();
            });
        }

        fetchNotifications();
        pollingTimer = window.setInterval(fetchNotifications, 10000);

        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'visible') {
                fetchNotifications();
            }
        });

        window.addEventListener('beforeunload', () => {
            if (pollingTimer) {
                window.clearInterval(pollingTimer);
            }
        });
    });
</script>
    @endpush
@endonce

