(function($, window) {


    window.simpleWpFaq = window.simpleWpFaq || {};

    simpleWpFaq.faqs = {
        collapsedClassName: 'collapsed',

        init: function() {
            var faqCategories = $(".faq-category");
            var faqs = faqCategories.find(".faq");

            faqCategories.addClass(this.collapsedClassName);
            faqs.addClass(this.collapsedClassName);

            var self = this;
            faqCategories.find(".faq-category-heading").click(function() {
                self.toggleCategory($(this).parent());
            });

            faqs.find(".question").click(function() {
                self.toggleFaq($(this).parent());
            });

            this.showInitialCategory();
        },

        showInitialCategory: function() {
            if(window.location.hash) {
                var categoryId = window.location.hash.replace("#", '');

                var category = $('#' + categoryId);
                if(category.length) {
                    category.removeClass(this.collapsedClassName);

                    var destination = category.offset().top;

                    $("html,body").animate({ scrollTop: destination}, 'fast', 'swing');
                }
            }
        },

        toggleCategory: function(category) {
            var self = this;

            this.setHash(category);
            category.addClass("animating");
            if(category.hasClass(this.collapsedClassName)) {
                category.find(".faq-list").slideDown(500, function() {
                    category.removeClass(self.collapsedClassName).removeClass("animating");
                });
            }else {
                category.find(".faq-list").slideUp(500, function() {
                    category.addClass(self.collapsedClassName).removeClass("animating");
                });
            }
        },

        setHash: function(category) {
            var categoryId = category.attr("id");
            category.attr("id", "");
            window.location.hash =categoryId;
            category.attr("id", categoryId);

        },

        toggleFaq: function(faq) {
            var self = this;
            faq.addClass("animating");
            if(faq.hasClass(this.collapsedClassName)) {
                faq.find(".answer").slideDown(500, function() {
                    faq.removeClass(self.collapsedClassName).removeClass("animating");
                });
            }else {
                faq.find(".answer").slideUp(500, function() {
                    faq.addClass(self.collapsedClassName).removeClass("animating");
                });
            }
        }


    };

    $(window).load(function() {
        simpleWpFaq.faqs.init();
    })

})(jQuery, window);