;(function ($) {

	'use strict';

	$('a[href=\\#]').on('click', function (e) {
		e.preventDefault();
	})

	var RadiusDocs = {

		_init: function () {

			var offCanvas = {
				menuBar: $('.trigger-off-canvas'),
				drawer: $('.radius-docs-offcanvas-drawer'),
				drawerClass: '.radius-docs-offcanvas-drawer',
				menuDropdown: $('.dropdown-menu.depth_0'),
			};

			//RadiusDocs.ajaxFilter();
			// RadiusDocs.newsTicker();
			RadiusDocs.readyFunctionality();
			// RadiusDocs.slickSlider();
			// RadiusDocs.magnificPopup();
			RadiusDocs.headerSticky();
			RadiusDocs.menuDrawerOpen(offCanvas);
			RadiusDocs.offcanvasMenuToggle(offCanvas);
			RadiusDocs.headerSearchOpen();
			RadiusDocs.backToTop();
			// RadiusDocs.counterUp();
			// RadiusDocs.pricingTab();
			// RadiusDocs.parallaxMouse();
			RadiusDocs.preLoader();
			// RadiusDocs.ProgressBar();
			RadiusDocs.menuOffset();
			RadiusDocs.AjaxSearch();
			RadiusDocs.wow();
			// RadiusDocs.magnificPopup();
			//RadiusDocs.hasAnimation();
			RadiusDocs.masonary();
			RadiusDocs.documentReady();
		},

		documentReady: function () {
			// $('.menu-icon-wrapper .radius-docs-button').prev().addClass('nav-button-prev');

			$('.radius-docs-navigation ul li.mega-menu > ul.dropdown-menu').each(function () {
				var liCount = $(this).children('li').length;
				$(this).addClass('columns-' + liCount);
			});
		},

		masonary: function () {
			if (typeof $.fn.masonry === 'function') {
				var masonryGrid = $('.radius-docs-masonry-grid').masonry({
					itemSelector: '.masonry-item',
					columnWidth: '.masonry-item',
					percentPosition: true
				});

				// Trigger layout after images load
				masonryGrid.imagesLoaded().progress(function () {
					masonryGrid.masonry('layout');
				});
			}
		},
		headerSticky: function () {

			if ($('body').hasClass('has-sticky-header')) {

				var stickyPlaceHolder = $("#radius-docs-sticky-placeholder");
				var mainMenu = $(".main-header-section");
				var menuParent = mainMenu.closest('.site-header');
				var menuHeight = mainMenu.outerHeight() || 0;
				var headerTopbar = $('.radius-docs-topbar').outerHeight() || 0;
				var targrtScroll = headerTopbar + menuHeight;

				if ($('body').hasClass('radius-docs-header-2')) {
					targrtScroll = $(window).height() - menuHeight;
				}

				// Main Menu
				if ($(window).scrollTop() > targrtScroll) {
					menuParent.addClass('radius-docs-sticky');
					stickyPlaceHolder.height(menuHeight);
				} else {
					menuParent.removeClass('radius-docs-sticky');
					stickyPlaceHolder.height(0);
				}

				//Mobile Menu
				var mobileMenu = $("#meanmenu");
				var mobileTopHeight = $('#mobile-menu-sticky-placeholder');

				if ($(window).scrollTop() > mobileMenu.outerHeight() + headerTopbar) {
					mobileMenu.addClass('radius-docs-sticky');
					mobileTopHeight.height(mobileMenu.outerHeight());
				} else {
					mobileMenu.removeClass('radius-docs-sticky');
					mobileTopHeight.height(0);
				}
			}
		},


		magnificPopup: function () {
			var yPopup = $(".radius-docs-popup-video");

			if (yPopup.length) {
				yPopup.magnificPopup({
					disableOn: 700,
					type: 'iframe',
					mainClass: 'mfp-fade',
					removalDelay: 160,
					preloader: false,
					fixedContentPos: false
				});
			}
		},


		wow: function () {
			var wow = new WOW({
				boxClass: 'wow',
				animateClass: 'animated',
				offset: 0,
				mobile: false,
				live: true,
				scrollContainer: null,
			});
			wow.init();
		},

		// Ajax search 1
		AjaxSearch: function () {
			if ($(".radius-docs-hero-section-search").length) {
				$(".radius-docs-hero-section-search").focusin(function () {
					$('body').addClass('radius-docs-search-active');
					$(this).css('z-index', '100')
				});
				$(".radius-docs-hero-section-search").focusout(function () {
					$('body').removeClass('radius-docs-search-active');
					$(this).attr('style', '')
				});
			}
			//nice-select
			if ($(".radius-docs-search-box-form").length) {
				$('select').niceSelect();
			}
			// Search ajax
			if ($("#radius_docs_datafetch").length) {
				$('#searchInput').on('keyup', function () {
					fetchResults();
				});
				$(document).on('radius_docs_search_input_change', function () {
					fetchResults();
					$('#searchInput').focus();
				});

				function fetchResults() {
					var keyword = $('#searchInput').val();
					var meta = $('#categories').val();
					var searchkey = $('.radius-docs-addon-search .keyword a').val();
					var searchTerm = $('#searchInput').val();
					$('#cleanText').on('click', function () {
						$('#searchInput').val('');
						$('.radius-docs-search-box-container').removeClass('radius-docs-search-container');
					});
					if (searchTerm.length > 0) {
						$('.radius-docs-search-box-container').addClass('radius-docs-search-container');

					} else {
						$('.radius-docs-search-box-container').removeClass('radius-docs-search-container');
					}

					if (keyword.length < 3) {
						$('#radius_docs_datafetch').html("<span class='letters'>Minimum 3 Latters</span>");
						return;
					}
					$.ajax({
						url: neuzinObj.ajaxURL,
						type: 'post',
						data: {
							action: 'radius_docs_data_fetch',
							security: neuzinObj.neuzinNonce,
							keyword: keyword,
							meta: meta,
							searchkey: searchkey,
						},
						success: function (data) {
							$('#radius_docs_datafetch').html(data);
						}
					});
				}

				//Search Keyword
				$(".radius-docs-addon-search .keyword").on("click", function () {
					var keyword = $(this).text();
					$('.radius-docs-input-wrap #searchInput').val(keyword);
					$(document).trigger('radius_docs_search_input_change');
				});

			}

			$('form.radius-docs-search-box-form').on('submit', function (e) {
				e.preventDefault();
				var $form = $(this);
				var catLink = $form.find('select[name=categories]').val();
				var searchValue = $form.find('input.search-box-input').val();
				if (catLink) {
					var newUrl = new URL(catLink);
					if (searchValue) {
						newUrl.searchParams.set('s', searchValue);
					}
					window.location = newUrl.toString();
				} else {
					if (searchValue) {
						$form[0].submit();
					}
				}
			})
		},

		menuOffset: function () {
			$(".dropdown-menu > li").each(function () {
				var $this = $(this),
					$win = $(window);

				if ($this.offset().left + ($this.width() + 30) > $win.width() + $win.scrollLeft() - $this.width()) {
					$this.addClass("dropdown-inverse");
				} else if ($this.offset().left < ($this.width() + 30)) {
					$this.addClass("dropdown-inverse-left");
				} else {
					$this.removeClass("dropdown-inverse");
				}
			});
		},

		readyFunctionality: function () {
			const siteHeader = $('.site-header');
			const adminBar = $('#wpadminbar');
			const paddingTop = siteHeader.height() + 30 + adminBar.height();

			const headerHeight = $('.site-header').outerHeight();
			const topbarHeight = $('.radius-docs-topbar').outerHeight() || 0;

			// Set CSS variables on the body
			$('body').css({
				'--header-height': `${headerHeight}px`,
				'--topbar-height': `${topbarHeight}px`
			});
			$('.has-trheader .radius-docs-breadcrumb-wrapper').css({'paddingTop': paddingTop + 'px', 'opacity': 1})
			$('.has-trheader.no-banner .content-area').css({'paddingTop': (paddingTop + 20) + 'px', 'opacity': 1})
		},

		menuDrawerOpen: function (offCanvas) {
			offCanvas.menuBar.on('click', e => {
				e.preventDefault();
				offCanvas.menuBar.toggleClass('is-open')
				offCanvas.drawer.toggleClass('is-open');
				e.stopPropagation()
			});

			$(document).on('click', e => {
				if (!$(e.target).closest(offCanvas.drawerClass).length) {
					offCanvas.drawer.removeClass('is-open');
					offCanvas.menuBar.removeClass('is-open')
				}
			});
		},

		offcanvasMenuToggle: function (offCanvas) {
			offCanvas.drawer.each(function () {
				const caret = $(this).find('.caret');
				caret.on('click', function (e) {
					e.preventDefault();
					$(this).closest('li').toggleClass('is-open');
					$(this).parent().next().slideToggle(300);
				})
			})
		},

		headerSearchOpen: function () {
			const $headerSearch = $('#radius-docs-header-search');
			const $openButton = $('a[href="#header-search"]');
			const $closeButton = $headerSearch.find('button.close');

			// Open the search popup
			$openButton.on("click", function (event) {
				event.preventDefault();
				event.stopPropagation();
				$headerSearch.addClass("open");

				setTimeout(function () {
					$headerSearch.find('input[type="search"]').focus();
				}, 500)
			});

			// Close the search popup on close button click
			$closeButton.on("click", function (event) {
				event.preventDefault();
				$headerSearch.removeClass("open");
			});

			// Close the search popup when clicking outside
			$('body').on('click', function (event) {
				if (
					$headerSearch.hasClass('open') &&
					!$(event.target).closest($headerSearch).length &&
					!$(event.target).is($openButton)
				) {
					$headerSearch.removeClass("open");
				}
			});
		}
		,

		backToTop: function () {
			/* Scroll to top */
			$('.scrollToTop').on('click', function () {
				$('html, body').animate({scrollTop: 0}, 800);
				return false;
			});
		},

		/* windrow back to top scroll */
		backTopTopScroll: function () {
			if ($(window).scrollTop() > 100) {
				$('.scrollToTop').addClass('show');
			} else {
				$('.scrollToTop').removeClass('show');
			}
		},


		/* preloader */
		preLoader: function () {
			$('#preloader').fadeOut('slow', function () {
				$(this).remove();
			});
		},

		// with skill bar
		ProgressBar: function () {
			let counter = true;
			$(".counter-appear").appear();
			$(".counter-appear").on("appear", function () {
				if (counter) {
					// with skill bar
					$(".skill-per").each(function () {
						let $this = $(this);
						let per = $this.attr("data-per");
						$this.css("width", per + "%");
						$({animatedValue: 0}).animate(
							{animatedValue: per},
							{
								duration: 500,
								step: function () {
									$this.attr("data-per", Math.floor(this.animatedValue) + "%");
								},
								complete: function () {
									$this.attr("data-per", Math.floor(this.animatedValue) + "%");
								},
							}
						);
					});
					counter = false;
				}
			});
		},

		/* windrow scroll animation */
		hasAnimation: function () {
			if (!!window.IntersectionObserver) {
				let observer = new IntersectionObserver((entries, observer) => {
					entries.forEach(entry => {
						if (entry.isIntersecting) {
							entry.target.classList.add("active-animation");
							observer.unobserve(entry.target);
						}
					});
				}, {
					rootMargin: "0px 0px -100px 0px"
				});
				document.querySelectorAll('.has-animation').forEach(block => {
					observer.observe(block)
				});
			} else {
				document.querySelectorAll('.has-animation').forEach(block => {
					block.classList.remove('has-animation')
				});
			}
		},

	};

	$(document).ready(function (e) {
		RadiusDocs._init();
	});

	$(document).on('load', () => {
		RadiusDocs.menuOffset();
	})

	$(window).on('scroll', (event) => {
		RadiusDocs.headerSticky(event);
		RadiusDocs.backTopTopScroll(event);
	});

	$(window).on('resize', () => {
		RadiusDocs.menuOffset();
	});

	$(window).on('elementor/frontend/init', () => {
		if (elementorFrontend.isEditMode()) {
			//For all widgets
			elementorFrontend.hooks.addAction('frontend/element_ready/widget', () => {
				RadiusDocs._init();
			});

		}
	});

	window.RadiusDocs = RadiusDocs;

})(jQuery);
