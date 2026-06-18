<form id="send-verification" method="post" action="{{ route('verification.send') }}" class="hidden">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class="form-section">
    @csrf
    @method('patch')

    <div class="field-group">
        <label class="field-label">Nama Lengkap <span class="field-required">*</span></label>
        <input type="text" id="name" name="name" class="field-input" value="{{ old('name', $user->name) }}"
            required autofocus autocomplete="name">
        @if ($errors->has('name'))
            <p class="field-error">
                @foreach ($errors->get('name') as $error)
                    {{ $error }}
                @endforeach
            </p>
        @endif
    </div>

    <div class="field-group">
        <label class="field-label">Email <span class="field-required">*</span></label>
        <input type="email" id="email" name="email" class="field-input" value="{{ old('email', $user->email) }}"
            required autocomplete="username">
        @if ($errors->has('email'))
            <p class="field-error">
                @foreach ($errors->get('email') as $error)
                    {{ $error }}
                @endforeach
            </p>
        @endif

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div class="verify-notice">
                <p>⚠️ Email Anda belum diverifikasi.</p>
                <button type="submit" form="send-verification" class="btn-primary btn-primary-sm">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Kirim ulang link verifikasi
                </button>
            </div>
        @endif
    </div>

    <div class="button-group">
        <button type="submit" class="btn-primary">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            Simpan Perubahan
        </button>
    </div>
</form>
