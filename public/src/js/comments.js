import { getComments, addComment } from "./comment-actions.js";

const comment_modal_main = document.querySelector(".comment-modal");
const engagement_section = document.querySelectorAll(".engagement-section");
const comment_modal_section = document.querySelector(".comment-modal-section");
const send_comment_btn = document.getElementById("send-comment-btn");

document.addEventListener("DOMContentLoaded", () => {
    let post_id;

    function toggleModalCommentSection(e) {
        post_id = e.target.parentNode.getAttribute("post-number")
        if (comment_modal_main.style.display == 'none' || !comment_modal_main.style.display){
            comment_modal_main.style.display = "flex"
            getComments(parseInt(post_id))
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

    // Add event listener for send button
    send_comment_btn.addEventListener("click", () => {
        addComment(parseInt(post_id))
    })
})