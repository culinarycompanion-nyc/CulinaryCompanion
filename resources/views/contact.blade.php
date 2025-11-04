<x-layout>
    <div class="mx-auto text-center pt-6">
        <h1 class="text-[clamp(1.7rem,4vw,2.4rem)] font-['Trueno',sans-serif]">Contact Us</h1>
    </div>

    <div class="flex items-center justify-center p-4">
        <form id="contactForm" method="POST" action="/contact/submit"
            class="w-full max-w-lg bg-white rounded-lg shadow-md p-6">
            @csrf

            @if(session('success'))
                <div class="mb-4 text-green-600 text-center font-medium">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 text-red-600 text-center font-medium">
                    Please correct the errors below and try again.
                </div>
            @endif

            <!-- Mode Toggle Buttons -->
            <div class="mb-4 flex space-x-4 justify-center">
                <button type="button" id="feedbackBtn"
                    class="mode-btn bg-indigo-100 text-indigo-700 font-medium px-4 py-2 rounded-md border border-indigo-300 hover:bg-indigo-200 transition">
                    Feedback / Suggestion
                </button>
                <button type="button" id="joinBtn"
                    class="mode-btn bg-gray-100 text-gray-700 font-medium px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-200 transition">
                    Join Us
                </button>
            </div>

            <!-- Mode Message -->
            <div id="modeMessage" class="mb-6 text-sm text-gray-600 text-center">
                Share your thoughts or suggestions to help us improve!
            </div>

            <!-- Hidden Input for Mode -->
            <input type="hidden" name="form_mode" id="formMode" value="{{ old('form_mode', 'feedback') }}" />

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 mb-1">
                    Name <span class="text-red-500" id="nameRequired">*</span>
                </label>
                <input id="name" name="name" type="text" placeholder="Your name" value="{{ old('name') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-400" />
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 mb-1">
                    Email <span class="text-red-500" id="emailRequired">*</span>
                </label>
                <input id="email" name="email" type="email" placeholder="you@example.com" value="{{ old('email') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-400" />
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Message -->
            <div class="mb-6">
                <label for="message" class="block text-gray-700 mb-1">
                    Message <span class="text-red-500">*</span>
                </label>
                <textarea id="message" name="message" rows="4" placeholder="Your message..." required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-400 resize-none">{{ old('message') }}</textarea>
                @error('message')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-indigo-500 text-white py-2 rounded-md hover:bg-indigo-600 transition">
                Submit
            </button>
        </form>
    </div>

    <!-- JavaScript -->
    <script>
        const feedbackBtn = document.getElementById('feedbackBtn');
        const joinBtn = document.getElementById('joinBtn');
        const nameField = document.getElementById('name');
        const emailField = document.getElementById('email');
        const nameRequired = document.getElementById('nameRequired');
        const emailRequired = document.getElementById('emailRequired');
        const modeMessage = document.getElementById('modeMessage');
        const formMode = document.getElementById('formMode');

        function setMode(mode) {
            formMode.value = mode;

            if (mode === 'join') {
                nameField.setAttribute('required', 'required');
                emailField.setAttribute('required', 'required');
                nameRequired.style.display = 'inline';
                emailRequired.style.display = 'inline';
                modeMessage.textContent = "Interested in featuring your restaurant on our site? We'd love to hear from you.";

                joinBtn.classList.add('bg-indigo-100', 'text-indigo-700', 'border-indigo-300');
                joinBtn.classList.remove('bg-gray-100', 'text-gray-700', 'border-gray-300');
                feedbackBtn.classList.add('bg-gray-100', 'text-gray-700', 'border-gray-300');
                feedbackBtn.classList.remove('bg-indigo-100', 'text-indigo-700', 'border-indigo-300');
            } else {
                nameField.removeAttribute('required');
                emailField.removeAttribute('required');
                nameRequired.style.display = 'none';
                emailRequired.style.display = 'none';
                modeMessage.textContent = "Share your thoughts or suggestions to help us improve!";

                feedbackBtn.classList.add('bg-indigo-100', 'text-indigo-700', 'border-indigo-300');
                feedbackBtn.classList.remove('bg-gray-100', 'text-gray-700', 'border-gray-300');
                joinBtn.classList.add('bg-gray-100', 'text-gray-700', 'border-gray-300');
                joinBtn.classList.remove('bg-indigo-100', 'text-indigo-700', 'border-indigo-300');
            }
        }

        feedbackBtn.addEventListener('click', () => setMode('feedback'));
        joinBtn.addEventListener('click', () => setMode('join'));

        window.addEventListener('DOMContentLoaded', () => setMode(formMode.value));
    </script>
</x-layout>