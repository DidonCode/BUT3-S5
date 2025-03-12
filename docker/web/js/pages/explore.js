(async () => {
	console.log(user);
	const contentContainer = document.getElementById('content-container');
	const swipeBtn = document.getElementById('button-swipe');

	function createSparkle() {
		const box = document.getElementById('swipe-btn-container');
		const sparkle = document.createElement('div');
		sparkle.style.position = 'absolute';
		sparkle.style.width = '5px';
		sparkle.style.height = '5px';
		sparkle.style.backgroundColor = 'gold';
		sparkle.style.borderRadius = '50%';

		const borderSize = -40;
		const boxRect = box.getBoundingClientRect();
		const position = Math.random() * ((boxRect.width - borderSize) * 2 + boxRect.height * 2);

		if (position < boxRect.width) {
			sparkle.style.top = `${-borderSize}px`;
			sparkle.style.left = `${position}px`;
		} else if (position < boxRect.width + boxRect.height) {
			sparkle.style.top = `${position - boxRect.width}px`;
			sparkle.style.left = `${boxRect.width}px`;
		} else if (position < boxRect.width * 2 + boxRect.height) {
			sparkle.style.top = `${boxRect.height}px`;
			sparkle.style.left = `${boxRect.width - (position - (boxRect.width + boxRect.height))}px`;
		} else {
			sparkle.style.top = `${boxRect.height - (position - (boxRect.width * 2 + boxRect.height))}px`;
			sparkle.style.left = `${-borderSize}px`;
		}

		sparkle.style.zIndex = "6";
		sparkle.style.opacity = '1';
		sparkle.style.transition = 'opacity 1s ease-out, transform 1s ease-out';
		box.appendChild(sparkle);

		setTimeout(() => {
			sparkle.style.opacity = '0';
			sparkle.style.transform = 'scale(2)';
		}, 50);

		setTimeout(() => {
			sparkle.remove();
		}, 1000);
	}

	setInterval(createSparkle, 100);

	async function disableSwipeBtn() {
		if (user['subscription'] == null || user['subscription']['type'] != 'premium') {
			swipeBtn.classList.add('disable');
			swipeBtn.setAttribute('disabled', true);
		}
	}

	async function mostListened() {
		await apiCall('api/like?type=mostListened', null, async function (data) {
			if (data != '') {
				const parsedData = JSON.parse(data);

				if (parsedData != null) {
					if (parsedData['error'] != undefined) {
						routeError(parsedData['error']);
						return;
					} else {
						if (parsedData.length == 0) return;

						const list = new List(
							'most-listened',
							'Musiques les plus écoutées',
							parsedData.map((sound) => {
								return new SoundCard(sound.id, sound.image, sound.title, sound.type, sound.artist, true);
							}),
						);

						contentContainer.append(await list.getSkeleton());
						list.makeList();
					}
				}
			}
		});
	}

	async function leastListened() {
		await apiCall('api/like?type=leastListened', null, async function (data) {
			if (data != '') {
				const parsedData = JSON.parse(data);

				if (parsedData != null) {
					if (parsedData['error'] != undefined) {
						routeError(parsedData['error']);
						return;
					} else {
						if (parsedData.length == 0) return;

						const list = new List(
							'least-listened',
							'Les musiques émergentes',
							parsedData.map((sound) => {
								return new SoundCard(sound.id, sound.image, sound.title, sound.type, sound.artist, true);
							}),
						);

						contentContainer.append(await list.getSkeleton());
						list.makeList();
					}
				}
			}
		});
	}

	async function mostLikedSound() {
		await apiCall('api/like?type=mostLikedSound', null, async function (data) {
			if (data != '') {
				const parsedData = JSON.parse(data);

				if (parsedData != null) {
					if (parsedData['error'] != undefined) {
						routeError(parsedData['error']);
						return;
					} else {
						if (parsedData.length == 0) return;

						const list = new List(
							'most-liked-sound',
							'Musiques les plus aimées',
							parsedData.map((sound) => {
								return new SoundCard(sound.id, sound.image, sound.title, sound.type, sound.artist, true);
							}),
						);

						contentContainer.append(await list.getSkeleton());
						list.makeList();
					}
				}
			}
		});
	}

	async function mostLikedPlaylist() {
		await apiCall('api/like?type=mostLikedPlaylist', null, async function (data) {
			if (data != '') {
				const parsedData = JSON.parse(data);

				if (parsedData != null) {
					if (parsedData['error'] != undefined) {
						routeError(parsedData['error']);
						return;
					} else {
						if (parsedData.length == 0) return;

						const list = new List(
							'most-liked-playlist',
							'Playlists les plus aimées',
							parsedData.map((playlist) => {
								return new PlaylistCard(playlist.id, playlist.image, playlist.title, playlist.description, playlist.owner, true);
							}),
						);

						contentContainer.append(await list.getSkeleton());
						list.makeList();
					}
				}
			}
		});
	}

	async function leastArtist() {
		await apiCall('api/like?type=leastArtist', null, async function (data) {
			if (data != '') {
				const parsedData = JSON.parse(data);

				if (parsedData != null) {
					if (parsedData['error'] != undefined) {
						routeError(parsedData['error']);
						return;
					} else {
						if (parsedData.length == 0) return;

						const list = new List(
							'least-artist',
							'Les artistes émergents',
							parsedData.map((artist) => {
								return new ArtistCard(artist.id, artist.image, artist.pseudo, true);
							}),
						);

						contentContainer.append(await list.getSkeleton());
						list.makeList();
					}
				}
			}
		});
	}

	await disableSwipeBtn();
	await mostListened();
	await leastListened();
	await mostLikedSound();
	await mostLikedPlaylist();
	await leastArtist();
})();
