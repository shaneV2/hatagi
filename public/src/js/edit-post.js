const edit_modal = document.querySelectorAll(".modal")[1];
const edit_post_modal = document.querySelectorAll(".modal-section")[1];
const auto_focus_input_edit = document.querySelectorAll(".post-description")[1];

// Closes the modal if clicked outside the post section
edit_modal.addEventListener('click', ()=>{
    closeEditPost();
});

// Stops the surrounding events from triggering 
edit_post_modal.addEventListener('click', (e)=>{
    e.stopPropagation();
});

function closeEditPost(){
    edit_modal.style.display = "none";   
}

function viewEditPost(post_id){
    const editxmlhttp = new XMLHttpRequest();
    editxmlhttp.onload = function() {
        edit_post_modal.innerHTML = this.responseText;
        edit_modal.style.display = "flex";

        const edit_auto_input_focus = edit_post_modal.querySelector(".post-description");
        edit_auto_input_focus.focus();
    }
    editxmlhttp.open("GET", "./queries.php?action=edit-post&post_id=" + post_id, true);
    editxmlhttp.send();
}