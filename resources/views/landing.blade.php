@extends('layouts.main')

@section('title', 'Home - AppLogo')

@section('content')
    <!-- 1. Hero / Title Section -->
    <section class="bg-indigo-50 py-20 px-4 sm:px-6 lg:px-8 text-center">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 sm:text-5xl mb-6">
                Build Something Amazing
            </h1>
            <p class="text-lg text-slate-600 mb-8">
                A simple, powerful, and mobile-first approach to solving your everyday problems. Let's get started.
            </p>
            <a href="#contact" class="inline-block bg-indigo-600 text-white font-semibold px-6 py-3 rounded-lg shadow-md hover:bg-indigo-700 transition">
                Get Started
            </a>
        </div>
    </section>

    <!-- 2. Our Services -->
    <section id="services" class="py-16 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-12">Our Services</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service Card -->
                <div class="p-6 bg-slate-50 rounded-xl shadow-sm border border-slate-100">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center mb-4">
                        <!-- Placeholder Icon -->
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V5h2v4z"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Service One</h3>
                    <p class="text-slate-600 text-sm">High-quality service delivery tailored directly to your mobile needs.</p>
                </div>
                <!-- Duplicate cards for more services... -->
            </div>
        </div>
    </section>

    <!-- 3. Stats and Facts -->
    <section id="stats" class="py-16 px-4 bg-indigo-600 text-white text-center">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="flex flex-col">
                    <span class="text-4xl font-extrabold mb-2">10k+</span>
                    <span class="text-indigo-200 text-sm">Active Users</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-4xl font-extrabold mb-2">99%</span>
                    <span class="text-indigo-200 text-sm">Uptime</span>
                </div>
                <!-- Add more stats as needed -->
            </div>
        </div>
    </section>

    <!-- 4. Customers / Testimony -->
    <section class="py-16 px-4 bg-white">
        <div class="max-w-md mx-auto md:max-w-4xl text-center">
            <h2 class="text-3xl font-bold mb-10">What People Say</h2>
            <div class="bg-slate-50 p-8 rounded-2xl shadow-sm italic text-slate-700 mb-6 border border-slate-100">
                "This platform completely changed how we handle our workflow on the go. The mobile experience is flawless."
            </div>
            <div class="font-semibold text-slate-900">- Jane Doe, CEO of TechCorp</div>
        </div>
    </section>

    <!-- 5. FAQs -->
    <section id="faqs" class="py-16 px-4 bg-slate-50">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-10">Frequently Asked Questions</h2>
            <div class="space-y-4">
                <!-- FAQ Item (Static UI for now) -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">
                    <h3 class="font-semibold text-lg mb-2">How does pricing work?</h3>
                    <p class="text-slate-600 text-sm">Our pricing is highly flexible. Contact us below for a tailored quote based on your usage.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Form & Contact (Combined) -->
    <section id="contact" class="py-16 px-4 bg-white border-t border-slate-100">
        <div class="max-w-xl mx-auto">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold mb-4">Get in Touch</h2>
                <p class="text-slate-600 text-sm">Email: hello@applogo.com | Phone: +60 12-345 6789</p>
            </div>
            
            <form action="#" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Name</label>
                    <input type="text" id="name" name="name" class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" required>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" required>
                </div>
                <div>
                    <label for="message" class="block text-sm font-medium text-slate-700 mb-1">Message</label>
                    <textarea id="message" name="message" rows="4" class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" required></textarea>
                </div>
                <button type="submit" class="w-full bg-indigo-600 text-white font-semibold py-3 px-4 rounded-md shadow-sm hover:bg-indigo-700 transition">
                    Send Message
                </button>
            </form>
        </div>
    </section>
@endsection