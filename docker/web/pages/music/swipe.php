<div id="main-container" class="mx-auto">
    <h2 class="text-center mb-3" id="song-title">Titre</h2>
    <div id="card-container" class="mx-auto swipe-img-container">
        <img class="rounded-img" src="/web/images/Tests/viva-la-vida.jpg" alt="Image de couverture musique Viva la vida" id="first-song">
        <img class="rounded-img secondSong text-center" src="/web/images/Tests/birds-of-feather.jpg" alt="Image de couverture musique Birds of feather" id="second-song">
    </div>
    <div class="text-center mt-4">
        <button class="btn mr-5" id="dislike-swipe">
            <i class="fa-solid fa-xmark fa-2xl cancel-color"></i>
        </button>
        <button class="btn like-swipe" id="like-swipe">
            <i class="fa-solid fa-heart fa-xl like-color"></i>
        </button>
    </div>
    <button id="test-popup" class="btn bg-primary">Test pop up</button>
</div>

<div id="add-to-swipe-playlist-confirmation" class="modal md" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Musique ajoutée à la playlist Matched</h4>
                <button id="close-confirmation" type="button" class="close" hidden>&times;</button>
            </div>
        </div>
    </div>
</div>