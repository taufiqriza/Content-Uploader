<x-page-layout title="Kebijakan Privasi" description="Kebijakan privasi Al-Amani Content Hub">
    <!-- Hero -->
    <section class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 text-white py-12 relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
            <h1 class="text-3xl font-bold mb-2">Kebijakan Privasi</h1>
            <p class="text-blue-200">Terakhir diperbarui: {{ date('d F Y') }}</p>
        </div>
    </section>

    <!-- Content -->
    <section class="max-w-3xl mx-auto px-4 py-12">
        <div class="bg-white rounded-2xl shadow-lg p-8 prose prose-blue max-w-none">
            <h2>1. Informasi yang Kami Kumpulkan</h2>
            <p>Kami mengumpulkan informasi berikut:</p>
            <ul>
                <li><strong>Informasi Akun:</strong> Nama, email, dan password terenkripsi</li>
                <li><strong>Token Platform:</strong> Token OAuth dari platform sosial media yang Anda hubungkan (terenkripsi)</li>
                <li><strong>Data Konten:</strong> File yang Anda unggah dan metadata terkait</li>
                <li><strong>Data Penggunaan:</strong> Log aktivitas dan statistik penggunaan</li>
            </ul>

            <h2>2. Bagaimana Kami Menggunakan Informasi</h2>
            <p>Informasi Anda digunakan untuk:</p>
            <ul>
                <li>Menyediakan dan meningkatkan Layanan</li>
                <li>Mempublikasikan konten ke platform yang Anda pilih</li>
                <li>Mengirim notifikasi terkait status publikasi</li>
                <li>Memberikan dukungan pelanggan</li>
            </ul>

            <h2>3. Keamanan Data</h2>
            <p>
                Kami menerapkan langkah-langkah keamanan industri standar untuk melindungi data Anda:
            </p>
            <ul>
                <li>Token OAuth dienkripsi menggunakan enkripsi AES-256</li>
                <li>File disimpan di Cloudflare R2 dengan akses terbatas</li>
                <li>Koneksi menggunakan HTTPS</li>
                <li>Password di-hash menggunakan bcrypt</li>
            </ul>

            <h2>4. Berbagi Informasi</h2>
            <p>
                Kami <strong>TIDAK</strong> menjual, menyewakan, atau membagikan informasi pribadi Anda 
                kepada pihak ketiga untuk tujuan pemasaran. Kami hanya membagikan informasi:
            </p>
            <ul>
                <li>Ke platform sosial media sesuai permintaan Anda (untuk publikasi)</li>
                <li>Jika diwajibkan oleh hukum</li>
                <li>Untuk melindungi hak dan keselamatan pengguna</li>
            </ul>

            <h2>5. Penyimpanan Data</h2>
            <p>
                Data Anda disimpan selama akun Anda aktif. Jika Anda menghapus akun, data akan dihapus 
                dalam waktu 30 hari, kecuali jika diwajibkan oleh hukum untuk disimpan lebih lama.
            </p>

            <h2>6. Hak Anda</h2>
            <p>Anda memiliki hak untuk:</p>
            <ul>
                <li>Mengakses dan mengunduh data Anda</li>
                <li>Memperbarui informasi akun</li>
                <li>Menghapus akun dan data Anda</li>
                <li>Mencabut akses ke platform sosial media</li>
            </ul>

            <h2>7. Cookies</h2>
            <p>
                Kami menggunakan cookies untuk menjaga sesi login dan preferensi pengguna. 
                Kami tidak menggunakan cookies untuk pelacakan iklan.
            </p>

            <h2>8. Perubahan Kebijakan</h2>
            <p>
                Kami dapat memperbarui Kebijakan Privasi ini. Perubahan signifikan akan 
                diumumkan melalui email.
            </p>

            <h2>9. Kontak</h2>
            <p>
                Untuk pertanyaan tentang privasi, hubungi kami di 
                <a href="mailto:privacy@alamani.edu.my">privacy@alamani.edu.my</a>.
            </p>
        </div>
    </section>
</x-page-layout>
