<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Dashboard</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-gray-400 to-blue-700 text-white py-12 py-3 px-4 sticky top-0 z-50 shadow-md flex items-center justify-between">
        <!-- Logo -->
        <a href="#" class="flex items-center">
            <img src="image/digilab logo.png" alt="Logo" class="w-10 h-10">
        </a>
        
        <!-- Navbar Links -->
         <div class="hidden md:flex space-x-4">
            <a href="#" class="text-white hover:text-blue-300">Beranda</a>
            <a href="#" class="text-white hover:text-blue-300">Layanan</a>
            <a href="#" class="text-white hover:text-blue-300">Download</a>
            <a href="#" class="text-white hover:text-blue-300">Peminjaman</a>
            <a href="#" class="text-white hover:text-blue-300">Pengembalian</a>

        </div>


        <!-- Search and Icons -->
        <div class="flex items-center space-x-3">
            <input type="text" placeholder="Search" class="px-3 py-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <span class="cursor-pointer text-xl">🔍</span>
            <span class="cursor-pointer text-xl">👤</span>
            <span class="cursor-pointer text-xl">🔔</span>
        </div>
    </nav>
    <!-- Hero Section -->
    <div class="bg-gray-300 py-12">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold text-blue-700 mb-4">Selamat Datang di Perpustakaan</h1>
            <p class="text-lg text-gray-700">Temukan koleksi buku terbaik dan terbaru hanya di sini!</p>
        </div>
    </div>
    
    <!-- Content -->
    <div class="container mx-auto py-8">
        
        
        <!DOCTYPE html>
        <html lang="en">
            
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Library Dashboard</title>
                <!-- Tailwind CSS -->
                <script src="https://cdn.tailwindcss.com"></script>
            </head>
            
            <body class="bg-gray-100">
                
                <!-- Carousel -->
                <div id="carouselExample" class="relative mb-6">
                    <!-- Wrapper Gambar -->
                    <div class="flex overflow-x-scroll snap-x snap-mandatory scrollbar-hide">
                        <!-- Slide 1 -->
                        <div class="flex-shrink-0 w-full snap-center relative">
                            <img src="image/perpus8.jpg" class="w-full h-64 object-cover rounded-lg" alt="Slide 1">
                            <div class="absolute bottom-6 left-6 bg-black bg-opacity-50 p-4 rounded-md text-white">
                            <h5 class="text-2xl font-semibold">Selamat Datang di DIGILAB!!</h5>
                            <p>Temukan buku favorit Anda di sini!</p>
                        </div>
                    </div>
                    <!-- Slide 2 -->
                    <div class="flex-shrink-0 w-full snap-center relative">
                        <img src="image/perpus2.jpg" class="w-full h-64 object-cover rounded-lg" alt="Slide 2">
                        <div class="absolute bottom-6 left-6 bg-black bg-opacity-50 p-4 rounded-md text-white">
                            <h5 class="text-2xl font-semibold">Berbagai Koleksi Buku</h5>
                            <p>Jelajahi koleksi buku terbaru kami.</p>
                        </div>
                    </div>
                    <!-- Slide 3 -->
                    <div class="flex-shrink-0 w-full snap-center relative">
                        <img src="image/perpus3.jpg" class="w-full h-64 object-cover rounded-lg" alt="Slide 3">
                        <div class="absolute bottom-6 left-6 bg-black bg-opacity-50 p-4 rounded-md text-white">
                            <h5 class="text-2xl font-semibold">Baca di Mana Saja</h5>
                            <p>Platform yang mendukung mobilitas Anda.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Tombol Navigasi -->
                <button id="prevButton" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700">
                    &lt;
                </button>
                <button id="nextButton" class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700">
                    &gt;
                </button>

                <!-- Indikator Slide -->
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                    <div class="w-3 h-3 bg-blue-600 rounded-full"></div>
                    <div class="w-3 h-3 bg-blue-300 rounded-full"></div>
                    <div class="w-3 h-3 bg-blue-300 rounded-full"></div>
                </div>
            </div>
            
            <!-- Statistik -->
            <div class="bg-white p-6 rounded-md shadow-lg mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                    <div>
                        <h5 class="text-3xl text-blue-600">500+</h5>
                        <p>Buku Tersedia</p>
                    </div>
                    <div>
                        <h5 class="text-3xl text-blue-600">200+</h5>
                        <p>Anggota Terdaftar</p>
                    </div>
                    <div>
                        <h5 class="text-3xl text-blue-600">100+</h5>
                        <p>Peminjaman Bulanan</p>
                    </div>
                </div>
            </div>
            
        </body>
        
        </html>
        <!-- Daftar Buku Terbaru -->
        <div class="mb-6">
            <h4 class="mb-4 text-2xl font-semibold">Buku Terbaru</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-4 rounded-md shadow-lg">
                    <img src="image/wanita.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 1">
                    <h5 class="font-semibold text-xl">Apa yang wanita inginkan</h5>
                    <p class="text-sm">"Apa yang Wanita Inginkan" adalah dongeng Indonesia yang mengajarkan bahwa wanita menginginkan kebebasan, penghargaan, dan hak untuk memilih.</p>
                </div>
                <div class="bg-white p-4 rounded-md shadow-lg">
                    <img src="image/Laut.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 2">
                    <h5 class="font-semibold text-xl">Laut Bebas Sampah</h5>
                    <p class="text-sm">Laut Bebas Sampah adalah konsep untuk menjaga laut tetap bersih dari sampah, terutama plastik, demi melestarikan ekosistem dan keanekaragaman hayati.</p>
                </div>
                <div class="bg-white p-4 rounded-md shadow-lg">
                    <img src="image/sosiologi.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 3">
                    <h5 class="font-semibold text-xl">Buku Ajar Sosiologi</h5>
                    <p class="text-sm">Buku ajar sosiologi membahas konsep-konsep dasar tentang masyarakat, interaksi sosial, budaya, dan perubahan sosial untuk memahami dinamika kehidupan sosial.</p>
                </div>
                <div class="bg-white p-4 rounded-md shadow-lg">
                    <img src="image/raja.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 4">
                    <h5 class="font-semibold text-xl">Raja Jenggot</h5>
                    <p class="text-sm">Pengembaraan seorang raja dalam menyelami kehidupan rakyatnya yang penuh dengan intrik.</p>
                </div>
            </div>
        </div>
        
        <!-- Daftar Buku Populer -->
        <div class="mb-6">
            <h4 class="mb-4 text-2xl font-semibold">Buku Terbaru</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-4 rounded-md shadow-lg">
                    <img src="image/wanita.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 1">
                    <h5 class="font-semibold text-xl">Apa yang wanita inginkan</h5>
                    <p class="text-sm">"Apa yang Wanita Inginkan" adalah dongeng Indonesia yang mengajarkan bahwa wanita menginginkan kebebasan, penghargaan, dan hak untuk memilih.</p>
                </div>
                <div class="bg-white p-4 rounded-md shadow-lg">
                    <img src="image/Laut.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 2">
                    <h5 class="font-semibold text-xl">Laut Bebas Sampah</h5>
                    <p class="text-sm">Laut Bebas Sampah adalah konsep untuk menjaga laut tetap bersih dari sampah, terutama plastik, demi melestarikan ekosistem dan keanekaragaman hayati.</p>
                </div>
                <div class="bg-white p-4 rounded-md shadow-lg">
                    <img src="image/sosiologi.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 3">
                    <h5 class="font-semibold text-xl">Buku Ajar Sosiologi</h5>
                    <p class="text-sm">Buku ajar sosiologi membahas konsep-konsep dasar tentang masyarakat, interaksi sosial, budaya, dan perubahan sosial untuk memahami dinamika kehidupan sosial.</p>
                </div>
                <div class="bg-white p-4 rounded-md shadow-lg">
                    <img src="image/raja.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 4">
                    <h5 class="font-semibold text-xl">Raja Jenggot</h5>
                    <p class="text-sm">Pengembaraan seorang raja dalam menyelami kehidupan rakyatnya yang penuh dengan intrik.</p>
                </div>
            </div>
        </div>
        
        <!-- Daftar Buku Rating Tertinggi -->
        <div class="mb-6">
            <h4 class="mb-4 text-2xl font-semibold">Buku Terbaru</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-4 rounded-md shadow-lg">
                    <img src="image/wanita.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 1">
                    <h5 class="font-semibold text-xl">Apa yang wanita inginkan</h5>
                    <p class="text-sm">"Apa yang Wanita Inginkan" adalah dongeng Indonesia yang mengajarkan bahwa wanita menginginkan kebebasan, penghargaan, dan hak untuk memilih.</p>
                </div>
                <div class="bg-white p-4 rounded-md shadow-lg">
                    <img src="image/Laut.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 2">
                    <h5 class="font-semibold text-xl">Laut Bebas Sampah</h5>
                    <p class="text-sm">Laut Bebas Sampah adalah konsep untuk menjaga laut tetap bersih dari sampah, terutama plastik, demi melestarikan ekosistem dan keanekaragaman hayati.</p>
                </div>
                <div class="bg-white p-4 rounded-md shadow-lg">
                    <img src="image/sosiologi.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 3">
                    <h5 class="font-semibold text-xl">Buku Ajar Sosiologi</h5>
                    <p class="text-sm">Buku ajar sosiologi membahas konsep-konsep dasar tentang masyarakat, interaksi sosial, budaya, dan perubahan sosial untuk memahami dinamika kehidupan sosial.</p>
                </div>
                <div class="bg-white p-4 rounded-md shadow-lg">
                    <img src="image/raja.jpg" class="w-full h-48 object-cover rounded-md mb-4" alt="Buku 4">
                    <h5 class="font-semibold text-xl">Raja Jenggot</h5>
                    <p class="text-sm">Pengembaraan seorang raja dalam menyelami kehidupan rakyatnya yang penuh dengan intrik.</p>
                </div>
            </div>
        </div>
        <div><a href="login.php" class="text-white hover:text-blue-300">Log-in</a>
        <!-- Tombol Login -->
        <div class="text-center py-6">
           <a href="login.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md transition duration-300 ease-in-out">
               Log-in
           </a>
        </div>
    </div>
    
    
