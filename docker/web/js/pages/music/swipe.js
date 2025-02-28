(() => {
	const cardTitle = document.getElementById('sound-title');
	const cardContainer = document.getElementById('card-container');
	const sliderContainer = document.getElementById('slider-container');

	const dislikeBtn = document.getElementById('dislike-swipe');
	const likeBtn = document.getElementById('like-swipe');

	const play = document.getElementById('swipe-play');
	const pause = document.getElementById('swipe-pause');

	const volume = document.getElementById('swipe-volume');

	const progress = document.getElementById('swipe-progress-bar');
	
	if (!sessionExist()) {
		sessionDestroy();
		return;
	}

	/*if (user['subscription'] == null || user['subscription']['type'] != 'premium') {
		window.history.pushState({}, '', '/web/subscription');
		handleLocation();
	}
		*/

    async function sounds() {
        /*
		let soundsFormData = new FormData();

        soundsFormData.append('type','sounds')
        soundsFormData.append('token', token)
        await apiCall("api/user/activity", soundsFormData, async function(data) {
		*/

		await apiCall("api/sound?playlist=1", null, async function(data) {
            if(data != "") {
                const parsedData = JSON.parse(data);

                if(parsedData != null){
                    if(parsedData['error'] != undefined) {
                        routeError(parsedData['error']);
                        return;
                    } else {
                        if(parsedData.lenth == 0) return;

                        let i = 0;
                        for(card of parsedData) {
                            soundCard = document.createElement('img');
							soundCard.classList.add('rounded-img', 'card');

							if(i == 0) {
								cardTitle.innerText = card.title;
							}
							soundCard.id = card.id
							soundCard.alt = `${card.title}`;
							soundCard.src = card.image;
							soundCard.setAttribute("data-link", card.link);

							cardContainer.appendChild(soundCard);
							i++
                        }

						if(cardContainer.children.length > 0) {
							loadButifyPlayer(cardContainer.children[0]);
						}
                    }
                }
            }
        })
    }

	const remove = async (isLiked) => {
		if (cardContainer.children.length > 0) {
			const firstCard = cardContainer.children[0];

			if (isLiked) {
				firstCard.classList.add('liked-sound');

				let formData = new FormData();

				formData.append("sound", firstCard.id);
				formData.append("action", 3);
				formData.append("token", token);

				await apiCall('api/user/like', formData, async (data) => {
					if (data != '') {
						const parsedData = JSON.parse(data);
		
						if (parsedData['error'] != undefined) console.log(parsedData['error']);
					}
				})
			} else {
				firstCard.classList.add('unliked-sound');				
			}

			await new Promise((resolve) => {
				firstCard.addEventListener('animationend', resolve, { once: true });
			});

			firstCard.remove();
			if (cardContainer.children.length > 0) {
				let nextCard = cardContainer.children[0];
				cardTitle.innerText = nextCard.alt;
				

				const player = document.getElementById('swipe-player');
				const source = document.getElementById('swipe-source');

           		player.pause();
            	player.currentTime = 0;

				source.src = '';

				loadButifyPlayer(nextCard);
				
			}
		}
	};

	function updateVolume(playerVolume) {
		sessionStorage.setItem('player-volume', playerVolume);
	}

	function updateTimecode(timeCode, duration) {
		time.innerText = formatTime(timeCode) + ' / ' + formatTime(duration);
	
		progress.max = duration;
		progress.value = timeCode;
	
		const value = (timeCode / duration) * 100;
		progress.style.setProperty('--progress', `${value}%`);
	}

	function loadButifyPlayer(video) {
		const playerContainer = document.getElementById('player-container');
	
		let player = document.getElementById('swipe-player');
		let source = document.getElementById('swipe-source');
		volume.value = 25;
	
		source.src = video.getAttribute("data-link");
	
		player.autoplay = false;
		player.muted = true;
		player.load();
		player.play();
		player.muted = false;
		player.volume = volume.value / 100;
	
		playerContainer.appendChild(player);
		
		

		//-------------\\

		player.onplaying = function () {
			play.style.display = 'none';
			pause.style.display = 'inline';
		};
	
		player.onpause = function () {
			pause.style.display = 'none';
			play.style.display = 'inline';
		};
	
		player.muted === true ? (mute.style.display = 'none') : (unmute.style.display = 'none');
	
		player.ontimeupdate = function () {
			if (player == null) return;
			updateTimecode(player.currentTime, player.duration);
		};

		//-------------\\

		play.onclick = function () {
			player.play();
		};
		pause.onclick = function () {
			player.pause();
		};
	
		mute.onclick = function () {
			player.volume = 0;
			volume.value = 0;
	
			mute.style.display = 'none';
			unmute.style.display = '';
			volume.style.display = 'none';
		};

		let hideTimeout;

		mute.onmouseover = function () {
			clearTimeout(hideTimeout);
			volume.style.display = '';
			volume.style.width = '';
		};

		mute.onmouseout = function () {
			hideTimeout = setTimeout(() => {
				volume.style.width = '0px';
				setTimeout(() => {
					volume.style.display = 'none';
				}, 300);
			}, 500);
		};

		unmute.onclick = function () {
			volume.value = sessionStorage.getItem('player-volume');
			player.volume = volume.value / 100;

			unmute.style.display = 'none';
			mute.style.display = '';
			volume.style.display = '';
		};

		volume.oninput = function () {
			player.volume = volume.value / 100;
			updateVolume(volume.value);
		};

		progress.onchange = function () {
			player.currentTime = progress.value;
		};

	}

	dislikeBtn.onclick = function () {
		remove(0);
	};

	likeBtn.onclick = function () {
		remove(1);
	};

	let startX = 0;
	let endX = 0;

	sliderContainer.addEventListener('touchstart', (e) => {
		startX = e.touches[0].clientX;
	});

	sliderContainer.addEventListener('touchend', (e) => {
		endX = e.changedTouches[0].clientX;
		detectSwipe();
	});

	sliderContainer.addEventListener('mousedown', (e) => {
		startX = e.clientX;
		console.log(startX);
	})

	sliderContainer.addEventListener('mouseup', (e) => {
		endX = e.clientX;
		console.log(endX);
		detectSwipe();
	})

	function detectSwipe() {
		const swipeDistance = endX - startX;
		const minSwipeDistance = 75;

		console.log("Swipe distance:", swipeDistance);

		if (swipeDistance > minSwipeDistance) {
			console.log("Swipe vers la droite");
			remove(1); 
		} else if (swipeDistance < -minSwipeDistance) {
			console.log("Swipe vers la gauche");
			remove(0); 
		}
	}

	sounds();
})();