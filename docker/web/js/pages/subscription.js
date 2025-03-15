(() => {
	const free = document.getElementById('free-buy');
	const basic = document.getElementById('basic-buy');
	const premiumCard = document.getElementById('premium');
	const premium = document.getElementById('premium-buy');
	const loading = document.getElementById('subscription-loading');

	if (user['subscription'] != null) {
		if (user['subscription']['type'] === 'premium') {
			basic.setAttribute('disabled', '');
			premium.setAttribute('disabled', '');
			premium.innerText = 'possédé';
		} else {
			basic.setAttribute('disabled', '');
			basic.innerText = 'possédé';
			premium.innerText = 'amélioré';
		}
	} else {
		free.innerText = 'possédé';
	}

	createSparkle(premiumCard, 200, 20);

	function createSession(subscription) {
		if (!sessionExist()) {
			sessionDestroy();
			return;
		}

		loading.removeAttribute('hidden');

		let formData = new FormData();

		formData.append('subscription', subscription);
		formData.append('token', token);

		apiCall('api/user/subscription', formData, async function (data) {
			if (data != '') {
				const parsedData = JSON.parse(data);

				await Stripe(parsedData['key']).redirectToCheckout({ sessionId: parsedData['session'] });
			}

			loading.setAttribute('hidden', '');
		});
	}

	premium.onclick = () => createSession('premium');
	basic.onclick = () => createSession('basic');
})();
