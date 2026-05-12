@php
    $me = auth()->user();
    $mePhoto = $me->profile_photo
        ? asset('storage/' . $me->profile_photo)
        : asset('backend/assets/img/doctors-dashboard/doctor-profile-img.jpg');
    $meName = 'Dr ' . $me->first_name . ' ' . $me->last_name;
    $openWith = request()->query('with');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Messages — Doccure</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('backend/assets/img/favicon.png') }}" type="image/x-icon">
    <script src="{{ asset('backend/assets/js/theme-script.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('backend/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/iconsax.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/custom.css') }}">
    <style>
        .chat-empty-state{display:flex;flex-direction:column;align-items:center;justify-content:center;height:100%;color:#9e9e9e;}
        .chat-empty-state i{font-size:4rem;margin-bottom:1rem;opacity:.4;}
        .contact-search-wrap{padding:12px 16px;}
        .online-row{display:flex;gap:10px;overflow-x:auto;padding:6px 16px 10px;}
        .online-row::-webkit-scrollbar{height:4px;}
        .online-row::-webkit-scrollbar-thumb{background:#ddd;border-radius:4px;}
        .chat-img-preview{padding:6px 16px;}
        .chat-img-preview img{max-height:90px;border-radius:8px;}
        .chat-img-preview .remove-img-btn{cursor:pointer;color:#dc3545;margin-left:8px;font-size:.85rem;}
        .msg-image img{max-width:220px;max-height:220px;border-radius:8px;display:block;margin-top:4px;}
        .user-list-item.active{background:rgba(var(--bs-primary-rgb),.07);}
        #middle{display:flex;flex-direction:column;min-height:0;}
        #activeChatArea{display:flex;flex-direction:column;flex:1;min-height:0;}
        .chat-body-scroll{flex:1;overflow-y:auto;padding:16px;}
        .chat-body-scroll .messages{display:flex;flex-direction:column;gap:4px;}
    </style>
</head>
<body class="main-chat-blk">

<div class="main-wrapper">

    @include('doctor.body.header')

    <div class="page-wrapper chat-page-wrapper">
        <div class="container">
            <div class="content doctor-content">
                <div class="chat-sec">

                    {{-- ── LEFT SIDEBAR ──────────────────────────────── --}}
                    <div class="sidebar-group left-sidebar chat_sidebar">
                        <div id="chats" class="left-sidebar-wrap sidebar active slimscroll">
                            <div class="slimscroll-active-sidebar">

                                {{-- Title --}}
                                <div class="left-chat-title all-chats">
                                    <div class="setting-title-head">
                                        <h4>All Chats</h4>
                                    </div>
                                    <div class="add-section">
                                        <div class="user-chat-search contact-search-wrap">
                                            <span class="form-control-feedback"><i class="fa-solid fa-magnifying-glass"></i></span>
                                            <input type="text" id="contactSearch" placeholder="Search" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                {{-- Online Now --}}
                                <div id="onlineSection" class="top-online-contacts" style="display:none;">
                                    <div class="fav-title">
                                        <h6>Online Now</h6>
                                    </div>
                                    <div class="online-row" id="onlineRow"></div>
                                </div>

                                {{-- Contact List --}}
                                <div class="sidebar-body chat-body" id="chatsidebar">
                                    <div class="d-flex justify-content-between align-items-center ps-0 pe-0">
                                        <div class="fav-title pin-chat"><h6>Recent Chat</h6></div>
                                    </div>
                                    <ul class="user-list" id="contactList">
                                        <li class="text-center py-4 text-muted">
                                            <small>Loading chats...</small>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- ── /LEFT SIDEBAR ─────────────────────────────── --}}

                    {{-- ── MAIN CHAT AREA ────────────────────────────── --}}
                    <div class="chat chat-messages" id="middle">

                        {{-- Empty state --}}
                        <div class="chat-empty-state" id="noChatSelected">
                            <i class="fa-regular fa-comments"></i>
                            <h6 class="text-muted">Select a patient to start chatting</h6>
                            <p class="text-muted fs-14">Only patients with completed appointments are listed.</p>
                        </div>

                        {{-- Active chat --}}
                        <div id="activeChatArea" style="display:none;">

                            {{-- Header --}}
                            <div class="chat-inner-header">
                                <div class="chat-header">
                                    <div class="user-details">
                                        <div class="d-lg-none">
                                            <a class="text-muted px-0 left_sides" href="#" data-chat="open">
                                                <i class="fas fa-arrow-left"></i>
                                            </a>
                                        </div>
                                        <figure class="avatar" id="chatHeaderAvatar">
                                            <img src="" id="chatHeaderImg" alt="image" style="width:48px;height:48px;border-radius:50%;object-fit:cover;">
                                        </figure>
                                        <div class="mt-1 ms-2">
                                            <h5 id="chatHeaderName"></h5>
                                            <small id="chatHeaderStatus" class="last-seen"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Messages --}}
                            <div class="slimscroll chat-body-scroll" id="msgScroll">
                                <div class="chat-body">
                                    <div class="messages" id="messagesContainer"></div>
                                </div>
                            </div>

                            {{-- Image Preview --}}
                            <div class="chat-img-preview d-none" id="imgPreviewWrap">
                                <img id="imgPreviewImg" src="" alt="preview">
                                <span class="remove-img-btn" id="removeImgBtn">
                                    <i class="fa-solid fa-times"></i> Remove
                                </span>
                            </div>

                            {{-- Footer --}}
                            <div class="chat-footer">
                                <form id="sendForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="smile-foot">
                                        <label for="imgInput" class="action-circle mb-0" title="Attach Image" style="cursor:pointer;">
                                            <i class="fa-solid fa-image"></i>
                                        </label>
                                        <input type="file" id="imgInput" accept="image/jpeg,image/png,image/gif,image/webp" style="display:none;">
                                    </div>
                                    <input type="text" id="msgBody" class="form-control chat_form" placeholder="Type your message here...">
                                    <div class="form-buttons">
                                        <button class="btn send-btn" type="submit">
                                            <i class="fa-solid fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                        {{-- /Active chat --}}

                    </div>
                    {{-- ── /MAIN CHAT AREA ───────────────────────────── --}}

                </div>
            </div>
        </div>
    </div>

