<form method="post" action="{{ route('password.update') }}" class="ps-form">
    @csrf
    @method('put')

    <div class="ps-field">
        <label class="ps-label" for="update_password_current_password">
            Password Saat Ini <span class="ps-required">*</span>
        </label>
        <input type="password" id="update_password_current_password" name="current_password" class="ps-input"
            autocomplete="current-password" required>
        @if ($errors->updatePassword->has('current_password'))
            <p class="ps-error">
                @foreach ($errors->updatePassword->get('current_password') as $error)
                    {{ $error }}
                @endforeach
            </p>
        @endif
    </div>

    <div class="ps-field">
        <label class="ps-label" for="update_password_password">
            Password Baru <span class="ps-required">*</span>
        </label>
        <input type="password" id="update_password_password" name="password" class="ps-input"
            autocomplete="new-password" required>
        <p class="ps-hint">Gunakan kombinasi huruf, angka, dan simbol untuk keamanan maksimal.</p>
        @if ($errors->updatePassword->has('password'))
            <p class="ps-error">
                @foreach ($errors->updatePassword->get('password') as $error)
                    {{ $error }}
                @endforeach
            </p>
        @endif
    </div>

    <div class="ps-field">
        <label class="ps-label" for="update_password_password_confirmation">
            Konfirmasi Password Baru <span class="ps-required">*</span>
        </label>
        <input type="password" id="update_password_password_confirmation" name="password_confirmation" class="ps-input"
            autocomplete="new-password" required>
        @if ($errors->updatePassword->has('password_confirmation'))
            <p class="ps-error">
                @foreach ($errors->updatePassword->get('password_confirmation') as $error)
                    {{ $error }}
                @endforeach
            </p>
        @endif
    </div>

    <div class="ps-btn-group">
        <button type="submit" class="ps-btn ps-btn--primary">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            Ubah Password
        </button>
    </div>
</form>
