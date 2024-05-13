
const likebutton = document.getElementById("like-button")

function curtir() {

    if (likebutton.src !== "/img/like0.png") {
        (likebutton.src = "/img/like1.png")
    }
    else {
        (likebutton.src = "/img/like0.png")
    }

}

