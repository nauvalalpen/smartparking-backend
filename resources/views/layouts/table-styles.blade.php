{{-- Shared table styles — include at bottom of any view using data-table --}}
<style>
    /* Token bridge (in case not injected by app.blade.php) */
    :root {
        --bg-base: #F7F6F3;
        --bg-surface: #FFFFFF;
        --bg-elevated: #FAFAF8;
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
        --shadow-sm: 0 1px 3px rgba(26, 25, 22, 0.06);
        --transition: 150ms cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* --- Card --- */
    .card {
        background: var(--bg-surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        overflow: hidden;
    }

    /* --- Table --- */
    .table-wrap {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13.5px;
    }

    .data-table thead tr {
        background: var(--bg-base);
        border-bottom: 1px solid var(--border);
    }

    .data-table th {
        padding: 11px 16px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: var(--text-muted);
        text-align: left;
        white-space: nowrap;
    }

    .data-table tbody tr {
        border-bottom: 1px solid var(--border-soft);
        transition: background var(--transition);
    }

    .data-table tbody tr:last-child {
        border-bottom: none;
    }

    .data-table tbody tr:hover {
        background: var(--bg-base);
    }

    .data-table td {
        padding: 13px 16px;
        color: var(--text-primary);
        vertical-align: middle;
    }

    .cell-num {
        font-family: var(--font-mono);
        font-size: 12px;
        color: var(--text-muted);
    }

    .cell-bold {
        font-weight: 600;
    }

    .cell-mono {
        font-family: var(--font-mono);
        font-size: 12px;
        color: var(--text-secondary);
        max-width: 260px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* --- Badges --- */
    .badge-green {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 11px;
        font-weight: 600;
        color: #15803D;
        background: #DCFCE7;
        padding: 3px 9px;
        border-radius: 99px;
        white-space: nowrap;
    }

    .badge-red {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 11px;
        font-weight: 600;
        color: #B91C1C;
        background: #FEE2E2;
        padding: 3px 9px;
        border-radius: 99px;
        white-space: nowrap;
    }

    /* --- Action buttons --- */
    .action-row {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 6px;
    }

    .btn-icon {
        width: 30px;
        height: 30px;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all var(--transition);
        background: transparent;
        text-decoration: none;
    }

    .btn-icon-amber {
        color: var(--accent);
    }

    .btn-icon-amber:hover {
        background: #FEF3C7;
        border-color: #FDE68A;
        color: var(--accent-hover);
    }

    .btn-icon-blue {
        color: #2563EB;
    }

    .btn-icon-blue:hover {
        background: #DBEAFE;
        border-color: #BFDBFE;
    }

    .btn-icon-red {
        color: #DC2626;
    }

    .btn-icon-red:hover {
        background: #FEE2E2;
        border-color: #FECACA;
    }

    /* --- Shared buttons --- */
    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 18px;
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
        padding: 7px 14px;
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

    /* --- Empty state --- */
    .empty-state {
        padding: 64px 32px;
        text-align: center;
    }

    .empty-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: var(--bg-base);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        margin: 0 auto 16px;
    }

    .empty-title {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 4px;
    }

    .empty-sub {
        font-size: 13px;
        color: var(--text-secondary);
    }
</style>
