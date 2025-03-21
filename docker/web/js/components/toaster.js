function makeToast(message, type) {
	const toast = document.createElement('div');
	toast.classList.add('toast');

	setTimeout(function () {
		toast.remove();
	}, 3000);

	let icon = null;

	switch (type) {
		case 'error':
			icon = document.createElement('i');
			icon.classList.add('fa-light', 'fa-circle-exclamation', 'my-auto');

			toast.classList.add('toast-error');
			break;

		case 'warning':
			icon = document.createElement('i');
			icon.classList.add('fa-light', 'fa-triangle-exclamation', 'my-auto');

			toast.classList.add('toast-warning');
			break;

		case 'success':
			icon = document.createElement('i');
			icon.classList.add('fa-light', 'fa-circle-check', 'my-auto');

			toast.classList.add('toast-success');
			break;
	}

	const text = document.createElement('p');
	text.innerText = message;

	toast.append(icon);
	toast.append(text);
	document.body.append(toast);
}
