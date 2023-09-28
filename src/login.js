function randomUser() {
	let user = "";
	let vowels = "aeiou"; let consonants = "bcdfgjklmnpsrtvxz"
	for (let i = 0; i < 10; i++) {
		if (i > 7) {
			user += parseInt(Math.random()*10).toString();
		} else if (i % 2) {
			user += vowels[parseInt(Math.random()*vowels.length)];
		} else {
			user += consonants[parseInt(Math.random()*consonants.length)];
		}
	}
	document.getElementById("login").value = user;
}

function signedIn(login, pwd) {
	localStorage.setItem("login", login);
	localStorage.setItem("pwd", pwd); // sorry, not encoded (I mean, it's local storage, this acts as a private key)
	document.location.href = "../dashboard";
}