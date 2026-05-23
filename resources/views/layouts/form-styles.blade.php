{{-- Shared form styles — include at bottom of any view using sp-form --}}
<style>
    :root {
        --bg-base: #F7F6F3;
        --bg-surface: #FFFFFF;
        --border: #E8E6E1;
        --border-soft: #F0EDE8;
        --text-primary: #1A1916;
        --text-secondary: #6B6860;
        --text-muted: #A09D97;
        --accent: #D97706;
        --accent-hover: #B45309;
        --font-mono: 'DM Mono', monospace;
        --radius-sm: 6px;
        --radius-md: 10px;
        --radius-lg: 14px;
        --transition: 150ms cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* --- Page shell --- */
    .form-page {
        max-width: 900px;
    }

    /* --- Breadcrumb --- */
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 28px;
        font-size: 13px;
        color: var(--text-muted);
    }

    .bc-link {
        color: var(--text-secondary);
        text-decoration: none;
    }

    .bc-link:hover {
        color: var(--accent);
    }

    .bc-current {
        color: var(--text-primary);
        font-weight: 500;
    }

    /* --- Page header --- */
    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 24px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .page-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--text-primary);
        letter-spacing: -0.02em;
    }

    .page-sub {
        font-size: 13px;
        color: var(--text-secondary);
        margin-top: 2px;
    }

    /* --- Layout --- */
    .form-layout {
        display: grid;
        grid-template-columns: 1fr 260px;
        gap: 20px;
        align-items: start;
    }

    /* --- Card --- */
    .form-card {
        background: var(--bg-surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 28px 28px 24px;
    }

    .form-card-header {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border-soft);
    }

    .form-card-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #FEF3C7;
        color: var(--accent);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .form-card-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-primary);
    }

    .form-card-sub {
        font-size: 13px;
        color: var(--text-secondary);
        margin-top: 2px;
    }

    /* --- Form elements --- */
    .sp-form {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .form-row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .field-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .field-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-secondary);
        letter-spacing: 0.02em;
    }

    .field-required {
        color: var(--accent);
    }

    .field-input,
    .field-select {
        width: 100%;
        padding: 9px 12px;
        font-size: 13.5px;
        font-family: inherit;
        color: var(--text-primary);
        background: var(--bg-surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        outline: none;
        transition: border-color var(--transition), box-shadow var(--transition);
        appearance: none;
    }

    .field-input:focus,
    .field-select:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.1);
    }

    .field-input::placeholder {
        color: var(--text-muted);
    }

    .field-mono {
        font-family: var(--font-mono);
        font-size: 12.5px;
    }

    .field-hint {
        font-size: 11.5px;
        color: var(--text-muted);
    }

    .field-hint code {
        font-family: var(--font-mono);
        font-size: 11px;
        background: var(--bg-base);
        padding: 1px 5px;
        border-radius: 4px;
    }

    /* Custom select arrow */
    .field-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23A09D97' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 36px;
    }

    /* --- Form actions --- */
    .form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 6px;
        padding-top: 18px;
        border-top: 1px solid var(--border-soft);
    }

    /* --- Shared buttons --- */
    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 20px;
        border-radius: var(--radius-md);
        font-size: 13px;
        font-weight: 600;
        color: #fff;
        background: var(--accent);
        border: none;
        text-decoration: none;
        cursor: pointer;
        transition: background var(--transition);
    }

    .btn-primary:hover {
        background: var(--accent-hover);
    }

    .btn-ghost-sm {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: var(--radius-md);
        font-size: 13px;
        font-weight: 500;
        color: var(--text-secondary);
        background: transparent;
        border: 1px solid var(--border);
        text-decoration: none;
        cursor: pointer;
        transition: all var(--transition);
    }

    .btn-ghost-sm:hover {
        background: var(--bg-base);
        color: var(--text-primary);
    }

    .btn-danger-sm {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: var(--radius-md);
        font-size: 12px;
        font-weight: 600;
        color: #DC2626;
        background: transparent;
        border: 1px solid #FECACA;
        cursor: pointer;
        transition: all var(--transition);
        margin-top: 12px;
        width: 100%;
        justify-content: center;
    }

    .btn-danger-sm:hover {
        background: #FEF2F2;
        border-color: #FCA5A5;
    }

    /* --- Error box --- */
    .error-box {
        display: flex;
        gap: 10px;
        padding: 13px 16px;
        border-radius: var(--radius-md);
        background: #FFF1F2;
        border: 1px solid #FECDD3;
        margin-bottom: 20px;
    }

    .error-box-icon {
        color: #DC2626;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .error-box-title {
        font-size: 13px;
        font-weight: 600;
        color: #BE123C;
        margin-bottom: 4px;
    }

    .error-box-item {
        font-size: 12.5px;
        color: #9F1239;
        margin-top: 2px;
    }

    /* --- Toast success --- */
    .toast-success {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 12px 16px;
        border-radius: var(--radius-md);
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
        color: #15803D;
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 20px;
    }

    /* --- Aside cards --- */
    .form-aside {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .aside-card {
        background: var(--bg-surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 18px 20px;
    }

    .aside-card-amber {
        background: #FFFBEB;
        border-color: #FDE68A;
    }

    .aside-card-danger {
        background: #FFF1F2;
        border-color: #FECDD3;
    }

    .aside-title {
        font-size: 12px;
        font-weight: 700;
        color: var(--text-primary);
        letter-spacing: 0.04em;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    .aside-desc {
        font-size: 12.5px;
        color: var(--text-secondary);
        line-height: 1.6;
        margin-bottom: 4px;
    }

    .aside-list {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 7px;
        padding: 0;
    }

    .aside-list li {
        font-size: 12.5px;
        color: var(--text-secondary);
        line-height: 1.55;
        padding-left: 12px;
        position: relative;
    }

    .aside-list li::before {
        content: '—';
        position: absolute;
        left: 0;
        color: var(--accent);
        font-size: 11px;
    }

    .aside-meta {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .aside-meta-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .aside-meta-key {
        font-size: 11.5px;
        color: var(--text-muted);
    }

    .aside-meta-val {
        font-size: 12px;
        color: var(--text-primary);
        font-weight: 500;
    }

    .aside-meta-val code {
        font-family: var(--font-mono);
        font-size: 11px;
        background: var(--bg-base);
        padding: 1px 6px;
        border-radius: 4px;
    }

    .rtsp-example {
        display: block;
        margin-top: 6px;
        font-family: var(--font-mono);
        font-size: 11px;
        line-height: 1.7;
        color: var(--accent-hover);
        word-break: break-all;
    }

    /* --- Badges (reused in edit aside) --- */
    .badge-green {
        display: inline-flex;
        font-size: 11px;
        font-weight: 600;
        color: #15803D;
        background: #DCFCE7;
        padding: 2px 8px;
        border-radius: 99px;
    }

    .badge-red {
        display: inline-flex;
        font-size: 11px;
        font-weight: 600;
        color: #B91C1C;
        background: #FEE2E2;
        padding: 2px 8px;
        border-radius: 99px;
    }

    @media (max-width: 720px) {
        .form-layout {
            grid-template-columns: 1fr;
        }

        .form-row-2 {
            grid-template-columns: 1fr;
        }
    }
</style>
