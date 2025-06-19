function showTime() {
	document.getElementById('currentTime').innerHTML = new Date().toUTCString();
}
showTime();
setInterval(function () {
	showTime();
}, 1000);

document.addEventListener('DOMContentLoaded', () => {
const links = document.querySelectorAll('.nav-center a');
const currentPath = window.location.pathname.split("/").pop();

links.forEach(link => {
	const href = link.getAttribute('href');
	if (href === currentPath || (href === 'index.html' && currentPath === '')) {
	link.classList.add('active');
	}
});
});

