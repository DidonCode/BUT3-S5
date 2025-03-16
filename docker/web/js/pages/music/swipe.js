( async () => {

	if (!sessionExist()) {
		sessionDestroy();
		return;
	}

	if (user['subscription'] == null || user['subscription']['type'] != 'premium') {
		window.history.pushState({}, '', '/web/subscription');
		handleLocation();
	}
	

	const swipe = document.getElementById("swipe");
	const cardTitle = document.getElementById('sound-title');
	const cardContainer = document.getElementById('card-container');

	const emptyMessage = document.getElementById("empty-message");

	const dislikeBtn = document.getElementById('dislike-swipe');
	const likeBtn = document.getElementById('like-swipe');

	const player = document.getElementById('swipe-player');
	const source = document.getElementById('swipe-source');

	const play = document.getElementById('swipe-play');
	const pause = document.getElementById('swipe-pause');
	const volume = document.getElementById('swipe-volume');
	const progress = document.getElementById('swipe-progress-bar');
	const mute = document.getElementById("swipe-mute");
	const unmute = document.getElementById("swipe-unmute");

	let playerVolume = 10;
	let sounds = [];

	async function getSounds() {
		
		let soundsFormData = new FormData();

        soundsFormData.append('type','swipe')
        soundsFormData.append('token', token)

		await apiCall('api/user/activity', soundsFormData, async function (data) {
			if (data != '') {
				const parsedData = JSON.parse(data);

				if (parsedData != null) {
					if(parsedData.length == 0) setEmpty();
					
					if (parsedData['error'] != undefined) {
						routeError(parsedData['error']);
						return;
					} else {
						if (parsedData.length == 0) return;						

						for (card of parsedData) {
							sounds.push(card);
							soundCard = document.createElement('img');
							soundCard.classList.add('rounded-img', 'card');

							if (cardContainer.children.length == 0) cardTitle.innerText = card.title;
							
							soundCard.id = card.id;
							soundCard.alt = card.title;
							soundCard.src = card.image;

							cardContainer.appendChild(soundCard);
						}

						if (cardContainer.children.length > 0) {
							loadButifyPlayer(sounds[0]);
						}
					}
				}
			}
		});
	}

	function setEmpty() {
		swipe.remove();

		emptyMessage.removeAttribute("hidden");
	}

	async function remove(isLiked) {
			const firstSound = sounds[0];

			if (isLiked) {

				let formData = new FormData();

				formData.append('sound', firstSound.id);
				formData.append('action', 3);
				formData.append('token', token);

				apiCall('api/user/like', formData, async (data) => {
					if (data != '') {
						const parsedData = JSON.parse(data);

						if (parsedData['error'] != undefined) console.log(parsedData['error']);
					}
				});
			}

			cardContainer.children[0].remove();
			sounds.shift();

			if (cardContainer.children.length > 0) {
				if(cardContainer.children.length <= 2) await getSounds();
				const nextCard = sounds[0];
				cardTitle.innerText = nextCard.title;

				loadButifyPlayer(nextCard);
			} else {
				setEmpty();
			}
	};

	function updateTimecode(timeCode, duration) {
		progress.max = duration;
		progress.value = timeCode;

		const value = (timeCode / duration) * 100;
		progress.style.setProperty('--progress', `${value}%`);
	}

	function loadButifyPlayer(video) {

		volume.value = playerVolume;
		player.pause();
		player.currentTime = 0;
		source.src = video.link;

		player.autoplay = false;
		player.muted = true;
		player.load();
		player.play();
		player.muted = false;
		player.volume = volume.value / 100;

		//-------------\\

		player.onplaying = function () {
			play.setAttribute("hidden", "");
			pause.removeAttribute("hidden");
		};

		player.onpause = function () {
			play.removeAttribute("hidden");
			pause.setAttribute("hidden", "");
		};

		player.muted === true ? (mute.setAttribute("hidden", "")) : (unmute.setAttribute("hidden", ""));

		player.ontimeupdate = function () {
			updateTimecode(player.currentTime, player.duration);
		};

		//-------------\\

		play.onclick = () => player.play();
		pause.onclick = () => player.pause();

		mute.onclick = function () {
			player.volume = 0;
			volume.value = 0;

			mute.setAttribute("hidden", "");
			unmute.removeAttribute("hidden");
		};

		unmute.onclick = function () {
			volume.value = playerVolume;
			player.volume = volume.value / 100;

			unmute.setAttribute("hidden", "");
			mute.removeAttribute("hidden");
		};

		volume.oninput = function () {
			playerVolume = volume.value;
			player.volume = volume.value / 100;
		};

		progress.onchange = function () {
			player.currentTime = progress.value;
		};
	}	

	dislikeBtn.onclick = function () {
		let activeCard = cardContainer.children[0];
		activeCard.classList.add('unliked-sound');
		activeCard.onanimationend = () => remove(0);
	};

	likeBtn.onclick = function () {
		let activeCard = cardContainer.children[0];
		activeCard.classList.add('liked-sound');
		activeCard.onanimationend = () => remove(1);
	};


	let startX = 0;
	let currentX = 0;
	let isDragging = false;
	let hasMoved = false;
	
	const minSwipeDistance = 50;

	cardContainer.ontouchstart = (e) => startDrag(e.touches[0].clientX);
	cardContainer.onmousedown= (e) => startDrag(e.clientX);

	function startDrag(x) {
		if(!cardContainer.children) return;

		activeCard = cardContainer.children[0];
		startX = x;
		isDragging = true;
		hasMoved = false;

		volume.style.pointerEvents = "none";
	}

	cardContainer.ontouchmove = (e) => moveDrag(e.touches[0].clientX);
	cardContainer.onmousemove = (e) => moveDrag(e.clientX);

	function moveDrag(x) {
		if(!isDragging || !activeCard) return;

		currentX = x;
		let deltaX = currentX - startX;
		let rotation = deltaX / 10;
		hasMoved = true;

		activeCard.style.transform = `translateX(${deltaX}px) rotateZ(${rotation}deg)`;
	}

	cardContainer.ontouchend = (e) => endDrag();
	cardContainer.onmouseup = (e) => endDrag();
	cardContainer.onmouseleave = () => endDrag();

	function endDrag() {
		if(!isDragging || !activeCard) return;

		let deltaX = currentX - startX;
		isDragging = false;

		volume.style.pointerEvents = "auto";

		if (!hasMoved) {
			activeCard.style.transform = "";
			return;
		}

		if(Math.abs(deltaX) > minSwipeDistance) {
			if(deltaX > 0) {
				remove(1);
			} else {
				remove(0);
			}
		} else {
			activeCard.style.transform = "";
		}
	}

	await getSounds();
})();
