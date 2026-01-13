<x-page-layout title="Kontak" description="Hubungi tim Al-Amani Content Hub">
    <!-- Hero -->
    <section class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 text-white py-16 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32"></div>
        <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
            <h1 class="text-3xl lg:text-4xl font-bold mb-4">Hubungi Kami</h1>
            <p class="text-blue-200 text-lg">Kami senang mendengar dari Anda</p>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="max-w-5xl mx-auto px-4 py-12">
        <div class="grid md:grid-cols-2 gap-8 -mt-12 relative z-20">
            <!-- Contact Info -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Informasi Kontak</h2>
                
                <div class="space-y-6">
                    <!-- WhatsApp -->
                    <a href="https://wa.me/601112134277" target="_blank" class="flex items-center gap-4 p-4 bg-green-50 rounded-xl hover:bg-green-100 transition group">
                        <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                            <i class="fab fa-whatsapp text-white text-2xl"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 group-hover:text-green-700">WhatsApp</p>
                            <p class="text-gray-600 text-sm">+60 11-1213 4277</p>
                        </div>
                        <i class="fas fa-arrow-right text-gray-400 ml-auto group-hover:text-green-600 group-hover:translate-x-1 transition"></i>
                    </a>

                    <!-- Email -->
                    <a href="mailto:support@alamani.edu.my" class="flex items-center gap-4 p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition group">
                        <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-envelope text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 group-hover:text-blue-700">Email</p>
                            <p class="text-gray-600 text-sm">support@alamani.edu.my</p>
                        </div>
                        <i class="fas fa-arrow-right text-gray-400 ml-auto group-hover:text-blue-600 group-hover:translate-x-1 transition"></i>
                    </a>

                    <!-- Website -->
                    <a href="https://alamani.edu.my" target="_blank" class="flex items-center gap-4 p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition group">
                        <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-globe text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 group-hover:text-purple-700">Website</p>
                            <p class="text-gray-600 text-sm">alamani.edu.my</p>
                        </div>
                        <i class="fas fa-arrow-right text-gray-400 ml-auto group-hover:text-purple-600 group-hover:translate-x-1 transition"></i>
                    </a>

                    <!-- Location -->
                    <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl">
                        <div class="w-12 h-12 bg-gray-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Alamat</p>
                            <p class="text-gray-600 text-sm">
                                Madrasah Tahfiz Al-Amani<br>
                                Kg. Chegar Permai, Pekan<br>
                                26600 Pahang, Malaysia
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="mt-8 pt-6 border-t border-gray-100">
                    <p class="font-semibold text-gray-900 mb-4">Ikuti Kami</p>
                    <div class="flex gap-3">
                        <a href="https://instagram.com/alamani_my" target="_blank" class="w-10 h-10 bg-gradient-to-br from-pink-500 to-orange-500 rounded-lg flex items-center justify-center text-white hover:opacity-80 transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://youtube.com/@alamani_my" target="_blank" class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center text-white hover:opacity-80 transition">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="https://tiktok.com/@alamani_my" target="_blank" class="w-10 h-10 bg-gray-900 rounded-lg flex items-center justify-center text-white hover:opacity-80 transition">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <a href="https://facebook.com/alamanitahfiz" target="_blank" class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white hover:opacity-80 transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan</h2>
                
                <form action="#" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama</label>
                        <input type="text" name="name" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Nama Anda">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <input type="email" name="email" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="nama@email.com">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Subjek</label>
                        <select name="subject" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="">Pilih subjek</option>
                            <option value="general">Pertanyaan Umum</option>
                            <option value="support">Bantuan Teknis</option>
                            <option value="billing">Billing & Pembayaran</option>
                            <option value="partnership">Kerjasama</option>
                            <option value="feedback">Saran & Masukan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Pesan</label>
                        <textarea name="message" rows="5" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition resize-none"
                            placeholder="Tulis pesan Anda..."></textarea>
                    </div>

                    <button type="submit" 
                        class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition flex items-center justify-center gap-2">
                        <span>Kirim Pesan</span>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </section>
</x-page-layout>
