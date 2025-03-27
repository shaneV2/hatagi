const user_comments_section = document.querySelector(".user-comments-section");
let hasNoComment = true;

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
        hasNoComment = false;
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
    }else {
        hasNoComment = true
    }
}

async function addComment(post_id) {
    // Create Elements
    const parent_div = document.createElement("div");
    const p = document.createElement("p");
    const child_div = document.createElement("div");
    const add_button = document.createElement("button");
    const delete_button = document.createElement("button");
    const img1 = document.createElement("img");
    const img2 = document.createElement("img");

    // Set Attributes
    parent_div.setAttribute("class", "comment")
    // div.setAttribute("comment-id")
    
    add_button.setAttribute("class", "add-btn")
    delete_button.setAttribute("class", "delete-btn")
    
    img1.setAttribute("width", "100%");
    img1.setAttribute("height", "100%");
    img1.setAttribute("src", "../src/assets/add.svg")
    
    img2.setAttribute("width", "100%");
    img2.setAttribute("height", "100%");
    img2.setAttribute("src", "../src/assets/delete.svg")

    // Add values to the elements and append childs
    parent_div.appendChild(p)
    parent_div.appendChild(child_div)

    p.textContent = "This is a text comment test."

    child_div.appendChild(add_button)
    child_div.appendChild(delete_button)

    add_button.appendChild(img1)
    delete_button.appendChild(img2)

    if (hasNoComment){
        user_comments_section.removeChild(user_comments_section.firstChild)
    }

    // div.innerHTML = "<p>this is a test comment</p><div><button class='add-btn'><img src='../src/assets/add.svg' width='100%' height='100%' alt=''></button><button class='delete-btn'><img src='../src/assets/delete.svg' width='100%' height='100%' alt=''></button></div>";

    user_comments_section.prepend(parent_div)
    hasNoComment = false
}

export {getComments, addComment}