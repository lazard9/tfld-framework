(function ($) {

   $(".user_vote").click(function (e) {
      e.preventDefault();
      post_id = $(this).attr("data-post_id");
      nonce = $(this).attr("data-nonce");

      $.ajax({
         type: "post",
         dataType: "json",
         url: ajaxConfig.ajaxUrl,
         data: { action: "tfld_ajax_user_vote", post_id: post_id, nonce: nonce },
         success: function (response) {
            if (response.type == "success") {
               $("#vote_counter").html(response.vote_count);
            }
            else {
               alert("Your vote could not be added");
            }
         }
      });
   });

})(jQuery);