</div>
<!-- Footer -->
<footer class="bg-gradient-to-r from-gray-500 to-blue-900 text-white py-12">
    <div class="container mx-auto px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-6 md:space-y-0">
            
            <!-- DIGILAB Section -->
            <div class="text-center md:text-left">
                    <h2 class="text-2xl font-bold tracking-tight">DIGILAB</h2>
                    <p class="mt-2 text-lg">Platform inovatif untuk mengakses koleksi buku secara online dengan mudah.</p>
                </div>

                <!-- Library Partners Section -->
                <div class="mt-4 md:mt-0">
                    <h3 class="text-2xl font-semibold mb-4">Library Partners</h3>
                    <ul class="space-y-3 text-sm md:text-base">
                        <li><a href="#" class="hover:text-blue-200 transition duration-300 ease-in-out">Perpustakaan Nasional</a></li>
                        <li><a href="#" class="hover:text-blue-200 transition duration-300 ease-in-out">Perpustakaan Universitas</a></li>
                    </ul>
                </div>
            </div>

            <!-- Social Media Links -->
            <div class="text-center">
                <h4 class="text-xl font-semibold">Follow Us</h4>
                <div>
                    <a href="#" class="text-white hover:text-blue-200 transition duration-300 ease-in-out">
                        <i class="fab fa-facebook fa-3x"></i>
                    </a>
                    <a href="#" class="text-white hover:text-blue-200 transition duration-300 ease-in-out">
                        <i class="fab fa-youtube fa-2x"></i>
                    </a>
                </div>
            </div>

            <!-- Digilab Website Link -->
            <div class="mt-6 text-center">
                <p class="text-blue-100 hover:text-blue-200 transition duration-300 ease-in-out">digilab.com</a>
                </p>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="mt-12 border-t-2 border-blue-800 pt-4 text-center text-sm">
            <p>&copy; 2024 DIGILAB. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>