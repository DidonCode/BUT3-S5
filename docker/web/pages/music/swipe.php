<h1 id="empty-message" class="contrast-text" hidden>Aucuns sons disponibles pour le moment.</h1>
<div id="swipe">
    <div id="display-flex">
        <h2 class="text-center mb-3 contrast-text" id="sound-title">Titre</h2>
        <video id="swipe-player" hidden>
            <source id="swipe-source" src= ""/>
        </video>
        <div id="slider-container">
            <div id="card-container" class="swipe-img-container"></div>
            <div id="volume-container">
                <input id="swipe-volume" type="range" min="0" step="0.1" max="100" class="swipe-volumeBar">
                <button id="swipe-mute" class="volume-btn">
                    <i class="fa-sharp fa-light fa-volume-high contrast-text"></i>
                </button>

                <button id="swipe-unmute" class="volume-btn"hidden>
                    <i class="fa-sharp fa-light fa-volume-slash contrast-text"></i>
                </button>
            </div>
        </div>
        <div id="progress-container">
            <input id="swipe-progress-bar" type="range" value="0" min="0"></input>
        </div>
        <div id="swipe-controller" class="text-center">
            <button id="dislike-swipe" class="swipe-btn mx-4">
                <i class="fa-solid fa-xmark fa-2xl cancel-color my-auto"></i>
            </button>
            <button id="swipe-play" class="swipe-btn mx-4">
                <i class="fa-solid fa-play contrast-text my-auto"></i>
            </button>
            <button id="swipe-pause" class="swipe-btn mx-4" hidden>
                <i class="fa-solid fa-pause contrast-text my-auto"></i>
            </button>
            <button id="like-swipe" class="swipe-btn mx-4 like-swipe">
                <i class="fa-solid fa-heart fa-xl like-color my-auto"></i>
            </button>
        </div>
    </div>
</div>