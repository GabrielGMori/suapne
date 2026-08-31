@props(['name', 'length' => 6])

<div {{ $attributes->only('class') }} x-data="otpInput({{ $length }}, {{ $errors->has($name) ? 'true' : 'false' }})">
    <div class="flex justify-center gap-3" x-ref="container">
        @for ($i = 0; $i < $length; $i++)
            <input
                type="text"
                inputmode="numeric"
                maxlength="1"
                x-ref="digit{{ $i }}"
                x-model="digits[{{ $i }}]"
                @input="onInput({{ $i }}, $event)"
                @keydown.backspace="onBackspace({{ $i }}, $event)"
                @paste="onPaste($event)"
                :class="hasError
                    ? 'border-error text-error focus:ring-error/50 focus:border-error'
                    : 'text-white border-white focus:ring-white/50 focus:border-white'"
                class="w-12 h-14 text-center text-2xl font-semibold bg-transparent border rounded-md shadow-sm focus:outline-none focus:ring-2 transition-all duration-200"
                autocomplete="one-time-code"
            >
        @endfor
    </div>

    <input type="hidden" name="{{ $name }}" x-ref="hiddenCode">

    @error($name)
        <p class="text-center text-error mt-3 text-sm">{{ $message }}</p>
    @enderror
</div>

<script>
    function otpInput(length, initialError) {
        return {
            digits: Array(length).fill(''),
            hasError: initialError,

            onInput(index, event) {
                const value = event.target.value.replace(/[^0-9]/g, '');
                this.digits[index] = value;
                this.hasError = false;

                if (value && index < length - 1) {
                    this.$refs[`digit${index + 1}`].focus();
                }

                this.syncHidden();
            },

            onBackspace(index, event) {
                if (!this.digits[index] && index > 0) {
                    this.$refs[`digit${index - 1}`].focus();
                }
            },

            onPaste(event) {
                event.preventDefault();
                const pasted = (event.clipboardData.getData('text') || '')
                    .replace(/[^0-9]/g, '')
                    .slice(0, length);

                pasted.split('').forEach((char, i) => {
                    this.digits[i] = char;
                });

                this.hasError = false;
                this.syncHidden();

                const lastIndex = Math.min(pasted.length, length - 1);
                this.$refs[`digit${lastIndex}`]?.focus();
            },

            syncHidden() {
                this.$refs.hiddenCode.value = this.digits.join('');
            },
        }
    }
</script>
