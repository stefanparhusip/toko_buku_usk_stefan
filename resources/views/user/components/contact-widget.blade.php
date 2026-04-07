<style>
    .help-fab {
        position: fixed;
        right: 18px;
        bottom: 18px;
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
        text-decoration: none;
        box-shadow: 0 12px 26px rgba(14, 120, 58, 0.34);
        z-index: 1060;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
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
        .help-fab {
            width: 72px;
            height: 72px;
            font-size: 0.67rem;
        }
    }
</style>

<a
    href="https://wa.me/6282114662588?text=Halo%20admin%203bieStore,%20saya%20ingin%20bertanya%20tentang%20buku."
    class="help-fab"
    target="_blank"
    rel="noopener noreferrer"
    aria-label="Tanya di sini lewat WhatsApp"
>
    <svg viewBox="0 0 24 24" aria-hidden="true">
        <path d="M19.05 4.94A9.94 9.94 0 0 0 12.02 2c-5.5 0-9.98 4.47-9.98 9.98 0 1.76.46 3.49 1.34 5.03L2 22l5.14-1.35a9.96 9.96 0 0 0 4.88 1.24h.01c5.5 0 9.98-4.47 9.98-9.98 0-2.67-1.04-5.18-2.96-6.97zM12.03 20.2h-.01a8.26 8.26 0 0 1-4.2-1.15l-.3-.18-3.05.8.82-2.97-.2-.3a8.27 8.27 0 0 1-1.27-4.4c0-4.56 3.71-8.27 8.28-8.27 2.2 0 4.26.86 5.82 2.42a8.2 8.2 0 0 1 2.43 5.84c0 4.56-3.71 8.27-8.27 8.27zm4.54-6.2c-.25-.12-1.46-.72-1.69-.81-.22-.08-.39-.12-.55.13-.17.24-.64.8-.79.96-.14.17-.29.18-.54.06-.25-.12-1.04-.38-1.98-1.2-.73-.65-1.23-1.45-1.37-1.69-.14-.24-.01-.37.1-.49.1-.1.25-.29.37-.43.13-.15.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.12-.55-1.33-.76-1.82-.2-.49-.4-.42-.55-.43h-.47c-.17 0-.43.06-.66.31s-.86.84-.86 2.04c0 1.2.88 2.35 1 2.51.12.17 1.72 2.63 4.17 3.68.58.25 1.04.4 1.39.51.58.18 1.1.15 1.51.09.46-.07 1.46-.6 1.67-1.17.2-.58.2-1.08.14-1.18-.05-.09-.21-.14-.46-.26z"/>
    </svg>
    Tanya<br>di sini
</a>
