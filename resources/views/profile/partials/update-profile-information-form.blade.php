<form id="send-verification" method="post" action="{{ route('verification.send') }}" style="display:none;">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class="ps-form">
    @csrf
    @method('patch')

    <div class="ps-field">
        <label class="ps-label" for="name">Nama Lengkap <span class="ps-required">*</span></label>
        <input type="text" id="name" name="name" class="ps-input" value="{{ old('name', $user->name) }}"
            required autofocus autocomplete="name">
        @if ($errors->has('name'))
            <p class="ps-error">
                @foreach ($errors->get('name') as $error)
                    {{ $error }}
                @endforeach
            </p>
        @endif
    </div>

    <div class="ps-field">
        <label class="ps-label" for="email">Email <span class="ps-required">*</span></label>
        <input type="email" id="email" name="email" class="ps-input" value="{{ old('email', $user->email) }}"
            required autocomplete="username">
        @if ($errors->has('email'))
            <p class="ps-error">
                @foreach ($errors->get('email') as $error)
                    {{ $error }}
                @endforeach
            </p>
        @endif

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div class="ps-verify">
                <p>⚠️ Email Anda belum diverifikasi.</p>
                <button type="submit" form="send-verification" class="ps-btn ps-btn--primary"
                    style="height:30px; font-size:12px; padding:0 12px;">
                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Kirim ulang link verifikasi
                </button>
            </div>
        @endif
    </div>

    <div class="ps-btn-group">
        <button type="submit" class="ps-btn ps-btn--primary">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            Simpan Perubahan
        </button>
    </div>
</form>
