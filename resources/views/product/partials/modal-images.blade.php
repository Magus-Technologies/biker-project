<!-- resources/views/product/partials/modal-images.blade.php -->
<div id="imagesModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg w-11/12 md:w-3/4 lg:w-1/2 max-h-[90vh] overflow-hidden flex flex-col">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-semibold">Imágenes del Producto</h3>
            <button class="text-gray-500 hover:text-gray-700 text-2xl" onclick="closeModalImages()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-4 flex-grow overflow-auto">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper" id="swiperWrapper"></div>
                <div class="swiper-button-next text-blue-600"></div>
                <div class="swiper-button-prev text-blue-600"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</div>
