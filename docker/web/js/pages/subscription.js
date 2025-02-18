(() => {

	const basic = document.getElementById("basic");
	const premium = document.getElementById("premium");

	function createSparkle() {
		const box = document.getElementById('premium');
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

	const stripe = Stripe("pk_test_51Qrwg3Pfaun29rdGpVgrLJ05OiWc5cdGZwgcMDMI5xrj9ldN3v84cMRPz2fN46CgplClCqg3IcA0eA5zVCsIfdat00i48vXkYT");

	premium.getElementsByClassName("btn")[0].onclick = async function(){
		let formData = new FormData();
		formData.append("priceId", "price_1Qt7KWPfaun29rdGUCACU0xz");
		formData.append("token", token);

		apiCall("api/user/subscription", formData, async function(data) {
			if (data != '') {
				const parsedData = JSON.parse(data);

				await stripe.redirectToCheckout({ sessionId: parsedData });
			}
		});
	}
})();