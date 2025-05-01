<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Privacy Policy') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <section class="bg-white p-8 rounded-2xl shadow-lg">
            <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-3">Privacy Policy</h1>

            <div class="space-y-6 text-gray-700 leading-relaxed">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">1. Information We Collect</h2>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li><strong>Contact Information:</strong> Name, phone number, email address</li>
                        <li><strong>Appointment Details:</strong> Date, time, services requested</li>
                        <li><strong>Payment Information:</strong> Card details (processed through secure third-party services)</li>
                        <li><strong>Feedback or Reviews</strong></li>
                        <li><strong>Photos:</strong> With your consent, we may take pictures of nail art for social media or portfolios</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">2. How We Use Your Information</h2>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li>Book and confirm appointments</li>
                        <li>Respond to inquiries and provide customer support</li>
                        <li>Improve our services and customer experience</li>
                        <li>Comply with legal or regulatory requirements</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">3. Sharing Your Information</h2>
                    <p>We do not sell or rent your personal data. We may share it with:</p>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li><strong>Service Providers:</strong> For booking, marketing, and payment processing</li>
                        <li><strong>Legal Authorities:</strong> When required to comply with legal obligations</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">4. Data Storage and Security</h2>
                    <p>We implement appropriate technical and organizational measures to protect your personal information from unauthorized access, alteration, disclosure, or destruction.</p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">5. Your Rights</h2>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li>Access, correct, or delete your personal data</li>
                        <li>Withdraw consent at any time</li>
                        <li>Lodge a complaint with a data protection authority</li>
                    </ul>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
