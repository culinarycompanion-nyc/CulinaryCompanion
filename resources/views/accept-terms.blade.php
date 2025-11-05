<x-html>

    <body class="bg-gray-100 flex flex-col items-center min-h-screen px-4">
        <!-- Logo and Message Section -->
        <div class="text-center mb-6 mt-8">
            <img src="{{ asset('assets/s_logo.png') }}" alt="Site Logo" class="mx-auto h-[20vh] w-auto mb-4">
            <p class="text-lg text-gray-800">
                *DISCLAIMER: Information from this site is meant to only be used as reference.
                <br>Always make sure to notify the restaurant and your server about your food allergies.
            </p>
        </div>

        <!-- Accept Terms Form Section -->
        <div class="w-full max-w-sm p-6 bg-white rounded-lg shadow-md sm:w-[90%]">
            <h2 class="text-2xl font-semibold text-center mb-6">Accept <a target="_blank" href="/"
                    class="hover:underline text-blue-500">Terms of Use</a></h2>
            <form method="POST" action="/accept-terms" class="space-y-4">
                @csrf
                <button type="submit"
                    class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition duration-200">
                    Accept Terms
                </button>
            </form>
        </div>
    </body>

</x-html>