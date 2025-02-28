<h2 class="text-center mb-3" id="sound-title">Titre</h2>
<video style="display: block;" id="swipe-player">
    <source id="swipe-source" src= ""/>
</video>
<div id="slider-container">
    <div id="card-container" class="mx-auto swipe-img-container"></div>
    <input id="swipe-volume" type="range" min="0" step="0.1" max="100" class="swipe-volumeBar">
</div>
<div id="progress-container">
    <input id="swipe-progress-bar" type="range" value="0" min="0"></input>
</div>
<div class="text-center">
    <button class="btn mx-4" id="dislike-swipe">
        <i class="fa-solid fa-xmark fa-2xl cancel-color"></i>
    </button>
    <button id="swipe-play" class="mx-4">
		<i class="fa-solid fa-play contrast-text"></i>
	</button>
    <button id="swipe-pause" class="mx-4" style="display: none;">
        <i class="fa-solid fa-pause contrast-text"></i>
    </button>
    <button class="btn mx-4 like-swipe" id="like-swipe">
        <i class="fa-solid fa-heart fa-xl like-color"></i>
    </button>
</div>