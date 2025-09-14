/**
 * 优化版产品图库放大功能
 * 解决点击图片跳转到源URL的问题
 * 使用document级委托事件捕获，更可靠的事件处理
 */

jQuery(document).ready(function($) {
    'use strict';
    
    console.log('优化版产品图库放大功能已加载');
    
    // 创建并缓存预览容器元素
    let previewContainer = null;
    let previewImage = null;
    let closeButton = null;
    
    /**
     * 初始化预览容器
     */
    function initPreviewContainer() {
        if (previewContainer && previewContainer.length) {
            console.log('复用已存在的预览容器');
            return;
        }
        
        console.log('创建新的预览容器');
        // 创建预览容器，使用与CSS匹配的类名
        previewContainer = $('<div>', {
            'id': 'product-image-zoom-container',
            'class': 'product-image-zoom-container'
        }).appendTo('body');
        
        // 预览内容容器
        const previewContent = $('<div>', {
            'class': 'product-image-zoom-content'
        }).appendTo(previewContainer);
        
        // 创建预览图片，使用与CSS匹配的类名
        previewImage = $('<img>', {
            'class': 'product-image-zoom-image'
        }).appendTo(previewContent);
        
        // 创建关闭按钮，使用与CSS匹配的类名
        closeButton = $('<button>', {
            'class': 'product-image-zoom-close',
            'text': '×',
            'title': '关闭'
        }).appendTo(previewContent);
        
        // 添加关闭功能
        closeButton.on('click', function() {
            closeImageZoom();
        });
        
        // 点击空白区域关闭
        previewContainer.on('click', function(e) {
            if (e.target === this) {
                closeImageZoom();
            }
        });
        
        // ESC键关闭
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && previewContainer.is(':visible')) {
                closeImageZoom();
            }
        });
    }
    
    /**
     * 打开图片预览
     */
    function openImageZoom(imgSrc) {
        console.log('打开图片预览:', imgSrc);
        
        if (!previewContainer) {
            initPreviewContainer();
        }
        
        // 设置图片源
        previewImage.attr('src', imgSrc);
        
        // 显示预览容器，使用CSS中定义的激活方式
        previewContainer.addClass('active');
        
        // 防止页面滚动，使用与CSS匹配的类名
        $('body').addClass('product-image-zoom-open');
    }
    
    /**
     * 关闭图片预览
     */
    function closeImageZoom() {
        if (!previewContainer) return;
        
        console.log('关闭图片预览');
        
        // 隐藏预览容器，使用CSS中定义的激活方式
        previewContainer.removeClass('active');
        
        // 允许页面滚动
        $('body').removeClass('product-image-zoom-open');
    }
    
    /**
     * 模拟轮播切换
     */
    function simulateCarouselChange(targetImageSrc) {
        console.log('模拟轮播切换到:', targetImageSrc);
        
        // 获取主图容器
        const mainImageContainer = $('.woocommerce-product-gallery__image');
        if (!mainImageContainer.length) {
            console.warn('未找到主图容器');
            return;
        }
        
        // 获取当前主图链接
        const mainImageLink = mainImageContainer.find('a:first');
        const mainImage = mainImageLink.find('img:first');
        
        if (mainImage.length) {
            // 添加淡入淡出效果
            mainImage.fadeOut(200, function() {
                // 更新主图链接和图片源
                mainImageLink.attr('href', targetImageSrc);
                mainImage.attr('src', targetImageSrc);
                
                // 淡入新图片
                mainImage.fadeIn(200);
            });
        }
    }
    
    /**
     * 主初始化函数
     */
    function initProductGalleryZoom() {
        console.log('开始初始化产品图库放大功能');
        
        // 初始化预览容器
        initPreviewContainer();
        
        // 为产品图库区域添加鼠标指针样式
        const galleryContainer = $('.woocommerce-product-gallery');
        if (galleryContainer.length) {
            galleryContainer.css('cursor', 'pointer');
        }
        
        // 使用document级委托事件捕获，确保捕获所有产品图片点击
        $(document).on('click.productZoom', '.woocommerce-product-gallery img', function(e) {
            console.log('捕获到产品图库图片点击');
            
            // 阻止默认行为和冒泡
            e.preventDefault();
            e.stopPropagation();
            
            // 获取图片源
            let imgSrc = $(this).attr('src');
            const parentLink = $(this).closest('a');
            
            if (parentLink.length) {
                // 如果图片在链接内，使用链接的href
                const linkHref = parentLink.attr('href');
                if (linkHref) {
                    imgSrc = linkHref;
                }
            }
            
            // 打开图片预览
            openImageZoom(imgSrc);
            
            return false;
        });
        
        // 特别处理缩略图链接点击事件
        $(document).on('click.productZoom', '.woocommerce-product-gallery__thumbnails a', function(e) {
            console.log('捕获到缩略图链接点击');
            
            // 阻止默认跳转
            e.preventDefault();
            e.stopPropagation();
            
            // 获取目标图片URL
            const targetImageSrc = $(this).attr('href');
            
            // 模拟轮播切换
            simulateCarouselChange(targetImageSrc);
            
            // 延迟打开预览，确保轮播切换完成
            setTimeout(function() {
                openImageZoom(targetImageSrc);
            }, 300);
            
            return false;
        });
        
        console.log('产品图库放大功能初始化完成');
    }
    
    // 在DOM完全加载后初始化
    $(window).on('load', function() {
        console.log('窗口加载完成，准备初始化产品图库放大功能');
        initProductGalleryZoom();
        
        // 为了确保兼容性，添加一个延迟初始化作为备选方案
        setTimeout(function() {
            if (!previewContainer) {
                console.log('执行延迟初始化');
                initProductGalleryZoom();
            }
        }, 1000);
    });
});