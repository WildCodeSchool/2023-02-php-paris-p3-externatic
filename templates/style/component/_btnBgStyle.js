let endpoint = window.location.href;
let afterSlash = endpoint.split('/').filter(element => element !== '').pop();
if (afterSlash === 'research') {
	document.getElementById('navbtn1').style.backgroundColor = '#FED32C';
} else if (afterSlash === 'applications') {
	document.getElementById('navbtn2').style.backgroundColor = '#FED32C';
} else if (afterSlash === 'collection') {
	document.getElementById('navbtn3').style.backgroundColor = '#FED32C';
} else {
	document.getElementById('navbtn4').style.backgroundColor = '#FED32C';
}