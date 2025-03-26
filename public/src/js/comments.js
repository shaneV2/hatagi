document.addEventListener("DOMContentLoaded", () => {
    const comment_modal_main = document.querySelector(".comment-modal");
    const engagement_section = document.querySelectorAll(".engagement-section");
    const comment_modal_section = document.querySelector(".comment-modal-section");
    const user_comments_section = document.querySelector(".user-comments-section");

    function toggleModalCommentSection(e) {
        const post_id = e.target.parentNode.getAttribute("post-number")
        if (comment_modal_main.style.display == 'none' || !comment_modal_main.style.display){
            comment_modal_main.style.display = "flex"
            
            async function getComments() {
                const res = await fetch("../../public/pages/queries.php?action=get-comments&post_id=" + post_id);
                const data = await res.text()

                user_comments_section.innerHTML = data;
            }

            getComments();

        }
        else {
            comment_modal_main.style.display = "none"
        }
    }

    comment_modal_main.addEventListener("click", (e) => toggleModalCommentSection(e))
    comment_modal_section.addEventListener("click", (e) => e.stopPropagation());

    engagement_section.forEach((btn) => {
        btn.addEventListener("click", (e) => toggleModalCommentSection(e));
    });
})

{/* <div class="interaction-section post-number-'. $row['post_id'] .'">
    <div class="suggestions-section">';
    // Get all the comments
    $comment->getComments($row['post_id'], $row['user_id']);
    echo'
    </div>
    <div class="comment_input">
        <form action="./queries.php?action=create-comment&post_id='. $row['post_id'] .'" method="post">
            <input type="text" placeholder="Add new suggestion" name="comment_text" autofocus>
        </form>
    </div>
</div> */}