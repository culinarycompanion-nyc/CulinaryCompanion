<x-html>

    <div class="bg-gray-100 flex flex-col items-center min-h-screen px-4">
        <!-- Logo and Message Section -->
        <div class="text-center mb-6 mt-8">
            <img src="{{ asset("assets/s_logo.png") }}" alt="Site Logo" class="mx-auto h-[20vh] w-auto mb-4">
            <p class="text-lg text-gray-800">
                <strong>Stay Tuned! Coming Soon!</strong><br>
                Use admin password to have an early look.
            </p>
        </div>

        <!-- Password Form Section -->
        <div class="w-full max-w-sm p-6 bg-white rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-center mb-6">Enter Site Password</h2>
            <form method="POST" action="/password" class="space-y-4">
                @csrf
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" required
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                @error('password')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
                    Enter
                </button>
            </form>
        </div>
    </div>

</x-html>