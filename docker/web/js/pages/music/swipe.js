(() => {

const likeBtn = document.getElementById("like-swipe");
const firstSong = document.getElementById("first-song");
const dislikeBtn = document.getElementById("dislike-swipe");

likeBtn.onclick = function() {
    firstSong.classList.remove('unliked-song');
    firstSong.classList.add('liked-song');
    
}

dislikeBtn.onclick = function() {
    firstSong.classList.remove('liked-song');
    firstSong.classList.add('unliked-song');
}

})();