<form method="post" action="{{ route('password.update') }}" class="form-section">
    @csrf
    @method('put')

    <div class="field-group">
        <label class="field-label">Password Saat Ini <span class="field-required">*</span></label>
        <input type="password" id="update_password_current_password" name="current_password" class="field-input"
            autocomplete="current-password" required>
        @if ($errors->updatePassword->has('current_password'))
            <p class="field-error">
                @foreach ($errors->updatePassword->get('current_password') as $error)
                    {{ $error }}
                @endforeach
            </p>
        @endif
    </div>

    <div class="field-group">
        <label class="field-label">Password Baru <span class="field-required">*</span></label>
        <input type="password" id="update_password_password" name="password" class="field-input"
            autocomplete="new-password" required>
        <p class="field-hint">Gunakan kombinasi huruf, angka, dan simbol untuk keamanan maksimal.</p>
        @if ($errors->updatePassword->has('password'))
            <p class="field-error">
                @foreach ($errors->updatePassword->get('password') as $error)
                    {{ $error }}
                @endforeach
            </p>
        @endif
    </div>

    <div class="field-group">
        <label class="field-label">Konfirmasi Password Baru <span class="field-required">*</span></label>
        <input type="password" id="update_password_password_confirmation" name="password_confirmation"
            class="field-input" autocomplete="new-password" required>
        @if ($errors->updatePassword->has('password_confirmation'))
            <p class="field-error">
                @foreach ($errors->updatePassword->get('password_confirmation') as $error)
                    {{ $error }}
                @endforeach
            </p>
        @endif
    </div>

    <div class="button-group">
        <button type="submit" class="btn-primary">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            Ubah Password
        </button>
    </div>
</form>
