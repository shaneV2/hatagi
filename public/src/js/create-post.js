const modal = document.querySelectorAll(".modal")[0];
const create_post = document.querySelectorAll(".modal-section")[0];
const auto_focus_input = document.querySelectorAll(".post-description")[0];

// Closes the modal if clicked outside the post section
modal.addEventListener('click', ()=>{
    closeCreatePost();
});

// Stops the surrounding events from triggering 
create_post.addEventListener('click', (e)=>{
    e.stopPropagation();
});

function closeCreatePost(){
    auto_focus_input.blur(); 
    modal.style.display = "none";   
}

function viewCreatePost(){
    modal.style.display = "flex";
    auto_focus_input.focus(); 
}