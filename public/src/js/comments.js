document.addEventListener("DOMContentLoaded", () => {
    const comment_modal_main = document.querySelector(".comment-modal");
    const engagement_section = document.querySelectorAll(".engagement-section");
    const comment_modal_section = document.querySelector(".comment-modal-section");
    const user_comments_section = document.querySelector(".user-comments-section");

    async function getComments(post_id) {
        const res = await fetch("../../public/pages/queries.php?action=get-comments&post_id=" + post_id);
        const data = await res.text()
    
        // Add response data as elements to the DOM
        user_comments_section.innerHTML = data;

        // Add event listeners to Add and Delete btns
        const comment = document.querySelector(".comment");
        const add_btns = document.querySelectorAll(".add-btn") 
        const delete_btns = document.querySelectorAll(".delete-btn")
        if (comment){
            // Add event listeners to add buttons
            add_btns.forEach(btn => {
                btn.addEventListener("click", () => {
                    const comment_id = btn.parentNode.parentNode.getAttribute("comment-id")
                    console.log("add: " + comment_id)
                })
            })
            // add event listeners to delete buttons
            delete_btns.forEach(btn => {
                btn.addEventListener("click", () => {
                    const comment_id = btn.parentNode.parentNode.getAttribute("comment-id")
                    console.log("delete: " + comment_id)
                })
            })
        }
    }
    
    function toggleModalCommentSection(e) {
        const post_id = e.target.parentNode.getAttribute("post-number")
        if (comment_modal_main.style.display == 'none' || !comment_modal_main.style.display){
            comment_modal_main.style.display = "flex"
            
            getComments(post_id)
        }else {
            comment_modal_main.style.display = "none"
        }
    }

    // Add event listeners for comment modal
    comment_modal_main.addEventListener("click", (e) => toggleModalCommentSection(e))
    comment_modal_section.addEventListener("click", (e) => e.stopPropagation());

    engagement_section.forEach((btn) => {
        btn.addEventListener("click", (e) => toggleModalCommentSection(e));
    });
})