</div>

<script src="{{ asset('backend/assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/script.js') }}"></script>

<script>
$(function () {

    /* ── Configuration ─────────────────────────────────────── */
    var CSRF           = '{{ csrf_token() }}';
    var ME_PHOTO       = '{{ $mePhoto }}';
    var ME_NAME        = '{{ addslashes($meName) }}';
    var CONTACTS_URL   = '{{ route("chat.contacts") }}';
    var MESSAGES_BASE  = '{{ url("chat/messages") }}';
    var SEND_BASE      = '{{ url("chat/send") }}';
    var HEARTBEAT_URL  = '{{ route("chat.heartbeat") }}';
    var INITIAL_WITH   = {{ $openWith ? (int)$openWith : 'null' }};

    /* ── State ─────────────────────────────────────────────── */
    var activeContactId    = null;
    var activeContactName  = '';
    var activeContactPhoto = '';
    var lastMsgId          = 0;
    var currentDate        = '';
    var renderedIds        = new Set(); // dedup guard: prevents poll + send racing

    /* ── Init ──────────────────────────────────────────────── */
    heartbeat();
    loadContacts();
    setInterval(pollMessages,   3000);
    setInterval(loadContacts,  10000);
    setInterval(heartbeat,     30000);

    /* ── Contact search ────────────────────────────────────── */
    $('#contactSearch').on('input', function () {
        var val = $(this).val().toLowerCase();
        $('#contactList li[data-id]').each(function () {
            $(this).toggle($(this).find('h5').text().toLowerCase().includes(val));
        });
    });

    /* ── Heartbeat ─────────────────────────────────────────── */
    function heartbeat() {
        $.post(HEARTBEAT_URL, { _token: CSRF });
    }

    /* ── Load contacts ─────────────────────────────────────── */
    function loadContacts() {
        $.get(CONTACTS_URL, function (contacts) {
            renderContacts(contacts);
            renderOnlineRow(contacts.filter(function (c) { return c.is_online; }));

            if (INITIAL_WITH && !activeContactId) {
                var found = contacts.find(function (c) { return c.id == INITIAL_WITH; });
                if (found) { openChat(found); INITIAL_WITH = null; }
            }
        });
    }

    /* ── Render contact list ───────────────────────────────── */
    function renderContacts(contacts) {
        if (!contacts.length) {
            $('#contactList').html(
                '<li class="text-center py-4 text-muted">' +
                '<i class="fa-regular fa-comment-dots fa-2x mb-2 d-block opacity-50"></i>' +
                '<small>No patients available for chat.<br>Complete an appointment first.</small></li>'
            );
            return;
        }
        var html = '';
        contacts.forEach(function (c) {
            var onlineCls  = c.is_online ? 'avatar-online' : '';
            var activeCls  = c.id == activeContactId ? 'active' : '';
            var unreadBadge = c.unread_count > 0
                ? '<div class="new-message-count">' + c.unread_count + '</div>' : '';
            var lastMsg = c.last_message
                ? '<p>' + escHtml(c.last_message) + '</p>'
                : '<p class="text-muted fs-13">No messages yet</p>';
            var lastTime = c.last_message_time
                ? '<small class="text-muted">' + c.last_message_time + '</small>' : '';

            html += '<li class="user-list-item ' + activeCls + '" data-id="' + c.id + '"' +
                    ' data-name="' + escAttr(c.name) + '"' +
                    ' data-photo="' + escAttr(c.photo) + '"' +
                    ' data-online="' + (c.is_online ? 1 : 0) + '">' +
                '<a href="javascript:void(0);">' +
                '<div class="avatar ' + onlineCls + '">' +
                '<img src="' + c.photo + '" alt="image" style="width:46px;height:46px;object-fit:cover;border-radius:50%;"></div>' +
                '<div class="users-list-body"><div>' +
                '<h5>' + escHtml(c.name) + '</h5>' + lastMsg + '</div>' +
                '<div class="last-chat-time">' + lastTime + unreadBadge + '</div>' +
                '</div></a></li>';
        });
        $('#contactList').html(html);
    }

    /* ── Render online-now row ─────────────────────────────── */
    function renderOnlineRow(online) {
        if (!online.length) { $('#onlineSection').hide(); return; }
        $('#onlineSection').show();
        var html = online.map(function (c) {
            return '<div class="top-contacts-box" title="' + escAttr(c.name) + '">' +
                '<div class="profile-img online">' +
                '<img src="' + c.photo + '" alt="' + escAttr(c.name) + '" ' +
                'style="width:48px;height:48px;border-radius:50%;object-fit:cover;cursor:pointer;" ' +
                'data-id="' + c.id + '">' +
                '</div></div>';
        }).join('');
        $('#onlineRow').html(html);
    }

    /* ── Click contact in list ─────────────────────────────── */
    $(document).on('click', '.user-list-item', function () {
        openChat({
            id:        $(this).data('id'),
            name:      $(this).data('name'),
            photo:     $(this).data('photo'),
            is_online: $(this).data('online') == 1
        });
    });

    /* ── Click online avatar in top row ────────────────────── */
    $(document).on('click', '#onlineRow img', function () {
        var id = $(this).data('id');
        var $li = $('#contactList li[data-id="' + id + '"]');
        if ($li.length) $li.trigger('click');
    });

    /* ── Open a conversation ───────────────────────────────── */
    function openChat(contact) {
        activeContactId    = contact.id;
        activeContactName  = contact.name;
        activeContactPhoto = contact.photo;
        lastMsgId          = 0;
        currentDate        = '';
        renderedIds        = new Set();

        $('.user-list-item').removeClass('active');
        $('.user-list-item[data-id="' + contact.id + '"]').addClass('active');

        $('#chatHeaderImg').attr('src', contact.photo);
        $('#chatHeaderName').text(contact.name);
        setOnlineStatus(contact.is_online);

        $('#noChatSelected').hide();
        $('#activeChatArea').show();
        $('#messagesContainer').empty();
        $('#imgPreviewWrap').addClass('d-none');
        $('#imgInput').val('');

        fetchMessages();
    }

    /* ── Set online / offline badge ────────────────────────── */
    function setOnlineStatus(isOnline) {
        if (isOnline) {
            $('#chatHeaderAvatar').addClass('avatar-online');
            $('#chatHeaderStatus').text('Online').css('color', '#28a745');
        } else {
            $('#chatHeaderAvatar').removeClass('avatar-online');
            $('#chatHeaderStatus').text('Offline').css('color', '#9e9e9e');
        }
    }

    /* ── Fetch / poll messages ─────────────────────────────── */
    function fetchMessages() {
        if (!activeContactId) return;
        $.get(MESSAGES_BASE + '/' + activeContactId, { after_id: lastMsgId }, function (data) {
            if (data.messages && data.messages.length) {
                appendMessages(data.messages);
                scrollBottom();
            }
            setOnlineStatus(data.is_online);
        });
    }

    function pollMessages() { fetchMessages(); }

    /* ── Append messages ───────────────────────────────────── */
    function appendMessages(msgs) {
        var html = '';
        msgs.forEach(function (msg) {
            if (renderedIds.has(msg.id)) return; // skip duplicates from poll/send race
            renderedIds.add(msg.id);
            if (msg.id > lastMsgId) lastMsgId = msg.id;
            if (msg.date !== currentDate) {
                currentDate = msg.date;
                html += '<div class="chat-line"><span class="chat-date">' + fmtDate(msg.date) + '</span></div>';
            }
            html += msg.mine ? buildOutgoing(msg) : buildIncoming(msg);
        });
        if (html) $('#messagesContainer').append(html);
    }

    /* ── Build incoming bubble ─────────────────────────────── */
    function buildIncoming(msg) {
        return '<div class="chats">' +
            '<div class="chat-avatar">' +
            '<img src="' + activeContactPhoto + '" class="dreams_chat" alt="img" ' +
            'style="width:40px;height:40px;border-radius:50%;object-fit:cover;"></div>' +
            '<div class="chat-content">' +
            '<div class="chat-profile-name">' +
            '<h6>' + escHtml(activeContactName) + '<span>' + msg.time + '</span></h6></div>' +
            '<div class="message-content">' + buildContent(msg) + '</div>' +
            '</div></div>';
    }

    /* ── Build outgoing bubble ─────────────────────────────── */
    function buildOutgoing(msg) {
        return '<div class="chats chats-right">' +
            '<div class="chat-content">' +
            '<div class="chat-profile-name text-end justify-content-end">' +
            '<h6>' + escHtml(ME_NAME) + '<span>' + msg.time + ' <i class="fa-solid fa-check-double green-check"></i></span></h6></div>' +
            '<div class="message-content">' + buildContent(msg) + '</div>' +
            '</div>' +
            '<div class="chat-avatar">' +
            '<img src="' + ME_PHOTO + '" class="dreams_chat" alt="img" ' +
            'style="width:40px;height:40px;border-radius:50%;object-fit:cover;"></div>' +
            '</div>';
    }

    /* ── Build message content (text + optional image) ─────── */
    function buildContent(msg) {
        var out = '';
        if (msg.body) out += '<p style="margin-bottom:' + (msg.image ? '6px' : '0') + ';">' + escHtml(msg.body) + '</p>';
        if (msg.image) {
            out += '<div class="msg-image"><a href="' + msg.image + '" target="_blank">' +
                '<img src="' + msg.image + '" alt="img"></a></div>';
        }
        return out;
    }

    /* ── Send form ─────────────────────────────────────────── */
    $('#sendForm').on('submit', function (e) {
        e.preventDefault();
        if (!activeContactId) return;

        var body = $.trim($('#msgBody').val());
        var file = $('#imgInput')[0].files[0];
        if (!body && !file) return;

        var fd = new FormData();
        fd.append('_token', CSRF);
        if (body) fd.append('body', body);
        if (file) fd.append('image', file);

        $('#msgBody').val('');
        $('#imgInput').val('');
        $('#imgPreviewWrap').addClass('d-none');

        $.ajax({
            url:         SEND_BASE + '/' + activeContactId,
            type:        'POST',
            data:        fd,
            processData: false,
            contentType: false,
            success: function (msg) {
                appendMessages([msg]);
                scrollBottom();
            },
            error: function () {
                alert('Failed to send message. Please try again.');
            }
        });
    });

    /* ── Enter key to send ─────────────────────────────────── */
    $('#msgBody').on('keydown', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            $('#sendForm').trigger('submit');
        }
    });

    /* ── Image attach preview ──────────────────────────────── */
    $('#imgInput').on('change', function () {
        var file = this.files[0];
        if (!file) { $('#imgPreviewWrap').addClass('d-none'); return; }
        var reader = new FileReader();
        reader.onload = function (ev) {
            $('#imgPreviewImg').attr('src', ev.target.result);
            $('#imgPreviewWrap').removeClass('d-none');
        };
        reader.readAsDataURL(file);
    });

    $('#removeImgBtn').on('click', function () {
        $('#imgInput').val('');
        $('#imgPreviewWrap').addClass('d-none');
    });

    /* ── Utilities ─────────────────────────────────────────── */
    function scrollBottom() {
        var el = document.getElementById('msgScroll');
        if (el) el.scrollTop = el.scrollHeight;
    }

    function escHtml(str) {
        if (!str) return '';
        return $('<div>').text(str).html();
    }

    function escAttr(str) {
        if (!str) return '';
        return str.replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    }

    function fmtDate(d) {
        var dt   = new Date(d);
        var now  = new Date();
        var yest = new Date(now); yest.setDate(yest.getDate() - 1);
        if (dt.toDateString() === now.toDateString())  return 'Today';
        if (dt.toDateString() === yest.toDateString()) return 'Yesterday';
        return dt.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
    }

});
</script>
</body>
</html>
