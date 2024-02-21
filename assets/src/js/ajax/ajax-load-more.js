(function ($) {

	class LoadMore {

		constructor() {

			this.ajaxUrl = ajaxConfig?.ajaxUrl ?? ''
			this.ajaxNonce = ajaxConfig?.ajax_nonce ?? ''
			this.loadMoreBtn = $('#load-more')

			this.options = {
				root: null,
				rootMargin: '0px',
				threshold: 0.35, // 1.0 means set isIntersecting to true when element comes in 100% view.
			};

			this.init()

		}

		init() {

			if (!this.loadMoreBtn.length) {
				return;
			}

			this.totalPagesCount = $('#post-pagination').data('max-pages')
			// console.log( this.totalPagesCount )

			if (ajaxConfig?.enable_infinite_scroll) {

				const observer = new IntersectionObserver(
					(entries) => this.intersectionObserverCallback(entries),
					this.options
				);
				observer.observe(this.loadMoreBtn[0])

			}
			else {

				this.loadMoreBtn.on('click', () => {
					this.loadMoreBtn.attr('disabled', true)
					this.handleLoadMorePosts()
				})

			}

		}

		/**
		 * Gets called on initial render with status 'isIntersecting' as false and then
		 * everytime element intersection status changes.
		 */
		intersectionObserverCallback(entries) {

			entries.forEach((entry) => {
				// If load more button in view.
				if (entry?.isIntersecting) {
					this.loadMoreBtn.attr('disabled', true)
					this.handleLoadMorePosts();
				}

			})

		}

		/**
		 * Load more posts.
		 */
		handleLoadMorePosts() {
			// Get page no from data attribute of load-more button.
			const page = this.loadMoreBtn.data('page')
			if (!page) {
				return null
			}

			const newPage = parseInt(page) + 1; // Increment page count by one.
			// console.log( newPage )

			$.ajax({

				url: this.ajaxUrl,
				type: 'post',
				data: {
					page: page,
					action: 'load_more',
					ajax_nonce: this.ajaxNonce,
				},

				success: (response) => {
					this.loadMoreBtn.data('page', newPage)
					$('#load-more-content').append(response)
					this.loadMoreBtn.attr('disabled', false)
					this.removeLoadMoreIfOnLastPage(newPage)
				},

				error: (response) => {
					console.log(response);
				},

			});

		}

		/**
		 * Remove Load more Button If on last page.
		 */
		removeLoadMoreIfOnLastPage(newPage) {

			if (newPage + 1 > this.totalPagesCount) {
				this.loadMoreBtn.remove();
			}

		}

	}

	new LoadMore();
})(jQuery);
