<style>
    .help-fab-wrap {
        position: fixed;
        right: 18px;
        bottom: 18px;
        z-index: 1060;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 10px;
    }

    .help-popup {
        width: clamp(230px, 28vw, 286px);
        max-width: calc(100vw - 24px);
        background: linear-gradient(165deg, #10284f, #0c1f3f 66%);
        color: #fff;
        border-radius: 16px;
        box-shadow: 0 16px 32px rgba(9, 24, 53, 0.32);
        border: 1px solid rgba(255, 255, 255, 0.18);
        padding: 14px;
        opacity: 0;
        transform: translateY(10px);
        visibility: hidden;
        pointer-events: none;
        transition: opacity 0.25s ease, transform 0.25s ease, visibility 0.25s ease;
    }

    .help-popup.is-open {
        opacity: 1;
        transform: translateY(0);
        visibility: visible;
        pointer-events: auto;
    }

    .help-popup-title {
        margin: 0;
        font-size: 0.98rem;
        font-weight: 700;
        letter-spacing: 0.15px;
    }

    .help-popup-sub {
        margin: 4px 0 12px;
        font-size: 0.78rem;
        color: rgba(255, 255, 255, 0.8);
    }

    .help-action {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        text-decoration: none;
        border-radius: 11px;
        padding: 10px 12px;
        font-size: 0.86rem;
        font-weight: 600;
        transition: transform 0.22s ease, filter 0.22s ease;
    }

    .help-action + .help-action {
        margin-top: 8px;
    }

    .help-action:hover {
        transform: translateY(-1px);
    }

    .help-action-web {
        background: #ffffff;
        color: #0d2347;
    }

    .help-action-web:hover {
        filter: brightness(0.96);
        color: #0d2347;
    }

    .help-action-wa {
        background: linear-gradient(145deg, #1fa855, #0f8a43);
        color: #ffffff;
    }

    .help-action-wa:hover {
        filter: brightness(1.03);
        color: #ffffff;
    }

    .help-fab {
        width: 78px;
        height: 78px;
        border-radius: 50%;
        border: 3px solid #fff;
        background: linear-gradient(145deg, #1fa855, #0f8a43);
        color: #fff;
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.15rem;
        text-align: center;
        font-size: 0.7rem;
        font-weight: 600;
        line-height: 1.08;
        box-shadow: 0 12px 26px rgba(14, 120, 58, 0.34);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        cursor: pointer;
    }

    .help-fab:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 28px rgba(14, 120, 58, 0.4);
        color: #fff;
    }

    .help-fab svg {
        width: 18px;
        height: 18px;
        fill: currentColor;
    }

    @media (max-width: 991px) {
        .help-fab-wrap {
            right: 12px;
            bottom: 12px;
        }

        .help-popup {
            width: min(300px, calc(100vw - 24px));
        }

        .help-fab {
            width: 72px;
            height: 72px;
            font-size: 0.67rem;
        }
    }
</style>

<div class="help-fab-wrap" data-help-widget>
    <div class="help-popup" data-help-popup aria-hidden="true">
        <h4 class="help-popup-title">Hubungi Kami</h4>
        <p class="help-popup-sub">Pilih cara komunikasi yang paling nyaman.</p>

        <a href="{{ url('/chat') }}" class="help-action help-action-web">💬 Chat di Website</a>
        <a
            href="https://wa.me/6282114662588"
            class="help-action help-action-wa"
            target="_blank"
            rel="noopener noreferrer"
        >🟢 Chat via WhatsApp</a>
    </div>

    <button type="button" class="help-fab" data-help-toggle aria-expanded="false" aria-controls="helpPopup" aria-label="Buka pilihan bantuan">
        <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M19.05 4.94A9.94 9.94 0 0 0 12.02 2c-5.5 0-9.98 4.47-9.98 9.98 0 1.76.46 3.49 1.34 5.03L2 22l5.14-1.35a9.96 9.96 0 0 0 4.88 1.24h.01c5.5 0 9.98-4.47 9.98-9.98 0-2.67-1.04-5.18-2.96-6.97zM12.03 20.2h-.01a8.26 8.26 0 0 1-4.2-1.15l-.3-.18-3.05.8.82-2.97-.2-.3a8.27 8.27 0 0 1-1.27-4.4c0-4.56 3.71-8.27 8.28-8.27 2.2 0 4.26.86 5.82 2.42a8.2 8.2 0 0 1 2.43 5.84c0 4.56-3.71 8.27-8.27 8.27zm4.54-6.2c-.25-.12-1.46-.72-1.69-.81-.22-.08-.39-.12-.55.13-.17.24-.64.8-.79.96-.14.17-.29.18-.54.06-.25-.12-1.04-.38-1.98-1.2-.73-.65-1.23-1.45-1.37-1.69-.14-.24-.01-.37.1-.49.1-.1.25-.29.37-.43.13-.15.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.12-.55-1.33-.76-1.82-.2-.49-.4-.42-.55-.43h-.47c-.17 0-.43.06-.66.31s-.86.84-.86 2.04c0 1.2.88 2.35 1 2.51.12.17 1.72 2.63 4.17 3.68.58.25 1.04.4 1.39.51.58.18 1.1.15 1.51.09.46-.07 1.46-.6 1.67-1.17.2-.58.2-1.08.14-1.18-.05-.09-.21-.14-.46-.26z"/>
        </svg>
        Tanya<br>di sini
    </button>
</div>

<script>
    (function () {
        const widget = document.querySelector('[data-help-widget]');
        if (!widget) {
            return;
        }

        const popup = widget.querySelector('[data-help-popup]');
        const toggle = widget.querySelector('[data-help-toggle]');

        if (!popup || !toggle) {
            return;
        }

        const setOpen = function (isOpen) {
            popup.classList.toggle('is-open', isOpen);
            popup.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        };

        toggle.addEventListener('click', function (event) {
            event.preventDefault();
            const willOpen = !popup.classList.contains('is-open');
            setOpen(willOpen);
        });

        document.addEventListener('click', function (event) {
            if (!popup.classList.contains('is-open')) {
                return;
            }

            if (widget.contains(event.target)) {
                return;
            }

            setOpen(false);
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                setOpen(false);
            }
        });
    })();
</script>
