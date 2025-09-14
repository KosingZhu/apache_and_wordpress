/**
 * 产品图片轮播功能实现
 * 1. 当产品只有一张图片时，不显示轮播区域
 * 2. 当产品有多张图片时，主区域展示主图，其他图片水平平铺在轮播区域
 * 3. 轮播区域左右有导航按钮，点击可以轮播图片，并同步更新主展示区
 */

jQuery(document).ready(function($) {
    // 等待页面完全加载后执行
    $(window).on('load', function() {
        initProductGallery();
    });

    function initProductGallery() {
        // 获取产品图库容器
        const galleryContainer = $('.woocommerce-product-gallery');
        
        if (!galleryContainer.length) {
            return;
        }

        // 获取所有图片
        const galleryImages = galleryContainer.find('.woocommerce-product-gallery__image');
        const totalImages = galleryImages.length;

        // 如果只有一张图片，不显示轮播区域
        if (totalImages <= 1) {
            return;
        }

        // 调整图片容器结构，创建轮播所需的元素
        restructureGallery(galleryContainer, galleryImages);

        // 初始化轮播功能
        initCarousel(galleryContainer, totalImages);

        // 初始化缩略图点击事件
        initThumbnailClick(galleryContainer);

        // 添加CSS类以启用自定义样式
        galleryContainer.addClass('custom-product-gallery');
    }

    function restructureGallery(galleryContainer, galleryImages) {
        // 获取主图片
        const mainImage = galleryImages.first();
        
        // 创建主图容器
        const mainImageContainer = $('<div class="gallery-main-image"></div>');
        mainImageContainer.append(mainImage.clone());

        // 创建缩略图容器
        const thumbnailsContainer = $('<div class="gallery-thumbnails"></div>');
        
        // 创建左右导航按钮
        const prevButton = $('<button type="button" class="gallery-nav gallery-nav-prev"><i class="fas fa-chevron-left"></i></button>');
        const nextButton = $('<button type="button" class="gallery-nav gallery-nav-next"><i class="fas fa-chevron-right"></i></button>');
        
        // 添加缩略图
        galleryImages.each(function(index) {
            const thumbnail = $(this).clone();
            thumbnail.addClass('gallery-thumbnail');
            thumbnail.attr('data-index', index);
            thumbnailsContainer.append(thumbnail);
        });

        // 清空原容器并添加新结构
        galleryContainer.empty();
        galleryContainer.append(mainImageContainer);
        galleryContainer.append(prevButton);
        galleryContainer.append(thumbnailsContainer);
        galleryContainer.append(nextButton);
    }

    function initCarousel(galleryContainer, totalImages) {
        let currentIndex = 0;
        const thumbnailsContainer = galleryContainer.find('.gallery-thumbnails');
        const thumbnails = galleryContainer.find('.gallery-thumbnail');
        const mainImage = galleryContainer.find('.gallery-main-image img');
        const prevButton = galleryContainer.find('.gallery-nav-prev');
        const nextButton = galleryContainer.find('.gallery-nav-next');

        // 设置初始激活状态
        thumbnails.first().addClass('active');

        // 上一张按钮点击事件
        prevButton.on('click', function() {
            currentIndex = (currentIndex - 1 + totalImages) % totalImages;
            updateGallery(currentIndex, mainImage, thumbnails);
        });

        // 下一张按钮点击事件
        nextButton.on('click', function() {
            currentIndex = (currentIndex + 1) % totalImages;
            updateGallery(currentIndex, mainImage, thumbnails);
        });

        // 支持键盘导航
        $(document).on('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                currentIndex = (currentIndex - 1 + totalImages) % totalImages;
                updateGallery(currentIndex, mainImage, thumbnails);
            } else if (e.key === 'ArrowRight') {
                currentIndex = (currentIndex + 1) % totalImages;
                updateGallery(currentIndex, mainImage, thumbnails);
            }
        });
    }

    function initThumbnailClick(galleryContainer) {
        const thumbnails = galleryContainer.find('.gallery-thumbnail');
        const mainImage = galleryContainer.find('.gallery-main-image img');

        thumbnails.on('click', function() {
            const index = $(this).data('index');
            updateGallery(index, mainImage, thumbnails);
        });
    }

    function updateGallery(index, mainImage, thumbnails) {
        // 获取选中的缩略图
        const selectedThumbnail = thumbnails.filter(`[data-index="${index}"]`);
        
        // 更新主图
        const newImageSrc = selectedThumbnail.find('img').attr('src');
        const newImageSrcset = selectedThumbnail.find('img').attr('srcset');
        const newImageAlt = selectedThumbnail.find('img').attr('alt');

        mainImage.fadeOut(200, function() {
            mainImage.attr('src', newImageSrc);
            if (newImageSrcset) {
                mainImage.attr('srcset', newImageSrcset);
            }
            mainImage.attr('alt', newImageAlt);
            mainImage.fadeIn(200);
        });

        // 更新缩略图激活状态
        thumbnails.removeClass('active');
        selectedThumbnail.addClass('active');

        // 滚动到选中的缩略图
        const thumbnailsContainer = thumbnails.parent();
        const scrollPosition = selectedThumbnail.position().left - 
                               (thumbnailsContainer.width() - selectedThumbnail.width()) / 2;
        
        thumbnailsContainer.animate({
            scrollLeft: scrollPosition
        }, 300);
    }
});