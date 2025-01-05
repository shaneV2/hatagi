window.onload = () => {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function(){
        document.querySelector(".content").innerHTML = this.responseText;
        const buttons = document.querySelectorAll("button[post-number]");

        buttons.forEach((button) => {
            button.addEventListener("click", () => {
                const post_id = button.getAttribute("post-number");
                const clickedPostCommentSection = document.querySelector(".post-number-" + post_id);

                const allCommentSection = document.querySelectorAll(".interaction-section");
                allCommentSection.forEach((comment_section) => {
                    if(comment_section === clickedPostCommentSection){
                        if(clickedPostCommentSection.style.display === 'block'){
                            clickedPostCommentSection.style.display = "none";
                        }else{
                            clickedPostCommentSection.style.display = "block";
                        }
                    }

                })
            });
        });
    }
    xhttp.open("GET", "./queries.php?action=get-post", true);
    xhttp.send();
}