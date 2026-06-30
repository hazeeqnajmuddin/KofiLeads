<header class="fixed top-0 w-full bg-brand-navy border-b-4 border-brand-gold z-50 shadow-sm font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20"> <!-- Slightly taller for breathing room -->
            
            <!-- Logo Area -->
            <div class="flex-shrink-0 flex items-center">
                <a href="/" class="flex flex-col justify-center">
                    <!-- Serif font for the main brand name, changed to white to match footer -->
                    <span class="text-2xl font-serif font-bold text-white uppercase tracking-widest leading-none mb-1">
                        Rahmah
                    </span>
                    <!-- Sans-serif with wide tracking for the subtitle, remains gold -->
                    <span class="text-[0.65rem] font-sans font-bold text-brand-gold uppercase text-spacing-wide leading-none">
                        Consultancy Services
                    </span>
                </a>
            </div>
            
            <!-- Desktop Navigation (Hidden on Mobile) -->
            <nav class="hidden md:flex space-x-8 items-center">
                <a href="#services" class="text-gray-300 hover:text-brand-gold transition-colors duration-200 font-medium">Servis</a>
                <a href="#stats" class="text-gray-300 hover:text-brand-gold transition-colors duration-200 font-medium">Statistik</a>
                <a href="#faqs" class="text-gray-300 hover:text-brand-gold transition-colors duration-200 font-medium">Soalan Lazim</a>
                
                <!-- Highlighted CTA Button - Changed to Gold to stand out against Navy -->
                <a href="#contact" class="bg-brand-gold text-white hover:bg-white hover:text-brand-navy transition-colors duration-200 px-5 py-2.5 rounded shadow-sm font-semibold text-sm">
                    Semak Kelayakan
                </a>
            </nav>

            <!-- Mobile Menu Button -->
            <div class="flex items-center md:hidden">
                <button type="button" class="text-white hover:text-brand-gold focus:outline-none focus:ring-2 focus:ring-brand-gold focus:ring-offset-2 focus:ring-offset-brand-navy rounded-md p-2 transition-colors duration-200" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Hamburger Icon -->
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
            
        </div>
    </div>
</header>